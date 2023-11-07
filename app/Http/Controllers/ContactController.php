<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(){
        $categories = DB::select('SELECT table_category.*
                                FROM table_category');
        return view('contact', ['categories'=>$categories]);
    }
}
