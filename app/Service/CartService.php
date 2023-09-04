<?php

namespace App\Service;

use App\Models\Cart;
use App\Models\CartItem;
use App\DTOs\CartItemDTO;
 

class CartService
{

    public function getCartItems()
    {

        $cart= $this->findOrCreate(auth()->user()->id);
        return $cart->loadMissing("items");
    }

    public function findOrCreate($user_id)
    {
        $cart =  Cart::where('user_id',$user_id)->first();
        if(!$cart){
            $cart = Cart::create([
                "user_id"=>$user_id,
            ]);
        }
        return $cart;
    }


    public function addItemToCart(
       
        CartItemDTO $dto
    ) {
         $cart = $this->findOrCreate($dto->user_id);

         $cart->items()->updateOrCreate([
             "product_id"=>$dto->product_id,
             
         ],[
            "product_id"=>$dto->product_id,
            "quantity" =>$dto->quantity,
         ]);

         $cart->refresh();
         return $this->updateTotalPrice($cart);
 

    }
    public function updateTotalPrice(Cart $cart){
        $total_price = 0;
         $cart?->items->each(function($item)use (&$total_price){
            $item->loadMissing("product");
         
            return $total_price+=$item->product->price*$item->quantity;
         });

         $cart->total_price = $total_price;
         $cart->save();
         return $cart;
    }
    public function update(
        CartItem $cart,
        CartItemDTO $dto,$user_id
    ) {
        $cart = $this->findOrCreate($user_id);

        $cart->items->update([
           "product_id"=>$dto->product_id,
           "quantity" =>$dto->quantity,
        ]);
    }

    public function delete($id):void{
        $item = CartItem::find($id);
         if($item){
            $item->delete();
            $cart = $this->getCartItems();
            $this->updateTotalPrice($cart);
             
         }
         
    }
}
