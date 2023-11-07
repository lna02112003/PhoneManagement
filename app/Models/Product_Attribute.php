<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Attribute extends Model
{
    protected $table = 'product_attribute';
    protected $primaryKey = ['product_attribute_id'];
    protected $fillable = ['attribute_id,product_id','created_at','update_at'];
}
