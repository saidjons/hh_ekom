<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\DTOs\CategoryDTO;
use Illuminate\Http\Request;
use App\Service\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\SortCatSubsRequest;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $service,
    ) {
    }

    public function index(){
        $categories = $this->service->all();

        return CategoryResource::collection($categories);
    }
    public function show($id){

        $category = $this->service->findOrFail($id);
        return CategoryResource::make($category);
    }
    
    public function store(CategoryRequest $r)
    {

        $category = $this->service->store(
            CategoryDTO::fromApiRequest($r)
        );

        return CategoryResource::make($category);
    }
    public function addSub(CategoryRequest $r)
    {

        $category = $this->service->store(
            CategoryDTO::fromApiRequest($r)
        );

        return CategoryResource::make($category);
    }
    public function update(CategoryRequest $r, Category $category)
    {

        $category = $this->service->update(
            $category,
            CategoryDTO::fromApiRequest($r), 

        );

        return CategoryResource::make($category);
    }
    public function addSubToCat(CategoryRequest $r, Category $category)
    {

        $category = $this->service->addSub(
            $category,
            CategoryDTO::fromApiRequest($r), 

        );

        return CategoryResource::make($category);
    }
    public function sortSubs(SortCatSubsRequest $r, Category $category)
    {

        $category = $this->service->sortCatSubs(
            $category,
             $r->validated("subs")

        );

        return CategoryResource::make($category);
    }

    public function delete($id){
        $categories = $this->service->delete($id);

        return response()->json([],200);
    }
}
