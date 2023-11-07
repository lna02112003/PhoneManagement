<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Category;
use App\Models\Product_Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    function index()
    {
        $product = DB::table('product as p')
            ->select('c.category_name', 'p.product_name', 'p.product_id', 'p.description', 'pd.URL as image')
            ->join('category as c', 'c.category_id', '=', DB::raw('(SELECT pc.category_id FROM product_category AS pc WHERE pc.product_id = p.product_id LIMIT 1)'))
            ->join('product_data as pd', 'pd.product_id', '=', 'p.product_id')
            ->where('p.row_delete', '=', '0')
            ->get();

        return view('admin.product', ['product' => $product]);
    }
    public function create()
    {
        $categories = DB::select('SELECT category.*
                            FROM category');
        return view('admin.product_create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'product_name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'description' => 'required|string',
        ]);
        
        $product = new Product;
        $product->product_name = $request->product_name;
        $product->description = $request->description;
        $product->hot = 0;
        $product->row_delete = 0;
        $product->save();
        
        $productData = new Product_Data;
        $productData->product_id = $product->product_id;
        $productData->URL = $request->file('image')->store('uploads', 'public');
        $productData->Loai_URL = 'img';
        $productData->save();
        
        $product_category = new Product_Category;
        $product_category->product_id = $product->product_id;
        $product_category->category_id = $request->category_id;
        $product_category->save();
        
        return redirect()->route('admin.product')->with('success', 'Product added successfully');
        
    }
    public function edit($id)
    {
        $product = DB::table('product as p')
            ->select('c.category_id','c.category_name', 'p.product_name', 'p.product_id', 'p.description', 'pd.URL as image')
            ->join('category as c', 'c.category_id', '=', DB::raw('(SELECT pc.category_id FROM product_category AS pc WHERE pc.product_id = p.product_id LIMIT 1)'))
            ->join('product_data as pd', 'pd.product_id', '=', 'p.product_id')
            ->where('p.product_id', '=', $id )
            ->first();
        $categories = DB::select('SELECT category.*
                                FROM category');

        return view('admin.product_update', compact('product','categories'));
    }
    public function update(Request $request, $id)
    {
        $product = DB::select('SELECT product.*
                      FROM product
                      WHERE product.product_id = ?', [$id]);
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
    
            $productData = Product_Data::where('product_id', $id)
                ->where('Loai_URL', 'img')
                ->first();
        
            if ($productData) {
                $productData->URL = $imagePath;
                $productData->save();
            } else {
                $productData = new Product_Data;
                $productData->product_id = $id;
                $productData->URL = $imagePath;
                $productData->Loai_URL = 'img';
                $productData->save();
            }
        }        

        DB::table('product')
            ->where('product_id', $id)
            ->update([
                'product_name' => $data['product_name'],
                'description' => $data['description'],
            ]);

        $productCategory = Product_Category::where('product_id', $id)->first();

        if ($productCategory) {
            $productCategory->category_id = $request->category_id;
            $productCategory->save();
        }
            
        return redirect()->route('admin.product')->with('success', 'Product updated successfully');
    }


    public function destroy($id)
    {
        Product::where('product_id', $id)->update(['row_delete' => 1]);

        return redirect()->route('admin.product')->with('success', 'Product deleted successfully');
    }
}
