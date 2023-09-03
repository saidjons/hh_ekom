<?php

namespace App\Service;

use App\DTOs\CategoryDTO;
use App\Models\Category;

class CategoryService
{

    public function all()
    {
        return Category::all();
    }
    public function findOrFail($id)
    {
        return Category::findOrFail($id);
    }


    public function store(
        CategoryDTO $dto
    ) {
        return Category::create([
            "title" => $dto->title,
            "parent_id" => $dto->parent_id,
        ]);
    }
    public function update(
        Category $category,
        CategoryDTO $dto
    ) {
        return tap($category)->update([
            "title" => $dto->title,
            "parent_id" => $dto->parent_id,
        ]);
    }

    public function delete($id){
        $category = $this->findOrFail($id);
        if($category){
            
            $category->delete();
        }
    }
}
