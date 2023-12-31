<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "sorting_number",
        "parent_id",
    ];

    public function subs(){
        
       return $this->hasMany(self::class,"parent_id");
    }
}
