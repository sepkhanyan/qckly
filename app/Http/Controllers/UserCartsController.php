<?php

namespace App\Http\Controllers;

use Auth;
use App\UserCart;
use App\UserCartItem;
use App\UserCartCollection;
use App\Menus;
use App\Collection;
use App\CollectionItem;


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
    public function addToCart(Request $request)
    {
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
            if ($collection_type == 1) {
                $validator = \Validator::make($DataRequests, [
                    'collection_price' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json(array('success' => 1, 'status_code' => 400,
                        'message' => 'Invalid inputs',
                        'error_details' => $validator->messages()));
                } else {
                    $collection_price = $DataRequests['collection_price'];
                    $cart = UserCart::where('user_id', '=', 1)->first();
                    if (!$cart) {
                        $cart = new UserCart();
                        $cart->user_id = 1;
                        $cart->save();
                    }
                    $cart_collection = new UserCartCollection();
                    $cart_collection->collection_id = $collection_id;
                    $cart_collection->cart_id = $cart->id;
                    $cart_collection->price = $collection_price;
                    $cart_collection->quantity = 1;
                    $cart_collection->save();
//                    $collection_items = CollectionItem::where('collection_id', $collection_id)->with('menu')->get();
//                    foreach ($collection_items as $collection_item) {
//                        $cart_item = new UserCartItem();
//                        $cart_item->cart_id = $cart->id;
//                        $cart_item->collection_id = $collection_id;
//                        $cart_item->item_id = $collection_item->menu->id;
//                        $cart_item->save();
//                    }
                }

            }
            if ($collection_type == 2) {
                $validator = \Validator::make($DataRequests, [
                    'collection_price' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json(array('success' => 1, 'status_code' => 400,
                        'message' => 'Invalid inputs',
                        'error_details' => $validator->messages()));
                } else {
                    $collection_price = $DataRequests['collection_price'];
                    $cart = UserCart::where('user_id', '=', 1)->first();
                    if (!$cart) {
                        $cart = new UserCart();
                        $cart->user_id = 1;
                        $cart->save();
                    }

                    $cart_collection = new UserCartCollection();
                    $cart_collection->collection_id = $collection_id;
                    $cart_collection->cart_id = $cart->id;
                    $cart_collection->price = $collection_price;
                    $cart_collection->quantity = 1;
                    $cart_collection->save();
//                    $collection_items = CollectionItem::where('collection_id', $collection_id)->with('menu')->get();
//                    foreach ($collection_items as $collection_item) {
//                        $cart_item = new UserCartItem();
//                        $cart_item->cart_id = $cart->id;
//                        $cart_item->collection_id = $collection_id;
//                        $cart_item->item_id = $collection_item->menu->id;
//                        $cart_item->save();
//                    }
                }

            }
            if ($collection_type == 3) {
                    $cart = UserCart::where('user_id', '=', 1)->first();
                    if (!$cart) {
                        $cart = new UserCart();
                        $cart->user_id = 1;
                        $cart->save();
                    }
                    if (isset($DataRequests['item_id'])) {
                        $item_id = $DataRequests['item_id'];
                        $cart_item = new UserCartItem();
                        $cart_item->collection_id = $collection_id;
                        $cart_item->cart_id = $cart->id;
                        $cart_item->item_id = $item_id;
                        $cart_item->quantity = 1;
                        $cart_item->save();
                        $cart_collection = UserCartCollection::where('collection_id', $collection_id)->first();
                        if (!$cart_collection) {
                            $validator = \Validator::make($DataRequests, [
                                'collection_price' => 'required',
                            ]);
                            if ($validator->fails()) {
                                return response()->json(array('success' => 1, 'status_code' => 400,
                                    'message' => 'Invalid inputs',
                                    'error_details' => $validator->messages()));
                            } else {
                                $collection_price = $DataRequests['collection_price'];
                                $cart_collection = new UserCartCollection();
                                $cart_collection->collection_id = $collection_id;
                                $cart_collection->cart_id = $cart->id;
                                $cart_collection->price = $collection_price;
                                $cart_collection->quantity = 1;
                                $cart_collection->save();
                            }
                        }
                    } else {
                        $collection = UserCartCollection::where('collection_id', $collection_id)->first();
                        if (!$collection) {
                            return response()->json(array(
                                'success' => 1,
                                'status_code' => 200,
                                'message' => 'You did not choose anything!'));
                        }
                        $collection_price = $DataRequests['collection_price'];
                        $cart_collection = new UserCartCollection();
                        $cart_collection->collection_id = $collection_id;
                        $cart_collection->cart_id = $cart->id;
                        $cart_collection->price = $collection_price;
                        $cart_collection->quantity = 1;
                        $cart_collection->save();
                    }

            }
            if ($collection_type == 4) {
                $cart = UserCart::where('user_id', '=', 1)->first();
                if (!$cart) {
                    $cart = new UserCart();
                    $cart->user_id = 1;
                    $cart->save();
                }
                if (isset($DataRequests['item_id'])) {
                    $item_id = $DataRequests['item_id'];
                    $validator = \Validator::make($DataRequests, [
                        'item_price' => 'required',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(array('success' => 1, 'status_code' => 400,
                            'message' => 'Invalid inputs',
                            'error_details' => $validator->messages()));
                    } else {
                        $item_price = $DataRequests['item_price'];
                        $cart_item = new UserCartItem();
                        $cart_item->collection_id = $collection_id;
                        $cart_item->cart_id = $cart->id;
                        $cart_item->item_id = $item_id;
                        $cart_item->price = $item_price;
                        $cart_item->quantity = 1;
                        $cart_item->save();
                        $cart_collection = UserCartCollection::where('collection_id', $collection_id)->first();
                        if (!$cart_collection) {
                            $cart_collection = new UserCartCollection();
                            $cart_collection->collection_id = $collection_id;
                            $cart_collection->cart_id = $cart->id;
                            $cart_collection->price = $item_price;
                            $cart_collection->quantity = 1;
                            $cart_collection->save();
                        } else {
                            UserCartCollection::where('collection_id', $collection_id)->increment('price', $item_price);
                        }
                    }
                } else {
                    $collection = UserCartCollection::where('collection_id', $collection_id)->first();
                    if (!$collection) {
                        return response()->json(array(
                            'success' => 1,
                            'status_code' => 200,
                            'message' => 'You did not choose anything!'));
                    }
                    $collection_price = $collection->price;
                    $cart_collection = new UserCartCollection();
                    $cart_collection->collection_id = $collection_id;
                    $cart_collection->cart_id = $cart->id;
                    $cart_collection->price = $collection_price;
                    $cart_collection->quantity = 1;
                    $cart_collection->save();
                }
            }
            $user_carts = UserCart::where('user_id', '=', 1)->with(['cartCollection.collection', 'cartCollection.cartItem'])->get();
            $price = 0;

//            $cart_items = \DB::table('user_cart_items')
//                ->join('menus', 'user_cart_items.item_id', '=', 'menus.id')
//                ->select('item_id',  \DB::raw('count(*) as count'))
//                ->groupBy('item_id')
//                ->orderBy('item_id', 'asc')
//                ->get();
//            $cart_collections = \DB::table('user_cart_collections')
//                ->join('collections', 'user_cart_collections.collection_id', '=', 'collections.id')
//                ->select('collections.name', 'user_cart_collections.price', \DB::raw('count(*) as count'))
//                ->groupBy('collection_id', 'price')
//                ->orderBy('collection_id', 'asc')
//                ->get();
            foreach($user_carts as $user_cart){
                foreach ($user_cart->cartCollection as $cartCollection) {
                    $price += $cartCollection->price;
                    $restaurant_id = $cartCollection->collection->restaurant_id;
                    $items = [];
                    if($cartCollection->collection->subcategory_id == 4 || $cartCollection->collection->subcategory_id == 3){
                        foreach($cartCollection->cartItem as $cartItem){
                            if($cartCollection->collection->subcategory_id == 4){
                                $items [] = [
                                    'item_id' => $cartItem->item_id,
                                    'item' => $cartItem->menu->menu_name,
                                    'item_price' => $cartItem->price,
                                ];
                            }else{
                                $items [] = [
                                    'item_id' => $cartItem->item_id,
                                    'item' => $cartItem->menu->menu_name,
                                ];
                            }
                            $collect_items = collect($items);
                            $items_unique = $collect_items->unique()->values()->all();
                        }

                        $collections [] = [
                            'collection_id' => $cartCollection->collection_id,
                            'collection_name' => $cartCollection->collection->name,
                            'collection_price' => $cartCollection->price,
                            'items' => $items_unique
                        ];
                        $collect_collections = collect($collections);
                        $collections_unique = $collect_collections->unique()->values()->all();
                    }else{
                        $collections [] = [
                            'collection_id' => $cartCollection->collection_id,
                            'collection_name' => $cartCollection->collection->name,
                            'collection_price' => $cartCollection->price,
                        ];
                        $collect_collections = collect($collections);
                        $collections_unique = $collect_collections->unique()->values()->all();
                    }
                }
            }
            $arr[] = [
                'cart_id' => $user_cart->id,
                'restaurant_id' => $restaurant_id,
                'collections' => $collections_unique,
                'total_price' => $price,
                'price_unit' => 'QR'
            ];

            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'data' => $arr));
        }

    }

    public function removeFromCart(Request $request)
    {
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
            if ($collection_type == 1) {
                $cart = UserCart::where('user_id', '=', 1)->first();
                if($cart){
                    $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                        ->where('collection_id', $collection_id)->orderBy('id', 'desc')->first();
                    $cart_collection->delete();
                }
            } else if ($collection_type == 2) {
                $cart = UserCart::where('user_id', '=', 1)->first();
                if($cart){
                    $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                        ->where('collection_id', $collection_id)->orderBy('id', 'desc')->first();
                    $cart_collection->delete();
                }
            } else if ($collection_type == 3) {
                if (isset($DataRequests['item_id'])) {
                    $item_id = $DataRequests['item_id'];
                    $cart = UserCart::where('user_id', '=', 1)->first();
                    if($cart){
                        $cart_item = UserCartItem::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)
                            ->where('item_id', $item_id)->orderBy('id', 'desc')->first();
                        $cart_item->delete();
                    }
                } else {
                    $cart = UserCart::where('user_id', '=', 1)->first();
                    if($cart){
                        $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)->orderBy('id', 'desc')->first();
                        $cart_collection->delete();
                    }
                }
            } else if ($collection_type == 4) {
                if (isset($DataRequests['item_id'])) {
                    $item_id = $DataRequests['item_id'];
                    $validator = \Validator::make($DataRequests, [
                        'item_price' => 'required',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(array('success' => 1, 'status_code' => 400,
                            'message' => 'Invalid inputs',
                            'error_details' => $validator->messages()));
                    } else {
                        $item_price = $DataRequests['item_price'];
                        $cart = UserCart::where('user_id', '=', 1)->first();
                        if($cart){
                            $cart_item = UserCartItem::where('cart_id', $cart->id)
                                ->where('collection_id', $collection_id)
                                ->where('item_id', $item_id)->orderBy('id', 'desc')->first();
                            $cart_item->delete();
                            UserCartCollection::where('cart_id', $cart->id)
                                ->where('collection_id', $collection_id)->decrement('price', $item_price);
                        }
                    }
                } else {
                    $cart = UserCart::where('user_id', '=', 1)->first();
                    if($cart){
                        $cart_collection = UserCartCollection::where('cart_id', $cart->id)
                            ->where('collection_id', $collection_id)->orderBy('id', 'desc')->first();
                        $cart_collection->delete();
                    }
                }

            }
            $user_carts = UserCart::where('user_id', '=', 1)->with(['cartCollection.collection', 'cartCollection.cartItem'])->get();
            $price = 0;
            if(count($user_carts) > 0){
                foreach($user_carts as $user_cart){
                    if(count($user_cart->cartCollection) > 0){
                        foreach ($user_cart->cartCollection as $cartCollection) {
                            $price += $cartCollection->price;
                            $restaurant_id = $cartCollection->collection->restaurant_id;
                            $items = [];
                            if($cartCollection->collection->subcategory_id == 4 || $cartCollection->collection->subcategory_id == 3){
                                foreach($cartCollection->cartItem as $cartItem){
                                    if($cartCollection->collection->subcategory_id == 4){
                                        $items [] = [
                                            'item_id' => $cartItem->item_id,
                                            'item' => $cartItem->menu->menu_name,
                                            'item_price' => $cartItem->price,
                                        ];
                                    }else{
                                        $items [] = [
                                            'item_id' => $cartItem->item_id,
                                            'item' => $cartItem->menu->menu_name,
                                        ];
                                    }
                                    $collect_items = collect($items);
                                    $items_unique = $collect_items->unique()->values()->all();
                                }

                                $collections [] = [
                                    'collection_id' => $cartCollection->collection_id,
                                    'collection_name' => $cartCollection->collection->name,
                                    'collection_price' => $cartCollection->price,
                                    'items' => $items_unique
                                ];
                                $collect_collections = collect($collections);
                                $collections_unique = $collect_collections->unique()->values()->all();
                            }else{
                                $collections [] = [
                                    'collection_id' => $cartCollection->collection_id,
                                    'collection_name' => $cartCollection->collection->name,
                                    'collection_price' => $cartCollection->price,
                                ];
                                $collect_collections = collect($collections);
                                $collections_unique = $collect_collections->unique()->values()->all();
                            }
                        }
                        $arr[] = [
                            'cart_id' => $user_cart->id,
                            'restaurant_id' => $restaurant_id,
                            'collections' => $collections_unique,
                            'total_price' => $price,
                            'price_unit' => 'QR'
                        ];

                    }else{
                        return response()->json(array(
                            'success' => 1,
                            'status_code' => 200,
                            'message' => 'You did not choose anything!'));
                    }
                }
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $arr));
            }
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
    public function addInCart(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}
