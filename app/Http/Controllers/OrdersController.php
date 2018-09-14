<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\UserCart;
use App\User;
use App\Category;

class OrdersController extends Controller
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


    public function orderList(Request $request)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if($lang == 'ar'){
            $validator->getTranslator()->setLocale('ar');
        }
        $token = str_replace("Bearer ","" , $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->with('cart.cartCollection')->first();
        if($user){
            $orders = Order::where('user_id', $user->id)->orderby('created_at', 'desc')->with('cart.address')->paginate(20);
            if(count($orders) > 0){
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
                        'is_default' => $default,
                        'latitude' => $order->cart->address->latitude,
                        'longitude' => $order->cart->address->longitude,
                    ];
                    $total = 0;
                    $collections = [];
                    foreach($order->cart->cartCollection as $cart_collection){
                        $menu = [];
                        $categories = Category::whereHas('cartItem', function($query) use ($cart_collection){
                            $query->where('cart_collection_id', $cart_collection->id);
                        })->with(['cartItem' => function ($x) use($cart_collection){
                            $x->where('cart_collection_id', $cart_collection->id);
                        }])->get();
                        foreach($categories as $category){
                            $items = [];
                            foreach($category->cartItem as $cartItem){
                                if($lang == 'ar'){
                                    $item_name = $cartItem->menu->name_ar;
                                }else{
                                    $item_name = $cartItem->menu->name_en;
                                }
                                $items [] = [
                                    'item_id' => $cartItem->item_id,
                                    'item_name' => $item_name,
                                    'item_price' => $cartItem->menu->price,
                                    'item_quantity' => $cartItem->quantity,
                                    'item_price_unit' => \Lang::get('message.priceUnit')
                                ];
                            }
                            if($lang == 'ar'){
                                $menu_name = $category->name_ar;
                            }else{
                                $menu_name = $category->name_en;
                            }
                            $menu [] = [
                                'menu_id' => $category->id,
                                'menu_name' => $menu_name,
                                'items' => $items
                            ];
                        }
                        if($cart_collection->collection->price == null){
                            $collection_price = '';
                        }else{
                            $collection_price = $cart_collection->collection->price;
                        }
                        if($cart_collection->persons_count == null){
                            $persons_count = -1;
                        }else{
                            $persons_count = $cart_collection->persons_count;
                        }
                        if($cart_collection->quantity == null){
                            $quantity = '';
                        }else{
                            $quantity = $cart_collection->quantity;
                        }
                        if($cart_collection->female_caterer == 1){
                            $female_caterer = true;
                        }else{
                            $female_caterer = false;
                        }

                        if($lang == 'ar'){
                            $restaurant_name = $cart_collection->collection->restaurant->name_ar;
                            $collection_type = $cart_collection->collection->category->name_ar;
                            $collection_name = $cart_collection->collection->name_ar;
                        }else{
                            $restaurant_name = $cart_collection->collection->restaurant->name_en;
                            $collection_type = $cart_collection->collection->category->name_en;
                            $collection_name = $cart_collection->collection->name_en;
                        }

                        $collections [] = [
                            'restaurant_id' => $cart_collection->collection->restaurant->id,
                            'restaurant_name' => $restaurant_name,
                            'collection_id' => $cart_collection->collection_id,
                            'collection_type_id' => $cart_collection->collection->category_id,
                            'collection_type' => $collection_type,
                            'collection_name' => $collection_name,
                            'collection_price' => $collection_price,
                            'collection_price_unit' => \Lang::get('message.priceUnit'),
                            'female_caterer' => $female_caterer,
                            'special_instruction' => $cart_collection->special_instruction,
                            'menu_items' => $menu,
                            'quantity' => $quantity,
                            'persons_count' => $persons_count,
                            'subtotal' => $cart_collection->price,
                            'subtotal_unit' => \Lang::get('message.priceUnit'),
                        ];
                        $total += $cart_collection->price;
                    }

                    $cart   = [
                        'cart_id' => $order->cart->id,
                        'order_area' => $order->cart->delivery_order_area,
                        'order_date' => date("j M, Y", strtotime($order->cart->delivery_order_date)),
                        'order_time' => date("g:i a", strtotime( $order->cart->delivery_order_time)),
                        'delivery_address_id' => $address_id,
                        'delivery_address' => $address,
                        'collections' => $collections,
                        'total' => $total,
                        'total_unit' => \Lang::get('message.priceUnit'),
                    ];

                    if($order->is_rated == 1){
                        $rated = true;
                    }else{
                        $rated = false;
                    }
                    if($order->status == 0){
                        $status = \Lang::get('message.progress');
                    }elseif ($order->status == 1){
                        $status = \Lang::get('message.complete');
                    }else{
                        $status = \Lang::get('message.cancel');
                    }
                    $arr [] = [
                        'order_id' => $order->id,
                        'order_status' => $status,
                        'order_date' =>  date("j M, Y", strtotime($order->created_at)),
                        'order_time' => date("g:i a", strtotime($order->created_at)),
                        'total_price' => $order->total_price,
                        'total_price_unit' => \Lang::get('message.priceUnit'),
                        'is_rated' => $rated,
                        'cart' => $cart
                    ];

                }

                $wholeData = [
                    "total" => $orders->total(),
                    "count" => $orders->count(),
                    "per_page" => 20,
                    "current_page" => $orders->currentPage(),
                    "next_page_url" => $orders->nextPageUrl(),
                    "prev_page_url" => $orders->previousPageUrl(),
                    "from" => $orders->firstItem(),
                    "to" => $orders->lastItem(),
                    "last_page" => $orders->lastPage(),
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
                    'data' => [],
                    'message' => \Lang::get('message.noOrder')));
            }
        }else{
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function completeOrder(Request $request)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if($lang == 'ar'){
            $validator->getTranslator()->setLocale('ar');
        }
        $token = str_replace("Bearer ","" , $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->with('cart.cartCollection')->first();
        if($user){
            $DataRequests = $request->all();
            $validator = \Validator::make($DataRequests, [
                'cart_id' => 'required|integer',
                'payment_type' => 'required|integer',
                'total_price' => 'required|numeric'
            ]);
            if ($validator->fails()) {
                return response()->json(array('success' => 1, 'status_code' => 400,
                    'message' => 'Invalid inputs',
                    'error_details' => $validator->messages()));
            } else {
                $cart_id = $DataRequests['cart_id'];
                $payment_type = $DataRequests['payment_type'];
                $price = $DataRequests['total_price'];
                $cart = UserCart::where('user_id', $user->id)
                    ->where('id', $cart_id)->first();
                if($cart){
                        if($cart->completed == 0){
                            if($cart->delivery_address_id == null){
                                return response()->json(array(
                                    'success' => 1,
                                    'status_code' => 200,
                                    'message' => \Lang::get('message.addAddress')));
                            }
                            $order = new Order();
                            $order->user_id = $user->id;
                            $order->cart_id = $cart_id;
                            $order->payment_type = $payment_type;
                            if(isset($DataRequests['transaction_id'])){
                                $transaction_id = $DataRequests['transaction_id'];
                                $order->transaction_id = $transaction_id;
                            }
                            $order->total_price = $price;
                            $order->save();
                            UserCart::where('id', $cart_id)->update(['completed'=> 1]);
                        }else{
                            return response()->json(array(
                                'success' => 1,
                                'status_code' => 200,
                                'message' => 'Cart already ordered.'));
                        }
                }else{
                    return response()->json(array(
                        'success' => 1,
                        'status_code' => 200,
                        'message' => 'No cart.'));
                }

                    if($order->payment_type == 1){
                        $order->transaction_id = -1;
                        $payment = \Lang::get('message.cash');
                    }
                    if($order->payment_type == 2){
                        $payment = \Lang::get('message.credit');
                    }
                    if($order->payment_type == 3){
                        $payment = \Lang::get('message.debit');
                    }


                $arr = [
                    'order_id' => $order->id,
                    'transaction_id' => $order->transaction_id,
                    'payment_type' => $payment,
                    'total_price' => $order->total_price,
                    'price_unit' => \Lang::get('message.priceUnit')
                ];
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $arr));
            }
        }else{
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}
