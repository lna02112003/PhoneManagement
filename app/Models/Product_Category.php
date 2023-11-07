<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Category extends Model
{
    protected $table = 'product_category';
    protected $primaryKey = 'product_category_id';
    protected $fillable = ['category_id','product_id','created_at','update_at'];
}
