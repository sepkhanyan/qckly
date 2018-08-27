<?php

namespace App\Http\Controllers;

use App\Order;
use App\Rating;
use App\User;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews(Request $request)
    {
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'restaurant_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $restaurant_id = $DataRequests['restaurant_id'];
        }
        $ratings = Rating::where('restaurant_id', $restaurant_id)
            ->orderby('created_at', 'desc')
            ->with('order.user')->paginate(20);
        if(count($ratings) > 0){
            foreach($ratings as $rating){
                $date = date("j M, Y", strtotime($rating->created_at));
                if(isset($rating->review)){
                    $review = $rating->review;
                }else{
                    $review = '';
                }
                $arr [] = [
                    'username' => $rating->order->user->username,
                    'review_id' => $rating->id,
                    'rate_value' => $rating->rate_value,
                    'review' => $review,
                    'review_date' => $date
                ];
            }

            $wholeData = [
                "total" => $ratings->total(),
                "count" => $ratings->count(),
                "per_page" => 20,
                "current_page" => $ratings->currentPage(),
                "next_page_url" => $ratings->nextPageUrl(),
                "prev_page_url" => $ratings->previousPageUrl(),
                "from" => $ratings->firstItem(),
                "to" => $ratings->lastItem(),
                "last_page" => $ratings->lastPage(),
                'data' => $arr,
            ];

            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'data' => $wholeData));
        }else{
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => 'No reviews!'));
        }

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
                if(isset($rate['review'])){
                    $rating->review = $rate['review'];
                }
                $rating->save();
                $order = Order::where('id', $rate['order_id'])->first();
                if($order){
                    $order->is_rated = 1;
                    $order->save();
                }
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
