<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'table_order';
    protected $fillable = ['user_id','total_amount','description','created_at','update_at'];
}
