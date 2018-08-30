<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use Auth;
use DB;
use App\Area;
use Illuminate\Http\Request;
use App\Menu;
use App\Restaurant;
use App\Category;
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

        $categories = Category::all();
        $restaurants = Restaurant::all();
        $selectedRestaurant = Restaurant::find($id);
        $data = $request->all();
        $menus = [];
        if($id){
            $menus = Menu::whereHas('restaurant',function ($query) use ($id){
                $query->where('restaurant_id', $id);})
                ->with('category');
            if(isset($data['menu_status'])) {
                $menus = $menus->where('status', $data['menu_status']);
            }
            if(isset($data['menu_category'])){
                $menus = $menus->where('category_id',$data['menu_category']);

            }
            if(isset($data['menu_search'])){
                $menus = $menus->where('name','like',$data['menu_search'])
                    ->orWhere('price','like',$data['menu_search'])
                    ->orWhere('stock_qty','like',$data['menu_search']);
            }
            $menus = $menus->paginate(20);
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
    public function create()
    {
        $restaurants = Restaurant::all();
        $categories = Category::all();
        return view('menu_create', [
            'restaurants' => $restaurants,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $menu = new Menu();
        $image = $request->file('menu_photo');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $menu->image = $name;
        $menu->name = $request->input('menu_name');
        $menu->description = $request->input('menu_description');
        $menu->price = $request->input('menu_price');
        $menu->category_id = $request->input('menu_category');
        $menu->stock_qty = $request->input('stock_qty');
        $menu->minimum_qty = $request->input('minimum_qty');
        $menu->subtract_stock = $request->input('subtract_stock');
        $menu->status = $request->input('menu_status');
        $menu->priority = $request->input('menu_priority');
        $menu->mealtime_id = $request->input('mealtime_id');
        $menu->restaurant_id = $request->input('restaurant_name');
        $menu->famous = $request->input('famous');
        $menu->save();
        return redirect('/menus');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::find($id);
        $restaurants = Restaurant::all();
        $categories = Category::all();
        return view('menu_edit', [
            'restaurants' => $restaurants,
            'categories' => $categories,
            'menu' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $id)
    {
        $menu = Menu::find($id);
        $menu->name = $request->input('menu_name');
        $menu->description = $request->input('menu_description');
        $menu->price = $request->input('menu_price');
        $menu->category_id = $request->input('menu_category');
        $menu->stock_qty = $request->input('stock_qty');
        $menu->minimum_qty = $request->input('minimum_qty');
        $menu->subtract_stock = $request->input('subtract_stock');
        $menu->status = $request->input('menu_status');
        $menu->priority = $request->input('menu_priority');
        $menu->mealtime_id = $request->input('mealtime_id');
        $menu->famous = $request->input('famous');
        if ($request->hasFile('menu_photo')) {
            $deletedImage = File::delete(public_path('images/' . $menu->image));
            if ($deletedImage) {
                $image = $request->file('menu_photo');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);
                $menu->image = $name;
            }
        }
        $menu->save();
        return redirect('/menus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMenus(Request $request)
    {
        $id = $request->get('id');
        $menus = Menu::where('id',$id)->get();
        $images = [];
        foreach ($menus as $menu) {
            $images[] = public_path('images/' . $menu->image);
        }
        File::delete($images);
        Menu::whereIn('id',$id)->delete();

        return redirect('/menus');
    }


}
