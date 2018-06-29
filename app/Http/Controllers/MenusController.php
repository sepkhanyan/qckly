<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use Auth;
use Illuminate\Http\Request;
use App\Menus;
use App\Restaurant;
use App\Categories;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null, Request $request)
    {

        $categories = Categories::all();
        $restaurants = Restaurant::all();
        $selectedRestaurant = Restaurant::find($id);
        $data = $request->all();
        $menus = [];
        if($id){
            $menus = Menus::where('restaurant_id',$id)->get();
            if(isset($data['menu_status'])){
                $menus = Menus::where('restaurant_id',$id)
                    ->where('menu_status',$data['menu_status'])->get();
            }
            if(isset($data['menu_category'])){
                $menus = Menus::where('restaurant_id',$id)
                    ->where('menu_category_id',$data['menu_category'])->get();
            }
            if(isset($data['menu_search'])){
                $menus = Menus::where('restaurant_id',$id)
                    ->where('menu_name','like',$data['menu_search'])
                    ->orWhere('menu_price','like',$data['menu_search'])
                    ->orWhere('stock_qty','like',$data['menu_search'])->get();
            }
        }
        return view('menus', [
            'id' => $id,
            'menus' => $menus,
            'restaurants' => $restaurants,
            'categories' => $categories,
            'selectedRestaurant' => $selectedRestaurant
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
        $categories = Categories::all();
        return view('new_menus', [
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
        $menus = new Menus();
        $menus->menu_name = $request->input('menu_name');
        $menus->menu_description = $request->input('menu_description');
        $menus->menu_price = $request->input('menu_price');
        $menus->menu_category_id = $request->input('menu_category');
        $menus->menu_photo = $request->input('menu_photo');
        $menus->stock_qty = $request->input('stock_qty');
        $menus->minimum_qty = $request->input('minimum_qty');
        $menus->subtract_stock = $request->input('subtract_stock');
        $menus->menu_status = $request->input('menu_status');
        $menus->menu_priority = $request->input('menu_priority');
        $menus->mealtime_id = $request->input('mealtime_id');
        $menus->restaurant_id = $request->input('restaurant_name');
        $menus->save();
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
        $menu = Menus::find($id);
        $restaurants = Restaurant::all();
        $categories = Categories::all();
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
        $menus = Menus::find($id);
        $menus->menu_name = $request->input('menu_name');
        $menus->menu_description = $request->input('menu_description');
        $menus->menu_price = $request->input('menu_price');
        $menus->menu_category_id = $request->input('menu_category');
        $menus->menu_photo = $request->input('menu_photo');
        $menus->stock_qty = $request->input('stock_qty');
        $menus->minimum_qty = $request->input('minimum_qty');
        $menus->subtract_stock = $request->input('subtract_stock');
        $menus->menu_status = $request->input('menu_status');
        $menus->menu_priority = $request->input('menu_priority');
        $menus->mealtime_id = $request->input('mealtime_id');
        $menus->save();
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
        Menus::whereIn('menu_id',$id)->delete();


        return redirect('/menus');
    }


}
