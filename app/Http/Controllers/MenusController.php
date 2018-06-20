<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use Auth;
use Illuminate\Http\Request;
use App\Menus;
use App\Locations;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        $locations = Locations::all();
        if($id){
            $menus = Menus::where('location_id',$id)->get();

        }else{
            $menus = [];
        }
        return view('menus', ['menus' => $menus, 'locations' => $locations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Locations::all();
        return view('new_menus', ['locations' => $locations]);
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
        $menus->location_id = $request->input('location_name');
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
        $locations = Locations::all();
        return view('menu_edit', ['locations' => $locations, 'menu' => $menu]);
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
