<?php

namespace App\DTOs;

use App\Http\Requests\ProductRequest;

class ProductDTO
{

    public function __construct(
        public string $title,
        public string $image,
        public string $description,
        public bool $in_stock,
        public int $price,

    ) {
    }

    static public function fromApiRequest(ProductRequest $r)
    {
        return new self(
            title: $r->validated("title"),
            price: $r->validated("price"),
            image: $r->validated("image"),
            description: $r->validated("description"),
            in_stock: $r->validated("in_stock")
        );
    }
}
