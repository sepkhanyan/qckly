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
use App\CollectionMenu;
use App\Mealtime;

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
        $data = $request->all();
        $collections = [];
        $selectedRestaurant = [];
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
            $selectedRestaurant = Restaurant::find($id);
            $collections = $collections->paginate(20);
        }
        if($user->admin == 2){
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $selectedRestaurant = Restaurant::find($restaurant->id);
            $collections = Collection::where('restaurant_id', $restaurant->id)->paginate(20);
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
    public function create(Request $request, $id = null)
    {
        $user = Auth::user();
        $restaurant = Restaurant::where('id', $id)->first();
        $categories = CollectionCategory::all();
        if($user->admin == 2){
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
        }
        $menu_categories = Category::with(['menu'=> function ($query) use ($restaurant){
            $query->where('restaurant_id', $restaurant->id);
        }])->get();
        $mealtimes = Mealtime::all();
        return view('collection_create', [
            'restaurant' => $restaurant,
            'categories' => $categories,
            'menu_categories' => $menu_categories,
            'mealtimes' => $mealtimes
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
        $collection->name_en = $request->input('name_en');
        $collection->name_ar = $request->input('name_ar');
        $collection->description_en = $request->input('description_en');
        $collection->description_ar = $request->input('description_ar');
        $collection->mealtime_id = $request->input('mealtime');
        $collection->female_caterer_available = $request->input('female_caterer_available');
        $collection->service_provide_en = $request->input('service_provide_en');
        $collection->service_provide_ar = $request->input('service_provide_ar');
        $collection->service_presentation_en = $request->input('service_presentation_en');
        $collection->service_presentation_ar = $request->input('service_presentation_ar');
        $collection->setup_time = $request->input('setup_time');
        $collection->max_time = $request->input('max_time');
        $collection->requirements_en = $request->input('requirements_en');
        $collection->requirements_ar = $request->input('requirements_ar');
        $collection->is_available = $request->input('is_available');
        $collection->price = $request->input('collection_price');
        $collection->max_qty = $request->input('max_quantity');
        $collection->min_qty = $request->input('min_quantity');
        $collection->persons_max_count = $request->input('persons_max_count');
        $collection->min_serve_to_person = $request->input('min_serve_to_person');
        $collection->max_serve_to_person = $request->input('max_serve_to_person');
        $collection->allow_person_increase = $request->input('allow_person_increase');
        $collection->save();
        if($collection->category_id == 1){
            foreach ($request['menu_item'] as $key => $value){
                $item = $request['menu_item'][$key];
                $collection_item = new CollectionItem();
                $collection_item->item_id = $item;
                $collection_item->quantity = 1;
                $collection_item->collection_id = $collection->id;
                $collection_item->save();
            }
        }else{
            foreach($request['menu'] as $key => $value){
                $menu_id = $request['menu'][$key];
                $min_qty = $request['menu_min_qty'][$key];
                $max_qty = $request['menu_max_qty'][$key];
                $collection_menu = new CollectionMenu();
                $collection_menu->collection_id = $collection->id;
                $collection_menu->menu_id = $menu_id;
                $menu = Category::where('id', $menu_id)->first();
                $collection_menu->name = $menu->name_en;
                $collection_menu->min_qty = $min_qty;
                $collection_menu->max_qty = $max_qty;
                $collection_menu->save();
            }
            foreach ($request['menu_item'] as $item_key => $item_value){
                $item = $request['menu_item'][$item_key];
                $collection_item = new CollectionItem();
                $collection_item->item_id = $item;
                $collection_item->quantity = 1;
                $menu_item = Menu::where('id', $item)->first();
                $category = Category::where('id', $menu_item->category_id)->first();
                $collection_item->collection_menu_id = $category->id;
                $collection_item->collection_id = $collection->id;
                $collection_item->save();
            }
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
        $collection = Collection::find($id);
        $restaurant = Restaurant::where('id', $collection->restaurant_id)->first();
        $menu_categories = Category::with(['menu'=> function ($query) use ($restaurant){
                $query->where('restaurant_id', $restaurant->id);
            }])->get();
        $categories = CollectionCategory::all();
        $mealtimes = Mealtime::all();
        return view('collection_edit', [
            'collection' => $collection,
            'categories' => $categories,
            'menu_categories' => $menu_categories,
            'mealtimes' => $mealtimes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CollectionRequest $request, $id)
    {
        $collection = Collection::with('restaurant.menu')->find($id);
        $collection->category_id = $request->input('category');
        $collection->name_en = $request->input('name_en');
        $collection->name_ar = $request->input('name_ar');
        $collection->description_en = $request->input('description_en');
        $collection->description_ar = $request->input('description_ar');
        $collection->mealtime = $request->input('mealtime');
        $collection->female_caterer_available = $request->input('female_caterer_available');
        $collection->service_provide_en = $request->input('service_provide_en');
        $collection->service_provide_ar = $request->input('service_provide_ar');
        $collection->service_presentation_en = $request->input('service_presentation_en');
        $collection->service_presentation_ar = $request->input('service_presentation_ar');
        $collection->setup_time = $request->input('setup_time');
        $collection->max_time = $request->input('max_time');
        $collection->requirements_en = $request->input('requirements_en');
        $collection->requirements_ar = $request->input('requirements_ar');
        $collection->is_available = $request->input('is_available');
        $collection->price = $request->input('collection_price');
        $collection->max_qty = $request->input('max_quantity');
        $collection->min_qty = $request->input('min_quantity');
        $collection->persons_max_count = $request->input('persons_max_count');
        $collection->min_serve_to_person = $request->input('min_serve_to_person');
        $collection->max_serve_to_person = $request->input('max_serve_to_person');
        $collection->allow_person_increase = $request->input('allow_person_increase');
        $collection->save();
        if($collection->category_id == 1){
            if(isset($request['menu_item'])){
                CollectionItem::where('collection_id', $collection->id)->delete();
                foreach ($request['menu_item'] as $key => $value){
                    $item = $request['menu_item'][$key];
                    $collection_item = new CollectionItem();
                    $collection_item->item_id = $item;
                    $collection_item->quantity = 1;
                    $collection_item->collection_id = $collection->id;
                    $collection_item->save();
                }
            }
        }else{
            if(isset($request['menu'])){
                CollectionMenu::where('collection_id', $collection->id)->delete();
                foreach($request['menu'] as $key => $value){
                    $menu_id = $request['menu'][$key];
                    $min_qty = $request['menu_min_qty'][$key];
                    $max_qty = $request['menu_max_qty'][$key];
                    $collection_menu = new CollectionMenu();
                    $collection_menu->collection_id = $collection->id;
                    $collection_menu->menu_id = $menu_id;
                    $menu = Category::where('id', $menu_id)->first();
                    $collection_menu->name = $menu->name_en;
                    $collection_menu->min_qty = $min_qty;
                    $collection_menu->max_qty = $max_qty;
                    $collection_menu->save();
                }
            }
            if(isset($request['menu_item'])){
                CollectionItem::where('collection_id', $collection->id)->delete();
                foreach ($request['menu_item'] as $item_key => $item_value){
                    $item = $request['menu_item'][$item_key];
                    $collection_item = new CollectionItem();
                    $collection_item->item_id = $item;
                    $collection_item->quantity = 1;
                    $menu_item = Menu::where('id', $item)->first();
                    $category = Category::where('id', $menu_item->category_id)->first();
                    $collection_item->collection_menu_id = $category->id;
                    $collection_item->collection_id = $collection->id;
                    $collection_item->save();
                }
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
