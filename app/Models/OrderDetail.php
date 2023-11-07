<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'table_order_detail';
    protected $fillable = ['order_id','product_id', 'quantity', 'unit_price', 'description','created_at','update_at'];
}
