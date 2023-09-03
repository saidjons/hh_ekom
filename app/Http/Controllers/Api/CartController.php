<?php

namespace App\Http\Controllers\Api;

 
use App\Models\Cart;
 
use App\Models\CartItem;
use App\DTOs\CartItemDTO;
use App\Service\CartService;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Requests\CartItemRequest;

class CartController extends Controller
{
    public function __construct(
        protected CartService $service,
    ) {
    }

    public function show(){
        $cart = $this->service->getCartItems();
        
        return CartResource::make($cart);
    }
     
    
    public function store(CartItemRequest $r)
    {

        $cart = $this->service->addItemToCart(
            CartItemDTO::fromApiRequest($r,auth()->user()->id)
        );

        return CartResource::make($cart);
    }
   

    public function delete($id){
        $this->service->delete($id);

        return response()->json([],200);
    }
}
