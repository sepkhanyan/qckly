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
        $restaurant->restaurant_category_id = $request->input('restaurant_category');
        $restaurant->restaurant_name = $request->input('restaurant_name');
        $restaurant->restaurant_email = $request->input('email');
        $restaurant->restaurant_telephone = $request->input('telephone');
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
        $restaurant->restaurant_category_id = $request->input('restaurant_category');
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
        $restaurants = Restaurant::with(['menu', 'category'])->paginate(20);
        foreach($restaurants as $restaurant){
            $famous = null;
            $famous = [];

            foreach($restaurant->menu as $menu){

                if ($menu->famous == 1){
                        $image = url('/').'/images/'. $menu->menu_photo;
                        array_push($famous , $image);
                }
            }
            if($lang == 'ar'){
                $category = $restaurant->category['restaurant_category_name_ar'];
            }else{
                $category = $restaurant->category['restaurant_category_name_en'];
            }

            $arr []=[
                    'restaurant_id' => $restaurant->id,
                    'restaurant_image'=> url('/').'/images/'. $restaurant->restaurant_image,
                    'famous_image' => $famous,
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
        if ($wholeData){
            return response()->json(array(
                'success'=> 1,
                'status_code'=> 200 ,
                'data' => $wholeData));
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
            $restaurants = Restaurant::
            join('restaurant_categories', 'restaurant_categories.id', '=', 'restaurants.restaurant_category_id')
                ->where('restaurant_categories.id', $id)
                ->with('menu')->paginate(20);
            if($id == 1){
                $restaurants = Restaurant::paginate(20);
            }
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
                    if($lang == 'ar'){
                        $category = $restaurant->category['restaurant_category_name_ar'];
                    }else{
                        $category = $restaurant->category['restaurant_category_name_en'];
                    }
                    $arr[] = [
                        'restaurant_id' => $restaurant->id,
                        'restaurant_image'=> url('/').'/images/'. $restaurant->restaurant_image,
                        'famous_image' => $famous,
                        'restaurant_name'=>$restaurant->restaurant_name,
                        'category' => $category
                    ];
                }
            }else {
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'message' => 'No available restaurant!'));
            }
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
        if ($wholeData){
            return response()->json(array(
                'success'=> 1,
                'status_code'=> 200 ,
                'data' => $wholeData));
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
                join('areas', 'areas.id', '=', 'restaurants.restaurant_country_id')
                ->join('working_hours', 'working_hours.restaurant_id', '=', 'restaurants.id')
                ->where('areas.id', $id)
                ->where('working_hours.weekday', $working_day)
                ->where('working_hours.opening_time', '<=', $working_time)
                ->where('working_hours.closing_time', '>=', $working_time)
                ->with('category');

            if(isset($DataRequests['category_id'])){
                $category = $DataRequests['category_id'];
                if($category == 1){
                    $restaurants = $restaurants->paginate(20);
                }else{
                    $restaurants = $restaurants->where('restaurant_category_id', $category)->paginate(20);
                }

            }else{
                $restaurants = $restaurants->paginate(20);
            }

            if (count($restaurants)>0) {
                foreach ($restaurants as $restaurant) {
                    if($lang == 'ar'){
                        $category = $restaurant->category->restaurant_category_name_ar;
                    }else{
                        $category =$restaurant->category->restaurant_category_name_en;
                    }

                   if($restaurant->status == 1){
                        $working_status = 'Open';
                   }elseif ($restaurant->status == 0){
                        $working_status = 'Close';
                   }else{
                        $working_status = 'Busy';
                   }

                    $arr [] = [
                        'restaurant_id' => $restaurant->id,
                        'restaurant_name' => $restaurant->restaurant_name,
                        'restaurant_image' => url('/') . '/images/' . $restaurant->restaurant_image,
                        'availability_hours' => $restaurant->opening_time  . '-' . $restaurant->closing_time,
                        'description' => $restaurant->description,
                        'status' => $working_status,
                        'category_id' => $restaurant->category->id,
                        'category_name' => $category

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
                if ($wholeData){
                    return response()->json(array(
                        'success'=> 1,
                        'status_code'=> 200 ,
                        'data' => $wholeData));
                }
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
                foreach($restaurant->menu as $menu){
                    if($menu->menu_status ==1){
                        $status = 'Enable';
                    }else{
                        $status = 'Disable';
                    }


                    $arr [] = [
                        'restaurant_id' => $restaurant->id,
                        'restaurant_name' => $restaurant->restaurant_name,
                        'restaurant_image' => url('/') . '/images/' . $restaurant->restaurant_image,
                        'menu' => $restaurant->menu[] = [
                            'menu_id' => $menu->id,
                            'menu_name' => $menu->menu_name,
                            'menu_price' => $menu->menu_price,
                            'menu_category' => $menu->category['name'],
                            'menu_stock_qty' => $menu->stock_qty,
                            'menu_status' => $status,
                        ],
                    ];
                }

            }

            if ($arr){
                return response()->json(array(
                    'success'=> 1,
                    'status_code'=> 200 ,
                    'data' => $arr));
            }
        }else {
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => 'No available restaurant!'));
        }

    }



}
