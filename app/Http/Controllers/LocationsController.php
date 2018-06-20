<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use Auth;
use Illuminate\Http\Request;
use App\Locations;
use App\Areas;

class LocationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Locations::all();
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
//dd($request->all());
        $location = new Locations();
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
        return view('restaurant_edit', ['location' => $location, 'areas' => $areas]);
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
}
