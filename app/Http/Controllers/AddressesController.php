<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addAddress(Request $request)
    {
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'name' => 'required|string',
            'mobile_number' => 'required|string',
            'location' => 'required|string',
            'building_number' => 'required|string',
            'zone' => 'required|string',
            'is_apartment' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            Address::where('user_id',1)->where('is_default', 1)->update(['is_default'=> 0]);;
            $address = new Address();
            $address->user_id = 1;
            $address->is_default = 1;
            $address->name = $DataRequests['name'];
            $address->mobile_number = $DataRequests['mobile_number'];
            $address->location = $DataRequests['location'];
            $address->building_number = $DataRequests['building_number'];
            $address->zone = $DataRequests['zone'];
            $address->is_apartment = $DataRequests['is_apartment'];
            $address->apartment_number = $DataRequests['apartment_number'];
            $address->save();
            return response()->json(array(
                'success' => 1,
                'status_code' => 200));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAddresses(Request $request)
    {
        $DataRequests = $request->all();
        $addresses = Address::where('user_id', 1)->get();
        foreach($addresses as $address){
            if($address->is_apartment = 1){
                $apartment = true;
            }else{
                $apartment = false;
            }
            $arr [] = [
                'address_id' => $address->id,
                'address_name' => $address->name,
                'mobile_number' => $address->mobile_number,
                'location' => $address->location,
                'building_number' => $address->building_number,
                'zone' => $address->zone,
                'is_apartment' => $apartment,
                'apartment_number' => $address->apartment_number
            ];
        }
        return response()->json(array(
            'success' => 1,
            'status_code' => 200,
            'data' => $arr));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
