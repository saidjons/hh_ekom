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
        array $subs = [],

    ) {
        $this->title = $title;
        $this->parent_id = $parent_id;
        $this->subs = $subs ;
    }

    static public function fromApiRequest(CategoryRequest $r)
    {
        return new self(
            title: $r->validated("title"),
            parent_id: $r->validated("parent_id"),
            subs:$r->validated("subs"),
        );
    }

    public function pushSubs(self $item){
      array_push($this->subs,$item);
    }

}
