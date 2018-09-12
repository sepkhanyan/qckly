<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RestaurantCategory;
use App\Restaurant;
use Illuminate\Support\Facades\File;

class RestaurantCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = RestaurantCategory::paginate(20);
        $data = $request->all();
        if(isset($data['restaurant_category_search'])){
            $categories = RestaurantCategory::where('name_en','like',$data['restaurant_category_search'])
                ->orWhere('name_ar','like',$data['restaurant_category_search'])->paginate(15);
        }
        return view('restaurant_categories', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $categories->name_en = $request->input('name_en');
        $categories->name_ar = $request->input('name_ar');
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
        //
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
        $category->name_en = $request->input('name_en');
        $category->name_ar = $request->input('name_ar');
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
        $restaurants = Restaurant::with('menu')->where('restaurant_category_id',$id)->get();
        $restaurant_images = [];
        $menu_images = [];
        foreach ($restaurants as $restaurant) {
            foreach($restaurant->menu as $menu){
                $menu_images[] = public_path('images/' . $menu->menu_photo);
            }
            $restaurant_images[] = public_path('images/' . $restaurant->restaurant_image);
        }
        File::delete($menu_images);
        File::delete($restaurant_images);
        RestaurantCategory::whereIn('id',$id)->delete();
        return redirect('/restaurant_categories');
    }

    public function getCategories(Request $request)
    {
        $lang = $request->header('Accept-Language');
        $categories = RestaurantCategory::all();
        foreach($categories as $category){
            if ($lang == 'ar'){
                $arr [] = [
                    'category_id' => $category->id,
                    'category_name' => $category->name_ar,
                ];
            }else{
                $arr [] = [
                    'category_id' => $category->id,
                    'category_name' => $category->name_en,
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
