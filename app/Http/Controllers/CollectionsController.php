<?php

namespace App\Http\Controllers;

use App\EditingCollection;
use App\EditingCollectionItem;
use App\EditingCollectionMenu;
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
                $collections = $collections->name($data['collection_search']);
            }
            $selectedRestaurant = Restaurant::find($id);
            $collections = $collections->paginate(20);
        }
        if ($user->admin == 2) {
            $collections = Collection::where('restaurant_id', $user->restaurant_id);
            if (isset($data['collection_type'])) {
                $collections = $collections->where('category_id', $data['collection_type']);

            }
            if (isset($data['collection_search'])) {
                $collections = $collections->name($data['collection_search']);
            }
            $selectedRestaurant = Restaurant::find($user->restaurant_id);
            $collections = $collections->paginate(20);
        }
        return view('collections', [
            'id' => $id,
            'categories' => $categories,
            'collections' => $collections,
            'restaurants' => $restaurants,
            'selectedRestaurant' => $selectedRestaurant,
            'user' => $user
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
            $restaurant = Restaurant::where('id', $user->restaurant_id)->first();
        }
        $menu_categories = MenuCategory::where('restaurant_id', $restaurant->id)->whereHas('menu', function ($query){
            $query->where('approved', 1);
        })->with(['menu' => function ($q){
            $q->where('approved', 1);
        }])->get();
        $mealtimes = Mealtime::all();
        $category_id = $request->input('collection_category');
        $collection_category = CollectionCategory::where('id', $category_id)->first();
        $menu_items = Menu::where('restaurant_id', $restaurant->id)->where('approved', 1)->get();
        if (count($menu_items) > 0) {
            return view('collection_create', [
                'restaurant' => $restaurant,
                'categories' => $categories,
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
    public function store(Request $request)
    {
        $user = Auth::user();
        $collection = New Collection();
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $restaurant_id = $user->restaurant_id;
        }
//        dd($request->all());
        $validator = \Validator::make($request->all(), [
            'category' => 'required|integer',
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'service_provide_en' => 'required|string',
            'service_provide_ar' => 'required|string',
            'service_presentation_en' => 'required|string',
            'service_presentation_ar' => 'required|string',
            'menu_item' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $category = $request->input('category');
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
                'max_quantity' => 'required|integer|gte:min_quantity',
            ]);
            $collection->max_qty = $request->input('max_quantity');
            $collection->min_qty = $request->input('min_quantity');
        }
        if ($category != 4) {
            $request->validate([
                'collection_price' => 'required|numeric',
                'min_serve_to_person' => 'required|integer',
                'max_serve_to_person' => 'required|integer|gte:min_serve_to_person',
            ]);
            $collection->price = $request->input('collection_price');
            $collection->min_serve_to_person = $request->input('min_serve_to_person');
            $collection->max_serve_to_person = $request->input('max_serve_to_person');
        }
        if ($category == 2) {
            $request->validate([
//                'persons_max_count' => 'required|integer',
                'setup_time' => 'required|integer',
                'max_time' => 'required|integer|gte:setup_time',
                'requirements_en' => 'required|string',
                'requirements_ar' => 'required|string',
            ]);
//            $collection->persons_max_count = $request->input('persons_max_count');
            $collection->allow_person_increase = $request->input('allow_person_increase');
            $collection->setup_time = $request->input('setup_time');
            $collection->max_time = $request->input('max_time');
            $collection->requirements_en = $request->input('requirements_en');
            $collection->requirements_ar = $request->input('requirements_ar');
        }
        if($user->admin == 1){
            $collection->approved = 1;
        }
        $collection->save();
        if ($collection->category_id == 1) {
            foreach ($request['menu_item'] as $menu_item) {
                $collection_item = new CollectionItem();
                $collection_item->item_id = $menu_item['id'];
                $collection_item->quantity = $menu_item['qty'];
                $collection_item->collection_id = $collection->id;
                $collection_item->save();
            }
        } else {

            foreach ($request['menu_item'] as $menu) {
                $collection_item = new CollectionItem();
                $collection_item->item_id = $menu;
                $menu_item = Menu::where('id', $menu)->first();
                $category = MenuCategory::where('id', $menu_item->category_id)->first();
                $collection_item->collection_menu_id = $category->id;
                $collection_item->collection_id = $collection->id;
                $collection_item->quantity = 1;
                $collection_item->save();
            }
            $menus = $request->input('menu');
            foreach ($menus as $menu) {
                $collection_menu = new CollectionMenu();
                $collection_menu->collection_id = $collection->id;
                $collection_menu->menu_id = $menu['id'];
                if ($collection->category_id != 4) {
                    $collection_menu->min_qty = $menu['min_qty'];
                    $collection_menu->max_qty = $menu['max_qty'];
                }
                $collection_menu->save();
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
    public function approve($id)
    {
        $user = Auth::user();
        if($user->admin ==1){
            Collection::where('id', $id)->update(['approved' => 1]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function reject($id)
    {
        $user = Auth::user();
        if($user->admin ==1){
            Collection::where('id', $id)->update(['approved' => 2]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
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
        $collection = Collection::find($id);
        $restaurant = Restaurant::where('id', $collection->restaurant_id)->first();
        if ($user->admin == 2) {
            $collection = Collection::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            $restaurant = Restaurant::where('id', $user->restaurant_id)->first();
            if (!$collection) {
                return redirect()->back();
            }

        }
        if ($user->admin == 1 && $collection->editingCollection!== null) {
            $collection = $collection->editingCollection;
            $restaurant = Restaurant::where('id', $collection->collection->restaurant_id)->first();
            $collection_menus = EditingCollectionMenu::where('editing_collection_id', $collection->id)->with(['editingCollectionItem' => function ($query) use ($collection) {
                $query->where('editing_collection_id', $collection->id);
            }])->whereHas('editingCollectionItem', function ($q) use ($collection) {
                $q->where('editing_collection_id', $collection->id);
            })->get();
            $menu_categories = MenuCategory::where('restaurant_id', $restaurant->id)->get();
            $menu_items = EditingCollectionItem::where('editing_collection_id', $collection->id)->get();
            $categories = CollectionCategory::all();
            $mealtimes = Mealtime::all();
            return view('collection_edit_approve', [
                'collection' => $collection,
                'categories' => $categories,
                'menu_categories' => $menu_categories,
                'mealtimes' => $mealtimes,
                'collection_menus' => $collection_menus,
                'menu_items' => $menu_items,
                'user' => $user
            ]);
        }
        $collection_menus = CollectionMenu::where('collection_id', $collection->id)->with(['collectionItem' => function ($query) use ($collection) {
            $query->where('collection_id', $collection->id);
        }])->whereHas('collectionItem', function ($q) use ($collection) {
            $q->where('collection_id', $collection->id);
        })->get();
        $menu_categories = MenuCategory::where('restaurant_id', $restaurant->id)->get();
        $menu_items = CollectionItem::where('collection_id', $collection->id)->get();
        $categories = CollectionCategory::all();
        $mealtimes = Mealtime::all();
        return view('collection_edit', [
            'collection' => $collection,
            'categories' => $categories,
            'menu_categories' => $menu_categories,
            'mealtimes' => $mealtimes,
            'collection_menus' => $collection_menus,
            'menu_items' => $menu_items,
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


    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'service_provide_en' => 'required|string',
            'service_provide_ar' => 'required|string',
            'service_presentation_en' => 'required|string',
            'service_presentation_ar' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = Auth::user();
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $restaurant_id = $user->restaurant_id;
            $oldCollection = Collection::where('id', $id)->where('restaurant_id', $user->restaurant_id)->with('restaurant.menu')->first();
            if (!$oldCollection) {
                return redirect('/collections/' .  $restaurant_id);
            }
            EditingCollection::where('collection_id', $id)->delete();
            $collection = new EditingCollection();
            $collection->collection_id = $id;
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
            if ($oldCollection->category_id == 1 || $oldCollection->category_id == 3) {
                $request->validate([
                    'min_quantity' => 'required|integer',
                    'max_quantity' => 'required|integer|gte:min_quantity',
                ]);
                $collection->max_qty = $request->input('max_quantity');
                $collection->min_qty = $request->input('min_quantity');
            }
            if ($oldCollection->category_id != 4) {
                $request->validate([
                    'collection_price' => 'required|numeric',
                    'min_serve_to_person' => 'required|integer',
                    'max_serve_to_person' => 'required|integer|gte:min_serve_to_person',
                ]);
                $collection->price = $request->input('collection_price');
                $collection->min_serve_to_person = $request->input('min_serve_to_person');
                $collection->max_serve_to_person = $request->input('max_serve_to_person');
            }
            if ($oldCollection->category_id == 2) {
                $request->validate([
                    'setup_time' => 'required|integer',
                    'max_time' => 'required|integer|gte:setup_time',
                    'requirements_en' => 'required|string|max:255',
                    'requirements_ar' => 'required|string|max:255',
                ]);
                $collection->allow_person_increase = $request->input('allow_person_increase');
                $collection->setup_time = $request->input('setup_time');
                $collection->max_time = $request->input('max_time');
                $collection->requirements_en = $request->input('requirements_en');
                $collection->requirements_ar = $request->input('requirements_ar');
            }
            $collection->save();
            if ($oldCollection->category_id == 1) {
                foreach ($request['menu_item'] as $menu_item) {
                    $collection_item = new EditingCollectionItem();
                    $collection_item->item_id = $menu_item['id'];
                    $collection_item->quantity = $menu_item['qty'];
                    $collection_item->editing_collection_id = $collection->id;
                    $collection_item->save();
                }
            } else {

                foreach ($request['menu_item'] as $menu) {
                    $collection_item = new EditingCollectionItem();
                    $collection_item->item_id = $menu;
                    $menu_item = Menu::where('id', $menu)->first();
                    $category = MenuCategory::where('id', $menu_item->category_id)->first();
                    $collection_item->collection_menu_id = $category->id;
                    $collection_item->editing_collection_id = $collection->id;
                    $collection_item->quantity = 1;
                    $collection_item->save();
                }
                $menus = $request->input('menu');
                foreach ($menus as $menu) {
                    $collection_menu = new EditingCollectionMenu();
                    $collection_menu->editing_collection_id = $collection->id;
                    $collection_menu->menu_id = $menu['id'];
                    if ($oldCollection->category_id != 4) {
                        $collection_menu->min_qty = $menu['min_qty'];
                        $collection_menu->max_qty = $menu['max_qty'];
                    }
                    $collection_menu->save();
                }
            }
        } elseif($user->admin == 1) {
            $collection = Collection::find($id);
            $collection->restaurant_id = $restaurant_id;
//        $collection->category_id = $category;
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
            if ($collection->category_id == 1 || $collection->category_id == 3) {
                $request->validate([
                    'min_quantity' => 'integer',
                    'max_quantity' => 'integer|gte:min_quantity',
                ]);
                $collection->max_qty = $request->input('max_quantity');
                $collection->min_qty = $request->input('min_quantity');
            }
            if ($collection->category_id != 4) {
                $request->validate([
                    'collection_price' => 'required|numeric',
                    'min_serve_to_person' => 'integer',
                    'max_serve_to_person' => 'integer|gte:min_serve_to_person',
                ]);
                $collection->price = $request->input('collection_price');
                $collection->min_serve_to_person = $request->input('min_serve_to_person');
                $collection->max_serve_to_person = $request->input('max_serve_to_person');
            }
            if ($collection->category_id == 2) {
                $request->validate([
//                'persons_max_count' => 'required|integer',
                    'setup_time' => 'integer',
                    'max_time' => 'integer|gte:setup_time',
                    'requirements_en' => 'string|max:255',
                    'requirements_ar' => 'string|max:255',
                ]);
//            $collection->persons_max_count = $request->input('persons_max_count');
                $collection->allow_person_increase = $request->input('allow_person_increase');
                $collection->setup_time = $request->input('setup_time');
                $collection->max_time = $request->input('max_time');
                $collection->requirements_en = $request->input('requirements_en');
                $collection->requirements_ar = $request->input('requirements_ar');
            }
            $collection->save();
            EditingCollection::where('collection_id', $id)->delete();
            if (isset($request['menu_item'])) {
                CollectionItem::where('collection_id', $collection->id)->delete();
                if ($collection->category_id == 1) {
                    foreach ($request['menu_item'] as $menu_item) {
                        $collection_item = new CollectionItem();
                        $collection_item->item_id = $menu_item['id'];
                        $collection_item->quantity = $menu_item['qty'];
                        $collection_item->collection_id = $collection->id;
                        $collection_item->save();
                    }
                } else {
                    foreach ($request['menu_item'] as $key => $value) {
                        $collection_item = new CollectionItem();
                        $collection_item->item_id = $request['menu_item'][$key];
                        $menu_item = Menu::where('id', $request['menu_item'][$key])->first();
                        $category = MenuCategory::where('id', $menu_item->category_id)->first();
                        $collection_item->collection_menu_id = $category->id;
                        $collection_item->collection_id = $collection->id;
                        $collection_item->quantity = 1;
                        $collection_item->save();
                    }
                    CollectionMenu::where('collection_id', $collection->id)->delete();
                    $menus = $request->input('menu');
                    foreach ($menus as $menu) {
                        $collection_menu = new CollectionMenu();
                        $collection_menu->collection_id = $collection->id;
                        $collection_menu->menu_id = $menu['id'];
                        if ($collection->category_id != 4) {
                            $collection_menu->min_qty = $menu['min_qty'];
                            $collection_menu->max_qty = $menu['max_qty'];
                        }
                        $collection_menu->save();
                    }
                }
                return redirect()->back();
            }
        }


        return redirect('/collections/' . $restaurant_id);
    }

    public function editApprove(Request $request, $id)
    {
        $user = Auth::user();
        if($user->admin ==1){
            $restaurant_id = $request->input('restaurant');
            $collection = Collection::find($id);
            $collection->restaurant_id = $restaurant_id;
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
            if ($collection->category_id == 1 || $collection->category_id == 3) {
                $request->validate([
                    'min_quantity' => 'integer',
                    'max_quantity' => 'integer|gte:min_quantity',
                ]);
                $collection->max_qty = $request->input('max_quantity');
                $collection->min_qty = $request->input('min_quantity');
            }
            if ($collection->category_id != 4) {
                $request->validate([
                    'collection_price' => 'required|numeric',
                    'min_serve_to_person' => 'integer',
                    'max_serve_to_person' => 'integer|gte:min_serve_to_person',
                ]);
                $collection->price = $request->input('collection_price');
                $collection->min_serve_to_person = $request->input('min_serve_to_person');
                $collection->max_serve_to_person = $request->input('max_serve_to_person');
            }
            if ($collection->category_id == 2) {
                $request->validate([
//                'persons_max_count' => 'required|integer',
                    'setup_time' => 'integer',
                    'max_time' => 'integer|gte:setup_time',
                    'requirements_en' => 'string|max:255',
                    'requirements_ar' => 'string|max:255',
                ]);
                $collection->allow_person_increase = $request->input('allow_person_increase');
                $collection->setup_time = $request->input('setup_time');
                $collection->max_time = $request->input('max_time');
                $collection->requirements_en = $request->input('requirements_en');
                $collection->requirements_ar = $request->input('requirements_ar');
            }
            $collection->save();
            CollectionItem::where('collection_id', $collection->id)->delete();
             $menu_items = EditingCollectionItem::where('editing_collection_id', $collection->editingCollection->id)->get();
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
                        $collection_item->collection_menu_id =  $menu_item->collection_menu_id;
                        $collection_item->collection_id = $collection->id;
                        $collection_item->quantity = 1;
                        $collection_item->save();
                    }
                    CollectionMenu::where('collection_id', $collection->id)->delete();
                    $menus = EditingCollectionMenu::where('editing_collection_id', $collection->editingCollection->id)->get();
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
            EditingCollection::where('collection_id', $id)->delete();
            return redirect('/collections/' . $collection->restaurant_id);
        }else{
            return redirect()->back();
        }
    }

    public function editReject($id)
    {
        $user = Auth::user();
        if($user->admin ==1){
            $collection = Collection::find($id);
            EditingCollection::where('collection_id', $id)->delete();
            return redirect('/collections/' . $collection->restaurant_id);
        }else{
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
            $collection = Collection::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if($collection){
                Collection::whereIn('id', $id)->delete();
            }else{
                return redirect()->back();
            }
        } else {
            Collection::whereIn('id', $id)->delete();
        }
        return redirect('/collections');
    }


}
