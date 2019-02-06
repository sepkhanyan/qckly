<?php

namespace App\Http\Controllers;

use Auth;
use Mail;

use App\User;
use App\Order;
use App\Status;
use App\UserCart;
use App\Restaurant;
use App\MenuCategory;
use App\RestaurantArea;
use App\DeliveryAddress;
use App\OrderCollection;
use App\OrderRestaurant;
use App\UserCartCollection;
use App\OrderCollectionItem;
use App\OrderCollectionMenu;

use Carbon\Carbon;

use App\Events\NewMessage;
use Illuminate\Http\Request;

use App\Jobs\SendEmailAndSMSAfterCompleteOrder;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, $id = null)
    {
        $user = Auth::user();
        $statuses = Status::all();
        $data = $request->all();
        
        $orders = OrderRestaurant::with('order.user', 'status', 'restaurant', 'order.cart.area');

        if ($user->admin == 1) {

            $restaurants = Restaurant::where('deleted', 0)->get();

            if ($id) {
                $orders->where('restaurant_id', $id);
                // $selectedRestaurant = Restaurant::find($id);
            }
        } elseif ($user->admin == 2) {

            $orders->where('restaurant_id', $user->restaurant_id);
        }

        if (isset($data['order_status'])) {
            $orders->where('status_id', $data['order_status']);
        }

        if (isset($data['order_search'])) {
            $orders->priceAndOrderId($data['order_search']);
        }

        $orders = $orders->orderBy('id', 'DESC')->paginate(20);

        return view('orders.orders', [
            'id' => $id,
            'statuses' => $statuses,
            'orders' => $orders,
            'restaurants' => isset($restaurants) ? $restaurants : "",
            // 'selectedRestaurant' => isset($selectedRestaurant) ? $selectedRestaurant : "",
            'user' => $user
        ]);
    }

    public function orderConfirmation($id)
    {

        $user = Auth::user();
        if ($user->admin == 2) {
            $order = Order::where('id', $id)->first();
            $restaurant = Restaurant::where('id', $user->restaurant_id)->first();
            $providerOrder = OrderRestaurant::where('order_id', $id)->where('restaurant_id', $user->restaurant_id)->where('status_id', 1)->first();
            if (!$providerOrder) {
                return redirect()->back();
            }

            $providerOrder->status_id = 2;
            $providerOrder->save();
            $restaurantOrders = OrderRestaurant::where('order_id', $id)->where('status_id', 1)->get();
            if ($restaurantOrders->isEmpty()) {
                $order->status_id = 2;
                $order->save();
            }
            $client = User::where('id', $order->user_id)->first();
            if (!$client->lang) {
                \App::setLocale("en");
                $restaurant_name = $restaurant->name_en;
            } else {
                \App::setLocale($client->lang);
                if ($client->lang == 'ar') {
                    $restaurant_name = $restaurant->name_ar;
                } else {
                    $restaurant_name = $restaurant->name_en;
                }
            }
            $userId = $order->user_id;
            $from = $user->id;
            $msg = \Lang::get('message.orderConfirmation', ['restaurant_name' => $restaurant_name, 'order_id' => $order->id]);
            $order_id = $order->id;
            $NotificationType = 3;
            $notification = new NotificationsController();
            $notification->sendNot($userId, $from, $msg, $order_id, $NotificationType);

        } else {
            return redirect()->back();
        }
        return redirect('/orders');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if ($user->admin == 2) {
            $order = Order::with(['user', 'status', 'cart.address' , 'cart.cartCollection.collection.serviceType', 'cart.cartCollection' => function ($query) use ($user) {
                $query->where('restaurant_id', $user->restaurant_id);
            }])->where('id', $id)->first();
            $restaurantOrder = OrderRestaurant::where('order_id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if (!$restaurantOrder) {
                return redirect()->back();
            }
            return view('orders.order_edit', [
                'order' => $order,
                'restaurantOrder' => $restaurantOrder,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function update($id)
    {
        $user = Auth::user();
        if ($user->admin == 2) {
            $order = Order::where('id', $id)->first();
            $restaurant = Restaurant::where('id', $user->restaurant_id)->first();
            $providerOrder = OrderRestaurant::where('order_id', $id)->where('restaurant_id', $user->restaurant_id)->where('status_id', 2)->first();
            if (!$providerOrder) {
                return redirect('/orders');
            }
            $providerOrder->status_id = 3;
            $providerOrder->save();
            $restaurantOrders = OrderRestaurant::where('order_id', $id)->where('status_id', 2)->get();

            if($restaurantOrders->isEmpty()){

                $order->status_id = 3;
                $order->save();

                $client = User::where('id', $order->user_id)->first();
                if (!$client->lang) {
                    \App::setLocale("en");
//                    $restaurant_name = $restaurant->name_en;
                } else {
                    \App::setLocale($client->lang);
//                    if ($client->lang == 'ar') {
//                        $restaurant_name = $restaurant->name_ar;
//                    } else {
//                        $restaurant_name = $restaurant->name_en;
//                    }
                }
                $userId = $order->user_id;
                $from = $user->id;
                $msg = \Lang::get('message.orderCompleteStatus', ['order_id' => $order->id]);
                $order_id = $order->id;
                $NotificationType = 4;
                $notification = new NotificationsController();
                $notification->sendNot($userId, $from, $msg, $order_id, $NotificationType);

            }


        } else {
            return redirect()->back();
        }
        return redirect('/orders');
    }

    public function orderList(Request $request)
    {
//        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $req_auth = $request->header('Authorization');
        $user_id = User::getUserByToken($req_auth);
        if ($user_id) {
            $orders = Order::where('user_id', $user_id)->orderby('id', 'desc')->with(['cart.address', 'cart.cartCollection.cartItem.menu', 'status', 'cart.cartCollection.collection.serviceType' ,'cart.cartCollection.cartItem.category', 'cart.cartCollection.collection.category'])->paginate(20);
            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    if ($order->cart->address->is_apartment == 1) {
                        $is_apartment = true;
                    } else {
                        $is_apartment = false;
                    }
                    if ($order->cart->address->is_default == 1) {
                        $default = true;
                    } else {
                        $default = false;
                    }
                    $address_id = $order->cart->address->id;
                    $address = [
                        'address_name' => $order->cart->address->name,
                        'mobile_number' => $order->cart->address->mobile_number,
                        'location' => $order->cart->address->location,
                        'street_number' => $order->cart->address->street_number,
                        'building_number' => $order->cart->address->building_number,
                        'zone' => $order->cart->address->zone,
                        'is_apartment' => $is_apartment,
                        'apartment_number' => $order->cart->address->apartment_number,
                        'is_default' => $default,
                        'latitude' => $order->cart->address->latitude,
                        'longitude' => $order->cart->address->longitude,
                    ];
                    $total = 0;
                    $collections = [];

                    foreach ($order->cart->cartCollection as $cartCollection) {
                        $menu = [];

                        foreach($cartCollection->cartItem as $cartItem){

                            if ($lang == 'ar') {
                                $menu_name = $cartItem->category->name_ar;
                            } else {
                                $menu_name = $cartItem->category->name_en;
                            }

                            if ($lang == 'ar') {
                                $item_name = $cartItem->menu->name_ar;
                            } else {
                                $item_name = $cartItem->menu->name_en;
                            }

                            $menu [] = [
                                'menu_id' => $cartItem->menu_id,
                                'menu_name' => $menu_name,
                                'item_id' => $cartItem->item_id,
                                'item_name' => $item_name,
                                'item_price' => $cartItem->menu->price,
                                'item_quantity' => $cartItem->quantity,
                                'item_price_unit' => \Lang::get('message.priceUnit')
                            ];
                        }

                        if ($cartCollection->collection->price == null) {
                            $collection_price = '';
                        } else {
                            $collection_price = $cartCollection->collection->price;
                        }
                        if ($cartCollection->persons_count == null) {
                            $persons_count = -1;
                        } else {
                            $persons_count = $cartCollection->persons_count;
                        }
                        if ($cartCollection->quantity == null) {
                            $quantity = '';
                        } else {
                            $quantity = $cartCollection->quantity;
                        }
                        if ($cartCollection->female_caterer == 1) {
                            $female_caterer = true;
                        } else {
                            $female_caterer = false;
                        }

                        if ($lang == 'ar') {
                            $restaurant_name = $cartCollection->collection->restaurant->name_ar;
                            $collection_type = $cartCollection->collection->category->name_ar;
                            $collection_name = $cartCollection->collection->name_ar;
                            $service_type = $cartCollection->collection->serviceType->name_ar;
                        } else {
                            $restaurant_name = $cartCollection->collection->restaurant->name_en;
                            $collection_type = $cartCollection->collection->category->name_en;
                            $collection_name = $cartCollection->collection->name_en;
                            $service_type = $cartCollection->collection->serviceType->name_en;
                        }

                        $collections [] = [
                            'restaurant_id' => $cartCollection->collection->restaurant->id,
                            'restaurant_name' => $restaurant_name,
                            'collection_id' => $cartCollection->collection_id,
                            'collection_category_id' => $cartCollection->collection->category_id,
                            'collection_category' => $collection_type,
                            'collection_name' => $collection_name,
                            'collection_price' => $collection_price,
                            'collection_price_unit' => \Lang::get('message.priceUnit'),
                            'female_caterer' => $female_caterer,
                            'special_instruction' => $cartCollection->special_instruction,
                            'service_type_id' => $cartCollection->collection->serviceType->service_type_id,
                            'service_type' => $service_type,
                            'menu_items' => $menu,
                            'quantity' => $quantity,
                            'persons_count' => $persons_count,
                            'subtotal' => $cartCollection->price,
                            'subtotal_unit' => \Lang::get('message.priceUnit'),
                        ];
                        $total += $cartCollection->price;
                    }

                    $cart = [
                        'cart_id' => $order->cart->id,
                        'delivery_area' => $order->cart->delivery_order_area,
                        'delivery_date' => date("j M Y", strtotime($order->cart->delivery_order_date)),
                        'delivery_time' => date("g:i A", strtotime($order->cart->delivery_order_time)),
                        'delivery_address_id' => $address_id,
                        'delivery_address' => $address,
                        'collections' => $collections,
                        'total' => $total,
                        'total_unit' => \Lang::get('message.priceUnit'),
                    ];

                    if ($order->is_rated == 1) {
                        $rated = true;
                    } else {
                        $rated = false;
                    }
                    if ($lang == 'ar') {
                        $status = $order->status->name_ar;
                    } else {
                        $status = $order->status->name_en;
                    }

                    $arr [] = [
                        'order_id' => $order->id,
                        'order_status_id' => $order->status_id,
                        'order_status' => $status,
                        'order_date' => date("j M Y", strtotime($order->created_at)),
                        'order_time' => date("g:i A", strtotime($order->created_at)),
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
            } else {
                return response()->json(array(
                    'success' => 0,
                    'status_code' => 200,
                    'data' => [],
                    'message' => \Lang::get('message.noOrder')));
            }
        } else {
            return response()->json(array(
                'success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }
    }

    public function orderDetails(Request $request, $id)
    {
//        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $req_auth = $request->header('Authorization');
        $user_id = User::getUserByToken($req_auth);
        if ($user_id) {
            $order = Order::where('id', $id)->where('user_id', $user_id)->with([ 'status','cart.address', 'cart.cartCollection.collection.serviceType', 'cart.cartCollection.cartItem.menu', 'cart.cartCollection.cartItem.category', 'cart.cartCollection.collection.category'])->first();
            if ($order) {
                if ($order->cart->address->is_apartment == 1) {
                    $is_apartment = true;
                } else {
                    $is_apartment = false;
                }
                if ($order->cart->address->is_default == 1) {
                    $default = true;
                } else {
                    $default = false;
                }
                $address_id = $order->cart->address->id;
                $address = [
                    'address_name' => $order->cart->address->name,
                    'mobile_number' => $order->cart->address->mobile_number,
                    'location' => $order->cart->address->location,
                    'street_number' => $order->cart->address->street_number,
                    'building_number' => $order->cart->address->building_number,
                    'zone' => $order->cart->address->zone,
                    'is_apartment' => $is_apartment,
                    'apartment_number' => $order->cart->address->apartment_number,
                    'is_default' => $default,
                    'latitude' => $order->cart->address->latitude,
                    'longitude' => $order->cart->address->longitude,
                ];
                $total = 0;
                $collections = [];

                foreach ($order->cart->cartCollection as $cartCollection) {
                    $menu = [];

                    foreach($cartCollection->cartItem as $cartItem){

                        if ($lang == 'ar') {
                            $menu_name = $cartItem->category->name_ar;
                        } else {
                            $menu_name = $cartItem->category->name_en;
                        }

                        if ($lang == 'ar') {
                            $item_name = $cartItem->menu->name_ar;
                        } else {
                            $item_name = $cartItem->menu->name_en;
                        }

                        $menu [] = [
                            'menu_id' => $cartItem->menu_id,
                            'menu_name' => $menu_name,
                            'item_id' => $cartItem->item_id,
                            'item_name' => $item_name,
                            'item_price' => $cartItem->menu->price,
                            'item_quantity' => $cartItem->quantity,
                            'item_price_unit' => \Lang::get('message.priceUnit')
                        ];
                    }

                    if ($cartCollection->collection->price == null) {
                        $collection_price = '';
                    } else {
                        $collection_price = $cartCollection->collection->price;
                    }
                    if ($cartCollection->persons_count == null) {
                        $persons_count = -1;
                    } else {
                        $persons_count = $cartCollection->persons_count;
                    }
                    if ($cartCollection->quantity == null) {
                        $quantity = '';
                    } else {
                        $quantity = $cartCollection->quantity;
                    }
                    if ($cartCollection->female_caterer == 1) {
                        $female_caterer = true;
                    } else {
                        $female_caterer = false;
                    }

                    if ($lang == 'ar') {
                        $restaurant_name = $cartCollection->collection->restaurant->name_ar;
                        $collection_type = $cartCollection->collection->category->name_ar;
                        $collection_name = $cartCollection->collection->name_ar;
                        $service_type = $cartCollection->collection->serviceType->name_ar;
                    } else {
                        $restaurant_name = $cartCollection->collection->restaurant->name_en;
                        $collection_type = $cartCollection->collection->category->name_en;
                        $collection_name = $cartCollection->collection->name_en;
                        $service_type = $cartCollection->collection->serviceType->name_en;
                    }

                    $collections [] = [
                        'restaurant_id' => $cartCollection->collection->restaurant->id,
                        'restaurant_name' => $restaurant_name,
                        'collection_id' => $cartCollection->collection_id,
                        'collection_category_id' => $cartCollection->collection->category_id,
                        'collection_category' => $collection_type,
                        'collection_name' => $collection_name,
                        'collection_price' => $collection_price,
                        'collection_price_unit' => \Lang::get('message.priceUnit'),
                        'female_caterer' => $female_caterer,
                        'special_instruction' => $cartCollection->special_instruction,
                        'service_type_id' => $cartCollection->collection->serviceType->service_type_id,
                        'service_type' => $service_type,
                        'menu_items' => $menu,
                        'quantity' => $quantity,
                        'persons_count' => $persons_count,
                        'subtotal' => $cartCollection->price,
                        'subtotal_unit' => \Lang::get('message.priceUnit'),
                    ];
                    $total += $cartCollection->price;
                }


                $cart = [
                    'cart_id' => $order->cart->id,
                    'delivery_area' => $order->cart->delivery_order_area,
                    'delivery_date' => date("j M Y", strtotime($order->cart->delivery_order_date)),
                    'delivery_time' => date("g:i A", strtotime($order->cart->delivery_order_time)),
                    'delivery_address_id' => $address_id,
                    'delivery_address' => $address,
                    'collections' => $collections,
                    'total' => $total,
                    'total_unit' => \Lang::get('message.priceUnit'),
                ];

                if ($order->is_rated == 1) {
                    $rated = true;
                } else {
                    $rated = false;
                }
                if ($lang == 'ar') {
                    $status = $order->status->name_ar;
                } else {
                    $status = $order->status->name_en;
                }

                $arr [] = [
                    'order_id' => $order->id,
                    'order_status_id' => $order->status_id,
                    'order_status' => $status,
                    'order_date' => date("j M Y", strtotime($order->created_at)),
                    'order_time' => date("g:i A", strtotime($order->created_at)),
                    'total_price' => $order->total_price,
                    'total_price_unit' => \Lang::get('message.priceUnit'),
                    'is_rated' => $rated,
                    'cart' => $cart
                ];


                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $arr));
            } else {
                return response()->json(array(
                    'success' => 0,
                    'status_code' => 200,
                    'data' => [],
                    'message' => \Lang::get('message.noOrder')));
            }
        } else {
            return response()->json(array(
                'success' => 0,
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function completeOrder(Request $request)
    {
        // \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);

        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }

        $req_auth = $request->header('Authorization');
        $user_id = User::getUserByToken($req_auth);

        if ($user_id) {
            $DataRequests = $request->all();

            $validator = \Validator::make($DataRequests, [
                'cart_id' => 'required|integer',
                'payment_type' => 'required|integer',
                'total_price' => 'required|numeric',
                'orders' => 'required'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'success' => 0, 'status_code' => 400,
                    'message' => 'Invalid inputs',
                    'error_details' => $validator->messages()
                ]);

            } else {

                $cart_id = $DataRequests['cart_id'];
                $payment_type = $DataRequests['payment_type'];
                $price = $DataRequests['total_price'];
                $cart = UserCart::with('address')->where('user_id', $user_id)->where('id', $cart_id)->first();

                if ($cart) {

                    if ($cart->completed == 0) {

                        if ($cart->delivery_address_id == null) {
                            return response()->json([
                                'success' => 0,
                                'status_code' => 200,
                                'message' => \Lang::get('message.addAddress')
                            ]);
                        }

                        $day = Carbon::parse($cart->delivery_order_date)->dayOfWeek;
                        $delivery_time = $cart->delivery_order_time;
                        $deliveryArea = $cart->delivery_order_area;
                        $restaurantOrders = $DataRequests['orders'];

                        $restaurantIDs = array_column($restaurantOrders, 'restaurant_id');

                        $restaurants = Restaurant::whereHas('workingHour', function ($query) use ($day, $delivery_time) {
                                $query->where([ ['weekday', $day], ['opening_time', '<=', $delivery_time], ['closing_time', '>=', $delivery_time], ['status', '1'] ]);
                            })
                        ->whereIn('id', $restaurantIDs)
                        ->get();

                        $areas = RestaurantArea::where('area_id', $deliveryArea)->whereIn('restaurant_id', $restaurantIDs)->get();

                        if ($restaurants->isEmpty() || count($restaurantIDs) != $restaurants->count()) {

                            return response()->json([
                                'success' => 0,
                                'status_code' => 200,
                                'message' => \Lang::get('message.availabilityChanged', [ 'restaurant_name' => 'Restaurant' ])
                            ]);
                        }

                        if ($areas->isEmpty() || count($restaurantIDs) != $areas->count()) {

                            return response()->json([
                                'success' => 0,
                                'status_code' => 200,
                                'message' => \Lang::get('message.areaRemoved')
                            ]);
                        }

                        foreach ($restaurantOrders as $restaurantOrder) {

                            foreach ($restaurants as $restaurant) {

                                if ($restaurant->id == $restaurantOrder['restaurant_id']) {
                                    $resArray[] = [
                                        'id' => $restaurant->id,
                                        'restaurant_name' => $lang == 'ar' ? $restaurant->name_ar : $restaurant->name_en,
                                        'total_price' => $restaurantOrder['restaurant_total']
                                    ];
                                }
                            }
                        }

                        $order = new Order;
                        $order->user_id = $user_id;
                        $order->cart_id = $cart_id;
                        $order->payment_type = $payment_type;

                        if (isset($DataRequests['transaction_id'])) {
                            $transaction_id = $DataRequests['transaction_id'];
                            $order->transaction_id = $transaction_id;
                        }

                        $order->total_price = $price;
                        $order->status_id = 1;
                        $order->save();

                        foreach ($resArray as $res) {

                            $orderRestaurantData[] = [
                                'restaurant_id' => $res['id'],
                                'order_id' => $order->id,
                                'total_price' => $res['total_price'],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                        }

                        OrderRestaurant::insert($orderRestaurantData);

                        $cart->update([ 'completed' => 1 ]);

                        // SendEmailAndSMSAfterCompleteOrder::dispatch($restaurants);

                    } else {
                        return response()->json([
                            'success' => 0,
                            'status_code' => 200,
                            'message' => \Lang::get('message.orderComplete')
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 0,
                        'status_code' => 200,
                        'message' => \Lang::get('message.noCart')
                    ]);
                }

                if ($order->payment_type == 1) {
                    $order->transaction_id = -1;
                    $payment = \Lang::get('message.cash');
                }
                if ($order->payment_type == 2) {
                    $payment = \Lang::get('message.credit');
                }
                if ($order->payment_type == 3) {
                    $payment = \Lang::get('message.debit');
                }


                $arr = [
                    'order_id' => $order->id,
                    'transaction_id' => $order->transaction_id,
                    'payment_type' => $payment,
                    'total_price' => $order->total_price,
                    'price_unit' => \Lang::get('message.priceUnit')
                ];

                return response()->json([
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $arr
                ]);
            }
        } else {
            return response()->json([
                'success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')
            ]);
        }
    }

    public function sendSMS($restaurants)
    {
        $randkey = rand(100000, 900000);
        $user_phone = '30666303';

        foreach ($restaurants as $restaurant) {

            $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content= &destination=974$user_phone&source=97772&mask=Qckly";
            // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=Your%20Mzad%20Qatar%20code%20is%20:%20$randkey&destination=974$user_phone&source=97772&mask=Mzad%20Qatar";
            $ret = file($url);
        }
    }

    public function testEMAIL()
    {
        $email = 'mabdulfattah@ebdaadt.com';

        Mail::send('welcome', [
            'email' => $email
        ], function ($m) use ($email) {
            $title = 'Qckly';
            $subject = 'Qckly Order Request';

            $m->from(config('mail.from.address'), $title);
            $m->to($email, $email)->subject($subject);
        });

        return response()->json([
            'success' => true,
            'email' => $email
        ]);
    }


//    public function deleteOrder(Request $request)
//    {
//        $user = Auth::user();
//        $id = $request->get('id');
//        if ($user->admin == 1) {
//            Order::whereIn('id', $id)->delete();
//        } elseif ($user->admin == 2) {
//            $user = $user->load('restaurant');
//            $restaurant = $user->restaurant;
//            $order = OrderRestaurant::where('order_id', $id)->where('restaurant_id', $restaurant->id)->first();
//            if ($order) {
//                $order->delete();
//                Order::where('id', $id)->decrement('total_price', $order->total_price);
//                $orders = OrderRestaurant::where('order_id', $id)->where('status_id', '!=', 2)->get();
//                if(count($orders) <= 0){
//                    Order::where('id', $id)->update(['status_id' => 2]);
//                }
//            }
//        }
//        return redirect('/orders');
//
//    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     *
     * /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

}
