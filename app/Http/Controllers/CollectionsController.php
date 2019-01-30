<?php

namespace App\Http\Controllers;

use Auth;

use App\User;
use App\Menu;
use App\Mealtime;
use App\Restaurant;
use App\Collection;
use App\MenuCategory;
use App\CollectionItem;
use App\CollectionMenu;
use App\EditingCollection;
use App\CategoryRestaurant;
use App\CollectionCategory;
use App\EditingCollectionItem;
use App\EditingCollectionMenu;
use App\CollectionServiceType;
use App\CollectionUnavailabilityHour;
use App\EditingCollectionServiceType;

use Carbon\Carbon;

use App\Http\Requests\CollectionRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

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
        $data = $request->all();
        $day = Carbon::today()->dayOfWeek;
        $time = Carbon::now()->toTimeString();

        if ($user->admin == 1) {

            $restaurants = Restaurant::where('deleted', 0)->get();

            if ($id) {

                $collections = Collection::where([ ['restaurant_id', $id], ['deleted', 0] ])->with('category', 'serviceType', 'editingCollection', 'unavailabilityHour', 'mealtime');

                if (isset($data['collection_type'])) {
                    $collections->where('category_id', $data['collection_type']);
                }

                if (isset($data['collection_search'])) {
                    $collections->name($data['collection_search']);
                }

                $selectedRestaurant = Restaurant::find($id);
                $collections = $collections->orderBy('approved', 'ASC')->paginate(20);
            }

        } elseif ($user->admin == 2) {

            $collections = Collection::where([ ['restaurant_id', $user->restaurant_id], ['deleted', 0] ])->with('category', 'serviceType', 'editingCollection', 'unavailabilityHour', 'mealtime');

            if (isset($data['collection_type'])) {
                $collections->where('category_id', $data['collection_type']);
            }

            if (isset($data['collection_search'])) {
                $collections->name($data['collection_search']);
            }

            $selectedRestaurant = Restaurant::find($user->restaurant_id);
            $collections = $collections->orderBy('approved', 'ASC')->paginate(20);
        }

        return view('collections.collections', [
            'id' => $id,
            'categories' => $categories,
            'collections' => isset($collections) ? $collections : collect(),
            'restaurants' => isset($restaurants) ? $restaurants : "",
            'selectedRestaurant' => isset($selectedRestaurant) ? $selectedRestaurant : "",
            'user' => $user,
            'time' => $time,
            'day' => $day
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate(['collection_category' => 'required|integer']);
        $user = Auth::user();
        $restaurant_id = $request->input('restaurant_id');
        $categories = CollectionCategory::all();
        if ($user->admin == 2) {
            if($user->restaurant_id != $restaurant_id){
                return redirect()->back();
            }
        }
        $restaurant = Restaurant::find($restaurant_id);
        $categoryRestaurants = CategoryRestaurant::where('restaurant_id', $restaurant->id)->get();
        $menu_categories = MenuCategory::where('restaurant_id', $restaurant->id)->where('deleted', 0)->where('approved', 1)->whereHas('menu', function ($query) {
            $query->where('approved', 1)->where('deleted', 0);
        })->with(['menu' => function ($q) {
            $q->where('approved', 1)->where('deleted', 0);
        }])->get();
        $mealtimes = Mealtime::all();
        $category_id = $request->input('collection_category');
        $collection_category = CollectionCategory::where('id', $category_id)->first();
        $menu_items = Menu::where('restaurant_id', $restaurant->id)->where('approved', 1)->where('deleted', 0)->get();
        if (count($menu_items) > 0) {
            return view('collections.collection_create', [
                'restaurant' => $restaurant,
                'categories' => $categories,
                'categoryRestaurants' => $categoryRestaurants,
                'menu_categories' => $menu_categories,
                'mealtimes' => $mealtimes,
                'collection_category' => $collection_category,
                'menu_items' => $menu_items,
                'user' => $user
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
    public function store(CollectionRequest $request)
    {
        $category = $request->input('category');
        $restaurant_id = $request->input('restaurant');
        $user = Auth::user();

        if ($user->admin == 2) {
            $restaurant_id = $user->restaurant_id;
        }

        $image = $request->file('image');
        $name = 'collection_' . time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('/images');
        $image->move($path, $name);

        $collection = New Collection();
        $collection->restaurant_id = $restaurant_id;
        $collection->notice_period = $request->input('notice_period');
        $collection->category_id = $category;
        $collection->name_en = $request->input('name_en');
        $collection->name_ar = $request->input('name_ar');
        $collection->description_en = $request->input('description_en');
        $collection->description_ar = $request->input('description_ar');

        $collection->image = $name;
        $collection->mealtime_id = $request->input('mealtime');
        $collection->female_caterer_available = $request->input('female_caterer_available');
        $collection->service_provide_en = $request->input('service_provide_en');
        $collection->service_provide_ar = $request->input('service_provide_ar');
        $collection->service_presentation_en = $request->input('service_presentation_en');
        $collection->service_presentation_ar = $request->input('service_presentation_ar');
        $collection->is_available = 1;

        if ($category == 1 || $category == 3) {
            $collection->max_qty = $request->input('max_quantity');
            $collection->min_qty = $request->input('min_quantity');
        }

        if ($category != 4) {
            $collection->price = $request->input('collection_price');
            $collection->min_serve_to_person = $request->input('min_serve_to_person');
            $collection->max_serve_to_person = $request->input('max_serve_to_person');
        }

        if ($category == 2) {
            $collection->allow_person_increase = $request->input('allow_person_increase');
            $collection->setup_time = $request->input('setup_time');
            $collection->max_time = $request->input('max_time');
            $collection->requirements_en = $request->input('requirements_en');
            $collection->requirements_ar = $request->input('requirements_ar');
        }

        if ($user->admin == 1) {
            $collection->approved = 1;
        }

        $collection->save();

        $service = $request->input('service_type');

            $categoryRestaurant = CategoryRestaurant::where('category_id', $service)->first();
            $serviceType = new CollectionServiceType();
            $serviceType->collection_id = $collection->id;
            $serviceType->service_type_id = $service;
            $serviceType->name_en = $categoryRestaurant->name_en;
            $serviceType->name_ar = $categoryRestaurant->name_ar;
            $serviceType->save();


        if ($collection->category_id == 1) {
            foreach ($request['menu'] as $menu_item) {
                $collection_item = new CollectionItem();
                $collection_item->item_id = $menu_item['id'];
                $collection_item->quantity = $menu_item['qty'];
                $collection_item->collection_id = $collection->id;
                $collection_item->save();
            }
        } else {

            $menus = $request->input('menu');
            foreach ($menus as $menu) {

                if (array_key_exists('item', $menu)) {
                    $collection_menu = new CollectionMenu();
                    $collection_menu->collection_id = $collection->id;
                    $collection_menu->menu_id = $menu['menu_id'];

                    if ($collection->category_id != 4) {
                        $collection_menu->min_qty = $menu['min_qty'];
                        $collection_menu->max_qty = $menu['max_qty'];
                    }

                    $collection_menu->save();

                    foreach ($menu['item'] as $menu_item) {
                        $collection_item = new CollectionItem();
                        $collection_item->item_id = $menu_item['item_id'];

                        if ($collection->category_id != 4) {
                            $collection_item->is_mandatory = $menu_item['is_mandatory'];
                        }

                        $collection_item->collection_menu_id = $collection_menu->id;
                        $collection_item->collection_id = $collection->id;
                        $collection_item->quantity = 1;
                        $collection_item->save();
                    }
                }
            }
        }

        // $categoryRestaurant = CategoryRestaurant::where('category_id', $request->input('service_type'))->first();

        return redirect('/collections/' . $restaurant_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            Collection::where('id', $id)->update(['approved' => 1]);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function reject($id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            Collection::where('id', $id)->update(['approved' => 2]);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function editAvailability($id)
    {
        $user = Auth::user();
        $collection = Collection::find($id);
        if ($user->admin == 2) {
            $collection = Collection::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if (!$collection) {
                return redirect()->back();
            }
        }
        $unavailability = CollectionUnavailabilityHour::where('collection_id', $collection->id)->first();
        $hours = CollectionUnavailabilityHour::where('collection_id', $collection->id)->get();
        $week = [];
        if (count($hours) > 0) {
            foreach ($hours as $key => $value) {
                $week[$value->weekday] = [];
            }
        }
        return view('collections.collection_availability_edit', [
            'collection' => $collection,
            'user' => $user,
            'hours' => $hours,
            'unavailability' => $unavailability,
            'week' => collect($week)
        ]);
    }

    public function updateAvailability(CollectionRequest $request, $id)
    {
        $user = Auth::user();
        $collection = Collection::find($id);
        if ($user->admin == 2) {
            $collection = Collection::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if (!$collection) {
                return redirect()->back();
            }
        }
        if ($request->input('is_available') == 0) {
            CollectionUnavailabilityHour::where('collection_id', $id)->delete();
            if ($request->input('type') == '24_7') {
                $hour = new CollectionUnavailabilityHour();
                $hour->type = $request->input('type');
                $hour->status = 0;
                $hour->collection_id = $collection->id;
                $hour->save();
                Collection::where('id', $collection->id)->update(['is_available' => 0]);
            } elseif ($request->input('type') == 'daily') {
                Collection::where('id', $collection->id)->update(['is_available' => 1]);
                $days = $request->input('daily_days');
                if ($days) {
                    foreach ($days as $day) {
                        $daily = $request->input('daily_hours');
                        $hour = new CollectionUnavailabilityHour();
                        $hour->weekday = $day;
                        $hour->collection_id = $collection->id;
                        $hour->type = $request->input('type');
                        $hour->status = 1;
                        $hour->start_time = Carbon::parse($daily['start']);
                        $hour->end_time = Carbon::parse($daily['end']);
                        $hour->save();
                    }
                }
            } elseif ($request->input('type') == 'flexible') {
                Collection::where('id', $collection->id)->update(['is_available' => 1]);
                foreach ($request->input('flexible_hours') as $flexible) {
                    $hour = new CollectionUnavailabilityHour();
                    $hour->weekday = $flexible['day'];
                    $hour->collection_id = $collection->id;
                    $hour->type = $request->input('type');
                    $hour->status = $flexible['status'];
                    $hour->start_time = Carbon::parse($flexible['start']);
                    $hour->end_time = Carbon::parse($flexible['end']);
                    $hour->save();
                }
            }
        } else {
            CollectionUnavailabilityHour::where('collection_id', $id)->delete();
            Collection::where('id', $collection->id)->update(['is_available' => 1]);
        }
        return redirect('/collections/' . $collection->restaurant_id);
    }

    public function edit($id)
    {
        $user = Auth::user();
        $collection = Collection::find($id);
        $restaurant = Restaurant::where('id', $collection->restaurant_id)->first();

        if ($user->admin == 2) {

            $collection = Collection::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            $restaurant = Restaurant::where('id', $user->restaurant_id)->first();

            if (!$collection) {
                return redirect()->back();
            }
        }

        if ($user->admin == 1 && $collection->editingCollection !== null) {
            $editingCollection = $collection->editingCollection;
            $restaurant = Restaurant::where('id', $collection->restaurant_id)->first();
            $collection_menus = CollectionMenu::where('collection_id', $collection->id)->with(['collectionItem' => function ($query) use ($collection) {
                $query->where('collection_id', $collection->id);
            }])->whereHas('collectionItem', function ($q) use ($collection) {
                $q->where('collection_id', $collection->id);
            })->get();
            $editingCollectionMenus = EditingCollectionMenu::where('editing_collection_id', $editingCollection->id)->with(['editingCollectionItem' => function ($query) use ($editingCollection) {
                $query->where('editing_collection_id', $editingCollection->id);
            }])->whereHas('editingCollectionItem', function ($q) use ($editingCollection) {
                $q->where('editing_collection_id', $editingCollection->id);
            })->get();
            $menu_categories = MenuCategory::where('restaurant_id', $restaurant->id)->where('approved', 1)->where('deleted', 0)->whereHas('menu', function ($query) {
                $query->where('approved', 1)->where('deleted', 0);
            })->with(['menu' => function ($q) {
                $q->where('approved', 1)->where('deleted', 0);
            }])->get();
            $menu_items = CollectionItem::where('collection_id', $collection->id)->get();
            $editingMenuItems = EditingCollectionItem::where('editing_collection_id', $editingCollection->id)->get();
            $categories = CollectionCategory::all();
            $mealtimes = Mealtime::all();
            $categoryRestaurants = CategoryRestaurant::where('restaurant_id', $restaurant->id)->get();

//            $serviceTypes = $editingCollection->serviceType->where('deleted', 0);
//
//            $service = [];
//            if (count($serviceTypes) > 0) {
//                foreach ($serviceTypes as $serviceType) {
//                    $service[$serviceType->service_type_id] = [];
//                }
//            }

            return view('collections.collection_edit_approve', [
                'collection' => $collection,
                'editingCollection' => $editingCollection,
                'categories' => $categories,
//                'service' => collect($service),
                'menu_categories' => $menu_categories,
                'mealtimes' => $mealtimes,
                'collection_menus' => $collection_menus,
                'editingCollectionMenus' => $editingCollectionMenus,
                'menu_items' => $menu_items,
                'editingMenuItems' => $editingMenuItems,
                'categoryRestaurants' => $categoryRestaurants,
                'user' => $user
            ]);
        }

        $collection_menus = CollectionMenu::where('collection_id', $collection->id)->with(['collectionItem' => function ($query) use ($collection) {
            $query->where('collection_id', $collection->id);
        }])->whereHas('collectionItem', function ($q) use ($collection) {
            $q->where('collection_id', $collection->id);
        })->get();
        $menu_categories = MenuCategory::where('restaurant_id', $restaurant->id)->where('approved', 1)->where('deleted', 0)->whereHas('menu', function ($query) {
            $query->where('approved', 1)->where('deleted', 0);
        })->with(['menu' => function ($q) {
            $q->where('approved', 1)->where('deleted', 0);
        }])->get();
        $menu_items = CollectionItem::where('collection_id', $collection->id)->get();
        $categories = CollectionCategory::all();
        $mealtimes = Mealtime::all();
        $categoryRestaurants = CategoryRestaurant::where('restaurant_id', $restaurant->id)->get();

//        $serviceTypes = $collection->serviceType->where('deleted', 0);
//
//        $service = [];
//        if (count($serviceTypes) > 0) {
//            foreach ($serviceTypes as $serviceType) {
//                $service[$serviceType->service_type_id] = [];
//            }
//        }

        $items = [];
        if (count($menu_items) > 0) {
            foreach ($menu_items as $menu_item) {
                $items[$menu_item->item_id] = [];
            }
        }

        return view('collections.collection_edit', [
            'collection' => $collection,
//            'service' => collect($service),
            'items' => collect($items),
            'categories' => $categories,
            'menu_categories' => $menu_categories,
            'mealtimes' => $mealtimes,
            'collection_menus' => $collection_menus,
            'menu_items' => $menu_items,
            'categoryRestaurants' => $categoryRestaurants,
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
    public function update(CollectionRequest $request, $id)
    {
        $user = Auth::user();
        $collection = Collection::find($id);
        if ($user->admin == 2) {
            $collection = Collection::where('id', $id)->where('restaurant_id', $user->restaurant_id)->with('restaurant.menu')->first();
            if (!$collection) {
                return redirect('/collections/');
            }
        }
        if ($user->admin == 2) {
            $oldEditingCollection = EditingCollection::where('collection_id', $id)->first();
            if ($oldEditingCollection) {
                if ($oldEditingCollection->image) {
                    File::delete(public_path('images/' . $oldEditingCollection->image));
                }
                EditingCollection::where('collection_id', $id)->delete();
            }
            $editingCollection = new EditingCollection();
            $editingCollection->collection_id = $collection->id;
            $editingCollection->notice_period = $request->input('notice_period');
            $editingCollection->name_en = $request->input('name_en');
            $editingCollection->name_ar = $request->input('name_ar');
            $editingCollection->description_en = $request->input('description_en');
            $editingCollection->description_ar = $request->input('description_ar');
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = 'collection_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('/images');
                $image->move($path, $name);
                $editingCollection->image = $name;
            }
            $editingCollection->mealtime_id = $request->input('mealtime');
            $editingCollection->female_caterer_available = $request->input('female_caterer_available');
            $editingCollection->service_provide_en = $request->input('service_provide_en');
            $editingCollection->service_provide_ar = $request->input('service_provide_ar');
            $editingCollection->service_presentation_en = $request->input('service_presentation_en');
            $editingCollection->service_presentation_ar = $request->input('service_presentation_ar');
            if ($collection->category_id == 1 || $collection->category_id == 3) {
                $editingCollection->max_qty = $request->input('max_quantity');
                $editingCollection->min_qty = $request->input('min_quantity');
            }
            if ($collection->category_id != 4) {
                $editingCollection->price = $request->input('collection_price');
                $editingCollection->min_serve_to_person = $request->input('min_serve_to_person');
                $editingCollection->max_serve_to_person = $request->input('max_serve_to_person');
            }
            if ($collection->category_id == 2) {
                $editingCollection->allow_person_increase = $request->input('allow_person_increase');
                $editingCollection->setup_time = $request->input('setup_time');
                $editingCollection->max_time = $request->input('max_time');
                $editingCollection->requirements_en = $request->input('requirements_en');
                $editingCollection->requirements_ar = $request->input('requirements_ar');
            }
            $editingCollection->save();


//            $services = $request->input('service_type');
//
//            foreach($services as $service){
//                $categoryRestaurant = CategoryRestaurant::where('category_id', $service)->first();
//                $serviceType = new EditingCollectionServiceType();
//                $serviceType->editing_collection_id = $editingCollection->id;
//                $serviceType->service_type_id = $service;
//                $serviceType->name_en = $categoryRestaurant->name_en;
//                $serviceType->name_ar = $categoryRestaurant->name_ar;
//                $serviceType->save();
//
//            }

            if ($request->has('menu')) {
                if ($collection->category_id == 1) {
                    foreach ($request['menu'] as $menu_item) {
                        $editingCollectionItem = new EditingCollectionItem();
                        $editingCollectionItem->item_id = $menu_item['id'];
                        $editingCollectionItem->quantity = $menu_item['qty'];
                        $editingCollectionItem->editing_collection_id = $editingCollection->id;
                        $editingCollectionItem->save();
                    }
                } else {

                    $menus = $request->input('menu');
                    foreach ($menus as $menu) {

                        if( array_key_exists('item', $menu)){
                            $editingCollectionMenu = new EditingCollectionMenu();
                            $editingCollectionMenu->editing_collection_id = $editingCollection->id;
                            $editingCollectionMenu->menu_id = $menu['menu_id'];
                            if ($collection->category_id != 4) {
                                $editingCollectionMenu->min_qty = $menu['min_qty'];
                                $editingCollectionMenu->max_qty = $menu['max_qty'];
                            }
                            $editingCollectionMenu->save();

                            foreach ($menu['item'] as $menu_item) {
                                $editingCollectionItem = new EditingCollectionItem();
                                $editingCollectionItem->item_id = $menu_item['item_id'];
                                if ($collection->category_id != 4) {
                                    $editingCollectionItem->is_mandatory = $menu_item['is_mandatory'];
                                }
                                $editingCollectionItem->collection_menu_id = $editingCollectionMenu->id;
                                $editingCollectionItem->editing_collection_id = $editingCollection->id;
                                $editingCollectionItem->quantity = 1;
                                $editingCollectionItem->save();
                            }
                        }
                    }


                }
            }
        } elseif ($user->admin == 1) {

            $collection->notice_period = $request->input('notice_period');
            $collection->name_en = $request->input('name_en');
            $collection->name_ar = $request->input('name_ar');
            $collection->description_en = $request->input('description_en');
            $collection->description_ar = $request->input('description_ar');
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = 'collection_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('/images');
                $image->move($path, $name);
                $collection->image = $name;
            }
            $collection->mealtime_id = $request->input('mealtime');
            $collection->female_caterer_available = $request->input('female_caterer_available');
            $collection->service_provide_en = $request->input('service_provide_en');
            $collection->service_provide_ar = $request->input('service_provide_ar');
            $collection->service_presentation_en = $request->input('service_presentation_en');
            $collection->service_presentation_ar = $request->input('service_presentation_ar');
            if ($collection->category_id == 1 || $collection->category_id == 3) {
                $collection->max_qty = $request->input('max_quantity');
                $collection->min_qty = $request->input('min_quantity');
            }
            if ($collection->category_id != 4) {
                $collection->price = $request->input('collection_price');
                $collection->min_serve_to_person = $request->input('min_serve_to_person');
                $collection->max_serve_to_person = $request->input('max_serve_to_person');
            }
            if ($collection->category_id == 2) {
                // $collection->persons_max_count = $request->input('persons_max_count');
                $collection->allow_person_increase = $request->input('allow_person_increase');
                $collection->setup_time = $request->input('setup_time');
                $collection->max_time = $request->input('max_time');
                $collection->requirements_en = $request->input('requirements_en');
                $collection->requirements_ar = $request->input('requirements_ar');
            }
            $collection->approved = 1;
            $collection->save();

//            $serviceTypes = $request->input('service_type');
//            if ($serviceTypes) {
//                CollectionServiceType::where('collection_id', $collection->id)->whereNotIn('service_type_id', $serviceTypes)->update(['deleted' => 1]);
//                foreach ($serviceTypes as $serviceType) {
//                    $service = CategoryRestaurant::where('category_id', $serviceType)->first();
//                    $collectionService = CollectionServiceType::updateOrCreate(
//                        ['service_type_id' => $serviceType, 'collection_id' => $collection->id],
//                        ['name_en' => $service->name_en, 'name_ar' => $service->name_ar, 'deleted' => 0]
//                    );
//                }
//            }

            if ($request->has('menu')) {
                CollectionItem::where('collection_id', $collection->id)->delete();
                CollectionMenu::where('collection_id', $collection->id)->delete();
                if ($collection->category_id == 1) {
                    foreach ($request['menu'] as $menu_item) {
                        $collection_item = new CollectionItem();
                        $collection_item->item_id = $menu_item['id'];
                        $collection_item->quantity = $menu_item['qty'];
                        $collection_item->collection_id = $collection->id;
                        $collection_item->save();
                    }
                } else {
                    $menus = $request->input('menu');
                    foreach ($menus as $menu) {

                        if( array_key_exists('item', $menu)){
                            $collection_menu = new CollectionMenu();
                            $collection_menu->collection_id = $collection->id;
                            $collection_menu->menu_id = $menu['menu_id'];
                            if ($collection->category_id != 4) {
                                $collection_menu->min_qty = $menu['min_qty'];
                                $collection_menu->max_qty = $menu['max_qty'];
                            }
                            $collection_menu->save();

                            foreach ($menu['item'] as $menu_item) {
                                $collection_item = new CollectionItem();
                                $collection_item->item_id = $menu_item['item_id'];
                                if ($collection->category_id != 4) {
                                    $collection_item->is_mandatory = $menu_item['is_mandatory'];
                                }
                                $collection_item->collection_menu_id = $collection_menu->id;
                                $collection_item->collection_id = $collection->id;
                                $collection_item->quantity = 1;
                                $collection_item->save();
                            }
                        }
                    }
                }
            }
        }
        return redirect('/collections/' . $collection->restaurant_id);
    }

    public function editApprove(CollectionRequest $request, $id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $restaurant_id = $request->input('restaurant');
            $collection = Collection::find($id);
            $collection->notice_period = $request->input('notice_period');
            $editingCollection = EditingCollection::where('collection_id', $id)->first();
            $collection->restaurant_id = $restaurant_id;
            $collection->name_en = $request->input('name_en');
            $collection->name_ar = $request->input('name_ar');
            $collection->description_en = $request->input('description_en');
            $collection->description_ar = $request->input('description_ar');
            if ($editingCollection->image) {
                $collection->image = $editingCollection->image;
            }
            $collection->mealtime_id = $request->input('mealtime');
            $collection->female_caterer_available = $request->input('female_caterer_available');
            $collection->service_provide_en = $request->input('service_provide_en');
            $collection->service_provide_ar = $request->input('service_provide_ar');
            $collection->service_presentation_en = $request->input('service_presentation_en');
            $collection->service_presentation_ar = $request->input('service_presentation_ar');
            if ($collection->category_id == 1 || $collection->category_id == 3) {
                $collection->max_qty = $request->input('max_quantity');
                $collection->min_qty = $request->input('min_quantity');
            }
            if ($collection->category_id != 4) {
                $collection->price = $request->input('collection_price');
                $collection->min_serve_to_person = $request->input('min_serve_to_person');
                $collection->max_serve_to_person = $request->input('max_serve_to_person');
            }
            if ($collection->category_id == 2) {
                $collection->allow_person_increase = $request->input('allow_person_increase');
                $collection->setup_time = $request->input('setup_time');
                $collection->max_time = $request->input('max_time');
                $collection->requirements_en = $request->input('requirements_en');
                $collection->requirements_ar = $request->input('requirements_ar');
            }
            $collection->approved = 1;
            $collection->save();

//            $serviceTypes = $request->input('service_type');
//            if ($serviceTypes) {
//                CollectionServiceType::where('collection_id', $collection->id)->whereNotIn('service_type_id', $serviceTypes)->update(['deleted' => 1]);
//                foreach ($serviceTypes as $serviceType) {
//                    $service = CategoryRestaurant::where('category_id', $serviceType)->first();
//                    $collectionService = CollectionServiceType::updateOrCreate(
//                        ['service_type_id' => $serviceType, 'collection_id' => $collection->id],
//                        ['name_en' => $service->name_en, 'name_ar' => $service->name_ar, 'deleted' => 0]
//                    );
//                }
//            }

            $menu_items = EditingCollectionItem::where('editing_collection_id', $editingCollection->id)->get();
            if (count($menu_items) > 0) {
                CollectionItem::where('collection_id', $collection->id)->delete();
                if ($collection->category_id == 1) {
                    foreach ($menu_items as $menu_item) {
                        $collection_item = new CollectionItem();
                        $collection_item->item_id = $menu_item->item_id;
                        $collection_item->quantity = $menu_item->quantity;
                        $collection_item->collection_id = $collection->id;
                        $collection_item->save();
                    }
                } else {
                    foreach ($menu_items as $menu_item) {
                        $collection_item = new CollectionItem();
                        $collection_item->item_id = $menu_item->item_id;
                        $collection_item->is_mandatory = $menu_item->is_mandatory;
                        $collection_item->collection_menu_id = $menu_item->collection_menu_id;
                        $collection_item->collection_id = $collection->id;
                        $collection_item->quantity = 1;
                        $collection_item->save();
                    }
                    CollectionMenu::where('collection_id', $collection->id)->delete();
                    $menus = EditingCollectionMenu::where('editing_collection_id', $editingCollection->id)->get();
                    foreach ($menus as $menu) {
                        $collection_menu = new CollectionMenu();
                        $collection_menu->collection_id = $collection->id;
                        $collection_menu->menu_id = $menu->menu_id;
                        if ($collection->category_id != 4) {
                            $collection_menu->min_qty = $menu->min_qty;
                            $collection_menu->max_qty = $menu->max_qty;
                        }
                        $collection_menu->save();
                    }
                }
            }
            EditingCollection::where('collection_id', $id)->delete();
            return redirect('/collections/' . $collection->restaurant_id);
        } else {
            return redirect()->back();
        }
    }

    public function editReject($id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $editingCollections = EditingCollection::where('collection_id', $id)->get();
            $collection = Collection::find($id);
            $collection_images = [];
            foreach ($editingCollections as $editingCollection) {
                $collection_images[] = public_path('images/' . $editingCollection->image);
            }
            File::delete($collection_images);
            EditingCollection::where('collection_id', $id)->delete();
            return redirect('/collections/' . $collection->restaurant_id);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCollection(Request $request)
    {
        $user = Auth::user();
        $id = $request->get('id');
        if ($user->admin == 2) {
            $subCollection = Collection::whereIn('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if ($subCollection) {
                Collection::whereIn('id', $id)->update(['deleted' => 1]);
            } else {
                return redirect()->back();
            }
        } else {
            Collection::whereIn('id', $id)->update(['deleted' => 1]);
        }

        Restaurant::whereDoesntHave('collection', function ($query){
            $query->where('deleted', 0);
        })->update(['active' => 0]);

        return redirect('/collections');
    }

    public function getEditedFields(Request $request)
    {
        // \DB::enableQueryLog();
        // dd(\DB::getQueryLog());
        $id = $request->id;

        $editedCollection = EditingCollection::with('editingCollectionItem', 'collection.collectionItem')->find($id);

        // $editedCollectionItems = EditingCollectionItem::where('editing_collection_id', $editedCollection->id)->get();

        if (!is_null($editedCollection)) {

            // $oldCollectionItems = $editedCollection->collection->collectionItem->toArray();
            // $newCollectionItems = $editedCollection->editingCollectionItem->toArray();
            // dd($oldCollectionItems, $newCollectionItems);

            $oldCollection = $editedCollection->collection->toArray();
            $newCollection = $editedCollection->toArray();

            $oldCollection = array_except($oldCollection, [ 'id', 'restaurant_id', 'category_id', 'is_available', 'approved', 'created_at', 'updated_at', 'deleted' ]);
            $newCollection = array_except($newCollection, [ 'id', 'collection_id', 'service_type_id', 'is_available', 'created_at', 'updated_at', 'collection' ]);

            // $arr1 = array_diff($oldCollection, $newCollection);
            // $arr2 = array_diff($newCollection, $oldCollection);

            // if (!isset($arr2['image'])) {
            //     unset($arr1['image']);
            // }

            $data = [];

            // dd($arr1, $arr2);

            $html = view('collections.editing_collection', $data)->render();
            return response()->json([ 'success' => true, 'html' => $html ]);
        } else {

            return response()->json([ 'success' => false ]);
        }
    }
}
