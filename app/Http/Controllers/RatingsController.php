<?php

namespace App\Http\Controllers;

use App\Order;
use App\Rating;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews()
    {
        dd(1);
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
    public function rateOrder(Request $request)
    {
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'rates' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $rates = $DataRequests['rates'];
            foreach($rates as $rate){

                $rating = new Rating();
                $rating->order_id = $rate['order_id'];
                $rating->restaurant_id = $rate['restaurant_id'];
                $rating->rate_value = $rate['rate_value'];
                $rating->review = $rate['review'];
                $rating->save();
                $order = Order::where('id', $rate['order_id'])->first();
                $order->is_rated = 1;
                $order->save();
            }
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
