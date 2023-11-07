<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product_Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function index($id)
    {
        $attribute = DB::table('attribute as a')
                        ->select('a.*', 'p.product_id', 'av.attribute_value_name' , 'av.attribute_value_id', 'av.price', 'p.product_name')
                        ->join('attribute_value as av', 'av.attribute_id', '=', 'a.attribute_id')
                        ->join('product_attribute as pa', 'pa.attribute_id', '=', 'a.attribute_id')
                        ->join('product as p', 'pa.product_id', '=', 'p.product_id')
                        ->where('av.row_delete', '=', 0)
                        ->where('p.product_id', '=', $id)
                        ->get();
        $product = DB::table('product')
                    ->where('product_id', $id)
                    ->first();
        return view('admin.attribute', ['attribute' => $attribute ,'product'=> $product]);
    }

    public function create($id)
    {
        $product = DB::table('product')
            ->where('product_id', $id)
            ->first();
        if (!$product) {
            return redirect()->route('admin.attribute')->withErrors(['message' => 'Product not found']);
        }

        return view('admin.attribute_create', ['product' => $product]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'attribute_name' => 'required|string|max:255',
        ]);
        $attributeData = [
            'attribute_name' => $request->attribute_name,
            'row_delete' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        $attributeId = DB::table('attribute')->insertGetId($attributeData);
        $attribute_product = [
            'product_id'=> $request->product_id,
            'attribute_id' => $attributeId,
        ];
        DB::table('product_attribute')->insert( $attribute_product);
        return redirect()->route('admin.attribute', ['id' => $request->product_id])->with('success', 'Attribute added successfully');

    }

    public function edit($product_id, $attribute_id)
    {
        $attributes = DB::table('attribute as a')
            ->select('a.*')
            ->join('product_attribute as pa', 'pa.attribute_id', '=', 'a.attribute_id')
            ->join('product as p', 'pa.product_id', '=', 'p.product_id')
            ->where('p.product_id', $product_id)
            ->get();
        $attribute = DB::table('attribute as a')
                        ->select('a.*', 'av.attribute_value_name', 'av.price')
                        ->join('attribute_value as av', 'av.attribute_id', '=', 'a.attribute_id')
                        ->join('product_attribute as pa', 'pa.attribute_id', '=', 'a.attribute_id')
                        ->join('product as p', 'pa.product_id', '=', 'p.product_id')
                        ->where('a.attribute_id', $attribute_id)
                        ->first();
        return view('admin.attribute_update', ['attributes' => $attributes, 'product_id' => $product_id, 'attribute'=>$attribute]);
    }

    public function update(Request $request, $product_id, $attribute_id)
    {
        $data = $request->validate([
            'attribute_id' => 'required',
            'attribute_value_name' => 'required|string|max:255',
            'price' => 'numeric|required',
        ]);
        
        $attributeValue = DB::table('attribute_value')
            ->where('attribute_id', $data['attribute_id'])
            ->where('attribute_value_name', $data['attribute_value_name'])
            ->first();
        if (!$attributeValue) {
            $attributeValueId = DB::table('attribute_value')->insertGetId([
                'attribute_id' => $data['attribute_id'],
                'attribute_value_name' => $data['attribute_value_name'],
                'price' => $data['price'],
            ]);
        } else {
            DB::table('attribute_value')
                ->where('attribute_id', $attribute_id)
                ->update([
                    'price' => $data['price'],
                ]);
        }
        
        $productAttribute = DB::table('product_attribute')
            ->where('product_id', $product_id)
            ->where('attribute_id', $data['attribute_id'])
            ->first();
        
        if (!$productAttribute) {
            DB::table('product_attribute')->insert([
                'product_id' => $product_id,
                'attribute_id' => $data['attribute_id'],
            ]);
        }
    
        return redirect()->route('admin.attribute',['id'=> $product_id])->with('success', 'Attribute updated successfully');
    }

    public function destroy($product_id, $attribute_value_id)
    {
        AttributeValue::where('attribute_value_id', $attribute_value_id)->update(['row_delete' => 1]);

        return redirect()->route('admin.attribute',['id'=> $product_id])->with('success', 'Attribute deleted successfully');
    }
}
