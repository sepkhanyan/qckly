<?php

namespace App\Http\Controllers;

use App\UserCart;
use App\UserCartItem;
use App\Menus;
use App\Collection;

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
    public function createUserCart(Request $request)
    {
        $cart = new UserCart();
        dd($cart);
        $cart->user_id = 1;
        $DataRequests = $request->all();
        $collection_id = $DataRequests['collection_id'];
        if(isset($DataRequests['collection_price'])){
            $collection_price = $DataRequests['collection_price'];
            $cart_item->price = $collection_price;
        }
        if(isset($DataRequests['collection_qty'])){
            $collection_qty = $DataRequests['collection_qty'];
            $cart_item->quantity = $collection_qty;
        }

        ;

        $cart_item = new UserCartItem();
        $cart_item->collection_id = $collection_id;
        $cart_item->cart_id = $cart->id;


        if(isset($DataRequests['item_id'])){
            $item_id = $DataRequests['item_id'];
            $cart_item->item_id = $item_id;
        }
        if(isset($DataRequests['item_price'])){
            $item_price = $DataRequests['item_price'];
            $cart_item->price = $item_price;
        }
        if(isset($DataRequests['item_qty'])){
            $item_qty = $DataRequests['item_qty'];
            $cart_item->quantity = $item_qty;
        }
        dd($cart_item);
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
