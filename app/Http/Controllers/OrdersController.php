<?php

namespace App\Http\Controllers;

use App\DeliveryAddress;
use App\OrderCollection;
use App\OrderCollectionItem;
use App\OrderCollectionMenu;
use App\OrderRestaurant;
use App\UserCartCollection;
use Illuminate\Http\Request;
use App\Order;
use App\UserCart;
use App\User;
use App\MenuCategory;
use App\Restaurant;
use App\Status;
use Auth;
use App\Events\NewMessage;

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
        $restaurants = Restaurant::all();
        $statuses = Status::all();
        $selectedRestaurant = [];
        $data = $request->all();
        $orders = [];
        if ($id) {
            $orders = OrderRestaurant::where('restaurant_id', $id);
            if (isset($data['order_status'])) {
                $orders = $orders->where('status_id', $data['order_status']);
            }

            if (isset($data['order_search'])) {
                $orders = $orders->name($data['order_search']);
            }
            $selectedRestaurant = Restaurant::find($id);
            $orders = $orders->orderby('created_at', 'desc')->paginate(20);
        }
        if ($user->admin == 2) {
            $selectedRestaurant = Restaurant::find($user->restaurant_id);
            $orders = OrderRestaurant::where('restaurant_id', $user->restaurant_id);
            if (isset($data['order_status'])) {
                $orders = $orders->where('status_id', $data['order_status']);
            }

            if (isset($data['order_search'])) {
                $orders = $orders->name($data['order_search']);
            }
            $orders = $orders->orderby('created_at', 'desc')->paginate(20);
        }
        return view('orders', [
            'id' => $id,
            'statuses' => $statuses,
            'orders' => $orders,
            'restaurants' => $restaurants,
            'selectedRestaurant' => $selectedRestaurant,
            'user' => $user
        ]);
    }

    public function orderConfirmation($id)
    {

        $user = Auth::user();
        if ($user->admin == 2) {
            $restaurant = Restaurant::where('id', $user->restaurant_id)->first();
            $restaurantOrder = OrderRestaurant::where('order_id', $id)->where('restaurant_id', $user->restaurant_id)->where('status_id', 1)->first();
            if (!$restaurantOrder) {
                return redirect()->back();
            }

            $restaurantOrder->status_id = 2;
            $restaurantOrder->save();
            $restaurantOrders = OrderRestaurant::where('order_id', $id)->where('status_id', '!=', 2)->get();
            $order = Order::where('id', $id)->first();
            if (count($restaurantOrders) <= 0) {
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
            $statuses = Status::where('id', '!=', 1)->get();
            $order = Order::with(['cart' => function ($query) use ($user) {
                $query->with(['cartCollection' => function ($q) use ($user) {
                    $q->where('restaurant_id', $user->restaurant_id);
                }]);
            }])->where('id', $id)->first();
            $restaurantOrder = OrderRestaurant::where('order_id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if (!$restaurantOrder) {
                return redirect()->back();
            }
            return view('order_edit', [
                'order' => $order,
                'restaurantOrder' => $restaurantOrder,
                'statuses' => $statuses
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->admin == 2) {
            $restaurantOrder = OrderRestaurant::where('order_id', $id)->where('restaurant_id', $user->restaurant_id)->where('status_id', 2)->first();
            if (!$restaurantOrder) {
                return redirect('/orders');
            }
            $restaurantOrder->status_id = $request->input('status');
            $restaurantOrder->save();
            $restaurantOrders = OrderRestaurant::where('order_id', $id)->where('status_id', '!=', 3)->get();
            if (count($restaurantOrders) <= 0) {
                $order = Order::where('id', $id)->first();
                $order->status_id = 3;
                $order->save();
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
            $orders = Order::where('user_id', $user_id)->orderby('created_at', 'desc')->with('cart.address')->paginate(20);
            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    if ($order->deliveryAddress->is_apartment == 1) {
                        $is_apartment = true;
                    } else {
                        $is_apartment = false;
                    }
                    if ($order->deliveryAddress->is_default == 1) {
                        $default = true;
                    } else {
                        $default = false;
                    }
                    $address_id = $order->deliveryAddress->id;
                    $address = [
                        'address_name' => $order->deliveryAddress->name,
                        'mobile_number' => $order->deliveryAddress->mobile_number,
                        'location' => $order->deliveryAddress->location,
                        'street_number' => $order->deliveryAddress->street_number,
                        'building_number' => $order->deliveryAddress->building_number,
                        'zone' => $order->deliveryAddress->zone,
                        'is_apartment' => $is_apartment,
                        'apartment_number' => $order->deliveryAddress->apartment_number,
                        'is_default' => $default,
                        'latitude' => $order->deliveryAddress->latitude,
                        'longitude' => $order->deliveryAddress->longitude,
                    ];
                    $total = 0;
                    $collections = [];
                    foreach($order->orderCollection as $orderCollection){
                        $menu = [];
                        $orderCollectionMenus = OrderCollectionMenu::where('order_id', $order->id)->where('order_collection_id', $orderCollection->collection_id)->get();
                        foreach ($orderCollectionMenus as $orderCollectionMenu){
                            $items = [];
                            $orderCollectionItems = OrderCollectionItem::where('order_id', $order->id)->where('order_collection_id', $orderCollection->collection_id)->where('order_collection_menu_id', $orderCollectionMenu->menu_id)->get();
                            foreach ($orderCollectionItems as $orderCollectionItem){
                                if ($lang == 'ar') {
                                    $item_name = $orderCollectionItem->item_ar;
                                } else {
                                    $item_name = $orderCollectionItem->item_en;
                                }

                                $items [] = [
                                    'item_id' => $orderCollectionItem->item_id,
                                    'item_name' => $item_name,
                                    'item_price' => $orderCollectionItem->item_price,
                                    'item_quantity' => $orderCollectionItem->quantity,
                                    'item_price_unit' => \Lang::get('message.priceUnit')
                                ];
                            }

                            if ($lang == 'ar') {
                                $menu_name = $orderCollectionMenu->menu_ar;
                            } else {
                                $menu_name = $orderCollectionMenu->menu_en;
                            }
                            $menu [] = [
                                'menu_id' => $orderCollectionMenu->menu_id,
                                'menu_name' => $menu_name,
                                'items' => $items
                            ];
                        }

                        if ($orderCollection->collection_price == null) {
                            $collection_price = '';
                        } else {
                            $collection_price = $orderCollection->collection_price;
                        }
                        if ($orderCollection->persons_count == null) {
                            $persons_count = -1;
                        } else {
                            $persons_count = $orderCollection->persons_count;
                        }
                        if ($orderCollection->quantity == null) {
                            $quantity = '';
                        } else {
                            $quantity = $orderCollection->quantity;
                        }
                        if ($orderCollection->female_caterer == 1) {
                            $female_caterer = true;
                        } else {
                            $female_caterer = false;
                        }

                        if ($lang == 'ar') {
                            $restaurant_name = $orderCollection->restaurant_ar;
                            $collection_type = $orderCollection->collection_category_ar;
                            $collection_name = $orderCollection->collection_ar;
                            $service_type = $orderCollection->service_type_ar;
                        } else {
                            $restaurant_name = $orderCollection->restaurant_en;
                            $collection_type = $orderCollection->collection_category_en;
                            $collection_name = $orderCollection->collection_en;
                            $service_type = $orderCollection->service_type_en;
                        }

                        $collections [] = [
                            'restaurant_id' => $orderCollection->restaurant_id,
                            'restaurant_name' => $restaurant_name,
                            'collection_id' => $orderCollection->collection_id,
                            'collection_category_id' => $orderCollection->collection_category_id,
                            'collection_category' => $collection_type,
                            'collection_name' => $collection_name,
                            'collection_price' => $collection_price,
                            'collection_price_unit' => \Lang::get('message.priceUnit'),
                            'female_caterer' => $female_caterer,
                            'special_instruction' => $orderCollection->special_instruction,
                            'service_type_id' => $orderCollection->service_type_id,
                            'service_type' => $service_type,
                            'menu_items' => $menu,
                            'quantity' => $quantity,
                            'persons_count' => $persons_count,
                            'subtotal' => $orderCollection->subtotal,
                            'subtotal_unit' => \Lang::get('message.priceUnit'),
                        ];
                        $total += $orderCollection->subtotal;
                    }
//                    foreach ($order->cart->cartCollection as $cart_collection) {
//                        $menu = [];
//                        $categories = MenuCategory::whereHas('cartItem', function ($query) use ($cart_collection) {
//                            $query->where('cart_collection_id', $cart_collection->id);
//                        })->with(['cartItem' => function ($x) use ($cart_collection) {
//                            $x->where('cart_collection_id', $cart_collection->id);
//                        }])->get();
//                        foreach ($categories as $category) {
//                            $items = [];
//                            foreach ($category->cartItem as $cartItem) {
//                                if ($lang == 'ar') {
//                                    $item_name = $cartItem->menu->name_ar;
//                                } else {
//                                    $item_name = $cartItem->menu->name_en;
//                                }
//                                $items [] = [
//                                    'item_id' => $cartItem->item_id,
//                                    'item_name' => $item_name,
//                                    'item_price' => $cartItem->menu->price,
//                                    'item_quantity' => $cartItem->quantity,
//                                    'item_price_unit' => \Lang::get('message.priceUnit')
//                                ];
//                            }
//                            if ($lang == 'ar') {
//                                $menu_name = $category->name_ar;
//                            } else {
//                                $menu_name = $category->name_en;
//                            }
//                            $menu [] = [
//                                'menu_id' => $category->id,
//                                'menu_name' => $menu_name,
//                                'items' => $items
//                            ];
//                        }
//                        if ($cart_collection->collection->price == null) {
//                            $collection_price = '';
//                        } else {
//                            $collection_price = $cart_collection->collection->price;
//                        }
//                        if ($cart_collection->persons_count == null) {
//                            $persons_count = -1;
//                        } else {
//                            $persons_count = $cart_collection->persons_count;
//                        }
//                        if ($cart_collection->quantity == null) {
//                            $quantity = '';
//                        } else {
//                            $quantity = $cart_collection->quantity;
//                        }
//                        if ($cart_collection->female_caterer == 1) {
//                            $female_caterer = true;
//                        } else {
//                            $female_caterer = false;
//                        }
//
//                        if ($lang == 'ar') {
//                            $restaurant_name = $cart_collection->collection->restaurant->name_ar;
//                            $collection_type = $cart_collection->collection->category->name_ar;
//                            $collection_name = $cart_collection->collection->name_ar;
//                            $service_type = $cart_collection->collection->serviceType->name_ar;
//                        } else {
//                            $restaurant_name = $cart_collection->collection->restaurant->name_en;
//                            $collection_type = $cart_collection->collection->category->name_en;
//                            $collection_name = $cart_collection->collection->name_en;
//                            $service_type = $cart_collection->collection->serviceType->name_en;
//                        }
//
//                        $collections [] = [
//                            'restaurant_id' => $cart_collection->collection->restaurant->id,
//                            'restaurant_name' => $restaurant_name,
//                            'collection_id' => $cart_collection->collection_id,
//                            'collection_category_id' => $cart_collection->collection->category_id,
//                            'collection_category' => $collection_type,
//                            'collection_name' => $collection_name,
//                            'collection_price' => $collection_price,
//                            'collection_price_unit' => \Lang::get('message.priceUnit'),
//                            'female_caterer' => $female_caterer,
//                            'special_instruction' => $cart_collection->special_instruction,
//                            'service_type_id' => $cart_collection->collection->service_type_id,
//                            'service_type' => $service_type,
//                            'menu_items' => $menu,
//                            'quantity' => $quantity,
//                            'persons_count' => $persons_count,
//                            'subtotal' => $cart_collection->price,
//                            'subtotal_unit' => \Lang::get('message.priceUnit'),
//                        ];
//                        $total += $cart_collection->price;
//                    }

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
            $order = Order::where('id', $id)->where('user_id', $user_id)->first();
            if ($order) {
                if ($order->deliveryAddress->is_apartment == 1) {
                    $is_apartment = true;
                } else {
                    $is_apartment = false;
                }
                if ($order->deliveryAddress->is_default == 1) {
                    $default = true;
                } else {
                    $default = false;
                }
                $address_id = $order->deliveryAddress->id;
                $address = [
                    'address_name' => $order->deliveryAddress->name,
                    'mobile_number' => $order->deliveryAddress->mobile_number,
                    'location' => $order->deliveryAddress->location,
                    'street_number' => $order->deliveryAddress->street_number,
                    'building_number' => $order->deliveryAddress->building_number,
                    'zone' => $order->deliveryAddress->zone,
                    'is_apartment' => $is_apartment,
                    'apartment_number' => $order->deliveryAddress->apartment_number,
                    'is_default' => $default,
                    'latitude' => $order->deliveryAddress->latitude,
                    'longitude' => $order->deliveryAddress->longitude,
                ];
                $total = 0;
                $collections = [];

                foreach($order->orderCollection as $orderCollection){
                    $menu = [];
                    $orderCollectionMenus = OrderCollectionMenu::where('order_id', $order->id)->where('order_collection_id', $orderCollection->collection_id)->get();
                    foreach ($orderCollectionMenus as $orderCollectionMenu){
                        $items = [];
                        $orderCollectionItems = OrderCollectionItem::where('order_id', $order->id)->where('order_collection_id', $orderCollection->collection_id)->where('order_collection_menu_id', $orderCollectionMenu->menu_id)->get();
                        foreach ($orderCollectionItems as $orderCollectionItem){
                            if ($lang == 'ar') {
                                $item_name = $orderCollectionItem->item_ar;
                            } else {
                                $item_name = $orderCollectionItem->item_en;
                            }

                            $items [] = [
                                'item_id' => $orderCollectionItem->item_id,
                                'item_name' => $item_name,
                                'item_price' => $orderCollectionItem->item_price,
                                'item_quantity' => $orderCollectionItem->quantity,
                                'item_price_unit' => \Lang::get('message.priceUnit')
                            ];
                        }

                        if ($lang == 'ar') {
                            $menu_name = $orderCollectionMenu->menu_ar;
                        } else {
                            $menu_name = $orderCollectionMenu->menu_en;
                        }
                        $menu [] = [
                            'menu_id' => $orderCollectionMenu->menu_id,
                            'menu_name' => $menu_name,
                            'items' => $items
                        ];
                    }

                    if ($orderCollection->collection_price == null) {
                        $collection_price = '';
                    } else {
                        $collection_price = $orderCollection->collection_price;
                    }
                    if ($orderCollection->persons_count == null) {
                        $persons_count = -1;
                    } else {
                        $persons_count = $orderCollection->persons_count;
                    }
                    if ($orderCollection->quantity == null) {
                        $quantity = '';
                    } else {
                        $quantity = $orderCollection->quantity;
                    }
                    if ($orderCollection->female_caterer == 1) {
                        $female_caterer = true;
                    } else {
                        $female_caterer = false;
                    }

                    if ($lang == 'ar') {
                        $restaurant_name = $orderCollection->restaurant_ar;
                        $collection_type = $orderCollection->collection_category_ar;
                        $collection_name = $orderCollection->collection_ar;
                        $service_type = $orderCollection->service_type_ar;
                    } else {
                        $restaurant_name = $orderCollection->restaurant_en;
                        $collection_type = $orderCollection->collection_category_en;
                        $collection_name = $orderCollection->collection_en;
                        $service_type = $orderCollection->service_type_en;
                    }

                    $collections [] = [
                        'restaurant_id' => $orderCollection->restaurant_id,
                        'restaurant_name' => $restaurant_name,
                        'collection_id' => $orderCollection->collection_id,
                        'collection_category_id' => $orderCollection->collection_category_id,
                        'collection_category' => $collection_type,
                        'collection_name' => $collection_name,
                        'collection_price' => $collection_price,
                        'collection_price_unit' => \Lang::get('message.priceUnit'),
                        'female_caterer' => $female_caterer,
                        'special_instruction' => $orderCollection->special_instruction,
                        'service_type_id' => $orderCollection->service_type_id,
                        'service_type' => $service_type,
                        'menu_items' => $menu,
                        'quantity' => $quantity,
                        'persons_count' => $persons_count,
                        'subtotal' => $orderCollection->subtotal,
                        'subtotal_unit' => \Lang::get('message.priceUnit'),
                    ];
                    $total += $orderCollection->subtotal;
                }

//                foreach ($order->cart->cartCollection as $cart_collection) {
//                    $menu = [];
//                    $categories = MenuCategory::whereHas('cartItem', function ($query) use ($cart_collection) {
//                        $query->where('cart_collection_id', $cart_collection->id);
//                    })->with(['cartItem' => function ($x) use ($cart_collection) {
//                        $x->where('cart_collection_id', $cart_collection->id);
//                    }])->get();
//                    foreach ($categories as $category) {
//                        $items = [];
//                        foreach ($category->cartItem as $cartItem) {
//                            if ($lang == 'ar') {
//                                $item_name = $cartItem->menu->name_ar;
//                            } else {
//                                $item_name = $cartItem->menu->name_en;
//                            }
//                            $items [] = [
//                                'item_id' => $cartItem->item_id,
//                                'item_name' => $item_name,
//                                'item_price' => $cartItem->menu->price,
//                                'item_quantity' => $cartItem->quantity,
//                                'item_price_unit' => \Lang::get('message.priceUnit')
//                            ];
//                        }
//                        if ($lang == 'ar') {
//                            $menu_name = $category->name_ar;
//                        } else {
//                            $menu_name = $category->name_en;
//                        }
//                        $menu [] = [
//                            'menu_id' => $category->id,
//                            'menu_name' => $menu_name,
//                            'items' => $items
//                        ];
//                    }
//                    if ($cart_collection->collection->price == null) {
//                        $collection_price = '';
//                    } else {
//                        $collection_price = $cart_collection->collection->price;
//                    }
//                    if ($cart_collection->persons_count == null) {
//                        $persons_count = -1;
//                    } else {
//                        $persons_count = $cart_collection->persons_count;
//                    }
//                    if ($cart_collection->quantity == null) {
//                        $quantity = '';
//                    } else {
//                        $quantity = $cart_collection->quantity;
//                    }
//                    if ($cart_collection->female_caterer == 1) {
//                        $female_caterer = true;
//                    } else {
//                        $female_caterer = false;
//                    }
//
//                    if ($lang == 'ar') {
//                        $restaurant_name = $cart_collection->collection->restaurant->name_ar;
//                        $collection_type = $cart_collection->collection->category->name_ar;
//                        $collection_name = $cart_collection->collection->name_ar;
//                        $service_type = $cart_collection->collection->serviceType->name_ar;
//                    } else {
//                        $restaurant_name = $cart_collection->collection->restaurant->name_en;
//                        $collection_type = $cart_collection->collection->category->name_en;
//                        $collection_name = $cart_collection->collection->name_en;
//                        $service_type = $cart_collection->collection->serviceType->name_en;
//                    }
//
//                    $collections [] = [
//                        'restaurant_id' => $cart_collection->collection->restaurant->id,
//                        'restaurant_name' => $restaurant_name,
//                        'collection_id' => $cart_collection->collection_id,
//                        'collection_type_id' => $cart_collection->collection->category_id,
//                        'collection_type' => $collection_type,
//                        'collection_name' => $collection_name,
//                        'collection_price' => $collection_price,
//                        'collection_price_unit' => \Lang::get('message.priceUnit'),
//                        'female_caterer' => $female_caterer,
//                        'special_instruction' => $cart_collection->special_instruction,
//                        'service_type_id' => $cart_collection->collection->service_type_id,
//                        'service_type' => $service_type,
//                        'menu_items' => $menu,
//                        'quantity' => $quantity,
//                        'persons_count' => $persons_count,
//                        'subtotal' => $cart_collection->price,
//                        'subtotal_unit' => \Lang::get('message.priceUnit'),
//                    ];
//                    $total += $cart_collection->price;
//                }

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
//        \Log::info($request->all());
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
                return response()->json(array('success' => 0, 'status_code' => 400,
                    'message' => 'Invalid inputs',
                    'error_details' => $validator->messages()));
            } else {
                $cart_id = $DataRequests['cart_id'];
                $payment_type = $DataRequests['payment_type'];
                $price = $DataRequests['total_price'];
                $cart = UserCart::where('user_id', $user_id)
                    ->where('id', $cart_id)->first();
                if ($cart) {
                    if ($cart->completed == 0) {
                        if ($cart->delivery_address_id == null) {
                            return response()->json(array(
                                'success' => 0,
                                'status_code' => 200,
                                'message' => \Lang::get('message.addAddress')));
                        }
                        $order = new Order();
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
                        if($order){
                            $restaurantOrders = $DataRequests['orders'];
                            foreach ($restaurantOrders as $restaurantOrder) {
                                $orderRestaurant = new OrderRestaurant();
                                $orderRestaurant->restaurant_id = $restaurantOrder['restaurant_id'];
                                $orderRestaurant->order_id = $order->id;
                                $orderRestaurant->total_price = $restaurantOrder['restaurant_total'];
                                $orderRestaurant->save();
                            }
                            UserCart::where('id', $cart_id)->update(['completed' => 1]);
                            $delivery_address = new DeliveryAddress();
                            $delivery_address->order_id = $order->id;
                            $delivery_address->address_id = $cart->delivery_address_id;
                            $delivery_address->name = $cart->address->name;
                            $delivery_address->mobile_number = $cart->address->mobile_number;
                            $delivery_address->location = $cart->address->location;
                            $delivery_address->street_number = $cart->address->street_number;
                            $delivery_address->building_number = $cart->address->building_number;
                            $delivery_address->zone = $cart->address->zone;
                            $delivery_address->is_apartment = $cart->address->is_apartment;
                            $delivery_address->latitude = $cart->address->latitude;
                            $delivery_address->longitude = $cart->address->longitude;
                            $delivery_address->apartment_number = $cart->address->apartment_number;
                            $delivery_address->save();

                            foreach ($order->cart->cartCollection as $cartCollection){
                                $orderCollection = new OrderCollection();
                                $orderCollection->order_id = $order->id;
                                $orderCollection->restaurant_id = $cartCollection->collection->restaurant->id;
                                $orderCollection->restaurant_en = $cartCollection->collection->restaurant->name_en;
                                $orderCollection->restaurant_ar = $cartCollection->collection->restaurant->name_ar;
                                $orderCollection->collection_id = $cartCollection->collection->id;
                                $orderCollection->collection_en = $cartCollection->collection->name_en;
                                $orderCollection->collection_ar = $cartCollection->collection->name_ar;
                                $orderCollection->collection_category_id = $cartCollection->collection->category->id;
                                $orderCollection->collection_category_en = $cartCollection->collection->category->name_en;
                                $orderCollection->collection_category_ar = $cartCollection->collection->category->name_ar;
                                $orderCollection->collection_price = $cartCollection->collection->price;
                                $orderCollection->subtotal = $cartCollection->price;
                                $orderCollection->female_caterer = $cartCollection->female_caterer;
                                $orderCollection->special_instruction = $cartCollection->special_instruction;
                                $orderCollection->service_type_id = $cartCollection->collection->service_type_id;
                                $orderCollection->service_type_en = $cartCollection->collection->serviceType->name_en;
                                $orderCollection->service_type_ar = $cartCollection->collection->serviceType->name_ar;
                                $orderCollection->quantity = $cartCollection->quantity;
                                $orderCollection->persons_count = $cartCollection->persons_count;
                                $orderCollection->save();

                                $categories = MenuCategory::whereHas('cartItem', function ($query) use ($cartCollection) {
                                    $query->where('cart_collection_id', $cartCollection->id);
                                })->with(['cartItem' => function ($x) use ($cartCollection) {
                                    $x->where('cart_collection_id', $cartCollection->id);
                                }])->get();

                                foreach ($categories as $category){
                                    $orderCollectionMenu = new OrderCollectionMenu();
                                    $orderCollectionMenu->order_id = $order->id;
                                    $orderCollectionMenu->order_collection_id = $cartCollection->collection_id;
                                    $orderCollectionMenu->menu_id = $category->id;
                                    $orderCollectionMenu->menu_en = $category->name_en;
                                    $orderCollectionMenu->menu_ar = $category->name_ar;
                                    $orderCollectionMenu->save();

                                    foreach ($category->cartItem as $cartItem){
                                        $orderCollectionItem = new OrderCollectionItem();
                                        $orderCollectionItem->order_id = $order->id;
                                        $orderCollectionItem->order_collection_id = $cartCollection->collection_id;
                                        $orderCollectionItem->order_collection_menu_id = $category->id;
                                        $orderCollectionItem->item_id = $cartItem->item_id;
                                        $orderCollectionItem->item_en = $cartItem->menu->name_en;
                                        $orderCollectionItem->item_ar = $cartItem->menu->name_ar;
                                        $orderCollectionItem->item_price = $cartItem->menu->price;
                                        $orderCollectionItem->quantity = $cartItem->quantity;
                                        $orderCollectionItem->save();
                                    }
                                }
                            }
                        }

                    } else {
                        return response()->json(array(
                            'success' => 0,
                            'status_code' => 200,
                            'message' => \Lang::get('message.orderComplete')));
                    }
                } else {
                    return response()->json(array(
                        'success' => 0,
                        'status_code' => 200,
                        'message' => \Lang::get('message.noCart')));
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
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $arr));
            }
        } else {
            return response()->json(array(
                'success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }
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
