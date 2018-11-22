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
                $menus = $menus->name($data['menu_search']);
            }
            $selectedRestaurant = Restaurant::find($id);
            $menus = $menus->orderby('category_id', 'asc')->paginate(20);
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
            $menus = $menus->orderby('category_id', 'asc')->paginate(20);
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
        $categories = MenuCategory::where('restaurant_id', $restaurant->id)->get();
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
            $menu = Menu::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if (!$menu) {
                return redirect()->back();
            }
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
        $validator = \Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = Auth::user();
        $menu = Menu::find($id);
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $restaurant_id = $user->restaurant_id;
            $menu = Menu::where('id', $id)->where('restaurant_id', $user->restaurant_idd)->first();
            if (!$menu) {
                return redirect()->back();
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
            $name = 'menu_' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('/images');
            $image->move($path, $name);
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
        $user = Auth::user();
        $menu = Menu::where('id', $id)->first();
        if ($user->admin == 2) {
            if($menu->restaurant_id == $user->restaurant_id){
                Menu::whereIn('id', $id)->delete();
            }else{
                return redirect()->back();
            }
        } else {
            Menu::whereIn('id', $id)->delete();
        }

        return redirect('/menus');
    }


}
