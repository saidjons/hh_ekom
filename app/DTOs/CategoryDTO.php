<?php
namespace App\DTOs;

class CategoryDTO {

    public function __construct(
        public string $title,
        public int $order,
        public int $parent_id,

    ){
    
    }
}