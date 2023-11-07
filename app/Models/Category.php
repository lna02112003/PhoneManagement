<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = ['category_id'];
    protected $fillable = ['category_name','description','parentID','row_delete','created_at','update_at'];
}
