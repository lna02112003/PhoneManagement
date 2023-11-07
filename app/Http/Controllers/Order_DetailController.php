<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order_DetailController extends Controller
{
   public function index(){
    $categories = DB::select('SELECT category.*
                            FROM category');
    return view('customer.order',['categories' => $categories]);
   }
}
