<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\UserCart;
use App\User;
use App\Categories;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderList()
    {
        $orders = Order::where('user_id', 1)->orderby('created_at', 'desc')->with('cart.address')->paginate(20);
        foreach($orders as $order){
                if($order->cart->address->is_apartment == 1){
                    $is_apartment = true;
                }else{
                    $is_apartment = false;
                }
                if($order->cart->address->is_default == 1){
                    $default = true;
                }else{
                    $default = false;
                }
                $address_id = $order->cart->address->id;
                $address = [
                    'address_name' => $order->cart->address->name,
                    'mobile_number' => $order->cart->address->mobile_number,
                    'location' => $order->cart->address->location,
                    'building_number' => $order->cart->address->location,
                    'zone' => $order->cart->address->zone,
                    'is_apartment' => $is_apartment,
                    'apartment_number' => $order->cart->address->apartment_number,
                    'is_default' => $default
                ];
            $total = 0;
            $collections = [];
            foreach($order->cart->cartCollection as $cart_collection){
                $menu = [];
                $categories = Categories::whereHas('cartItem', function($query) use ($cart_collection){
                    $query->where('cart_collection_id', $cart_collection->id);
                })->with(['cartItem' => function ($x) use($cart_collection){
                    $x->where('cart_collection_id', $cart_collection->id);
                }])->get();
                foreach($categories as $category){
                    $items = [];
                    foreach($category->cartItem as $cartItem){
                        $items [] = [
                            'item_id' => $cartItem->item_id,
                            'item_name' => $cartItem->menu->menu_name,
                            'item_price' => $cartItem->menu->menu_price,
                            'item_quantity' => $cartItem->quantity,
                            'item_price_unit' => 'QR'
                        ];
                    }
                    $menu [] = [
                        'menu_id' => $category->id,
                        'menu_name' => $category->name,
                        'items' => $items
                    ];
                }
                if($cart_collection->collection->price == null){
                    $cart_collection->collection->price = '';
                }
                if($cart_collection->persons_count == null){
                    $cart_collection->persons_count = '';
                }
                if($cart_collection->quantity == null){
                    $cart_collection->quantity = '';
                }
                if($cart_collection->female_caterer == 1){
                    $female_caterer = true;
                }else{
                    $female_caterer = false;
                }
                $persons_count = -1;
                if($cart_collection->collection->subcategory_id == 2){
                    $persons_count =  $cart_collection->persons_count;
                }
                $collections [] = [
                    'restaurant_id' => $cart_collection->collection->restaurant->id,
                    'restaurant_name' => $cart_collection->collection->restaurant->restaurant_name,
                    'collection_id' => $cart_collection->collection_id,
                    'collection_type_id' => $cart_collection->collection->subcategory_id,
                    'collection_type' => $cart_collection->collection->subcategory->subcategory_en,
                    'collection_name' => $cart_collection->collection->name,
                    'collection_price' => $cart_collection->collection->price,
                    'collection_price_unit' => 'QR',
                    'female_caterer' => $female_caterer,
                    'special_instruction' => $cart_collection->special_instruction,
                    'menu_items' => $menu,
                    'quantity' => $cart_collection->quantity,
                    'persons_count' => $persons_count,
                    'subtotal' => $cart_collection->price,
                    'subtotal_unit' => "QR",
                ];
                $total += $cart_collection->price;
            }

            $cart   = [
                'cart_id' => $order->cart->id,
                'order_area' => $order->cart->delivery_order_area,
                'order_date' => $order->cart->delivery_order_date,
                'order_time' => date("g:i a", strtotime( $order->cart->delivery_order_time)),
                'delivery_address_id' => $address_id,
                'delivery_address' => $address,
                'collections' => $collections,
                'total' => $total,
                'total_unit' => 'QR',
            ];

            $datetime = explode(' ',$order->created_at);

            $arr [] = [
                'order_id' => $order->id,
                'order_status' => $order->status,
                'order_date' => $datetime[0],
                'order_time' => date("g:i a", strtotime($datetime[1])),
                'total_price' => $order->total_price,
                'total_price_unit' => 'QR',
                'cart' => $cart
            ];

        }
        $wholeData = [
            "total" => count($orders),
            "per_page" => 20,
            "current_page" => $orders->currentPage(),
            "next_page_url" => $orders->nextPageUrl(),
            "prev_page_url" => $orders->previousPageUrl(),
            "from" => $orders->firstItem(),
            "to" => $orders->lastItem(),
            "count" => $orders->total(),
            "lastPage" => $orders->lastPage(),
            'data' => $arr,
        ];


        return response()->json(array(
            'success' => 1,
            'status_code' => 200,
            'data' => $wholeData));
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
                'total_price' => $order->total_price,
                'price_unit' => 'QR'
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
