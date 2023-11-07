<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attribute';
    protected $primaryKey = ['attribute_id'];
    protected $fillable = ['attribute_name','created_at','update_at','row_delete'];
}
