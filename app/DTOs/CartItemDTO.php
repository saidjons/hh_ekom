<?php

namespace App\DTOs;

use App\Http\Requests\CartRequest;
use App\Http\Requests\CartItemRequest;
use App\Http\Requests\CategoryRequest;

class CartItemDTO
{
   
    public function __construct(
        public int $user_id,
        public int $product_id,
        public int $quantity,

    ) {
        
    }

    static public function fromApiRequest(CartItemRequest $r,$user_id)
    {
        return new self(
            user_id: $user_id,
            product_id: $r->validated("product_id"),
            quantity: $r->validated("quantity"),
        );
    }

    

}
