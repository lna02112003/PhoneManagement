<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    function index(){
        $category = DB::table('category')
                    ->where('row_delete', 0)
                    ->get();
        return view('admin.category',['category'=> $category]);
    }
    public function create()
    {
        return view('admin.category_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $data['row_delete'] = 0;
        DB::table('category')->insert($data);
        return redirect()->route('admin.category')->with('success', 'Category added successfully');
    }
    public function edit($id)
    {
        $category = DB::table('category')
                    ->where('category_id', $id)
                    ->where('row_delete', 0)
                    ->first();

        return view('admin.category_update', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $category = DB::table('category')
                    ->where('category_id', $id)
                    ->where('row_delete', 0)
                    ->first();

    
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        DB::table('category')
            ->where('category_id', $id)
            ->where('row_delete', 0)
            ->update($data);
    
        return redirect()->route('admin.category')->with('success', 'Category updated successfully');
    }
    public function destroy($id)
    {
        Category::where('category_id', $id)->update(['row_delete' => 1]);

        return redirect()->route('admin.category')->with('success', 'Category deleted successfully');
    }
}

