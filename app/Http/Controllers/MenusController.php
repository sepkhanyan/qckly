<?php

namespace App\Http\Controllers;

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
        $restaurants = Restaurant::all();
        $selectedRestaurant = [];
        $data = $request->all();
        $menus = [];
        $categories = [];
        if ($id) {
            $menus = Menu::where('restaurant_id', $id);
            if (isset($data['menu_status'])) {
                $menus = $menus->where('status', $data['menu_status']);
            }
            if (isset($data['menu_category'])) {
                $menus = $menus->where('category_id', $data['menu_category']);

            }
            if (isset($data['menu_search'])) {
                $menus = $menus->where('name_en', 'like', $data['menu_search'])
                    ->orWhere('price', 'like', $data['menu_search']);
            }
            $selectedRestaurant = Restaurant::find($id);
            $menus = $menus->orderby('category_id', 'asc')->paginate(20);
            $categories = MenuCategory::where('restaurant_id',$selectedRestaurant->id )->get();
        }
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $menus = Menu::where('restaurant_id', $restaurant->id);
            if (isset($data['menu_status'])) {
                $menus = $menus->where('status', $data['menu_status']);
            }
            if (isset($data['menu_category'])) {
                $menus = $menus->where('category_id', $data['menu_category']);

            }
            if (isset($data['menu_search'])) {
                $menus = $menus->where('name_en', 'like', $data['menu_search'])
                    ->orWhere('price', 'like', $data['menu_search'])
                    ->orWhere('description_en', 'like', $data['menu_search']);
            }
            $selectedRestaurant = Restaurant::find($restaurant->id);
            $menus = $menus->orderby('category_id', 'asc')->paginate(20);
            $categories = MenuCategory::where('restaurant_id',$selectedRestaurant->id )->get();
        }
        return view('menus', [
            'id' => $id,
            'menus' => $menus,
            'restaurants' => $restaurants,
            'categories' => $categories,
            'selectedRestaurant' => $selectedRestaurant,
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
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
        }
        $categories = MenuCategory::where('restaurant_id', $restaurant->id)->get();
        if(count($categories) > 0){
            return view('menu_create', [
                'restaurant' => $restaurant,
                'categories' => $categories
            ]);
        }else{
            return redirect('/menu_categories/' . $id);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|integer',
            'image' => 'required|image'
        ]);
        $user = Auth::user();
        $menu = new Menu();
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant_id = $user->restaurant->id;
        }
        $menu->restaurant_id = $restaurant_id;
        $menu->category_id = $request->input('category');
        $image = $request->file('image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $menu->image = $name;
        $menu->name_en = $request->input('name_en');
        $menu->description_en = $request->input('description_en');
        $menu->name_ar = $request->input('name_ar');
        $menu->description_ar = $request->input('description_ar');
        $menu->price = $request->input('price');
        $menu->status = $request->input('status');
        $menu->famous = $request->input('famous');
        $menu->save();
        if($menu){
            $collections = Collection::where('restaurant_id', $restaurant_id)->where('category_id', '!=', 1)->get();
            if(count($collections) > 0){
                foreach ($collections as $collection) {
                    $collection_item = new CollectionItem();
                    $collection_item->item_id = $menu->id;
                    $collection_item->collection_menu_id = $menu->category_id;
                    $collection_item->collection_id = $collection->id;
                    $collection_item->quantity = 1;
                    $collection_item->save();
                    $collection_menu = CollectionMenu::where('collection_id',$collection->id)->where('menu_id',$menu->category_id)->first();
                    if(!$collection_menu){
                        $collection_menu = new CollectionMenu();
                        $collection_menu->collection_id = $collection->id;
                        $collection_menu->menu_id = $menu->category_id;
                        $collection_menu->name = $menu->category->name_en;
                        if ($collection->id != 4) {
                            $collection_menu->min_qty = 1;
                            $collection_menu->max_qty = 1;
                        }
                        $collection_menu->save();
                    }
                }
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
    public function show($id)
    {

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
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $menu = Menu::where('id', $id)->where('restaurant_id', $restaurant->id)->first();
            if (!$menu) {
                return redirect('/menus');
            }
        }
        return view('menu_edit', [
            'menu' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'price' => 'required|numeric',
        ]);
        $user = Auth::user();
        $menu = Menu::find($id);
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $restaurant_id = $restaurant->id;
            $menu = Menu::where('id', $id)->where('restaurant_id', $restaurant->id)->first();
            if (!$menu) {
                return redirect('/menus');
            }
        }
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
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $menu->image = $name;
        }
        $menu->save();
        return redirect('/menus/' . $restaurant_id);
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
        $menus = Menu::where('id', $id)->get();
        $user = Auth::user();
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $menus = Menu::where('id', $id)->where('restaurant_id', $restaurant->id)->get();
            $images = [];
            foreach ($menus as $menu) {
                $images[] = public_path('images/' . $menu->image);
            }
            File::delete($images);
            Menu::whereIn('id', $id)->where('restaurant_id')->delete();
        }else{
            $images = [];
            foreach ($menus as $menu) {
                $images[] = public_path('images/' . $menu->image);
            }
            File::delete($images);
            Menu::whereIn('id', $id)->delete();
        }

        return redirect('/menus');
    }


}
