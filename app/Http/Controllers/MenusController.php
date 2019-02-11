<?php

namespace App\Http\Controllers;

use App\EditingMenu;
use App\Http\Requests\MenuRequest;
use Auth;
use DB;
use App\Area;
use App\User;
use Illuminate\Http\Request;
use App\Menu;
use App\Restaurant;
use App\MenuCategory;
use App\Collection;
use App\CollectionItem;
use App\CollectionMenu;
use Illuminate\Support\Facades\File;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null, Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        if ($user->admin == 1) {

            $restaurants = Restaurant::where('deleted', 0)->get();

            if ($id) {

                $menus = Menu::where('restaurant_id', $id)->where('deleted', 0)->with('editingMenu');

                if (isset($data['menu_status'])) {
                    $menus = $menus->where('status', $data['menu_status']);
                }

                if (isset($data['menu_category'])) {
                    $menus = $menus->where('category_id', $data['menu_category']);

                }

                if (isset($data['menu_search'])) {
                    $menus = $menus->name($data['menu_search']);
                }

                $selectedRestaurant = Restaurant::find($id);
                $menus = $menus->orderby('approved', 'asc')->orderby('category_id', 'asc')->paginate(20);
                $categories = MenuCategory::where('restaurant_id', $selectedRestaurant->id)->where('deleted', 0)->where('approved', 1)->get();
            }

        } elseif ($user->admin == 2) {

            $menus = Menu::where('restaurant_id', $user->restaurant_id)->where('deleted', 0)->with('editingMenu');

            if (isset($data['menu_status'])) {
                $menus = $menus->where('status', $data['menu_status']);
            }

            if (isset($data['menu_category'])) {
                $menus = $menus->where('category_id', $data['menu_category']);
            }

            if (isset($data['menu_search'])) {
                $menus = $menus->name($data['menu_search']);
            }

            $selectedRestaurant = Restaurant::find($user->restaurant_id);
            $menus = $menus->orderby('approved', 'asc')->orderby('category_id', 'asc')->paginate(20);
            $categories = MenuCategory::where('restaurant_id', $user->restaurant_id)->where('deleted', 0)->where('approved', 1)->get();
        }
        return view('menus.menus', [
            'id' => $id,
            'menus' => isset($menus) ? $menus : collect(),
            'restaurants' => isset($restaurants) ? $restaurants : "",
            'selectedRestaurant' => isset($selectedRestaurant) ? $selectedRestaurant : "",
            'categories' => isset($categories) ? $categories : collect(),
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $user = Auth::user();
        $restaurant = Restaurant::where('id', $id)->first();
        if ($user->admin == 2) {
            $restaurant = Restaurant::where('id', $user->restaurant_id)->first();
        }
        $categories = MenuCategory::where('restaurant_id', $restaurant->id)->where('approved', 1)->where('deleted', 0)->get();
        if (count($categories) > 0) {
            return view('menus.menu_create', [
                'restaurant' => $restaurant,
                'categories' => $categories,
                'user' => $user
            ]);
        } else {
            return redirect('/menu_categories/' . $id);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $user = Auth::user();
        $menu = new Menu();
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $restaurant_id = $user->restaurant_id;
        }
        $menu->restaurant_id = $restaurant_id;
        $menu->category_id = $request->input('category');
        $image = $request->file('image');
        $name = 'menu_' . time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('/images');
        $image->move($path, $name);
        $menu->image = $name;
        $menu->name_en = $request->input('name_en');
        $menu->description_en = $request->input('description_en');
        $menu->name_ar = $request->input('name_ar');
        $menu->description_ar = $request->input('description_ar');
        $menu->price = $request->input('price');
        $menu->status = $request->input('status');
        $menu->famous = $request->input('famous');
        if ($user->admin == 1) {
            $menu->approved = 1;
        }
        $menu->save();
        if ($menu) {

            $collections = Collection::where('restaurant_id', $restaurant_id)->get();

            if(count($collections) > 0 ){
//                $collectionMenus = CollectionMenu::where('menu_id', $menu->category_id)->get();
                foreach($collections as $collection){

                    $collection_menu = CollectionMenu::firstOrCreate(
                        ['collection_id' => $collection->id, 'menu_id' => $menu->category_id],
                        ['min_qty' => 1, 'max_qty' => 1]
                    );


                    $collection_item = CollectionItem::firstOrCreate(
                        ['collection_id' => $collection->id, 'item_id' => $menu->id],
                        ['collection_menu_id' => $collection_menu->id, 'quantity' => 1, 'is_mandatory' => 1 ]
                    );

                }
            }

            if($user->admin == 2){

                $restaurant = Restaurant::find($user->restaurant_id);

                $superadmin = User::where('admin', 1)->where('group_id', 1)->first();

                $mobile = $superadmin->mobile_number;

                $provider = $restaurant->name_en;

                $content = $provider . ' has added a new menu item.';

                // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content= $content&destination=974$mobile&source=97772&mask=Qckly";

                // file($url);
            }

            return redirect('/menus/' . $restaurant_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {

            Menu::where('id', $id)->update(['approved' => 1]);


            $menu= Menu::find($id);

            $provider = User::where('admin', 2)->where('group_id', 2)->where('restaurant_id', $menu->restaurant_id)->first();

            $mobile = $provider->mobile_number;

            $content = 'Your added menu item is approved.';

            // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=$content&destination=974$mobile&source=97772&mask=Qckly";

            // file($url);

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function reject($id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {

            Menu::where('id', $id)->update(['approved' => 2]);


            $menu= Menu::find($id);

            $provider = User::where('admin', 2)->where('group_id', 2)->where('restaurant_id', $menu->restaurant_id)->first();

            $mobile = $provider->mobile_number;

            $content = 'Your added menu item is rejected.';

            // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=$content&destination=974$mobile&source=97772&mask=Qckly";

            // file($url);

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $menu = Menu::find($id);
        if ($user->admin == 2) {
            $menu = Menu::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if (!$menu) {
                return redirect()->back();
            }
        }

        return view('menus.menu_edit', [
            'menu' => $menu,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $id)
    {
        $user = Auth::user();
        $menu = Menu::find($id);
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $restaurant_id = $user->restaurant_id;
            $menu = Menu::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if (!$menu) {
                return redirect()->back();
            }

                $oldEditingMenu = EditingMenu::where('menu_id', $id)->first();
                if ($oldEditingMenu) {
                    if ($oldEditingMenu->image) {
                        File::delete(public_path('images/' . $oldEditingMenu->image));
                    }
                    EditingMenu::where('menu_id', $id)->delete();
                }

                $editingMenu = new EditingMenu();
                $editingMenu->menu_id = $id;
                $editingMenu->name_en = $request->input('name_en');
                $editingMenu->description_en = $request->input('description_en');
                $editingMenu->name_ar = $request->input('name_ar');
                $editingMenu->description_ar = $request->input('description_ar');
                $editingMenu->price = $request->input('price');
                $editingMenu->famous = $request->input('famous');
                $editingMenu->status = $request->input('status');

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $name = 'menu_' . time() . '.' . $image->getClientOriginalExtension();
                    $path = public_path('/images');
                    $image->move($path, $name);
                    $editingMenu->image = $name;
                }

                $editingMenu->save();

            $restaurant = Restaurant::find($user->restaurant_id);

            $superadmin = User::where('admin', 1)->where('group_id', 1)->first();

            $mobile = $superadmin->mobile_number;

            $provider = $restaurant->name_en;

            $editingProduct = $menu->name_en;

            $content = $provider . ' changed '. $editingProduct . ' data.';


            // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=$content&destination=974$mobile&source=97772&mask=Qckly";

            // file($url);

        } elseif ($user->admin == 1) {
            $menu->name_en = $request->input('name_en');
            $menu->description_en = $request->input('description_en');
            $menu->name_ar = $request->input('name_ar');
            $menu->description_ar = $request->input('description_ar');
            $menu->price = $request->input('price');
//        $menu->category_id = $request->input('category');
            $menu->status = $request->input('status');
            $menu->famous = $request->input('famous');
            if ($request->hasFile('image')) {
                if ($menu->image) {
                    File::delete(public_path('images/' . $menu->image));
                }
                $image = $request->file('image');
                $name = 'menu_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('/images');
                $image->move($path, $name);
                $menu->image = $name;
            }
            $menu->approved = 1;
            $menu->save();
        }
        return redirect('/menus/' . $restaurant_id);
    }


    public function changeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        $user = Auth::user();
        if ($user->admin == 2) {
            $menu = Menu::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if ($menu) {
                Menu::where('id', $id)->update(['status' => $status]);
            } else {
                return redirect()->back();
            }
        } else {
            Menu::where('id', $id)->update(['status' => $status]);
        }
        return redirect()->back();

    }

    public function editApprove(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {


            $data = $request->except('_token');

            $menu = Menu::find($id);
            $editingProduct = $menu->name_en;

            $editingMenu = EditingMenu::where('menu_id', $id)->first();
            if ($editingMenu->image) {
                $data['image'] = $editingMenu->image;
            }

            $data['approved'] = 1;
            $menu->update($data);

            EditingMenu::where('menu_id', $menu->id)->delete();

            $provider = User::where('admin', 2)->where('group_id', 2)->where('restaurant_id', $menu->restaurant_id)->first();

            $mobile = $provider->mobile_number;

            $content = 'Your changes for ' . $editingProduct . ' have been approved.';

            // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=$content&destination=974$mobile&source=97772&mask=Qckly";

            // file($url);

            if($menu->status == 1){
                $status = 'Enable';
            }else{
                $status = 'Disable';
            }

            $updatedMenu = [
                'name' => $menu->name_en,
                'description' => $menu->description_en,
                'categoryName' => $menu->category->name_en,
                'status' => $status,
                'price' => $menu->price
            ];

            return response()->json($updatedMenu);
        } else {
            return redirect()->back();
        }
    }

    public function editReject($id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {

            $editingMenus = EditingMenu::where('menu_id', $id)->get();
            $menu = Menu::find($id);
            $editingProduct = $menu->name_en;

            $menu_images = [];
            foreach ($editingMenus as $editingMenu) {
                $menu_images[] = public_path('images/' . $editingMenu->image);
            }

            File::delete($menu_images);
            EditingMenu::where('menu_id', $id)->delete();

            $provider = User::where('admin', 2)->where('group_id', 2)->where('restaurant_id', $menu->restaurant_id)->first();

            $mobile = $provider->mobile_number;

            $content = 'Your changes for ' . $editingProduct . ' have been rejected.';

            // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=$content&destination=974$mobile&source=97772&mask=Qckly";

            // file($url);

            return redirect('/menus/' . $menu->restaurant_id);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMenu(Request $request)
    {
        $id = $request->get('id');
        $user = Auth::user();
        $menu = Menu::where('id', $id)->first();
        if ($user->admin == 2) {
            if ($menu->restaurant_id == $user->restaurant_id) {
                Menu::whereIn('id', $id)->update(['deleted' => 1]);
            } else {
                return redirect()->back();
            }
        } else {
            Menu::whereIn('id', $id)->update(['deleted' => 1]);
        }
        return redirect()->back();
    }



    public function getEditedFields($id)
    {
        $user = Auth::user();
        $menu = Menu::with('category')->find($id);

        if ($user->admin == 1 && !is_null($menu)) {

            $oldMenu = $menu->toArray();
            $oldMenu = array_except($oldMenu, [
                'id',
                'restaurant_id',
                'category_id',
                'approved',
                'created_at',
                'updated_at',
                'deleted',
            ]);

            $editedMenu = EditingMenu::where('menu_id', $id)->first();


            $newMenu = $editedMenu->toArray();
            $newMenu = array_except($newMenu, [
                'id',
                'menu_id',
                'created_at',
                'updated_at',
            ]);

            if (is_null($newMenu['image'])) {

                unset($newMenu['image']);
                unset($oldMenu['image']);
            }

            $oldFields = array_diff_assoc($oldMenu, $newMenu);
            $newFields = array_diff_assoc($newMenu, $oldMenu);


            $data = [
                'menu' => $menu,
                'editedMenu' => $editedMenu,
                'oldFields' => $oldFields,
                'newFields' => $newFields
            ];

            $html = view('menus.editing_menu', $data)->render();
            return response()->json(['success' => true, 'html' => $html]);
        }
    }


}
