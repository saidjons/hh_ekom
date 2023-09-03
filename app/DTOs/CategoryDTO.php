<?php

namespace App\DTOs;

use App\Http\Requests\CategoryRequest;

class CategoryDTO
{
    public string $title;
    public int|null $parent_id;

    /**
     * @param array<CategoryDTO>$subs
     */

    public array $subs = [];

    public function __construct(
        string $title,
        int $parent_id = null,

    ) {
        $this->title = $title;
        $this->parent_id = $parent_id;
    }

    static public function fromApiRequest(CategoryRequest $r)
    {
        return new self(
            title: $r->validated("title"),
            parent_id: $r->validated("parent_id"),
        );
    }

    public function pushSubs(self $item){
      array_push($this->subs,$item);
    }

}
