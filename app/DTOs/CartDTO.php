<?php
namespace App\DTOs;

class CartDTO {
/**
 * i think , this cart doesnt look good with service pattern
 */
    public function __construct(
        public string $title,
        public int $user_id,
        public int $product_id,

    ){
    
    }
}