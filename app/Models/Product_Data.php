<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Data extends Model
{
    protected $table = 'product_data';
    protected $primaryKey = 'product_data_id';
    protected $fillable = ['URL','product_id', 'Loai_URL','row_delete','created_at','update_at'];
}
