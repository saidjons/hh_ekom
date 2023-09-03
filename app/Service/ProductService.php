<?php

namespace App\Service;

use App\DTOs\ProductDTO;
use App\Models\Product;

class ProductService
{

    public function all()
    {
        return Product::all();
    }
    public function findOrFail($id)
    {
        return Product::findOrFail($id);
    }


    public function store(
        ProductDTO $dto
    ) {
        return Product::create([
            "title" => $dto->title,
            "price" => $dto->price,
            "image" > $dto->image,
            "description" => $dto->description,
            "in_stock" => $dto->in_stock,

        ]);
    }
    public function update(
        Product $product,
        ProductDTO $dto
    ) {
        return tap($product)->update([
            "title" => $dto->title,
            "price" => $dto->price,
            "image" > $dto->image,
            "description" => $dto->description,
            "in_stock" => $dto->in_stock,

        ]);
    }

    public function delete($id){
        $product = $this->findOrFail($id);
        $product->delete();
    }
}
