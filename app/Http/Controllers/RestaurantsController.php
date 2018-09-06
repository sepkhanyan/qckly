<?php

namespace App\Http\Controllers;

use App\CollectionMenu;
use App\Http\Requests\RestaurantRequest;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Restaurant;
use App\Area;
use App\WorkingHour;
use App\Menu;
use App\Category;
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
        $user = Auth::user();
        $restaurants = Restaurant::paginate(20);
        if($user->admin == 2){
            $restaurants = Restaurant::where('user_id', $user->id)->paginate(20);
        }
        $data = $request->all();
        if(isset($data['restaurant_status'])){
            $restaurants = Restaurant::where('status',$data['restaurant_status'])->paginate(20);
        }
        if(isset($data['restaurant_search'])){
            $restaurants = Restaurant::where('name','like',$data['restaurant_search'])
                ->orWhere('city','like',$data['restaurant_search'])
                ->orWhere('description','like',$data['restaurant_search'])->paginate(20);
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
        $areas = Area::all();
        $categories = RestaurantCategory::all();
        return view('restaurant_create', [
            'areas' => $areas,
            'categories' => $categories,
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
        $manager = new User();
        $manager->username = $request->input('manager_name');
        $manager->password = bcrypt($request->input('password'));
        $manager->country_code = $request->input('country_code');
        $manager->mobile_number = $request->input('telephone');
        $manager->email = $request->input('email');
        $manager->otp = rand(15000, 50000);
        $manager->lang = 'en';
        $manager->admin = 2;
        $manager->save();
        $restaurant = new Restaurant();
        $image = $request->file('image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $restaurant->image = $name;
        $restaurant->user_id = $manager->id;
        $restaurant->name = $request->input('name');
        $restaurant->email = $request->input('email');
        $restaurant->telephone = $request->input('telephone');
        $restaurant->address = $request->input('address');
        $restaurant->city = $request->input('city');
        $restaurant->state = $request->input('state');
        $restaurant->postcode = $request->input('postcode');
        $restaurant->area_id = $request->input('country');
        $restaurant->latitude = $request->input('latitude');
        $restaurant->longitude = $request->input('longitude');
        $restaurant->description = $request->input('description');
        $restaurant->status = $request->input('status');
        $restaurant->save();
        $categories = $request->input('category');
        foreach($categories as $category){
            $restaurantCategories = RestaurantCategory::where('id',$category)->get();
            foreach($restaurantCategories as $restaurantCategory){
               $en = $restaurantCategory->name_en;
               $ar = $restaurantCategory->name_ar;
            }
            $categoryRestaurant = new CategoryRestaurant();
            $categoryRestaurant->restaurant_id = $restaurant->id;
            $categoryRestaurant->category_id = $category;
            $categoryRestaurant->name_en = $en;
            $categoryRestaurant->name_ar = $ar;
            $categoryRestaurant->save();
        }

        $days = $request->input('daily_days');
            foreach($days as $day){
                $working = new WorkingHour();
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
        $working = WorkingHour::where('restaurant_id', $id)->first();
        $restaurant = Restaurant::find($id);
        $areas = Area::all();
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
        $restaurant->name = $request->input('name');
        $restaurant->email = $request->input('email');
        $restaurant->telephone = $request->input('telephone');
        $restaurant->address =  $request->input('address');
        $restaurant->city = $request->input('city');
        $restaurant->state = $request->input('city');
        $restaurant->postcode = $request->input('postcode');
        $restaurant->latitude = $request->input('latitude');
        $restaurant->longitude = $request->input('longitude');
        $restaurant->description = $request->input('description');
        $restaurant->status = $request->input('status');
        if ($request->hasFile('image')) {
            $deletedImage = File::delete(public_path('images/' . $restaurant->image));
            if ($deletedImage) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);
                $restaurant->image = $name;
            }
        }
        $restaurant->save();
        $categories = $request->input('category');
        if($categories){
            CategoryRestaurant::where('restaurant_id',$id)->delete();
            foreach($categories as $category){
                $restaurantCategories = RestaurantCategory::where('id',$category)->get();
                foreach($restaurantCategories as $restaurantCategory){
                    $en = $restaurantCategory->name_en;
                    $ar = $restaurantCategory->name_ar;
                }
                $categoryRestaurant = new CategoryRestaurant();
                $categoryRestaurant->restaurant_id = $restaurant->id;
                $categoryRestaurant->category_id = $category;
                $categoryRestaurant->name_en = $en;
                $categoryRestaurant->name_ar = $ar;
                $categoryRestaurant->save();
            }
        }

        $days = $request->input('daily_days');
        if($days){
            WorkingHour::where('restaurant_id', $id)->delete();
            foreach($days as $day){
                $working = new WorkingHour();
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
                $menu_images[] = public_path('images/' . $menu->image);
            }
            $restaurant_images[] = public_path('images/' . $restaurant->image);
        }
        File::delete($menu_images);
        File::delete($restaurant_images);
        Restaurant::whereIn('id',$id)->delete();
        return redirect('/restaurants');
    }




    public function getRestaurants(Request $request)
    {
        $lang = $request->header('Accept-Language');
        $restaurants = Restaurant::with(['menu', 'categoryRestaurant'])->paginate(20);
        if(count($restaurants) > 0){
            foreach($restaurants as $restaurant){
                $famous = null;
                $famous = [];

                foreach($restaurant->menu as $menu){

                    if ($menu->famous == 1){
                        $image = url('/').'/images/'. $menu->image;
                        array_push($famous , $image);
                    }
                }
                $category= [];
                foreach($restaurant->categoryRestaurant as $categoryRestaurant){
                    if($lang == 'ar'){
                        $ar = $categoryRestaurant['name_ar'];
                        array_push( $category,$ar);
                    }else{
                        $en = $categoryRestaurant['name_en'];
                        array_push( $category,$en);
                    }
                }

                $arr []=[
                    'restaurant_id' => $restaurant->id,
                    'restaurant_image'=> url('/').'/images/'. $restaurant->image,
                    'famous_images' => $famous,
                    'restaurant_name'=>$restaurant->name,
                    'category' => $category
                ];
            }

            $wholeData = [
                "total" => $restaurants->total(),
                "count" => $restaurants->count(),
                "per_page" => 20,
                "current_page" => $restaurants->currentPage(),
                "next_page_url" => $restaurants->nextPageUrl(),
                "prev_page_url" => $restaurants->previousPageUrl(),
                "from" => $restaurants->firstItem(),
                "to" => $restaurants->lastItem(),
                "last_page" => $restaurants->lastPage(),
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
                'message' => 'No available restaurant.'));
        }

    }



    public function getRestaurantByCategory(Request $request)
    {
        \Log::info($request->all());
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
                            $image = url('/').'/images/'. $menu->image;
                            array_push($famous , $image);
                        }
                    }

                    $category= [];
                    foreach($restaurant->categoryRestaurant as $categoryRestaurant){
                        if($lang == 'ar'){
                            $ar = $categoryRestaurant['name_ar'];
                            array_push( $category,$ar);
                        }else{
                            $en = $categoryRestaurant['name_en'];
                            array_push( $category,$en);
                        }
                    }
                    $arr[] = [
                        'restaurant_id' => $restaurant->id,
                        'restaurant_image'=> url('/').'/images/'. $restaurant->image,
                        'famous_images' => $famous,
                        'restaurant_name'=>$restaurant->name,
                        'category' => $category
                    ];
                }

                $wholeData = [
                    "total" => $restaurants->total(),
                    "count" => $restaurants->count(),
                    "per_page" => 20,
                    "current_page" => $restaurants->currentPage(),
                    "next_page_url" => $restaurants->nextPageUrl(),
                    "prev_page_url" => $restaurants->previousPageUrl(),
                    "from" => $restaurants->firstItem(),
                    "to" => $restaurants->lastItem(),
                    "last_page" => $restaurants->lastPage(),
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
                    'message' => 'No available restaurant.'));
            }
        }
    }

    public function availableRestaurants(Request $request)
    {
        \Log::info($request->all());
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
                where('area_id', $id)
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
                            $image = url('/').'/images/'. $menu->image;
                            array_push($famous , $image);
                        }
                    }

                    $category = [];
                    foreach($restaurant->categoryRestaurant as $categoryRestaurant){
                        $id = $categoryRestaurant->category_id;
                        if($lang == 'ar'){
                            $name= $categoryRestaurant->name_ar;

                        }else{
                            $name = $categoryRestaurant->name_en;

                        }

                        $category [] = [
                            'category_id' => $id,
                            'category_name' => $name
                        ];

                    }

                    $rate_sum = 0;
                    $review_count = $restaurant->review->count();
                    foreach($restaurant->review as $review){
                        $rate_sum += $review->rate_value;
                    }
                    if($review_count){
                        $rating_count = $rate_sum / $review_count;
                    }else{
                        $rating_count = 0;
                    }

                    $arr [] = [
                        'restaurant_id' => $restaurant->id,
                        'restaurant_name' => $restaurant->name,
                        'restaurant_image' => url('/') . '/images/' . $restaurant->image,
                        'famous_images' => $famous,
                        'ratings_count' => $rating_count,
                        'review_count' => $review_count,
                        'availability_hours' => date("g:i a", strtotime( $opening))  . ' - ' . date("g:i a", strtotime( $closing)),
                        'description' => $restaurant->description,
                        'status' => $working_status,
                        'category' => $category
                    ];

                }

                $wholeData = [
                    "total" => $restaurants->total(),
                    "count" => $restaurants->count(),
                    "per_page" => 20,
                    "current_page" => $restaurants->currentPage(),
                    "next_page_url" => $restaurants->nextPageUrl(),
                    "prev_page_url" => $restaurants->previousPageUrl(),
                    "from" => $restaurants->firstItem(),
                    "to" => $restaurants->lastItem(),
                    "last_page" => $restaurants->lastPage(),
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
                    'message' => 'There is no any Restaurant found. Please select other Area, Date and Time.					'));
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
                        if($menu->status ==1){
                            $status = 'Enable';
                        }else{
                            $status = 'Disable';
                        }
                        $restaurant_menu [] = [
                            'menu_id' => $menu->id,
                            'menu_name' => $menu->name,
                            'menu_price' => $menu->price,
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
                    'restaurant_name' => $restaurant->name,
                    'restaurant_image' => url('/') . '/images/' . $restaurant->image,
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
                'message' => 'No available restaurant.'));
        }

    }

    public function restaurantMenuItems(Request $request)
    {
        \Log::info($request->all());
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
                ->with(['menu.category' ,'collection.category', 'collection.collectionItem', 'collection.collectionMenu']);
            if(isset($DataRequests['category_id'])){
                $category_id = $DataRequests['category_id'];
                $restaurants = $restaurants->whereHas('categoryRestaurant',function ($query) use ($category_id){
                    $query->where('category_id', $category_id);
                })->get();
            }else{
                $restaurants = $restaurants->get();
            }

            if(count($restaurants) > 0){
                foreach($restaurants as $restaurant) {
                    if (count($restaurant->collection) > 0) {
                        $menu_collection = [];
                        foreach ($restaurant->collection as $collection) {
                            if ($collection->female_caterer_available == 1) {
                                $female_caterer_available = true;
                            } else {
                                $female_caterer_available = false;
                            }
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
                            $max_persons = -1;
                            $min_serve = -1;
                            $max_serve = -1;
                            $collection_max = -1;
                            $collection_min = -1;
                            $person_increase = false;
                            $collection_price = 0;
                            if($collection->category_id != 4){
                                $min_serve = $collection->min_serve_to_person;
                                $max_serve = $collection->max_serve_to_person;
                                $collection_price = $collection->price;
                            }
                            if($collection->category_id != 2 && $collection->category_id != 4){
                                $collection_min = $collection->min_qty;
                                $collection_max = $collection->max_qty;
                            }

                            if($collection->category_id == 1){
                                $items = [];
                                $menu = [];
                                foreach ($collection->collectionItem as $collection_item) {
                                    $foodlist [] = $collection_item->menu->name;
                                    $image = url('/') . '/images/' . $collection_item->menu->image;
                                    array_push($foodlist_images, $image);
                                    if ($collection_item->menu->status == 1) {
                                        $status = true;
                                    } else {
                                        $status = false;
                                    }

                                        $items  [] = [
                                            'item_id' => $collection_item->item_id,
                                            'item_name' => $collection_item->menu->name,
                                            'item_image' => url('/') . '/images/' .  $collection_item->menu->image,
                                            'item_qty' => $collection_item->quantity,
                                            'item_price' => $collection_item->menu->price,
                                            'item_price_unit' => 'QR',
                                            'item_availability' => $status

                                        ];
                                }
                                $menu [] = [
                                    'menu_name' => 'Combo Delicious',
                                    'items' => $items,
                                ];
                            }else{
                                $menu_min_qty = -1;
                                $menu_max_qty = -1;
                                $menu = [];
                                $collectionMenus = CollectionMenu::where('collection_id', $collection->id)->with(['collectionItem' => function ($query) use($collection){
                                    $query->where('collection_id', $collection->id);
                                }])->get();
                                foreach ($collectionMenus as $collectionMenu) {
                                    $items = [];
                                    if($collection->category_id !=4 && $collection->category_id !=1){
                                        $menu_min_qty = $collectionMenu->min_qty;
                                        $menu_max_qty = $collectionMenu->max_qty;
                                    }
                                    foreach($collectionMenu->collectionItem as $collection_item){
                                        $foodlist [] = $collection_item->menu['name'];
                                        $image = url('/') . '/images/' . $collection_item->menu['image'];
                                        array_push($foodlist_images, $image);
                                        if($collection->category_id == 2){
                                            if($collection->allow_person_increase == 1){
                                                $person_increase = true;
                                            }else{
                                                $person_increase = false;
                                            }
                                            $max_persons = $collection->persons_max_count;

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


                                        if ($collection_item->menu->status == 1) {
                                            $status = true;
                                        } else {
                                            $status = false;
                                        }
                                        $items [] = [
                                            'item_id' => $collection_item->menu->id,
                                            'item_name' => $collection_item->menu->name,
                                            'item_image' => url('/') . '/images/' .  $collection_item->menu->image,
                                            'item_price' => $collection_item->menu->price,
                                            'item_price_unit' => 'QR',
                                            'item_availability' => $status

                                        ];
                                    }

                                    usort($items, function ($item1, $item2) {
                                        return $item2['item_availability'] <=> $item1['item_availability'];
                                    });
                                    $menu [] = [
                                        'menu_id' => $collectionMenu->category->id,
                                        'menu_name' => $collectionMenu->category->name,
                                        'menu_min_qty' => $menu_min_qty,
                                        'menu_max_qty' => $menu_max_qty,
                                        'items' => $items,
                                    ];

                                }
//                                $categories = Category::with(['menu' => function ($query) use ($collection, $restaurant_id){
//                                    $query->where('restaurant_id', $restaurant_id)
//                                        ->whereHas('collectionItem', function ($x) use ($collection){
//                                        $x->where('collection_id', $collection->id);
//                                    });
//                                }])->get();

                            }
                            $menu_collection [] = [
                                'collection_id' => $collection->id,
                                'collection_name' => $collection->name,
                                'collection_description' => $collection->description,
                                'collection_type_id' => $collection->category_id,
                                'collection_type' => $collection->category->name_en,
                                'female_caterer_available' => $female_caterer_available,
                                'mealtime' => $collection->mealtime,
                                'collection_min_qty' => $collection_min,
                                'collection_max_qty' => $collection_max,
                                'collection_price' => $collection_price,
                                'collection_price_unit' => "QR",
                                'is_available' => $is_available,
                                'min_serve_to_person' => $min_serve,
                                'max_serve_to_person' => $max_serve,
                                'allow_person_increase' => $person_increase,
                                'persons_max_count' => $max_persons,
                                'service_provide' => $collection->service_provide,
                                'food_list' => $foodlist,
                                'service_presentation' => $collection->service_presentation,
                                'special_instruction' => '',
                                'food_item_image' => url('/') . '/images/' . $collection_item->menu['image'],
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
                            'message' => 'No collection.'));
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
                    'message' => 'No available restaurant.'));
            }

        }

    }



}
