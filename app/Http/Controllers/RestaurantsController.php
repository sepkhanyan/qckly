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
        $restaurants = Restaurant::all();
        $data = $request->all();
        if(isset($data['restaurant_status'])){
            $restaurants = Restaurant::where('restaurant_status',$data['restaurant_status'])->get();
        }
        if(isset($data['restaurant_search'])){
            $restaurants = Restaurant::where('restaurant_name','like',$data['restaurant_search'])
                ->orWhere('restaurant_city','like',$data['restaurant_search'])
                ->orWhere('restaurant_postcode','like',$data['restaurant_search'])
                ->orWhere('restaurant_state','like',$data['restaurant_search'])->get();
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
        return view('new_restaurant', ['areas' => $areas]);
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
                $working->restaurant_id = $restaurant->restaurant_id;
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
        return view('restaurant_edit', [
            'restaurant' => $restaurant,
            'areas' => $areas,
            'working' => $working
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
            $working->restaurant_id = $restaurant->restaurant_id;
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
        Restaurant::whereIn('restaurant_id',$id)->delete();


        return redirect('/restaurants');
    }



    public function getRestaurants(){
        $restaurants = Restaurant::paginate(20);
        foreach($restaurants as $restaurant){
            $arr []=[
                'restaurant_id' => $restaurant->restaurant_id,
                'restaurant_image'=>url('/').'/images/'. $restaurant->restaurant_image,
                'restaurant_name'=>$restaurant->restaurant_name,
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

    public function availableRestaurants(Request $request)
    {
        $DataRequests = $request->all();

        $validator = \Validator::make($DataRequests, [
            'restaurant_id' => 'required|integer',
            'working_day' => 'required|integer',
            'working_time' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $id = $DataRequests['restaurant_id'];
            $working_day = $DataRequests['working_day'];
            $working_time = $DataRequests['working_time'];
            $working_time = Carbon::parse($working_time);
            $restaurants = Restaurant::whereHas('workingHour', function ($q) use ($id, $working_day, $working_time) {
                $q
                    ->where('restaurant_id', $id)
                    ->where('weekday', $working_day)
                    ->where('opening_time', '<=', $working_time)
                    ->where('closing_time', '>=', $working_time);
            })->get();

            if (count($restaurants) > 0) {
                foreach ($restaurants as $restaurant) {
                    $arr [] = [
                        'restaurant_id' => $restaurant->restaurant_id,
                        'restaurant_name' => $restaurant->restaurant_name,
                        'restaurant_image' => url('/') . '/images/' . $restaurant->restaurant_image,
                    ];
                    return response()->json(array(
                        'success' => 1,
                        'status_code' => 200,
                        'data' => $arr));
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
        $restaurants = Restaurant::where('restaurant_id',$id)->with(['menu', 'menu.category'])->get();
        foreach($restaurants as $restaurant){
            foreach($restaurant->menu as $menu){
                if($menu->menu_status ==1){
                    $status = 'Enable';
                }else{
                    $status = 'Disable';
                }

                $arr [] = [
                    'restaurant_id' => $restaurant->restaurant_id,
                    'restaurant_name' => $restaurant->restaurant_name,
                    'restaurant_image' => url('/') . '/images/' . $restaurant->restaurant_image,
                    'menu' => $restaurant->menu[] = [
                        'menu_id' => $menu->menu_id,
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

    }

}
