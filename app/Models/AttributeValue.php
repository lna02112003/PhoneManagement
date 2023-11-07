<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'attribute_value';
    protected $primaryKey = ['attribute_value_id'];
    protected $fillable = ['attribute_id,attribute_value_name','price','row_delete','created_at','update_at'];
}
