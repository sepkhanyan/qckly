<?php

namespace App\Http\Controllers;


use App\Categories;
use App\CollectionItem;
use Illuminate\Http\Request;
use App\Collection;
use App\Restaurant;
use App\MenuSubcategory;
use App\Menus;
use Carbon\Carbon;

class CollectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        $restaurants = Restaurant::all();
        $selectedRestaurant = Restaurant::find($id);
        $collections = [];
        if($id){
            $collections = Collection::where('restaurant_id', $id)
                ->with(['subcategory', 'collectionItem.menu'])->get();

        }
        return view('collections', [
            'collections' => $collections,
            'restaurants' => $restaurants,
            'selectedRestaurant' => $selectedRestaurant
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $menus = [];
        if(isset($data['restaurant_name'])) {
                $menus = Menus::where('restaurant_id', $data['restaurant_name']);
            if(isset($data['category_name'])) {
                $menus = $menus->where('menu_category_id', $data['category_name']);
            }
            $menus = $menus->get();
        }


        $restaurants = Restaurant::all();
        $subcategories = MenuSubcategory::all();
        $categories = Categories::all();
        return view('new_collection', [
            'restaurants' => $restaurants,
            'subcategories' => $subcategories,
            'menus' => $menus,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $collection = New Collection();
        $collection->restaurant_id = $request->input('restaurant_name');
        $collection->subcategory_id = $request->input('subcategory');
        $collection->name = $request->input('name');
        $collection->description = $request->input('description');
        $collection->mealtime = $request->input('mealtime');
        $collection->service_provide = $request->input('service_provide');
        $collection->service_presentation = $request->input('service_presentation');
        $collection->instruction = $request->input('instructions');
        $collection->setup_time = $request->input('setup_time');
        $collection->max_time = $request->input('max_time');
        $collection->requirements = $request->input('requirements');
        $collection->female_caterer_available = $request->input('female_caterer_available');
        $collection->is_available = $request->input('is_available');
        $collection->notes = $request->input('notes');
        $collection->price = $request->input('collection_price');
        $collection->max_qty = $request->input('max_quantity');
        $collection->min_qty = $request->input('min_quantity');
        $collection->save();
        $menus = $request->input('menu_item');
        foreach($menus as $menu){
            $collection_item = new CollectionItem();
            $collection_item->menu_id = $menu;
            $collection_item->min_count = $request->input('item_qty');
            $collection_item->persons = $request->input('persons');
            $collection_item->collection_id = $collection->id;
            $collection_item->save();
        }

        return redirect('/collections');
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

        $collection = Collection::with('restaurant.menu')->find($id);
//        dd($collection->restaurant->menu);
//        dd($collection->restaurant);
//        foreach($collection->restaurant->menu as $menu){
//                dd($menu->category->name);
//            $categories = $menu->category;
//        }
//        $menus = $menu->where('menu_category_id', $menu->category->id)->get();
////        dd();
////        $menus = $collection->restaurant->menu;
////        $data = $request->all();
        $menus = $collection->restaurant->menu;
//        $restaurant = Restaurant::all();
        $subcategories = MenuSubcategory::all();
//        $categories = Categories::all();
        return view('edit_collection', [
            'menus' => $menus,
            'collection' => $collection,
            'subcategories' => $subcategories,
//            'categories' => $categories
        ]);
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
        $collection = Collection::with('restaurant.menu')->find($id);
//        dd($collection->restaurant_id);
//        $collection->restaurant_id = $request->input('restaurant_name');
        $collection->subcategory_id = $request->input('subcategory');
        $collection->name = $request->input('name');
        $collection->description = $request->input('description');
        $collection->mealtime = $request->input('mealtime');
        $collection->service_provide = $request->input('service_provide');
        $collection->service_presentation = $request->input('service_presentation');
        $collection->instruction = $request->input('instructions');
        $collection->setup_time = $request->input('setup_time');
        $collection->max_time = $request->input('max_time');
        $collection->requirements = $request->input('requirements');
        $collection->female_caterer_available = $request->input('female_caterer_available');
        $collection->is_available = $request->input('is_available');
        $collection->notes = $request->input('notes');
        $collection->price = $request->input('collection_price');
        $collection->max_qty = $request->input('max_quantity');
        $collection->min_qty = $request->input('min_quantity');
        $collection->save();
        $menus = $request->input('menu_item');
        foreach($menus as $menu){
            $collection_item = CollectionItem::where('collection_id', $id)->first();
            $collection_item->menu_id = $menu;
            $collection_item->min_count = $request->input('item_qty');
            $collection_item->persons = $request->input('persons');
            $collection_item->collection_id = $collection->id;
            $collection_item->save();
        }





        return redirect('/collections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCollection(Request $request)
    {
        $id = $request->get('id');
        Collection::whereIn('id',$id)->delete();
        return redirect('/collections');
    }


}
