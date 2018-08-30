<?php

namespace App\Http\Controllers;

use App\Order;
use App\Review;
use App\User;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews(Request $request)
    {
        \Log::info($request->all());
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
        $reviews = Review::where('restaurant_id', $restaurant_id)
            ->orderby('created_at', 'desc')
            ->with('order.user')->paginate(20);
        if(count($reviews) > 0){
            foreach($reviews as $review){
                $date = date("j M, Y", strtotime($review->created_at));
                if(isset($review->review_text)){
                    $review_text = $review->review_text;
                }else{
                    $review_text = '';
                }
                $arr [] = [
                    'username' => $review->order->user->username,
                    'review_id' => $review->id,
                    'rate_value' => $review->rate_value,
                    'review_text' => $review_text,
                    'review_date' => $date
                ];
            }

            $wholeData = [
                "total" => $reviews->total(),
                "count" => $reviews->count(),
                "per_page" => 20,
                "current_page" => $reviews->currentPage(),
                "next_page_url" => $reviews->nextPageUrl(),
                "prev_page_url" => $reviews->previousPageUrl(),
                "from" => $reviews->firstItem(),
                "to" => $reviews->lastItem(),
                "last_page" => $reviews->lastPage(),
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
                'message' => 'No reviews.'));
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
        \Log::info($request->all());
        $token = str_replace("Bearer ","" , $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->with('cart.cartCollection')->first();
        if($user){
            $DataRequests = $request->all();
            $validator = \Validator::make($DataRequests, [
                'reviews' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(array('success' => 1, 'status_code' => 400,
                    'message' => 'Invalid inputs',
                    'error_details' => $validator->messages()));
            } else {
                $reviews = $DataRequests['reviews'];
                foreach($reviews as $review){
                    $rating = new Review();
                    $rating->order_id = $review['order_id'];
                    $rating->restaurant_id = $review['restaurant_id'];
                    $rating->rate_value = $review['rate_value'];
                    if(isset($review['review_text'])){
                        $rating->review_text = $review['review_text'];
                    }
                    $rating->save();
                    $order = Order::where('id', $review['order_id'])->where('user_id', $user->id)->first();
                    if($order){
                        $order->is_rated = 1;
                        $order->save();
                    }
                }
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200));
            }
        }else{
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => 'You are not logged in: Please log in and try again.'));
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
