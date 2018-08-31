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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createCart(Request $request)
    {
        \Log::info($request->all());
        $token = str_replace("Bearer ","" , $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->first();
        if($user){
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
                if(isset($DataRequests['special_instruction'])){
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
                        if($address){
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
                        'collection_price' => 'required',
                        'collection_quantity' => 'integer|required',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(array('success' => 1, 'status_code' => 400,
                            'message' => 'Invalid inputs',
                            'error_details' => $validator->messages()));
                    } else {
                        $collection_price = $DataRequests['collection_price'];
                        $collection_quantity = $DataRequests['collection_quantity'];
                        $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)->first();
                        if(!$cart_collection){
                            $cart_collection = new UserCartCollection();
                            $cart_collection->collection_id = $collection_id;
                            $cart_collection->cart_id = $cart->id;
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
                                $cart_item->quantity = $collection_item->min_count;
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->save();
                            }
                        }else{
                            $cart_collection->price = $collection_price;
                            $cart_collection->quantity = $collection_quantity;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                        }

                    }

                }else if ($collection_type == 2) {
                    $validator = \Validator::make($DataRequests, [
                        'collection_price' => 'required',
                        'persons_count' => 'required',
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
                        $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)->first();
                        if(!$cart_collection){
                            $cart_collection = new UserCartCollection();
                            $cart_collection->collection_id = $collection_id;
                            $cart_collection->cart_id = $cart->id;
                            $cart_collection->price = $collection_price;
                            $cart_collection->persons_count = $persons_count;
                            $cart_collection->quantity = 1;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            foreach($menus as $menu){
                                $cart_item = new UserCartItem();
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->menu_id = $menu['menu_id'];
                                $cart_item->item_id = $menu['item_id'];
                                $cart_item->quantity = $menu['item_quantity'];
                                $cart_item->save();
                            }
                        }else{
                            $cart_collection->price = $collection_price;
                            $cart_collection->persons_count = $persons_count;
                            $cart_collection->quantity = 1;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            UserCartItem::where('cart_collection_id', $cart_collection->id)->delete();
                            foreach($menus as $menu){
                                $cart_item = new UserCartItem();
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->menu_id = $menu['menu_id'];
                                $cart_item->item_id = $menu['item_id'];
                                $cart_item->quantity = $menu['item_quantity'];
                                $cart_item->save();
                            }
                        }
                    }
                }elseif ($collection_type == 3) {
                    $validator = \Validator::make($DataRequests, [
                        'collection_price' => 'required',
                        'collection_quantity' => 'required',
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
                        $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)->first();
                        if(!$cart_collection){
                            $cart_collection = new UserCartCollection();
                            $cart_collection->collection_id = $collection_id;
                            $cart_collection->cart_id = $cart->id;
                            $cart_collection->price = $collection_price;
                            $cart_collection->quantity = $collection_quantity;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            foreach($menus as $menu){
                                $cart_item = new UserCartItem();
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->menu_id = $menu['menu_id'];
                                $cart_item->item_id = $menu['item_id'];
                                $cart_item->quantity = $menu['item_quantity'];
                                $cart_item->save();
                            }
                        }else{
                            $cart_collection->price = $collection_price;
                            $cart_collection->quantity = $collection_quantity;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            UserCartItem::where('cart_collection_id', $cart_collection->id)->delete();
                            foreach($menus as $menu){
                                $cart_item = new UserCartItem();
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->menu_id = $menu['menu_id'];
                                $cart_item->item_id = $menu['item_id'];
                                $cart_item->quantity = $menu['item_quantity'];
                                $cart_item->save();
                            }
                        }
                    }
                }elseif ($collection_type == 4) {
                    $validator = \Validator::make($DataRequests, [
                        'collection_price' => 'required',
                        'menus' => 'required',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(array('success' => 1, 'status_code' => 400,
                            'message' => 'Invalid inputs',
                            'error_details' => $validator->messages()));
                    } else {
                        $collection_price = $DataRequests['collection_price'];
                        $menus = $DataRequests['menus'];
                        $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)->first();
                        if(!$cart_collection){
                            $cart_collection = new UserCartCollection();
                            $cart_collection->collection_id = $collection_id;
                            $cart_collection->cart_id = $cart->id;
                            $cart_collection->price = $collection_price;
                            $cart_collection->quantity = 1;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            foreach($menus as $menu){
                                $cart_item = new UserCartItem();
                                $cart_item->cart_collection_id = $cart_collection->id;
                                $cart_item->menu_id = $menu['menu_id'];
                                $cart_item->item_id = $menu['item_id'];
                                $cart_item->price = $menu['item_price'];
                                $cart_item->quantity = $menu['item_quantity'];
                                $cart_item->save();
                            }
                        }else{
                            $cart_collection->price = $collection_price;
                            $cart_collection->quantity = 1;
                            $cart_collection->female_caterer = $female_caterer;
                            $cart_collection->special_instruction = $special_instruction;
                            $cart_collection->save();
                            UserCartItem::where('cart_collection_id', $cart_collection->id)->delete();
                            foreach($menus as $menu){
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
                    'cart_id' => $cart->id,
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
                'message' => 'You are not logged in: Please log in and try again.'));
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCart(Request $request, $id)
    {
        \Log::info($request->all());
        $token = str_replace("Bearer ","" , $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->first();
        if($user){
            $cart = UserCart::where('id', $id)
                ->where('user_id', $user->id)
                ->where('completed', 0)
                ->with(['address', 'cartCollection' => function ($query) {
                    $query->with(['cartItem', 'collection.subcategory']);
                }])->first();
            if($cart){
                $address = (object) array();
                $address_id = -1;
                if($cart->address){
                    if($cart->address->is_apartment == 1){
                        $is_apartment = true;
                    }else{
                        $is_apartment = false;
                    }
                    if($cart->address->is_default == 1){
                        $default = true;
                    }else{
                        $default = false;
                    }
                    $address_id = $cart->address->id;
                    $address = [
                        'address_name' => $cart->address->name,
                        'mobile_number' => $cart->address->mobile_number,
                        'location' => $cart->address->location,
                        'building_number' => $cart->address->location,
                        'zone' => $cart->address->zone,
                        'is_apartment' => $is_apartment,
                        'apartment_number' => $cart->address->apartment_number,
                        'is_default' => $default
                    ];
                }


                if(count($cart->cartCollection ) > 0){
                    $total = 0;
                    foreach($cart->cartCollection as $cart_collection){
                        $menu = [];
                        $categories = Category::whereHas('cartItem', function($query) use ($cart_collection){
                            $query->where('cart_collection_id', $cart_collection->id);
                        })->with(['cartItem'=>function ($x) use($cart_collection){
                            $x->where('cart_collection_id', $cart_collection->id);
                        }])->get();
                        foreach($categories as $category){
                            $items = [];
                            foreach($category->cartItem as $cartItem){
                                $items [] = [
                                    'item_id' => $cartItem->item_id,
                                    'item_name' => $cartItem->menu->name,
                                    'item_price' => $cartItem->menu->price,
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
                            'restaurant_name' => $cart_collection->collection->restaurant->name,
                            'collection_id' => $cart_collection->collection_id,
                            'collection_type_id' => $cart_collection->collection->subcategory_id,
                            'collection_type' => $cart_collection->collection->subcategory->name_en,
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
                    $arr  = [
                        'cart_id' => $cart->id,
                        'order_area' => $cart->delivery_order_area,
                        'order_date' => $cart->delivery_order_date,
                        'order_time' => date("g:i a", strtotime($cart->delivery_order_time)),
                        'delivery_address_id' => $address_id,
                        'delivery_address' => $address,
                        'collections' => $collections,
                        'total' => $total,
                        'total_unit' => 'QR',
                    ];
                }
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $arr));
            }else{
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => []));
            }
        }else{
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => 'You are not logged in: Please log in and try again.'));
        }

    }

    public function cartCount(Request $request)
    {
        \Log::info($request->all());
        $token = str_replace("Bearer ","" , $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->with('cart.cartCollection')->first();
//        $cart = UserCart::where('user_id', $user->id)->where('completed', 0)->with('cartCollection')->first();
        if($user){
            if($user->cart->count() > 0){
                $cart = $user->cart->where('completed', 0)->first();
                if($cart){
                    $cart_count = $cart->cartCollection->count();
                    $arr  = [
                        'cart_id' => $cart->id,
                        'cart_count' => $cart_count
                    ];
                }else{
                    $arr  = [
                        'cart_count' => 0
                    ];
                }
            }else{
                $arr  = [
                    'cart_count' => 0
                ];

            }
        }else{
            $arr  = [
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
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'collection_type' => 'required|integer',
            'collection_id' => 'required|integer',
//            'restaurant_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $collection_type = $DataRequests['collection_type'];
            $collection_id = $DataRequests['collection_id'];
//            $restaurant_id = $DataRequests['restaurant_id'];
            $collection = Collection::where('id', $collection_id)->with('collectionItem.menu')->first();
            if ($collection->restaurant->female_caterer_available == 1) {
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
            $collection_min = -1;
            $collection_max = -1;
            $person_increase = false;
            if($collection_type != 4){
                $min_serve = $collection->min_serve_to_person;
                $max_serve = $collection->max_serve_to_person;
            }
            if($collection_type != 2 && $collection_type != 4){
                $collection_min = $collection->min_qty;
                $collection_max = $collection->max_qty;
            }
            if($collection_type == 1){
                $items = [];
                $menu = [];
                foreach ($collection->collectionItem as $collection_item) {
                    $foodlist [] = $collection_item->menu->name;
                    $image = url('/') . '/images/' . $collection_item->menu->image;
                    array_push($foodlist_images, $image);
                    if ($collection_item->menu->status == 1) {
                        $status = true;
                    } else {
                        $status = false;
                    }

                    $items  [] = [
                        'item_id' => $collection_item->item_id,
                        'item_name' => $collection_item->menu->name,
                        'item_qty' => $collection_item->min_count,
                        'item_price' => $collection_item->menu->price,
                        'item_price_unit' => 'QR',
                        'item_availability' => $status

                    ];
                }
                $menu [] = [
                    'menu_name' => 'Combo Delicious',
                    'items' => $items,
                ];
            }else{
                foreach ($collection->collectionItem as $collection_item) {
                    $foodlist [] = $collection_item->menu->name;
                    $image = url('/') . '/images/' . $collection_item->menu->image;
                    array_push($foodlist_images, $image);
                    $min_qty = $collection_item->min_count;
                    $max_qty = $collection_item->max_count;
                    if($collection->subcategory_id == 2){
                        if($collection->allow_person_increase == 1){
                            $person_increase = true;
                        }else{
                            $person_increase = false;
                        }
                        $max_persons = $collection->persons_max_count;

                        $setup_hours = $collection->setup_time / 60;
                        $setup_minutes = $collection->setup_time % 60;
                        if ($setup_minutes > 0) {
                            $setup = floor($setup_hours) . " hours " . ($setup_minutes) . " minutes";
                        } else {
                            $setup = floor($setup_hours) . " hours";
                        }

                        $max_hours = $collection->max_time / 60;
                        $max_minutes = $collection->max_time % 60;
                        if ($max_minutes > 0) {
                            $max = floor($max_hours) . " hours " . ($max_minutes) . " minutes";
                        } else {
                            $max = floor($max_hours) . " hours";
                        }
                        $requirement = $collection->requirements;
                    }
                }
                $categories = Category::with(['menu' => function ($query) use ($collection_id){
                    $query->whereHas('collectionItem', function ($x) use($collection_id){
                        $x->where('collection_id', $collection_id);
                    });
                }])->get();
                $menu = [];
                foreach($categories as $category){
                    $items = [];
                    foreach($category->menu as $item){
                        if ($item->status == 1) {
                            $status = true;
                        } else {
                            $status = false;
                        }
                        $items  [] = [
                            'item_id' => $item->id,
                            'item_name' => $item->name,
                            'item_price' => $item->price,
                            'item_price_unit' => 'QR',
                            'item_availability' => $status

                        ];
                    }
                    usort($items, function ($item1, $item2) {
                        return $item2['item_availability'] <=> $item1['item_availability'];
                    });
                    $menu [] = [
                        'menu_id' => $category->id,
                        'menu_name' => $category->name,
                        'menu_min_qty' => $min_qty,
                        'menu_max_qty' => $max_qty,
                        'items' => $items,
                    ];
                }
                if($collection->subcategory_id == 4){
                    $collection->price = 0;
                }

            }
            $menu_collection [] = [
                'restaurant_id' => $collection->restaurant->id,
                'restaurant_name' => $collection->restaurant->name,
                'collection_id' => $collection->id,
                'collection_name' => $collection->name,
                'collection_description' => $collection->description,
                'collection_type_id' => $collection->subcategory_id,
                'collection_type' => $collection->subcategory->name_en,
                'female_caterer_available' => $female_caterer_available,
                'mealtime' => $collection->mealtime,
                'collection_min_qty' => $collection_min,
                'collection_max_qty' => $collection_max,
                'collection_price' => $collection->price,
                'collection_price_unit' => "QR",
                'is_available' => $is_available,
                'min_serve_to_person' => $min_serve,
                'max_serve_to_person' => $max_serve,
                'allow_person_increase' => $person_increase,
                'persons_max_count' => $max_persons,
                'service_provide' => $collection->service_provide,
                'food_list' => $foodlist,
                'service_presentation' => $collection->service_presentation,
                'instruction' => $collection->instruction,
                'food_item_image' => url('/') . '/images/' . $collection_item->menu->image,
                'food_list_images' => $foodlist_images,
                'setup_time' => $setup,
                'requirement' => $requirement,
                'max_time' => $max,
                'menu_items' => $menu
            ];
        }

        return response()->json(array(
            'success'=> 1,
            'status_code'=> 200 ,
            'data' => $menu_collection));
    }


    public function removeCart(Request $request, $id)
    {
        \Log::info($request->all());
        $token = str_replace("Bearer ","" , $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->with('cart.cartCollection')->first();
        if($user){
            $DataRequests = $request->all();
            $cart = UserCart::where('id', $id)
                ->where('user_id', $user->id)->first();
            if(isset($DataRequests['collection_id'])){
                $collection_id = $DataRequests['collection_id'];
                UserCartCollection::where('cart_id', $cart->id)
                    ->where('collection_id', $collection_id)->delete();
                $cart_collections = UserCartCollection::where('cart_id', $cart->id)->get();
                if(count($cart_collections) > 0){
                    return response()->json(array(
                        'success' => 1,
                        'status_code' => 200,
                        'message' => 'Collection deleted successfully.'));
                }else{
                    $cart->delete();
                    return response()->json(array(
                        'success' => 1,
                        'status_code' => 200,
                        'message' => 'Cart deleted successfully.'));
                }

            }else{
                $cart->delete();
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'message' => 'Cart deleted successfully.'));
            }
        }

    }

    public function changeDeliveryAddress(Request $request, $id)
    {
        \Log::info($request->all());
        $token = str_replace("Bearer ","" , $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->with('cart.cartCollection')->first();
        if($user){
            $address = Address::where('id', $id)->where('user_id', $user->id)->first();
            $cart = UserCart::where('user_id', $user->id)->where('completed', 0)->first();
            $cart->delivery_address_id = $address->id;
            $cart->save();

            return response()->json(array(
                'success' => 1,
                'status_code' => 200));
        }else{
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => 'You are not logged in: Please log in and try again.'));
        }

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


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
