<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use Auth;
use Illuminate\Http\Request;
use App\Locations;
use App\Areas;
use Illuminate\Support\Facades\File;

class LocationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locations = Locations::all();
        $data = $request->all();
        if(isset($data['restaurant_status'])){
            $locations = Locations::where('location_status',$data['restaurant_status'])->get();
        }
        if(isset($data['restaurant_search'])){
            $locations = Locations::where('location_name','like',$data['restaurant_search'])
                ->orWhere('location_city','like',$data['restaurant_search'])
                ->orWhere('location_postcode','like',$data['restaurant_search'])
                ->orWhere('location_state','like',$data['restaurant_search'])->get();
        }
        return view('restaurants', ['locations' => $locations]);
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
    public function store(RestaurantRequest $request)
    {

        $image = $request->file('location_image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $location = new Locations();
        $location->location_image = $name;
        $location->location_name = $request->input('location_name');
        $location->location_email = $request->input('email');
        $location->location_telephone = $request->input('telephone');
        $address = $request->input('address');
        if($address){
            $location->location_address_1 = $address['address_1'];
            $location->location_address_2 = $address['address_2'];
            $location->location_city = $address['city'];
            $location->location_state = $address['state'];
            $location->location_postcode = $address['postcode'];
            $location->location_country_id = $address['country'];
            $location->location_lat = $address['location_lat'];
            $location->location_lng = $address['location_lng'];
        }
        $location->description = $request->input('description');
        $location->offer_delivery = $request->input('offer_delivery');
        $location->offer_delivery = $request->input('offer_collection');
        $location->delivery_time = $request->input('delivery_time');
        $location->last_order_time = $request->input('last_order_time');
        $location->reservation_interval = $request->input('reservation_time_interval');
        $location->reservation_turn = $request->input('reservation_stay_time');
        $location->collection_time = $request->input('collection_time');

        $location->location_status = $request->input('location_status');
        $location->save();
        if ($location) {
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
        $location = Locations::find($id);
        $areas = Areas::all();
        return view('restaurant_edit', [
            'location' => $location,
            'areas' => $areas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RestaurantRequest $request, $id)
    {

        $location = Locations::find($id);

        $location->location_name = $request->input('location_name');
        $location->location_email = $request->input('email');
        $location->location_telephone = $request->input('telephone');
        $address = $request->input('address');
        if($address){
            $location->location_address_1 = $address['address_1'];
            $location->location_address_2 = $address['address_2'];
            $location->location_city = $address['city'];
            $location->location_state = $address['state'];
            $location->location_postcode = $address['postcode'];
            $location->location_country_id = $address['country'];
            $location->location_lat = $address['location_lat'];
            $location->location_lng = $address['location_lng'];

        }
        $location->description = $request->input('description');
        $location->offer_delivery = $request->input('offer_delivery');
        $location->offer_collection = $request->input('offer_collection');
        $location->delivery_time = $request->input('delivery_time');
        $location->last_order_time = $request->input('last_order_time');
        $location->reservation_interval = $request->input('reservation_time_interval');
        $location->reservation_turn = $request->input('reservation_stay_time');
        $location->collection_time = $request->input('collection_time');
        $location->location_status = $request->input('location_status');
        if ($request->hasFile('location_image')) {
            $deletedImage = File::delete(public_path('images/' . $location->location_image));
            if ($deletedImage) {
                $image = $request->file('location_image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);
                $location->location_image = $name;
            }
        }
        $location->save();
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
        Locations::whereIn('location_id',$id)->delete();


        return redirect('/restaurants');
    }



    public function getRestaurants(){
        $locations = Locations::all();
        foreach($locations as $location){
            $arr []=[
                'restaurant_image'=>url('/').'/images/'. $location->location_image,
                'restaurant_name'=>$location->location_name,
                ];

        }
        if ($arr){
            return response()->json(array(
                'success'=> 1,
                'status_code'=> 200 ,
                'data' => $arr));
        }
    }

    public function selectImages()
    {
        $locations = Locations::all();
        return view('image_manager', ['locations' => $locations]);
    }
}
