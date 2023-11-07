<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function index(){
        $order = DB::select('SELECT order.*,user.name
                                FROM table_order
                                JOIN users on users.id = table_order.user_id');
        return view('admin.order',['order'=>$order]);                        
    }
    public function create()
    {
        $categories = Category::all(); // Lấy danh sách các danh mục
        return view('admin.order_create', compact('categories'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required',
            'total_amount' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $order = new Order();
        $order->user_id = $request->user_id;
        $order->total_amount = $request->total_amount;
        $order->description = $request->description;
        $order->save();

        return redirect()->route('admin.order')->with('success', 'Order added successfully');
    }
    public function edit($id)
    {
        $order = Order::find($id);
        $categories = Category::all();

        return view('admin.order_update', compact('order', 'categories'));
    }
    public function update(Request $request, $id)
    {
        // Lấy thông tin sản phẩm dựa trên ID
        $order = Order::find($id);

        if (!$order) {
            // Xử lý khi sản phẩm không tồn tại
            return redirect()->back()->withErrors(['message' => 'Order not found']);
        }

        // Kiểm tra và xử lý dữ liệu từ form
        $data = $request->validate([
            'user_id' => 'required',
            'total_amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // Cập nhật thông tin sản phẩm
        $order->user_id = $data['user_id'];
        $order->total_amount = $data['total_amount'];
        $order->description = $data['description'];

        $order->save();
        return redirect()->route('admin.order')->with('success', 'Order updated successfully');
    }
    public function destroy($id)
    {
        // Xóa danh mục dựa trên ID
        Order::destroy($id);

        // Chuyển hướng sau khi xóa thành công
        return redirect()->route('admin.order')->with('success', 'Order deleted successfully');
    }
}
