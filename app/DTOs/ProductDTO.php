<?php

namespace App\DTOs;

use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductDTO
{

    public function __construct(
        public string $title,
        public  $image,
        public string $description,
        public bool $in_stock,
        public int $price,

    ) {
        // $path = $this->image->file('avatar')->store('avatars');
        $path = Storage::putFile('avatars', $this->image);
        $this->image = $path;
         

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
