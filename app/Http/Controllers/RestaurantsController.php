<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use Auth;
use Illuminate\Http\Request;
use App\Restaurant;
use App\Areas;
use App\WorkingHours;
use App\Menus;
use App\Categories;
use App\RestaurantCategory;
use App\CategoryRestaurant;
use DB;
use App\Quotation;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class RestaurantsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $restaurants = Restaurant::paginate(20);
        $data = $request->all();
        if(isset($data['restaurant_status'])){
            $restaurants = Restaurant::where('restaurant_status',$data['restaurant_status'])->paginate(20);
        }
        if(isset($data['restaurant_search'])){
            $restaurants = Restaurant::where('restaurant_name','like',$data['restaurant_search'])
                ->orWhere('restaurant_city','like',$data['restaurant_search'])
                ->orWhere('restaurant_postcode','like',$data['restaurant_search'])
                ->orWhere('restaurant_state','like',$data['restaurant_search'])->paginate(20);
        }

        return view('restaurants', ['restaurants' => $restaurants]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Areas::all();
        $categories = RestaurantCategory::all();
        return view('new_restaurant', [
            'areas' => $areas,
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
        $restaurant = new Restaurant();

        $image = $request->file('restaurant_image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $restaurant->restaurant_image = $name;
        $restaurant->restaurant_name = $request->input('restaurant_name');
        $restaurant->restaurant_email = $request->input('email');
        $restaurant->restaurant_telephone = $request->input('telephone');
        $restaurant->female_caterer_available = $request->input('female_caterer_available');
        $address = $request->input('address');
        if($address){
            $restaurant->restaurant_address_1 = $address['address_1'];
            $restaurant->restaurant_address_2 = $address['address_2'];
            $restaurant->restaurant_city = $address['city'];
            $restaurant->restaurant_state = $address['state'];
            $restaurant->restaurant_postcode = $address['postcode'];
            $restaurant->restaurant_country_id = $address['country'];
            $restaurant->restaurant_lat = $address['restaurant_lat'];
            $restaurant->restaurant_lng = $address['restaurant_lng'];
        }
        $restaurant->description = $request->input('description');
        $restaurant->offer_delivery = $request->input('offer_delivery');
        $restaurant->offer_collection = $request->input('offer_collection');
        $restaurant->delivery_time = $request->input('delivery_time');
        $restaurant->last_order_time = $request->input('last_order_time');
        $restaurant->reservation_interval = $request->input('reservation_time_interval');
        $restaurant->reservation_turn = $request->input('reservation_stay_time');
        $restaurant->collection_time = $request->input('collection_time');

        $restaurant->restaurant_status = $request->input('restaurant_status');
        $restaurant->save();
        $categories = $request->input('restaurant_category');
        foreach($categories as $category){
            $restaurantCategories = RestaurantCategory::where('id',$category)->get();
            foreach($restaurantCategories as $restaurantCategory){
               $en = $restaurantCategory->restaurant_category_name_en;
               $ar = $restaurantCategory->restaurant_category_name_ar;
            }
            $categoryRestaurant = new CategoryRestaurant();
            $categoryRestaurant->restaurant_id = $restaurant->id;
            $categoryRestaurant->category_id = $category;
            $categoryRestaurant->category_name_en = $en;
            $categoryRestaurant->category_name_ar = $ar;
            $categoryRestaurant->save();
        }

        $days = $request->input('daily_days');
            foreach($days as $day){
                $working = new WorkingHours();
                $working->type = $request->input('opening_type');
                $working->weekday = $day;
                $working->opening_time = Carbon::parse("11:00 AM");
                $working->closing_time = Carbon::parse("11:59 PM");
                $working->status = 1;
                $working->restaurant_id = $restaurant->id;
                if($working->type == 'daily'){
                    $daily = $request->input('daily_hours');
                    if($daily){
                        $working->opening_time = Carbon::parse($daily['open']);
                        $working->closing_time = Carbon::parse($daily['close']);
                    };
                }
                if($working->type == 'flexible'){
                    $flexible = $request->input('flexible_hours');
                    if($flexible){
                        $working->opening_time = Carbon::parse($flexible[$day]['open']);
                        $working->closing_time = Carbon::parse($flexible[$day]['close']);
                        $working->status = $flexible[$day]['status'];
                    };
                }
                $working->save();
            }


        if ($restaurant) {
            return redirect('/restaurants');
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
        $working = WorkingHours::where('restaurant_id', $id)->first();
        $restaurant = Restaurant::find($id);
        $areas = Areas::all();
        $categories = RestaurantCategory::all();
        return view('restaurant_edit', [
            'restaurant' => $restaurant,
            'areas' => $areas,
            'working' => $working,
            'categories' => $categories
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
        $restaurant = Restaurant::find($id);
        $restaurant->restaurant_name = $request->input('restaurant_name');
        $restaurant->restaurant_email = $request->input('email');
        $restaurant->restaurant_telephone = $request->input('telephone');
        $restaurant->female_caterer_available = $request->input('female_caterer_available');
        $address = $request->input('address');
        if($address){
            $restaurant->restaurant_address_1 = $address['address_1'];
            $restaurant->restaurant_address_2 = $address['address_2'];
            $restaurant->restaurant_city = $address['city'];
            $restaurant->restaurant_state = $address['state'];
            $restaurant->restaurant_postcode = $address['postcode'];
            $restaurant->restaurant_country_id = $address['country'];
            $restaurant->restaurant_lat = $address['restaurant_lat'];
            $restaurant->restaurant_lng = $address['restaurant_lng'];
        }
        $restaurant->description = $request->input('description');
        $restaurant->offer_delivery = $request->input('offer_delivery');
        $restaurant->offer_collection = $request->input('offer_collection');
        $restaurant->delivery_time = $request->input('delivery_time');
        $restaurant->last_order_time = $request->input('last_order_time');
        $restaurant->reservation_interval = $request->input('reservation_time_interval');
        $restaurant->reservation_turn = $request->input('reservation_stay_time');
        $restaurant->collection_time = $request->input('collection_time');
        $restaurant->restaurant_status = $request->input('restaurant_status');
        if ($request->hasFile('restaurant_image')) {
            $deletedImage = File::delete(public_path('images/' . $restaurant->restaurant_image));
            if ($deletedImage) {
                $image = $request->file('restaurant_image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);
                $restaurant->restaurant_image = $name;
            }
        }

        $restaurant->save();
        $categories = $request->input('restaurant_category');
        foreach($categories as $category){
            $restaurantCategories = RestaurantCategory::where('id',$category)->get();
            foreach($restaurantCategories as $restaurantCategory){
                $en = $restaurantCategory->restaurant_category_name_en;
                $ar = $restaurantCategory->restaurant_category_name_ar;
            }
            $categoryRestaurant = CategoryRestaurant::where('restaurant_id',$id)->first();
            $categoryRestaurant->restaurant_id = $restaurant->id;
            $categoryRestaurant->category_id = $category;
            $categoryRestaurant->category_name_en = $en;
            $categoryRestaurant->category_name_ar = $ar;
            $categoryRestaurant->save();
        }
        $days = $request->input('daily_days');

        foreach($days as $day){
            $working = WorkingHours::where('restaurant_id', $id)->first();
            $working->type = $request->input('opening_type');
            $working->weekday = $day;
            $working->opening_time = Carbon::parse("11:00 AM");
            $working->closing_time = Carbon::parse("11:59 PM");
            $working->status = 1;
            $working->restaurant_id = $restaurant->id;
            if($working->type == 'daily'){
                $daily = $request->input('daily_hours');
                if($daily){
                    $working->opening_time = Carbon::parse($daily['open']);
                    $working->closing_time = Carbon::parse($daily['close']);
                };
            }
            if($working->type == 'flexible'){
                $flexible = $request->input('flexible_hours');
                if($flexible){
                    $working->opening_time = Carbon::parse($flexible[$day]['open']);
                    $working->closing_time = Carbon::parse($flexible[$day]['close']);
                    $working->status = $flexible[$day]['status'];
                };
            }
            $working->save();
        }

        return redirect('/restaurants');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteRestaurants(Request $request)
    {
        $id = $request->get('id');
        $restaurants = Restaurant::with('menu')->where('id',$id)->get();
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
        Restaurant::whereIn('id',$id)->delete();
        return redirect('/restaurants');
    }




    public function getRestaurants(Request $request){
        $lang = $request->header('Accept-Language');
        $restaurants = Restaurant::with(['menu', 'categoryRestaurant'])->paginate(20);
        if(count($restaurants) > 0){
            foreach($restaurants as $restaurant){
                $famous = null;
                $famous = [];

                foreach($restaurant->menu as $menu){

                    if ($menu->famous == 1){
                        $image = url('/').'/images/'. $menu->menu_photo;
                        array_push($famous , $image);
                    }
                }
                $category= [];
                foreach($restaurant->categoryRestaurant as $categoryRestaurant){
                    if($lang == 'ar'){
                        $ar = $categoryRestaurant['category_name_ar'];
                        array_push( $category,$ar);
                    }else{
                        $en = $categoryRestaurant['category_name_en'];
                        array_push( $category,$en);
                    }
                }

                $arr []=[
                    'restaurant_id' => $restaurant->id,
                    'restaurant_image'=> url('/').'/images/'. $restaurant->restaurant_image,
                    'famous_images' => $famous,
                    'restaurant_name'=>$restaurant->restaurant_name,
                    'category' => $category
                ];
            }
            $wholeData = [
                "total" => count($restaurants),
                "per_page" => 20,
                "current_page" => $restaurants->currentPage(),
                "next_page_url" => $restaurants->nextPageUrl(),
                "prev_page_url" => $restaurants->previousPageUrl(),
                "from" => $restaurants->firstItem(),
                "to" => $restaurants->lastItem(),
                "count" => $restaurants->total(),
                "lastPage" => $restaurants->lastPage(),
                'data' => $arr,
            ];
            return response()->json(array(
                'success'=> 1,
                'status_code'=> 200 ,
                'data' => $wholeData));
        }else{
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => 'No available restaurant!'));
        }

    }



    public function getRestaurantByCategory(Request $request){

        $lang = $request->header('Accept-Language');
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'category_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $id = $DataRequests['category_id'];
            $restaurants = Restaurant::whereHas('categoryRestaurant',function ($query) use ($id){
                    $query->where('category_id', $id);
                })->with('menu')->paginate(20);

            if (count($restaurants)>0) {
                foreach($restaurants as $restaurant){
                    $famous = null;
                    $famous = [];

                    foreach($restaurant->menu as $menu){

                        if ($menu->famous == 1){
                            $image = url('/').'/images/'. $menu->menu_photo;
                            array_push($famous , $image);
                        }
                    }

                    $category= [];
                    foreach($restaurant->categoryRestaurant as $categoryRestaurant){
                        if($lang == 'ar'){
                            $ar = $categoryRestaurant['category_name_ar'];
                            array_push( $category,$ar);
                        }else{
                            $en = $categoryRestaurant['category_name_en'];
                            array_push( $category,$en);
                        }
                    }
                    $arr[] = [
                        'restaurant_id' => $restaurant->id,
                        'restaurant_image'=> url('/').'/images/'. $restaurant->restaurant_image,
                        'famous_images' => $famous,
                        'restaurant_name'=>$restaurant->restaurant_name,
                        'category' => $category
                    ];
                }

                $wholeData = [
                    "total" => count($restaurants),
                    "per_page" => 20,
                    "current_page" => $restaurants->currentPage(),
                    "next_page_url" => $restaurants->nextPageUrl(),
                    "prev_page_url" => $restaurants->previousPageUrl(),
                    "from" => $restaurants->firstItem(),
                    "to" => $restaurants->lastItem(),
                    "count" => $restaurants->total(),
                    "lastPage" => $restaurants->lastPage(),
                    'data' => $arr,
                ];

                    return response()->json(array(
                        'success'=> 1,
                        'status_code'=> 200 ,
                        'data' => $wholeData));

            }else {
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'message' => 'No available restaurant!'));
            }
        }
    }

    public function availableRestaurants(Request $request)
    {
        $lang = $request->header('Accept-Language');
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'area_id' => 'required|integer',
            'working_day' => 'required',
            'working_time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $id = $DataRequests['area_id'];
            $working_day = Carbon::parse($DataRequests['working_day'])->dayOfWeek;
            $working_time = $DataRequests['working_time'];
            $working_time = Carbon::parse($working_time);
            $restaurants = Restaurant::
                where('restaurant_country_id', $id)
                ->whereHas('workingHour',function ($query) use ($working_day,$working_time){
                    $query->where('weekday', $working_day)
                          ->where('opening_time', '<=', $working_time)
                          ->where('closing_time', '>=', $working_time);
                })->with(['menu','categoryRestaurant']);

            if(isset($DataRequests['category_id'])){
                $category = $DataRequests['category_id'];
                    $restaurants = $restaurants->whereHas('categoryRestaurant',function ($query) use ($category){
                        $query->where('category_id', $category);
                    })->paginate(20);
            }else{
                $restaurants = $restaurants->paginate(20);
            }



            if (count($restaurants)>0) {
                foreach ($restaurants as $restaurant) {

                    foreach($restaurant->workingHour as $workingHour){
                        $opening = $workingHour->opening_time;
                        $closing = $workingHour->closing_time;
                        $status = $workingHour->status;
                    }
                    if($status == 1){
                        $working_status = 'Open';
                    }elseif ($status == 0){
                        $working_status = 'Close';
                    }else{
                        $working_status = 'Busy';
                    }
                    $famous = null;
                    $famous = [];
                    foreach($restaurant->menu as $menu){

                        if ($menu->famous == 1){
                            $image = url('/').'/images/'. $menu->menu_photo;
                            array_push($famous , $image);
                        }
                    }

                    $category = [];
                    foreach($restaurant->categoryRestaurant as $categoryRestaurant){
                        $id = $categoryRestaurant->category_id;
                        if($lang == 'ar'){
                            $name= $categoryRestaurant->category_name_ar;

                        }else{
                            $name = $categoryRestaurant->category_name_en;

                        }

                        $category [] = [
                            'category_id' => $id,
                            'category_name' => $name
                        ];

                    }
                    $arr [] = [
                        'restaurant_id' => $restaurant->id,
                        'restaurant_name' => $restaurant->restaurant_name,
                        'restaurant_image' => url('/') . '/images/' . $restaurant->restaurant_image,
                        'famous_images' => $famous,
                        'ratings_count' => 0,
                        'review_count' => 0,
                        'availability_hours' => $opening  . '-' . $closing,
                        'description' => $restaurant->description,
                        'status' => $working_status,
                        'category' => $category
                    ];

                }
                $wholeData = [
                    "total" => count($restaurants),
                    "per_page" => 20,
                    "current_page" => $restaurants->currentPage(),
                    "next_page_url" => $restaurants->nextPageUrl(),
                    "prev_page_url" => $restaurants->previousPageUrl(),
                    "from" => $restaurants->firstItem(),
                    "to" => $restaurants->lastItem(),
                    "count" => $restaurants->total(),
                    "lastPage" => $restaurants->lastPage(),
                    'data' => $arr,
                ];

                    return response()->json(array(
                        'success'=> 1,
                        'status_code'=> 200 ,
                        'data' => $wholeData));

            } else {
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'message' => 'No available restaurant!'));
            }
        }


    }

    public function getRestaurant($id)
    {
        $restaurants = Restaurant::where('id',$id)->with(['menu', 'menu.category'])->get();
        if(count($restaurants)>0){
            foreach($restaurants as $restaurant){
                if(count($restaurant->menu) > 0){
                    foreach($restaurant->menu as $menu){
                        if($menu->menu_status ==1){
                            $status = 'Enable';
                        }else{
                            $status = 'Disable';
                        }
                        $restaurant_menu [] = [
                            'menu_id' => $menu->id,
                            'menu_name' => $menu->menu_name,
                            'menu_price' => $menu->menu_price,
                            'menu_category' => $menu->category['name'],
                            'menu_stock_qty' => $menu->stock_qty,
                            'menu_status' => $status,
                        ];
                    }

                }else{
                    $restaurant_menu = [];
                }
                $arr [] = [
                    'restaurant_id' => $restaurant->id,
                    'restaurant_name' => $restaurant->restaurant_name,
                    'restaurant_image' => url('/') . '/images/' . $restaurant->restaurant_image,
                    'menu' => $restaurant_menu
                    ];
            }

            return response()->json(array(
                    'success'=> 1,
                    'status_code'=> 200 ,
                    'data' => $arr));

        }else {
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => 'No available restaurant!'));
        }

    }

    public function restaurantMenuItems(Request $request)
    {
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'restaurant_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $restaurant_id = $DataRequests['restaurant_id'];

            $restaurants = Restaurant::where('id', $restaurant_id)
                ->with(['menu.category' ,'collection.subcategory', 'collection.collectionItem']);
            if(isset($DataRequests['category_id'])){
                $category_id = $DataRequests['category_id'];
                $restaurants = $restaurants->whereHas('categoryRestaurant',function ($query) use ($category_id){
                    $query->where('category_id', $category_id);
                })->paginate(20);
            }else{
                $restaurants = $restaurants->paginate(20);
            }

            if(count($restaurants) > 0){
                foreach($restaurants as $restaurant) {
                    if ($restaurant->female_caterer_available == 1) {
                        $female_caterer_available = true;
                    } else {
                        $female_caterer_available = false;
                    }
                    $menu_collection = [];
                    if (count($restaurant->collection) > 0) {
                        foreach ($restaurant->collection as $collection) {

                            $foodlist = [];
                            $foodlist_images = [];
                            if ($collection->is_available == 1) {
                                $is_available = true;
                            } else {
                                $is_available = false;
                            }
                            $setup = '';
                            $max = '';
                            $requirement = '';
                            $persons = '';
                            if($collection->subcategory_id == 1){
                                $items = [];
                                $menu = [];
                                foreach ($collection->collectionItem as $collection_item) {
                                    $foodlist [] = $collection_item->menu->menu_name;
                                    $image = url('/') . '/images/' . $collection_item->menu->menu_photo;
                                    array_push($foodlist_images, $image);
                                    if ($collection_item->menu->menu_status == 1) {
                                        $status = true;
                                    } else {
                                        $status = false;
                                    }

                                        $items  [] = [
                                            'item_id' => $collection_item->menu_id,
                                            'item_name' => $collection_item->menu->menu_name,
                                            'item_qty' => $collection_item->min_count,
                                            'item_price' => $collection_item->menu->menu_price,
                                            'item_price_unit' => 'QR',
                                            'item_availability' => $status

                                        ];
                                }
                                $menu [] = [
                                    'menu_name' => 'Combo Delicious',
                                    'items' => $items,
                                ];

                            }elseif ($collection->subcategory_id == 3) {
                                $items = [];
                                $menu = [];
                                foreach ($collection->collectionItem as $collection_item) {
                                    $foodlist [] = $collection_item->menu->menu_name;
                                    $image = url('/') . '/images/' . $collection_item->menu->menu_photo;
                                    array_push($foodlist_images, $image);
                                    if ($collection_item->menu->menu_status == 1) {
                                        $status = true;
                                    } else {
                                        $status = false;
                                    }

                                    $items  [] = [
                                        'item_id' => $collection_item->menu_id,
                                        'item_name' => $collection_item->menu->menu_name,
                                        'item_price' => $collection_item->menu->menu_price,
                                        'item_price_unit' => 'QR',
                                        'item_availability' => $status

                                    ];
                                    usort($items, function ($item1, $item2) {
                                        return $item2['item_availability'] <=> $item1['item_availability'];
                                    });
                                }
                                $menu [] = [
                                    'menu_name' => 'Your Choice Food',
                                    'menu_min_qty' => $collection_item->min_count,
                                    'menu_max_qty' => $collection_item->max_count,
                                    'items' => $items,
                                ];
                            }else{
                                foreach ($collection->collectionItem as $collection_item) {
                                    $foodlist [] = $collection_item->menu->menu_name;
                                    $image = url('/') . '/images/' . $collection_item->menu->menu_photo;
                                    array_push($foodlist_images, $image);
                                       $min_qty = $collection_item->min_count;
                                       $max_qty = $collection_item->max_count;
                                       if($collection->subcategory_id == 2){
                                           $persons = $collection_item->persons;
                                           $setup_hours = $collection->setup_time / 60;
                                           $setup_minutes = $collection->setup_time % 60;
                                           if ($setup_minutes > 0) {
                                               $setup = floor($setup_hours) . " hours " . ($setup_minutes) . " minutes";
                                           } else {
                                               $setup = floor($setup_hours) . " hours";
                                           }

                                           $max_hours = $collection->max_time / 60;
                                           $max_minutes = $collection->max_time % 60;
                                           if ($max_minutes > 0) {
                                               $max = floor($max_hours) . " hours " . ($max_minutes) . " minutes";
                                           } else {
                                               $max = floor($max_hours) . " hours";
                                           }
                                           $requirement = $collection->requirements;
                                       }
                                }
                                $categories = Categories::whereHas('menu',function ($query) use ($restaurant_id){
                                    $query->where('restaurant_id', $restaurant_id);
                                })->get();

                                $menu = [];
                                foreach($categories as $category){
                                    $items = [];
                                    foreach($category->menu as $item){
                                        if ($item->menu_status == 1) {
                                            $status = true;
                                        } else {
                                            $status = false;
                                        }
                                        $items  [] = [
                                            'item_id' => $item->id,
                                            'item_name' => $item->menu_name,
                                            'item_price' => $item->menu_price,
                                            'item_price_unit' => 'QR',
                                            'item_availability' => $status

                                        ];
                                    }
                                    usort($items, function ($item1, $item2) {
                                        return $item2['item_availability'] <=> $item1['item_availability'];
                                    });
                                    $menu [] = [
                                        'menu_id' => $category->id,
                                        'menu_name' => $category->name,
                                        'menu_min_qty' => $min_qty,
                                        'menu_max_qty' => $max_qty,
                                        'items' => $items,
                                    ];
                                }
                                if($collection->subcategory_id == 4){
                                    $collection->price = 0;
                                }
                            }
                            $menu_collection [] = [
                                'collection_id' => $collection->id,
                                'collection_name' => $collection->name,
                                'collection_description' => $collection->description,
                                'collection_type_id' => $collection->subcategory_id,
                                'collection_type' => $collection->subcategory->subcategory_en,
                                'female_caterer_available' => $female_caterer_available,
                                'mealtime' => $collection->mealtime,
                                'price' => $collection->price,
                                'price_unit' => "QR",
                                'is_available' => $is_available,
                                'persons_count' => $persons,
                                'service_provide' => $collection->service_provide,
                                'food_list' => $foodlist,
                                'service_presentation' => $collection->service_presentation,
                                'instruction' => $collection->instruction,
                                'food_item_image' => url('/') . '/images/' . $collection_item->menu->menu_photo,
                                'food_list_images' => $foodlist_images,
                                'setup_time' => $setup,
                                'requirement' => $requirement,
                                'max_time' => $max,
                                'menu_items' => $menu
                            ];
                        }
                        usort($menu_collection, function ($menu1, $menu2) {
                            return $menu2['is_available'] <=> $menu1['is_available'];
                        });
                        $arr = [
                            'restaurant_id' => $restaurant->id,
                            'collections' => $menu_collection
                        ];
                    }else{
                        return response()->json(array(
                            'success' => 1,
                            'status_code' => 200,
                            'message' => 'No Collection!'));
                    }

                }

                return response()->json(array(
                    'success'=> 1,
                    'status_code'=> 200 ,
                    'data' => $arr));

            }else {
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'message' => 'No available restaurant!'));
            }

        }

    }



}
