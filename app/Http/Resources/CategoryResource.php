<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "parent_id" => $this->parent_id,
            "sorting_number" => $this->sorting_number,
            "subs" => $request->get("relation") == "subs" ?$this->subs :[],
            
        ];
    }
}
