<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RestaurantCategory;
use App\Restaurant;

class RestaurantCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = RestaurantCategory::all();
        return view('restaurant_categories', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new_restaurant_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories = new RestaurantCategory();
        $categories->restaurant_category_name_en = $request->input('name_en');
        $categories->restaurant_category_name_ar = $request->input('name_ar');
        $categories->save();
        if ($categories) {
            return redirect('/restaurant_categories');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = RestaurantCategory::find($id);
        return view('restaurant_category_edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = RestaurantCategory::find($id);
        $category->restaurant_category_name_en = $request->input('name_en');
        $category->restaurant_category_name_ar = $request->input('name_ar');
        $category->save();
        return redirect('/restaurant_categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteRestaurantCategory(Request $request)
    {
        $id = $request->get('id');
        RestaurantCategory::whereIn('restaurant_category_id',$id)->delete();


        return redirect('/restaurant_categories');
    }

    public function getCategories(Request $request)
    {
        $lang = $request->header('Accept-Language');
        $categories = RestaurantCategory::all();
        foreach($categories as $category){
            if ($lang == 'en'){
                $arr [] = [
                    'category_id' => $category->restaurant_category_id,
                    'category_name' => $category->restaurant_category_name_en,
                ];
            }else{
                $arr [] = [
                    'category_id' => $category->restaurant_category_id,
                    'category_name' => $category->restaurant_category_name_ar,
                ];
            }

        }

        if ($arr){
            return response()->json(array(
                'success'=> 1,
                'status_code'=> 200 ,
                'data' => $arr));
        }
    }
}
