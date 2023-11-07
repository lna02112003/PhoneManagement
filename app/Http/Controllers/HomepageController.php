<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    function index()
    {
        $products = DB::table('product as p')
            ->join('product_category as pc', 'p.product_id', '=', 'pc.product_id')
            ->join('category as c', 'c.category_id', '=', 'pc.category_id')
            ->join('product_data as pd', 'pd.product_id', '=', 'p.product_id')
            ->select('p.product_id', 'p.product_name', 'c.category_name', 'pd.URL as image')
            ->where('pd.Loai_URL', '=', 'img')
            ->where('p.row_delete', 0)
            ->get();       
        $categories = DB::select('SELECT category.*
                                FROM category
                                WHERE row_delete = 0');
        $hotProducts = DB::table('product')
            ->select('product.product_id', 'product.product_name', 'category.category_name', 'pd.url as image', 'pd.url as description')
            ->join('product_category', 'product.product_id', '=', 'product_category.product_id')
            ->join('category', 'product_category.category_id', '=', 'category.category_id')
            ->join('product_data as pd', 'pd.product_id', '=', 'product.product_id')
            ->where('product.hot', 1)
            ->where('product.row_delete', 0)
            ->where('pd.Loai_URL', 'img')
            ->get();
        return view('homepage', ['categories' => $categories, 'products' => $products, 'hotProducts' => $hotProducts]);
    }
    public function show($id)
    {
        $product = DB::table('product')
            ->select('product.product_id', 'product.product_name', 'product.description', 'product_data.URL as image')
            ->join('product_data', 'product.product_id', '=', 'product_data.product_id')
            ->where('product.product_id', $id)
            ->where('product.row_delete', 0)
            ->first();

        $products = DB::table('product')
            ->select('product.product_id', 'category.category_name' ,'product.product_name', 'product_data.URL as image')
            ->join('product_data', 'product.product_id', '=', 'product_data.product_id')
            ->join('product_category', 'product_category.product_id','=','product.product_id')
            ->join('category', 'category.category_id','=', 'product_category.category_id')
            ->where('product.row_delete', 0)
            ->get();
        $Color = DB::table('attribute_value as av')
                ->select('av.*')
                ->join('attribute as a', 'a.attribute_id','=', 'av.attribute_id')
                ->join('product_attribute as pa', 'pa.attribute_id','=','a.attribute_id')
                ->join('product as p', 'p.product_id','=','pa.product_id')
                ->where('p.product_id', $id)
                ->where('a.attribute_name', 'Color')
                ->where('av.row_delete', 0)
                ->get();
        $Version = DB::table('attribute_value as av')
                ->select('av.*')
                ->join('attribute as a', 'a.attribute_id','=', 'av.attribute_id')
                ->join('product_attribute as pa', 'pa.attribute_id','=','a.attribute_id')
                ->join('product as p', 'p.product_id','=','pa.product_id')
                ->where('p.product_id', $id)
                ->where('a.attribute_name', 'Phiên bản')
                ->where('av.row_delete', 0)
                ->get();
        $categories = DB::select('SELECT category.*
                                FROM category');
        return view('viewproduct', ['product' => $product, 'products' => $products, 'categories' => $categories, 'Color'=>$Color, 'Version'=>$Version]);
    }
    public function searchByCategory($id)
    {
        $products = DB::table('product as p')
            ->select('p.product_id', 'p.product_name', 'c.category_name', 'pd.URL as image')
            ->join('product_category as pc', 'p.product_id', '=', 'pc.product_id')
            ->join('category as c', 'c.category_id', '=', 'pc.category_id')
            ->join('product_data as pd', 'p.product_id', '=', 'pd.product_id')
            ->where('c.category_id', $id)
            ->where('p.row_delete', 0)
            ->get();
        $category_select = DB::table('category')
                            ->select('category_name')
                            ->where('category_id', $id)
                            ->where('row_delete', 0)
                            ->first();
        $categories = DB::select('SELECT category.* 
                                    FROM category
                                    WHERE row_delete = 0');
        return view('product', ['products' => $products, 'categories' => $categories, 'category_select' => $category_select]);
    }
    public function getProductPrice($color, $version) {
        $colorPrice = DB::table('attribute_value')
            ->where('attribute_value_id', $color)
            ->value('price');
    
        $versionPrice = DB::table('attribute_value')
            ->where('attribute_value_id', $version)
            ->value('price');
    
        $price = ($colorPrice + $versionPrice)/2;
    
        return response()->json(['price' => $price]);
    }
}
