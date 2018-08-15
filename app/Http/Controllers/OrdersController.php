<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\UserCart;
use App\User;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderList()
    {
        $orders = Order::where('user_id', 1)->orderby('created_at', 'desc')->get();
//        $arr = [
//            'order_id' => $order->id,
//            'transaction_id' => $order->transaction_id,
//            'payment_type' => $payment,
//            'total_price' => $order->total_price
//        ];
        return response()->json(array(
            'success' => 1,
            'status_code' => 200,
            'data' => $orders));
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
    public function completeOrder(Request $request)
    {
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'cart_id' => 'required|integer',
            'payment_type' => 'required|integer',
            'total_price' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $cart_id = $DataRequests['cart_id'];
            $payment_type = $DataRequests['payment_type'];
            $price = $DataRequests['total_price'];
            $order = new Order();
            $order->user_id = 1;
            $order->cart_id = $cart_id;
            $order->payment_type = $payment_type;
            if(isset($DataRequests['transaction_id'])){
                $transaction_id = $DataRequests['transaction_id'];
                $order->transaction_id = $transaction_id;
            }
            $order->total_price = $price;
            $order->save();
            UserCart::where('id', $cart_id)->update(['completed'=> 1]);
            if($order->payment_type == 1){
                $order->transaction_id = -1;
                $payment = 'By Cash';
            }
            if($order->payment_type == 2){
                $payment = 'Credit Card';
            }
            if($order->payment_type == 3){
                $payment = 'Via payment gateway';
            }
            $arr = [
                'order_id' => $order->id,
                'transaction_id' => $order->transaction_id,
                'payment_type' => $payment,
                'total_price' => $order->total_price
            ];
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'data' => $arr));
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

    public function getLastOrder()
    {

    }
}
