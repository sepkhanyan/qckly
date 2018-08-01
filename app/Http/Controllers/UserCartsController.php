<?php

namespace App\Http\Controllers;

use App\Categories;
use App\UserCartMenu;
use Auth;
use App\UserCart;
use App\UserCartItem;
use App\UserCartCollection;
use App\Menus;
use App\Collection;
use App\CollectionItem;
use Carbon\Carbon;


use Illuminate\Foundation\Auth\User;
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
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'collection_type' => 'required|integer',
            'collection_id' => 'required|integer',
            'female_caterer' => 'required',
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
            $cart = UserCart::where('user_id', '=', 1)->first();
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
                    $cart->user_id = 1;
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
                            $cart_item->cart_id = $cart->id;
                            $cart_item->collection_id = $collection_id;
                            $cart_item->menu_id = $collection_item->menu->menu_category_id;
                            $cart_item->item_id = $collection_item->menu->id;
                            $cart_item->quantity = $collection_item->min_count;
                            $cart_item->cart_collection_id = $cart_collection->id;
                            $cart_item->save();
                        }
                    }else{
                        UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)
                            ->increment('price', $collection_price);
                        UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)
                            ->increment('quantity', $collection_quantity);
                        UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)
                            ->update((['special_instruction' => $special_instruction, 'female_caterer' => $female_caterer]));
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
                            $cart_item->cart_id = $cart->id;
                            $cart_item->collection_id = $collection_id;
                            $cart_item->cart_collection_id = $cart_collection->id;
                            $cart_item->menu_id = $menu['menu_id'];
                            $cart_item->item_id = $menu['item_id'];
                            $cart_item->quantity = $menu['item_quantity'];
                            $cart_item->save();
                        }
                    }else{
                        $cart_collection->collection_id = $collection_id;
                        $cart_collection->cart_id = $cart->id;
                        $cart_collection->price = $collection_price;
                        $cart_collection->persons_count = $persons_count;
                        $cart_collection->quantity = 1;
                        $cart_collection->female_caterer = $female_caterer;
                        $cart_collection->special_instruction = $special_instruction;
                        $cart_collection->save();
                        UserCartItem::where('cart_id', $cart->id)->where('collection_id', $collection_id)->delete();
                        foreach($menus as $menu){
                            $cart_item = new UserCartItem();
                            $cart_item->cart_id = $cart->id;
                            $cart_item->collection_id = $collection_id;
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
                            $cart_item->cart_id = $cart->id;
                            $cart_item->collection_id = $collection_id;
                            $cart_item->cart_collection_id = $cart_collection->id;
                            $cart_item->menu_id = $menu['menu_id'];
                            $cart_item->item_id = $menu['item_id'];
                            $cart_item->quantity = $menu['item_quantity'];
                            $cart_item->save();
                        }
                    }else{
                        $cart_collection->collection_id = $collection_id;
                        $cart_collection->cart_id = $cart->id;
                        $cart_collection->price = $collection_price;
                        $cart_collection->quantity = $collection_quantity;
                        $cart_collection->female_caterer = $female_caterer;
                        $cart_collection->special_instruction = $special_instruction;
                        $cart_collection->save();
                        UserCartItem::where('cart_id', $cart->id)->where('collection_id', $collection_id)->delete();
                        foreach($menus as $menu){
                            $cart_item = new UserCartItem();
                            $cart_item->cart_id = $cart->id;
                            $cart_item->collection_id = $collection_id;
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
                            $cart_item->cart_id = $cart->id;
                            $cart_item->collection_id = $collection_id;
                            $cart_item->cart_collection_id = $cart_collection->id;
                            $cart_item->menu_id = $menu['menu_id'];
                            $cart_item->item_id = $menu['item_id'];
                            $cart_item->price = $menu['item_price'];
                            $cart_item->quantity = $menu['item_quantity'];
                            $cart_item->save();
                        }
                    }else{
                        $cart_collection->collection_id = $collection_id;
                        $cart_collection->cart_id = $cart->id;
                        $cart_collection->price = $collection_price;
                        $cart_collection->quantity = 1;
                        $cart_collection->female_caterer = $female_caterer;
                        $cart_collection->special_instruction = $special_instruction;
                        $cart_collection->save();
                        UserCartItem::where('cart_id', $cart->id)->where('collection_id', $collection_id)->delete();
                        foreach($menus as $menu){
                                $cart_item = new UserCartItem();
                                $cart_item->cart_id = $cart->id;
                                $cart_item->collection_id = $collection_id;
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

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCart($id)
    {
        $cart = UserCart::find($id);
        $cart_collections = UserCartCollection::where('cart_id', $cart->id)->with('collection.subcategory')->get();
        $total = 0;
        if(count($cart_collections) > 0){
            foreach($cart_collections as $cart_collection){
                $menu = [];
                $categories = Categories::whereHas('cartItem', function($query) use ($id, $cart_collection){
                    $query->where('collection_id', $cart_collection->collection_id);
                })->with(['cartItem'=>function ($x) use($cart_collection){
                    $x->where('collection_id', $cart_collection->collection_id);
                }])->get();
                foreach($categories as $category){
                    $items = [];
                    foreach($category->cartItem as $cartItem){
                        $items [] =[
                            'item_id' => $cartItem->item_id,
                            'item_name' => $cartItem->menu->menu_name,
                            'item_price' => $cartItem->menu->menu_price,
                            'item_quantity' => $cartItem->quantity,
                            'price_unit' => 'QR'
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


                $collections [] = [
                    'collection_id' => $cart_collection->collection_id,
                    'collection_type_id' => $cart_collection->collection->subcategory_id,
                    'collection_type' => $cart_collection->collection->subcategory->subcategory_en,
                    'collection_name' => $cart_collection->collection->name,
                    'collection_price' => $cart_collection->collection->price,
                    'menu_items' => $menu,
                    'quantity' => $cart_collection->quantity,
                    'persons_count' => $cart_collection->persons_count,
                    'subtotal' => $cart_collection->price,
                    'price_unit' => "QR"
                ];
                $total += $cart_collection->price;

            }

            $arr  = [
                'cart_id' => $cart->id,
                'order_area' => $cart->delivery_order_area,
                'order_date' => $cart->delivery_order_date,
                'order_time' => $cart->delivery_order_time,
                'collections' => $collections,
                'total' => $total,
                'price_unit' => 'QR'
            ];

            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'data' => $arr));
        }else{
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'data' => "Nothing selected!"));
        }

    }

    public function editCart(Request $request, $id)
    {
        $cart = UserCart::find($id);
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'collection_type' => 'required|integer',
            'collection_id' => 'required|integer',
            'female_caterer' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $collection_type = $DataRequests['collection_type'];
            $collection_id = $DataRequests['collection_id'];
            $female_caterer = $DataRequests['female_caterer'];
            if (isset($DataRequests['special_instruction'])) {
                $special_instruction = $DataRequests['special_instruction'];
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
                    $cart_collection = UserCartCollection::where('cart_id', $cart->id)->where('collection_id', $collection_id)->first();
                    $cart_collection->price = $collection_price;
                    $cart_collection->quantity = $collection_quantity;
                    $cart_collection->female_caterer = $female_caterer;
                    $cart_collection->special_instruction = $special_instruction;
                    $cart_collection->save();
                }
            }else if ($collection_type == 2) {
                $validator = \Validator::make($DataRequests, [
                    'collection_price' => 'required',
                    'persons_count' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json(array('success' => 1, 'status_code' => 400,
                        'message' => 'Invalid inputs',
                        'error_details' => $validator->messages()));
                } else {
                    $collection_price = $DataRequests['collection_price'];
                    $persons_count = $DataRequests['persons_count'];
                    $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                        ->where('collection_id', $collection_id)->first();
                        $cart_collection->price = $collection_price;
                        $cart_collection->persons_count = $persons_count;
                        $cart_collection->female_caterer = $female_caterer;
                        $cart_collection->special_instruction = $special_instruction;
                        $cart_collection->save();
                }
            }elseif ($collection_type == 3) {
                $validator = \Validator::make($DataRequests, [
                    'collection_price' => 'required',
                    'collection_quantity' => 'required',
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
                        $cart_collection->price = $collection_price;
                        $cart_collection->quantity = $collection_quantity;
                        $cart_collection->female_caterer = $female_caterer;
                        $cart_collection->special_instruction = $special_instruction;
                        $cart_collection->save();
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
                        $cart_collection->price = $collection_price;
                        $cart_collection->female_caterer = $female_caterer;
                        $cart_collection->special_instruction = $special_instruction;
                        $cart_collection->save();
                        UserCartItem::where('cart_id', $cart->id)->where('collection_id', $collection_id)->delete();
                        foreach($menus as $menu){
                            $cart_item = new UserCartItem();
                            $cart_item->cart_id = $cart->id;
                            $cart_item->collection_id = $collection_id;
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
        $cart_collections = UserCartCollection::where('cart_id', $cart->id)->with('collection.subcategory')->get();
        $total = 0;
        if(count($cart_collections) > 0){
            foreach($cart_collections as $cart_collection){
                $menu = [];
                $categories = Categories::whereHas('cartItem', function($query) use ($id, $cart_collection){
                    $query->where('collection_id', $cart_collection->collection_id);
                })->with(['cartItem'=>function ($x) use($cart_collection){
                    $x->where('collection_id', $cart_collection->collection_id);
                }])->get();
                foreach($categories as $category){
                    $items = [];
                    foreach($category->cartItem as $cartItem){
                        $items [] =[
                            'item_id' => $cartItem->item_id,
                            'item_name' => $cartItem->menu->menu_name,
                            'item_price' => $cartItem->menu->menu_price,
                            'item_quantity' => $cartItem->quantity,
                            'price_unit' => 'QR'
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


                $collections [] = [
                    'collection_id' => $cart_collection->collection_id,
                    'collection_type_id' => $cart_collection->collection->subcategory_id,
                    'collection_type' => $cart_collection->collection->subcategory->subcategory_en,
                    'collection_name' => $cart_collection->collection->name,
                    'collection_price' => $cart_collection->collection->price,
                    'menu_items' => $menu,
                    'quantity' => $cart_collection->quantity,
                    'persons_count' => $cart_collection->persons_count,
                    'subtotal' => $cart_collection->price,
                    'price_unit' => "QR"
                ];
                $total += $cart_collection->price;

            }

            $arr  = [
                'cart_id' => $cart->id,
                'order_area' => $cart->delivery_order_area,
                'order_date' => $cart->delivery_order_date,
                'order_time' => $cart->delivery_order_time,
                'collections' => $collections,
                'total' => $total,
                'price_unit' => 'QR'
            ];

            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'data' => $arr));
        }else{
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'data' => "Nothing selected!"));
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
