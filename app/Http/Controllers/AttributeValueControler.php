<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeValueControler extends Controller
{
    public function create($id)
    {
        $product = DB::table('product')
                    ->where('product_id', $id)
                    ->first();
        $attributes = DB::select('SELECT a.*
                    FROM attribute as a
                    JOIN product_attribute as pa ON pa.attribute_id = a.attribute_id
                    JOIN product as p ON pa.product_id = p.product_id
                    WHERE p.product_id = ?', [$id]);        
        return view('admin.attribute_value_create' , ['attributes'=> $attributes , 'product' => $product] );
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'attribute_id' => 'required',
            'attribute_value_name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        $attributeValue = [
            'attribute_id' => $request->attribute_id,
            'attribute_value_name' => $request->attribute_value_name,
            'price' => $request->price,
            'row_delete' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        DB::table('attribute_value')->insert($attributeValue);
        return redirect()->route('admin.attribute', ['id' => $request->product_id])->with('success', 'Attribute added successfully');
    }
}
