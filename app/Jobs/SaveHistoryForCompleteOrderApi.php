<?php

namespace App\Jobs;

use App\UserCart;
use App\MenuCategory;
use App\DeliveryAddress;
use App\OrderCollection;
use App\OrderCollectionMenu;
use App\OrderCollectionItem;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SaveHistoryForCompleteOrderApi implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $user_id;
	protected $cart_id;
	protected $order_id;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($user_id, $cart_id, $order_id)
	{
		$this->user_id = $user_id;
		$this->cart_id = $cart_id;
		$this->order_id = $order_id;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$cart = UserCart::with('address', 'cartCollection.collection.category', 'cartCollection.collection.serviceType')->where('user_id', $this->user_id)->where('id', $this->cart_id)->first();

		$delivery_address = new DeliveryAddress;
		$delivery_address->order_id = $this->order_id;
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

		$cartCollections = $cart->cartCollection;

		foreach ($cartCollections as $cartCollection) {

			$orderCollection = new OrderCollection;
			$orderCollection->order_id = $this->order_id;
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
				$orderCollectionMenu = new OrderCollectionMenu;
				$orderCollectionMenu->order_id = $this->order_id;
				$orderCollectionMenu->order_collection_id = $cartCollection->collection_id;
				$orderCollectionMenu->menu_id = $category->id;
				$orderCollectionMenu->menu_en = $category->name_en;
				$orderCollectionMenu->menu_ar = $category->name_ar;
				$orderCollectionMenu->save();

				foreach ($category->cartItem as $cartItem){
					$orderCollectionItem = new OrderCollectionItem;
					$orderCollectionItem->order_id = $this->order_id;
					$orderCollectionItem->order_collection_id = $cartCollection->collection_id;
					$orderCollectionItem->order_collection_menu_id = $category->id;
					$orderCollectionItem->item_id = $cartItem->item_id;
					$orderCollectionItem->item_en = $cartItem->menu->name_en;
					$orderCollectionItem->item_ar = $cartItem->menu->name_ar;
					if($cartItem->is_mandatory == 1){
						$orderCollectionItem->item_price = 0;
					}else{
						$orderCollectionItem->item_price = $cartItem->menu->price;
					}
					$orderCollectionItem->quantity = $cartItem->quantity;
					$orderCollectionItem->is_mandatory = $cartItem->is_mandatory;
					$orderCollectionItem->save();
				}
			}
		}
	}
}
