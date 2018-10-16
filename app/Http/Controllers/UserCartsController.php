<?php

namespace App\Http\Controllers;

use App\Address;
use App\Category;
use App\Restaurant;
use App\UserCart;
use App\UserCartItem;
use App\UserCartCollection;
use App\Menu;
use App\Collection;
use App\CollectionItem;
use Carbon\Carbon;
use App\User;
use App\CollectionMenu;


//use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class UserCartsController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function createCart(Request $request)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $token = str_replace("Bearer ", "", $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->first();
        if ($user) {
            $DataRequests = $request->all();
            $validator = \Validator::make($DataRequests, [
                'collection_type' => 'required|integer',
                'collection_id' => 'required|integer',
                'female_caterer' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json(array('success' => 1, 'status_code' => 400,
                    'message' => 'Invalid inputs',
                    'error_details' => $validator->messages()));
            } else {
                $collection_type = $DataRequests['collection_type'];
                $collection_id = $DataRequests['collection_id'];
                $female_caterer = $DataRequests['female_caterer'];
                $special_instruction = '';
                if (isset($DataRequests['special_instruction'])) {
                    $special_instruction = $DataRequests['special_instruction'];
                }
                $cart = UserCart::where('user_id', '=', $user->id)->where('completed', 0)->first();
                if (!$cart) {
                    $validator = \Validator::make($DataRequests, [
                        'delivery_order_area' => 'required|integer',
                        'delivery_order_date' => 'required',
                        'delivery_order_time' => 'required',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(array('success' => 1, 'status_code' => 400,
                            'message' => 'Invalid inputs',
                            'error_details' => $validator->messages()));
                    } else {
                        $delivery_area = $DataRequests['delivery_order_area'];
                        $delivery_date = $DataRequests['delivery_order_date'];
                        $delivery_time = $DataRequests['delivery_order_time'];
                        $cart = new UserCart();
                        $cart->user_id = $user->id;
                        $address = Address::where('user_id', $user->id)->where('is_default', 1)->first();
                        if ($address) {
                            $cart->delivery_address_id = $address->id;
                        }
                        $cart->delivery_order_area = $delivery_area;
                        $cart->delivery_order_date = Carbon::parse($delivery_date);
                        $cart->delivery_order_time = Carbon::parse($delivery_time);
                        $cart->save();
                    }
                }
                if ($collection_type == 1) {
                    $validator = \Validator::make($DataRequests, [
                        'collection_price' => 'required|numeric',
                        'collection_quantity' => 'required|integer',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(array('success' => 1, 'status_code' => 400,
                            'message' => 'Invalid inputs',
                            'error_details' => $validator->messages()));
                    } else {
                        $collection_price = $DataRequests['collection_price'];
                        $collection_quantity = $DataRequests['collection_quantity'];
                        $collection = Collection::where('id', $collection_id)->first();
                        $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)->first();
                        if (!$cart_collection) {
                            $cart_collection = new UserCartCollection();
                            $cart_collection->collection_id = $collection_id;
                            $cart_collection->cart_id = $cart->id;
                            $cart_collection->restaurant_id = $collection->restaurant_id;
                            $cart_collection->price = $collection_price;
                            $cart_collection->quantity = $collection_quantity;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            $collection_items = CollectionItem::where('collection_id', $collection_id)->with('menu')->get();
                            foreach ($collection_items as $collection_item) {
                                $cart_item = new UserCartItem();
                                $cart_item->menu_id = $collection_item->menu->category_id;
                                $cart_item->item_id = $collection_item->menu->id;
                                $cart_item->quantity = $collection_item->quantity;
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->save();
                            }
                        } else {
                            $cart_collection->price = $collection_price;
                            $cart_collection->quantity = $collection_quantity;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                        }

                    }

                } else if ($collection_type == 2) {
                    $validator = \Validator::make($DataRequests, [
                        'collection_price' => 'required|numeric',
                        'persons_count' => 'required|integer',
                        'menus' => 'required',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(array('success' => 1, 'status_code' => 400,
                            'message' => 'Invalid inputs',
                            'error_details' => $validator->messages()));
                    } else {
                        $collection_price = $DataRequests['collection_price'];
                        $persons_count = $DataRequests['persons_count'];
                        $menus = $DataRequests['menus'];
                        $collection = Collection::where('id', $collection_id)->first();
                        $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)->first();
                        if (!$cart_collection) {
                            $cart_collection = new UserCartCollection();
                            $cart_collection->collection_id = $collection_id;
                            $cart_collection->restaurant_id = $collection->restaurant_id;
                            $cart_collection->cart_id = $cart->id;
                            $cart_collection->price = $collection_price;
                            $cart_collection->persons_count = $persons_count;
                            $cart_collection->quantity = 1;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            foreach ($menus as $menu) {
                                $cart_item = new UserCartItem();
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->menu_id = $menu['menu_id'];
                                $cart_item->item_id = $menu['item_id'];
                                $cart_item->quantity = $menu['item_quantity'];
                                $cart_item->save();
                            }
                        } else {
                            $cart_collection->price = $collection_price;
                            $cart_collection->persons_count = $persons_count;
                            $cart_collection->quantity = 1;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            UserCartItem::where('cart_collection_id', $cart_collection->id)->delete();
                            foreach ($menus as $menu) {
                                $cart_item = new UserCartItem();
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->menu_id = $menu['menu_id'];
                                $cart_item->item_id = $menu['item_id'];
                                $cart_item->quantity = $menu['item_quantity'];
                                $cart_item->save();
                            }
                        }
                    }
                } elseif ($collection_type == 3) {
                    $validator = \Validator::make($DataRequests, [
                        'collection_price' => 'required|numeric',
                        'collection_quantity' => 'required|integer',
                        'menus' => 'required',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(array('success' => 1, 'status_code' => 400,
                            'message' => 'Invalid inputs',
                            'error_details' => $validator->messages()));
                    } else {
                        $collection_price = $DataRequests['collection_price'];
                        $collection_quantity = $DataRequests['collection_quantity'];
                        $menus = $DataRequests['menus'];
                        $collection = Collection::where('id', $collection_id)->first();
                        $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)->first();
                        if (!$cart_collection) {
                            $cart_collection = new UserCartCollection();
                            $cart_collection->collection_id = $collection_id;
                            $cart_collection->restaurant_id = $collection->restaurant_id;
                            $cart_collection->cart_id = $cart->id;
                            $cart_collection->price = $collection_price;
                            $cart_collection->quantity = $collection_quantity;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            foreach ($menus as $menu) {
                                $cart_item = new UserCartItem();
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->menu_id = $menu['menu_id'];
                                $cart_item->item_id = $menu['item_id'];
                                $cart_item->quantity = $menu['item_quantity'];
                                $cart_item->save();
                            }
                        } else {
                            $cart_collection->price = $collection_price;
                            $cart_collection->quantity = $collection_quantity;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            UserCartItem::where('cart_collection_id', $cart_collection->id)->delete();
                            foreach ($menus as $menu) {
                                $cart_item = new UserCartItem();
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->menu_id = $menu['menu_id'];
                                $cart_item->item_id = $menu['item_id'];
                                $cart_item->quantity = $menu['item_quantity'];
                                $cart_item->save();
                            }
                        }
                    }
                } elseif ($collection_type == 4) {
                    $validator = \Validator::make($DataRequests, [
                        'collection_price' => 'required|numeric',
                        'menus' => 'required',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(array('success' => 1, 'status_code' => 400,
                            'message' => 'Invalid inputs',
                            'error_details' => $validator->messages()));
                    } else {
                        $collection_price = $DataRequests['collection_price'];
                        $menus = $DataRequests['menus'];
                        $collection = Collection::where('id', $collection_id)->first();
                        $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)->first();
                        if (!$cart_collection) {
                            $cart_collection = new UserCartCollection();
                            $cart_collection->collection_id = $collection_id;
                            $cart_collection->restaurant_id = $collection->restaurant_id;
                            $cart_collection->cart_id = $cart->id;
                            $cart_collection->price = $collection_price;
                            $cart_collection->quantity = 1;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            foreach ($menus as $menu) {
                                $cart_item = new UserCartItem();
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->menu_id = $menu['menu_id'];
                                $cart_item->item_id = $menu['item_id'];
                                $cart_item->price = $menu['item_price'];
                                $cart_item->quantity = $menu['item_quantity'];
                                $cart_item->save();
                            }
                        } else {
                            $cart_collection->price = $collection_price;
                            $cart_collection->quantity = 1;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            UserCartItem::where('cart_collection_id', $cart_collection->id)->delete();
                            foreach ($menus as $menu) {
                                $cart_item = new UserCartItem();
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->menu_id = $menu['menu_id'];
                                $cart_item->item_id = $menu['item_id'];
                                $cart_item->price = $menu['item_price'];
                                $cart_item->quantity = $menu['item_quantity'];
                                $cart_item->save();
                            }
                        }
                    }
                }
                $arr = [
                    'cart_id' => $cart->id
                ];

                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $arr,
                    'message' => \Lang::get('message.collectionSuccess')));
            }
        } else {
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showCart(Request $request, $id)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $token = str_replace("Bearer ", "", $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->first();
        if ($user) {
            $cart = UserCart::where('id', $id)
                ->where('user_id', $user->id)
                ->where('completed', 0)
                ->with(['address', 'cartCollection' => function ($query) {
                    $query->with(['cartItem', 'collection.category']);
                }])->first();
            if ($cart) {
                $address = (object)array();
                $address_id = -1;
                if ($cart->address) {
                    if ($cart->address->is_apartment == 1) {
                        $is_apartment = true;
                    } else {
                        $is_apartment = false;
                    }
                    if ($cart->address->is_default == 1) {
                        $default = true;
                    } else {
                        $default = false;
                    }
                    $address_id = $cart->address->id;
                    $address = [
                        'address_name' => $cart->address->name,
                        'mobile_number' => $cart->address->mobile_number,
                        'location' => $cart->address->location,
                        'building_number' => $cart->address->building_number,
                        'zone' => $cart->address->zone,
                        'is_apartment' => $is_apartment,
                        'apartment_number' => $cart->address->apartment_number,
                        'is_default' => $default,
                        'latitude' => $cart->address->latitude,
                        'longitude' => $cart->address->longitude,
                    ];
                }


                if (count($cart->cartCollection) > 0) {
                    $total = 0;
                    foreach ($cart->cartCollection as $cart_collection) {
                        $menu = [];
                        $categories = Category::whereHas('cartItem', function ($query) use ($cart_collection) {
                            $query->where('cart_collection_id', $cart_collection->id);
                        })->with(['cartItem' => function ($x) use ($cart_collection) {
                            $x->where('cart_collection_id', $cart_collection->id);
                        }])->get();
                        foreach ($categories as $category) {
                            $items = [];
                            foreach ($category->cartItem as $cartItem) {
                                if ($lang == 'ar') {
                                    $item_name = $cartItem->menu->name_ar;
                                } else {
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
                            if ($lang == 'ar') {
                                $menu_name = $category->name_ar;
                            } else {
                                $menu_name = $category->name_en;
                            }

                            $menu [] = [
                                'menu_id' => $category->id,
                                'menu_name' => $menu_name,
                                'items' => $items
                            ];
                        }
                        if ($cart_collection->collection->price == null) {
                            $collection_price = '';
                        } else {
                            $collection_price = $cart_collection->collection->price;
                        }
                        if ($cart_collection->persons_count == null) {
                            $persons_count = -1;
                        } else {
                            $persons_count = $cart_collection->persons_count;
                        }
                        if ($cart_collection->quantity == null) {
                            $quantity = '';
                        } else {
                            $quantity = $cart_collection->quantity;
                        }
                        if ($cart_collection->female_caterer == 1) {
                            $female_caterer = true;
                        } else {
                            $female_caterer = false;
                        }


                        if ($lang == 'ar') {
                            $restaurant_name = $cart_collection->collection->restaurant->name_ar;
                            $collection_type = $cart_collection->collection->category->name_ar;
                            $collection_name = $cart_collection->collection->name_ar;
                        } else {
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
                    $arr = [
                        'cart_id' => $cart->id,
                        'delivery_area' => $cart->delivery_order_area,
                        'delivery_date' => $cart->delivery_order_date,
                        'delivery_time' => date("g:i a", strtotime($cart->delivery_order_time)),
                        'delivery_address_id' => $address_id,
                        'delivery_address' => $address,
                        'collections' => $collections,
                        'total' => $total,
                        'total_unit' => \Lang::get('message.priceUnit'),
                    ];
                }
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $arr));
            } else {
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => []));
            }
        } else {
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }

    }

    public function cartCount(Request $request)
    {
        \Log::info($request->all());
        $token = str_replace("Bearer ", "", $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->with('cart.cartCollection')->first();
        if ($user) {
            if ($user->cart->count() > 0) {
                $cart = $user->cart->where('completed', 0)->first();
                if ($cart) {
                    $cart_count = $cart->cartCollection->count();
                    $arr = [
                        'cart_id' => $cart->id,
                        'cart_count' => $cart_count
                    ];
                } else {
                    $arr = [
                        'cart_count' => 0
                    ];
                }
            } else {
                $arr = [
                    'cart_count' => 0
                ];

            }
        } else {
            $arr = [
                'cart_count' => 0
            ];
        }
        return response()->json(array(
            'success' => 1,
            'status_code' => 200,
            'data' => $arr));
    }

    public function collectionDetails(Request $request)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'collection_type' => 'required|integer',
            'collection_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $collection_type = $DataRequests['collection_type'];
            $collection_id = $DataRequests['collection_id'];
            $collection = Collection::where('id', $collection_id)->with('collectionItem.menu')->first();
            if ($collection) {
                if ($collection->female_caterer_available == 1) {
                    $female_caterer_available = true;
                } else {
                    $female_caterer_available = false;
                }
                $foodlist = [];
                $foodlist_images = [];
                if ($collection->is_available == 1) {
                    $is_available = true;
                } else {
                    $is_available = false;
                }
                $setup = '';
                $max = '';
                $requirement = '';
                $max_persons = -1;
                $min_serve = -1;
                $max_serve = -1;
                $collection_price = 0;
                $collection_min = -1;
                $collection_max = -1;
                $person_increase = false;
                if ($collection_type != 4) {
                    $min_serve = $collection->min_serve_to_person;
                    $max_serve = $collection->max_serve_to_person;
                    $collection_price = $collection->price;
                }
                if ($collection_type != 2 && $collection_type != 4) {
                    $collection_min = $collection->min_qty;
                    $collection_max = $collection->max_qty;
                }
                if ($collection_type == 1) {
                    $items = [];
                    $menu = [];
                    foreach ($collection->collectionItem as $collection_item) {
                        if ($lang == 'ar') {
                            $foodlist [] = $collection_item->menu->name_ar;
                            $item_name = $collection_item->menu->name_ar;
                        } else {
                            $foodlist [] = $collection_item->menu->name_en;
                            $item_name = $collection_item->menu->name_en;
                        }
                        $image = url('/') . '/images/' . $collection_item->menu->image;
                        array_push($foodlist_images, $image);
                        if ($collection_item->menu->status == 1) {
                            $status = true;
                        } else {
                            $status = false;
                        }

                        $items  [] = [
                            'item_id' => $collection_item->item_id,
                            'item_name' => $item_name,
                            'item_qty' => $collection_item->quantity,
                            'item_price' => $collection_item->menu->price,
                            'item_price_unit' => \Lang::get('message.priceUnit'),
                            'item_availability' => $status

                        ];
                    }
                    $menu [] = [
                        'menu_name' => \Lang::get('message.combo'),
                        'items' => $items,
                    ];
                } else {
                    $menu_min_qty = -1;
                    $menu_max_qty = -1;
                    $menu = [];
                    $collectionMenus = CollectionMenu::where('collection_id', $collection->id)->with(['collectionItem' => function ($query) use ($collection) {
                        $query->where('collection_id', $collection->id);
                    }])->whereHas('collectionItem' , function ($q) use ($collection) {
                        $q->where('collection_id', $collection->id);
                    })->get();
                    foreach ($collectionMenus as $collectionMenu) {
                        $items = [];
                        if ($collection->category_id != 4 && $collection->category_id != 1) {
                            $menu_min_qty = $collectionMenu->min_qty;
                            $menu_max_qty = $collectionMenu->max_qty;
                        }
                        foreach ($collectionMenu->collectionItem as $collection_item) {
                            if ($lang == 'ar') {
                                $foodlist [] = $collection_item->menu->name_ar;
                                $item_name = $collection_item->menu->name_ar;
                                $menu_name = $collectionMenu->category->name_ar;
                            } else {
                                $foodlist [] = $collection_item->menu->name_en;
                                $item_name = $collection_item->menu->name_en;
                                $menu_name = $collectionMenu->category->name_en;
                            }
                            $image = url('/') . '/images/' . $collection_item->menu->image;
                            array_push($foodlist_images, $image);
                            if ($collection->category_id == 2) {
                                if ($collection->allow_person_increase == 1) {
                                    $person_increase = true;
                                } else {
                                    $person_increase = false;
                                }
                                $max_persons = $collection->persons_max_count;

                                $setup_hours = $collection->setup_time / 60;
                                $setup_minutes = $collection->setup_time % 60;
                                if ($setup_minutes > 0) {
                                    $setup = floor($setup_hours) . ' ' . \Lang::get('message.hour') . ' ' . ($setup_minutes) . ' ' . \Lang::get('message.minute');
                                } else {
                                    $setup = floor($setup_hours) . ' ' . \Lang::get('message.hour');
                                }
                                $max_hours = $collection->max_time / 60;
                                $max_minutes = $collection->max_time % 60;
                                if ($max_minutes > 0) {
                                    $max = floor($max_hours) . ' ' . \Lang::get('message.hour') . ' ' . ($max_minutes) . ' ' . \Lang::get('message.minute');
                                } else {
                                    $max = floor($max_hours) . ' ' . \Lang::get('message.hour');
                                }
                                if ($lang == 'ar') {
                                    $requirement = $collection->requirements_ar;
                                } else {
                                    $requirement = $collection->requirements_en;
                                }
                            }


                            if ($collection_item->menu->status == 1) {
                                $status = true;
                            } else {
                                $status = false;
                            }
                            $items [] = [
                                'item_id' => $collection_item->menu->id,
                                'item_name' => $item_name,
                                'item_image' => url('/') . '/images/' . $collection_item->menu->image,
                                'item_price' => $collection_item->menu->price,
                                'item_price_unit' => \Lang::get('message.priceUnit'),
                                'item_availability' => $status

                            ];
                        }

                        usort($items, function ($item1, $item2) {
                            return $item2['item_availability'] <=> $item1['item_availability'];
                        });
                        $menu [] = [
                            'menu_id' => $collectionMenu->category->id,
                            'menu_name' => $menu_name,
                            'menu_min_qty' => $menu_min_qty,
                            'menu_max_qty' => $menu_max_qty,
                            'items' => $items,
                        ];

                    }

                }

                if ($lang == 'ar') {
                    $restaurant_name = $collection->restaurant->name_ar;
                    $collection_name = $collection->name_ar;
                    $collection_description = $collection->description_ar;
                    $collection_type = $collection->category->name_ar;
                    $mealtime = $collection->mealtime->name_ar;
                    $service_provide = $collection->service_provide_ar;
                    $service_presentation = $collection->service_presentation_ar;
                } else {
                    $restaurant_name = $collection->restaurant->name_en;
                    $collection_name = $collection->name_en;
                    $collection_description = $collection->description_en;
                    $collection_type = $collection->category->name_en;
                    $mealtime = $collection->mealtime->name_en;
                    $service_provide = $collection->service_provide_en;
                    $service_presentation = $collection->service_presentation_en;
                }

                $menu_collection [] = [
                    'restaurant_id' => $collection->restaurant->id,
                    'restaurant_name' => $restaurant_name,
                    'collection_id' => $collection->id,
                    'collection_name' => $collection_name,
                    'collection_description' => $collection_description,
                    'collection_type_id' => $collection->category_id,
                    'collection_type' => $collection_type,
                    'female_caterer_available' => $female_caterer_available,
                    'mealtime_id' => $collection->mealtime_id,
                    'mealtime' => $mealtime,
                    'collection_min_qty' => $collection_min,
                    'collection_max_qty' => $collection_max,
                    'collection_price' => $collection_price,
                    'collection_price_unit' => \Lang::get('message.priceUnit'),
                    'is_available' => $is_available,
                    'min_serve_to_person' => $min_serve,
                    'max_serve_to_person' => $max_serve,
                    'allow_person_increase' => $person_increase,
                    'persons_max_count' => $max_persons,
                    'service_provide' => $service_provide,
                    'food_list' => $foodlist,
                    'service_presentation' => $service_presentation,
                    'special_instruction' => '',
                    'food_item_image' => url('/') . '/images/' . $collection_item->menu->image,
                    'food_list_images' => $foodlist_images,
                    'setup_time' => $setup,
                    'requirement' => $requirement,
                    'max_time' => $max,
                    'menu_items' => $menu
                ];
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $menu_collection));
            } else {
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => [],
                    'message' => \Lang::get('message.noCollection')));
            }
        }

    }


    public function removeCart(Request $request, $id)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $token = str_replace("Bearer ", "", $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->with('cart.cartCollection')->first();
        if ($user) {
            $DataRequests = $request->all();
            $cart = UserCart::where('id', $id)
                ->where('user_id', $user->id)->first();
            if (isset($DataRequests['collection_id'])) {
                $collection_id = $DataRequests['collection_id'];
                UserCartCollection::where('cart_id', $cart->id)
                    ->where('collection_id', $collection_id)->delete();
                $cart_collections = UserCartCollection::where('cart_id', $cart->id)->get();
                if (count($cart_collections) > 0) {
                    return response()->json(array(
                        'success' => 1,
                        'status_code' => 200,
                        'message' => \Lang::get('message.collectionRemove')));
                } else {
                    $cart->delete();
                    return response()->json(array(
                        'success' => 1,
                        'status_code' => 200,
                        'message' => \Lang::get('message.cartRemove')));
                }

            } else {
                $cart->delete();
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'message' => \Lang::get('message.cartRemove')));
            }
        }

    }

    public function changeDeliveryAddress(Request $request, $id)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $token = str_replace("Bearer ", "", $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->with('cart.cartCollection')->first();
        if ($user) {
            $address = Address::where('id', $id)->where('user_id', $user->id)->first();
            if ($address) {
                $cart = UserCart::where('user_id', $user->id)->where('completed', 0)->first();
                if ($cart) {
                    $cart->delivery_address_id = $address->id;
                    $cart->save();
                    return response()->json(array(
                        'success' => 1,
                        'status_code' => 200));
                }
            }
        } else {
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */


    /**
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
