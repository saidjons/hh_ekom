<?php

namespace App\Service;

use App\DTOs\CategoryDTO;
use App\Http\Requests\SortCatSubs;
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
        $cat =  Category::create([
            "title" => $dto->title,
            "parent_id" => $dto->parent_id,
        ]);
        foreach ($dto->subs as $key => $sub) {
            $cat->subs()->updateOrCreate([
                "title"=>$sub['title'],
                "sorting_number"=>$key,
            ]);
        }
        $cat->refresh();
        return $cat;
    }
// updates only category itself not subs
    public function update(
        Category $category,
        CategoryDTO $dto
    ) {
        $cat =  tap($category)->update([
            "title" => $dto->title,
            "parent_id" => $dto->parent_id,
        ]);
        return $cat;

    }
    // TODO: add sub one by one 
    
    public function addSub(
        Category $category,
        CategoryDTO $dto
    ) {
        $cat =  tap($category)->update([
            "title" => $dto->title,
            "parent_id" => $dto->parent_id,
        ]);
        return $cat;

    }

    public function sortCatSubs(Category $cat,array $subs) {
        
        foreach ($subs as $key => $sub) {
          $model = $this->findOrFail($sub['id']);
          $model->sorting_number = $key;
          $model->save();
        }
 
        return $cat;

    }

    public function delete($id){
        $category = $this->findOrFail($id);
        if($category){
            
            $category->delete();
        }
    }
}
