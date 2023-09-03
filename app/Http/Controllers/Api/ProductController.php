<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Service\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service,
    ) {
    }

    public function index(){
        $products = $this->service->all();

        return ProductResource::collection($products);
    }
    public function show($id){

        $product = $this->service->findOrFail($id);
        return ProductResource::make($product);
    }
    
    public function store(ProductRequest $r)
    {

        $product = $this->service->store(
            ProductDTO::fromApiRequest($r)
        );

        return ProductResource::make($product);
    }
    public function update(ProductRequest $r, Product $product)
    {

        $product = $this->service->update(
            $product,
            ProductDTO::fromApiRequest($r), 

        );

        return ProductResource::make($product);
    }

    public function delete($id){
        $products = $this->service->delete($id);

        return response()->json([],200);
    }
}
