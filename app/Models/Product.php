<?php

namespace App\Models;

use App\Traits\Seachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use Seachable;

    protected $searchableFields = [
         "title","description" 
         ];

    protected   $fillable =[
        "title","image","description","price","in_stock"
    ];
}
