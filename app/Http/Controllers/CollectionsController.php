<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionRequest;
use App\Category;
use App\CollectionItem;
use Illuminate\Http\Request;
use App\Collection;
use App\Restaurant;
use App\CollectionCategory;
use App\Menu;
use Carbon\Carbon;
use Auth;
use App\User;

class CollectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id=null)
    {
        $user = Auth::user();
        $categories = CollectionCategory::all();
        $restaurants = Restaurant::all();
        $selectedRestaurant = Restaurant::find($id);
        $data = $request->all();
        $collections = [];
        if($id){
            $collections = Collection::where('restaurant_id', $id)
                ->with(['category', 'collectionItem.menu']);
            if(isset($data['collection_type'])){
                $collections = $collections->where('category_id',$data['collection_type']);

            }
            if(isset($data['collection_search'])){
                $collections = $collections->where('name','like',$data['collection_search'])
                    ->orWhere('price','like',$data['collection_search'])
                    ->orWhere('mealtime','like',$data['collection_search']);
            }
            $collections = $collections->get();
        }
        if($user->admin == 2){
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $selectedRestaurant = Restaurant::find($restaurant->id);
            $collections = Collection::where('restaurant_id', $restaurant->id)->get();
        }
        return view('collections', [
            'id' => $id,
            'categories' => $categories,
            'collections' => $collections,
            'restaurants' => $restaurants,
            'selectedRestaurant' => $selectedRestaurant,
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
        $user = Auth::user();
        $menus = [];
        $restaurants = Restaurant::all();
        if(isset($data['restaurant_name'])) {
                $menus = Menu::where('restaurant_id', $data['restaurant_name']);
            if(isset($data['menu_category_name'])) {
                $menus = $menus->where('category_id', $data['menu_category_name']);
            }
            $menus = $menus->get();
        }
        $categories = CollectionCategory::all();
        $menu_categories = Category::all();
        if($user->admin == 2){
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $menus = Menu::where('restaurant_id', $restaurant->id)->get();
        }
        return view('collection_create', [
            'restaurants' => $restaurants,
            'categories' => $categories,
            'menus' => $menus,
            'menu_categories' => $menu_categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollectionRequest $request)
    {
        $user = Auth::user();
        $collection = New Collection();
        $collection->restaurant_id = $request->input('restaurant');
        if($user->admin == 2){
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $collection->restaurant_id = $restaurant->id;
        }
        $collection->category_id = $request->input('category');
        $collection->name = $request->input('name');
        $collection->description = $request->input('description');
        $collection->mealtime = $request->input('mealtime');
        $collection->female_caterer_available = $request->input('female_caterer_available');
        $collection->service_provide = $request->input('service_provide');
        $collection->service_presentation = $request->input('service_presentation');
        $collection->setup_time = $request->input('setup_time');
        $collection->max_time = $request->input('max_time');
        $collection->requirements = $request->input('requirements');
        $collection->is_available = $request->input('is_available');
        $collection->price = $request->input('collection_price');
        $collection->max_qty = $request->input('max_quantity');
        $collection->min_qty = $request->input('min_quantity');
        $collection->persons_max_count = $request->input('persons_max_count');
        $collection->min_serve_to_person = $request->input('min_serve_to_person');
        $collection->max_serve_to_person = $request->input('max_serve_to_person');
        $collection->allow_person_increase = $request->input('allow_person_increase');
        $collection->save();
        $menus = $request->input('menu_item');
        foreach($menus as $menu){
            $collection_item = new CollectionItem();
            $collection_item->item_id = $menu;
            $collection_item->min_count = $request->input('item_qty');
            $collection_item->max_count = $request->input('item_qty');
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
        $menus = $collection->restaurant->menu;
        $categories = CollectionCategory::all();
        return view('collection_edit', [
            'menus' => $menus,
            'collection' => $collection,
            'categories' => $categories,
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
        $collection->category_id = $request->input('category');
        $collection->name = $request->input('name');
        $collection->description = $request->input('description');
        $collection->mealtime = $request->input('mealtime');
        $collection->female_caterer_available = $request->input('female_caterer_available');
        $collection->service_provide = $request->input('service_provide');
        $collection->service_presentation = $request->input('service_presentation');
        $collection->setup_time = $request->input('setup_time');
        $collection->max_time = $request->input('max_time');
        $collection->requirements = $request->input('requirements');
        $collection->is_available = $request->input('is_available');
        $collection->price = $request->input('collection_price');
        $collection->max_qty = $request->input('max_quantity');
        $collection->min_qty = $request->input('min_quantity');
        $collection->persons_max_count = $request->input('persons_max_count');
        $collection->min_serve_to_person = $request->input('min_serve_to_person');
        $collection->max_serve_to_person = $request->input('max_serve_to_person');
        $collection->allow_person_increase = $request->input('allow_person_increase');
        $collection->save();
        $menus = $request->input('menu_item');
        if($menus){
            CollectionItem::where('collection_id', $id)->delete();
            foreach($menus as $menu){
                $collection_item = new CollectionItem();
                $collection_item->item_id = $menu;
                $collection_item->min_count = $request->input('item_qty');
                $collection_item->max_count = $request->input('item_qty');
                $collection_item->collection_id = $collection->id;
                $collection_item->save();
            }
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
