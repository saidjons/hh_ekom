<?php
namespace App\Traits;

trait Seachable {

    public function scopeSearch($query,$term){
        
        foreach($this->searchableFields as $field){
            $query->orWhere($field,"like","%$term%");
        }

        return $query;
    }
}