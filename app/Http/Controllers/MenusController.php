<?php

namespace App\Http\Controllers;

use App\EditingMenu;
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
                $menus = $menus->name($data['menu_search']);
            }
            $selectedRestaurant = Restaurant::find($id);
            $menus = $menus->orderby('approved', 'asc')->orderby('category_id', 'asc')->paginate(20);
            $categories = MenuCategory::where('restaurant_id', $selectedRestaurant->id)->get();
        }
        if ($user->admin == 2) {
            $menus = Menu::where('restaurant_id', $user->restaurant_id);
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
            $categories = MenuCategory::where('restaurant_id', $user->restaurant_id)->get();
        }
        return view('menus', [
            'id' => $id,
            'menus' => $menus,
            'restaurants' => $restaurants,
            'categories' => $categories,
            'selectedRestaurant' => $selectedRestaurant,
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
        $categories = MenuCategory::where('restaurant_id', $restaurant->id)->where('approved', 1)->get();
        if (count($categories) > 0) {
            return view('menu_create', [
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
        if($user->admin == 1){
            $menu->approved = 1;
        }
        $menu->save();
        if ($menu) {
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
        if($user->admin ==1){
            Menu::where('id', $id)->update(['approved' => 1]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function reject($id)
    {
        $user = Auth::user();
        if($user->admin ==1){
            Menu::where('id', $id)->update(['approved' => 2]);
            return redirect()->back();
        }else{
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
        if($user->admin == 1 && $menu->editingMenu !== null){
            $editingMenu = $menu->editingMenu;
            return view('menu_edit_approve', [
                'menu' => $menu,
                'editingMenu' => $editingMenu,
                'user' => $user
            ]);
        }
        return view('menu_edit', [
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
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $user = Auth::user();
        $menu = Menu::find($id);
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $restaurant_id = $user->restaurant_id;
            $menu = Menu::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if (!$menu) {
                return redirect()->back();
            }else{
                $oldEditingMenu = EditingMenu::where('menu_id', $id)->first();
                if($oldEditingMenu){
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
            }
        }elseif ($user->admin == 1){
            $validator = \Validator::make($request->all(), [
                'name_en' => 'string|max:255',
                'description_en' => 'string',
                'name_ar' => 'string|max:255',
                'description_ar' => 'string',
                'price' => 'numeric',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
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
            $menu  = Menu::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
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
        if($user->admin ==1){
            $restaurant_id = $request->input('restaurant');
            $menu = Menu::find($id);
            $editingMenu = EditingMenu::where('menu_id', $id)->first();
            $menu->name_en = $request->input('name_en');
            $menu->description_en = $request->input('description_en');
            $menu->name_ar = $request->input('name_ar');
            $menu->description_ar = $request->input('description_ar');
            $menu->price = $request->input('price');
            $menu->famous = $request->input('famous');
            $menu->status = $request->input('status');
            if ($editingMenu->image) {
                if ($menu->image) {
                    File::delete(public_path('images/' . $menu->image));
                }
                $menu->image = $editingMenu->image;
            }
            $menu->approved = 1;
            $menu->save();
            EditingMenu::where('menu_id', $menu->id)->delete();
            return redirect('/menus/' . $restaurant_id);
        }else{
            return redirect()->back();
        }
    }

    public function editReject($id)
    {
        $user = Auth::user();
        if($user->admin ==1){
            $editingMenus = EditingMenu::where('menu_id', $id)->get();
            $menu = Menu::find($id);
            $menu_images = [];
            foreach ($editingMenus as $editingMenu){
                $menu_images[] = public_path('images/' . $editingMenu->image);
            }
            File::delete($menu_images);
            EditingMenu::where('menu_id', $id)->delete();
            return redirect('/menus/' . $menu->restaurant_id);
        }else{
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
        $menus = Menu::whereIn('id', $id)->get();
        $menu = Menu::where('id', $id)->first();
        if ($user->admin == 2) {
            if($menu->restaurant_id == $user->restaurant_id){
                $menu_images = [];
                foreach($menus as $menu){
                    $menu_images[] = public_path('images/' . $menu->image);
                }
                File::delete($menu_images);
                Menu::whereIn('id', $id)->delete();
            }else{
                return redirect()->back();
            }
        } else {
            $menu_images = [];
            foreach($menus as $menu){
                $menu_images[] = public_path('images/' . $menu->image);
            }
            File::delete($menu_images);
            Menu::whereIn('id', $id)->delete();
        }
        return redirect()->back();
    }


}
