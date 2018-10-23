<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionRequest;
use App\MenuCategory;
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
    public function index(Request $request, $id = null)
    {
        $user = Auth::user();
        $categories = CollectionCategory::all();
        $restaurants = Restaurant::all();
        $data = $request->all();
        $collections = [];
        $selectedRestaurant = [];
        if ($id) {
            $collections = Collection::where('restaurant_id', $id)
                ->with(['category', 'collectionItem.menu']);
            if (isset($data['collection_type'])) {
                $collections = $collections->where('category_id', $data['collection_type']);

            }
            if (isset($data['collection_search'])) {
                $collections = $collections->where('name_en', 'like', $data['collection_search'])
                    ->orWhere('price', 'like', $data['collection_search']);
            }
            $selectedRestaurant = Restaurant::find($id);
            $collections = $collections->paginate(20);
        }
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $collections = Collection::where('restaurant_id', $restaurant->id);
            if (isset($data['collection_type'])) {
                $collections = $collections->where('category_id', $data['collection_type']);

            }
            if (isset($data['collection_search'])) {
                $collections = $collections->where('name_en', 'like', $data['collection_search'])
                    ->orWhere('price', 'like', $data['collection_search'])
                    ->orWhere('mealtime_id', 'like', $data['collection_search']);
            }
            $selectedRestaurant = Restaurant::find($restaurant->id);
            $collections = $collections->paginate(20);
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
        $request->validate([
            'collection_category' => 'required|integer',
        ]);
        $user = Auth::user();
        $restaurant = Restaurant::where('id', $id)->first();
        $categories = CollectionCategory::all();
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
        }
        $menu_categories = MenuCategory::where('restaurant_id', $restaurant->id)->wherehas('menu')->get();
        $mealtimes = Mealtime::all();
        $category_id = $request->input('collection_category');
        $collection_category = CollectionCategory::where('id', $category_id)->first();
        $menu_items = Menu::where('restaurant_id', $restaurant->id)->get();
        if (count($menu_items) > 0) {
            return view('collection_create', [
                'restaurant' => $restaurant,
                'categories' => $categories,
                'menu_categories' => $menu_categories,
                'mealtimes' => $mealtimes,
                'collection_category' => $collection_category,
            ]);
        } else {
            return redirect('/menus/' . $restaurant->id);
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
            'service_provide_en' => 'required|string',
            'service_provide_ar' => 'required|string',
            'service_presentation_en' => 'required|string',
            'service_presentation_ar' => 'required|string',
            'menu_item' => 'required|array',
        ]);
        $category = $request->input('category');
        $user = Auth::user();
        $collection = New Collection();
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $restaurant_id = $restaurant->id;
        }
        $collection->restaurant_id = $restaurant_id;
        $collection->category_id = $category;
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
        $collection->is_available = $request->input('is_available');
        if ($category == 1 || $category == 3) {
            $request->validate([
                'min_quantity' => 'required|integer',
                'max_quantity' => 'required|integer',
            ]);
            $collection->max_qty = $request->input('max_quantity');
            $collection->min_qty = $request->input('min_quantity');
        }
        if ($category != 4) {
            $request->validate([
                'collection_price' => 'required|numeric',
                'min_serve_to_person' => 'required|integer',
                'max_serve_to_person' => 'required|integer',
            ]);
            $collection->price = $request->input('collection_price');
            $collection->min_serve_to_person = $request->input('min_serve_to_person');
            $collection->max_serve_to_person = $request->input('max_serve_to_person');
        }
        if ($category == 2) {
            $request->validate([
                'persons_max_count' => 'required|integer',
                'setup_time' => 'required|integer',
                'max_time' => 'required|integer',
                'requirements_en' => 'required|string|max:255',
                'requirements_ar' => 'required|string|max:255',
            ]);
            $collection->persons_max_count = $request->input('persons_max_count');
            $collection->allow_person_increase = $request->input('allow_person_increase');
            $collection->setup_time = $request->input('setup_time');
            $collection->max_time = $request->input('max_time');
            $collection->requirements_en = $request->input('requirements_en');
            $collection->requirements_ar = $request->input('requirements_ar');
        }
        $collection->save();
        if ($collection->category_id == 1) {
            $quantity = array_values(array_filter($request['menu_item_qty']));
            foreach ($request['menu_item'] as $key => $value) {
                $item = $request['menu_item'][$key];
                $collection_item = new CollectionItem();
                $collection_item->item_id = $item;
                if (count($quantity) == count($request['menu_item'])) {
                    $collection_item->quantity = $quantity[$key];;
                } else {
                    $collection_item->quantity = 1;
                }
                $collection_item->collection_id = $collection->id;
                $collection_item->save();
            }
        } else {
            foreach ($request['menu_item'] as $item_key => $item_value) {
                $item = $request['menu_item'][$item_key];
                $collection_item = new CollectionItem();
                $collection_item->item_id = $item;
                $menu_item = Menu::where('id', $item)->first();
                $category = MenuCategory::where('id', $menu_item->category_id)->first();
                $collection_item->collection_menu_id = $category->id;
                $collection_item->collection_id = $collection->id;
                $collection_item->quantity = 1;
                $collection_item->save();
            }
            if ($collection->category_id == 4) {
                foreach ($request['menu'] as $key => $value) {
                    $menu_id = $request['menu'][$key];
                    $collection_menu = new CollectionMenu();
                    $collection_menu->collection_id = $collection->id;
                    $collection_menu->menu_id = $menu_id;
                    $collection_menu->save();
                }
            } else {
                if (isset($request['menu_min_qty']) && isset($request['menu_max_qty'])) {
                    $min_qty = array_values(array_filter($request['menu_min_qty']));
                    $max_qty = array_values(array_filter($request['menu_max_qty']));
                    foreach ($request['menu'] as $key => $value) {
                        $menu_id = $request['menu'][$key];
                        $collection_menu = new CollectionMenu();
                        $collection_menu->collection_id = $collection->id;
                        $collection_menu->menu_id = $menu_id;
                        if (count($min_qty) != count($request['menu'])) {
                            $collection_menu->min_qty = 1;
                            $collection_menu->max_qty = 1;
                        } elseif (count($max_qty) != count($request['menu'])) {
                            $collection_menu->min_qty = 1;
                            $collection_menu->max_qty = 1;
                        } else {
                            $collection_menu->min_qty = $min_qty[$key];
                            $collection_menu->max_qty = $max_qty[$key];
                        }
                        $collection_menu->save();
                    }
                }
            }
        }
        return redirect('/collections/' . $restaurant_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $collection = Collection::where('id', $id)->where('restaurant_id', $restaurant->id)->first();
            if (!$collection) {
                return redirect('/collections');
            }
        } else {
            $collection = Collection::find($id);
            $restaurant = Restaurant::where('id', $collection->restaurant_id)->first();
        }
        $collection_menus = CollectionMenu::where('collection_id', $collection->id)->with(['collectionItem' => function ($query) use ($collection) {
            $query->where('collection_id', $collection->id);
        }])->whereHas('collectionItem', function ($q) use ($collection) {
            $q->where('collection_id', $collection->id);
        })->get();
        $menu_categories = MenuCategory::where('restaurant_id', $restaurant->id)->wherehas('menu')->get();
        $categories = CollectionCategory::all();
        $mealtimes = Mealtime::all();
        return view('collection_edit', [
            'collection' => $collection,
            'categories' => $categories,
            'menu_categories' => $menu_categories,
            'mealtimes' => $mealtimes,
            'collection_menus' => $collection_menus
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
        $request->validate([
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'service_provide_en' => 'required|string',
            'service_provide_ar' => 'required|string',
            'service_presentation_en' => 'required|string',
            'service_presentation_ar' => 'required|string',
        ]);
        $user = Auth::user();
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $restaurant_id = $restaurant->id;
            $collection = Collection::where('id', $id)->where('restaurant_id', $restaurant->id)->with('restaurant.menu')->first();
            if (!$collection) {
                return redirect('/collections');
            }
        } else {
            $collection = Collection::with('restaurant.menu')->find($id);
        }
        if (isset($request['menu_item'])) {
            CollectionItem::where('collection_id', $collection->id)->delete();
            if ($collection->category_id == 1) {
                $quantity = array_values(array_filter($request['menu_item_qty']));
                foreach ($request['menu_item'] as $key => $value) {
                    $item = $request['menu_item'][$key];
                    $collection_item = new CollectionItem();
                    $collection_item->item_id = $item;
                    if (count($quantity) == count($request['menu_item'])) {
                        $collection_item->quantity = $quantity[$key];;
                    } else {
                        $collection_item->quantity = 1;
                    }
                    $collection_item->collection_id = $collection->id;
                    $collection_item->save();
                }
            } else {
                foreach ($request['menu_item'] as $item_key => $item_value) {
                    $item = $request['menu_item'][$item_key];
                    $collection_item = new CollectionItem();
                    $collection_item->item_id = $item;
                    $menu_item = Menu::where('id', $item)->first();
                    $category = MenuCategory::where('id', $menu_item->category_id)->first();
                    $collection_item->collection_menu_id = $category->id;
                    $collection_item->collection_id = $collection->id;
                    $collection_item->quantity = 1;
                    $collection_item->save();
                }
                CollectionMenu::where('collection_id', $collection->id)->delete();
                if ($collection->category_id == 4) {
                    foreach ($request['menu'] as $key => $value) {
                        $menu_id = $request['menu'][$key];
                        $collection_menu = new CollectionMenu();
                        $collection_menu->collection_id = $collection->id;
                        $collection_menu->menu_id = $menu_id;
                        $collection_menu->save();
                    }
                } else {
                    if (isset($request['menu_min_qty']) && isset($request['menu_max_qty'])) {
                        $min_qty = array_values(array_filter($request['menu_min_qty']));
                        $max_qty = array_values(array_filter($request['menu_max_qty']));
                        foreach ($request['menu'] as $key => $value) {
                            $menu_id = $request['menu'][$key];
                            $collection_menu = new CollectionMenu();
                            $collection_menu->collection_id = $collection->id;
                            $collection_menu->menu_id = $menu_id;
                            if (count($min_qty) != count($request['menu'])) {
                                $collection_menu->min_qty = 1;
                                $collection_menu->max_qty = 1;
                            } elseif (count($max_qty) != count($request['menu'])) {
                                $collection_menu->min_qty = 1;
                                $collection_menu->max_qty = 1;
                            } else {
                                $collection_menu->min_qty = $min_qty[$key];
                                $collection_menu->max_qty = $max_qty[$key];
                            }
                            $collection_menu->save();
                        }
                    }
                }
            }
        }
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

        return redirect('/collections/' . $restaurant_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function deleteCollection(Request $request)
    {
        $user = Auth::user();
        $id = $request->get('id');
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            Collection::whereIn('id', $id)->where('restaurant_id', $restaurant->id)->delete();
        } else {
            Collection::whereIn('id', $id)->delete();
        }
        return redirect('/collections');
    }


}
