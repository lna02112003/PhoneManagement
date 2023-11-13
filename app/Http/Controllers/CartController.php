<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $categories = DB::select('SELECT category.* FROM category');
        $cart = $this->getCartFromCookies();
        return view('customer.cart', ['cart' => $cart, 'categories' => $categories]);
    }

    public function addToCart($productId)
    {
        $color = request('color');
        $version = request('version');

        $quantity = request('quantity');
        $price = $this->getProductPrice($color, $version);

        $color_name = DB::table('attribute_value')
            ->select('attribute_value_name')
            ->where('attribute_value_id', $color)
            ->first();

        $version_name = DB::table('attribute_value')
            ->select('attribute_value_name')
            ->where('attribute_value_id', $version)
            ->first();

        $cart = $this->getCartFromCookies();

        $cartItem = [
            'productId' => $productId,
            'color' => $color_name->attribute_value_name,
            'color_id' =>$color,
            'version_id' => $version,
            'version' => $version_name->attribute_value_name,
            'quantity' => $quantity,
            'price' => $price * $quantity,
        ];
        $cart[$productId] = $cartItem;
        $this->setCartInCookies($cart);
        return redirect()->route('customer.cart');
    }
    public function cartData(Request $request) {
        $customer = Auth::guard('customer')->user();
    
        $existingOrder = Order::where('customer_id', $customer->customer_id)
            ->where('status', 'Đang chờ thanh toán')
            ->first();
        $order_id = null;

        if ($existingOrder) {
            $order = $existingOrder;
            $order_id = $order->order_id;
            $orderDetail = DB::table('order_detail as od')
            ->select('od.description', 'od.unit_price', 'od.quantity', 'p.product_name', 'pd.URL as image', 'o.order_total')
            ->join('product as p', 'p.product_id', '=', 'od.product_id')
            ->join('product_data as pd', 'pd.product_id', '=', 'p.product_id')
            ->join('order as o', 'o.order_id', '=', 'od.order_id')
            ->where('od.order_id', $order_id)
            ->get();
        } else {
            $cartTotal = $request->input('cart_total.0');
            if ($cartTotal > 0) {
                $order = Order::create([
                    'customer_id' => $customer->customer_id,
                    'status' => 'Đang chờ thanh toán',
                    'order_total' => $cartTotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'row_delete' => 0,
                ]);
                $order_id = $order->order_id; // Gán giá trị $order_id nếu tạo đơn hàng mới
            }
            $index = 0;
            $product_ids = $request->input('product_id');
            $quantities = $request->input('hidden_quantity');
            $color_ids = $request->input('color_id');
            $version_ids = $request->input('version_id');
            $prices = $request->input('price');
            if (isset($product_ids) && isset($quantities) && isset($color_ids) && isset($version_ids)) {
                for ($index = 0; $index < count($product_ids); $index++) {
                    $product_id = $product_ids[$index];
                    $quantity = $quantities[$index];
                    $color_id = $color_ids[$index];
                    $version_id = $version_ids[$index];
                    $price = $prices[$index];
                    
                    $color_name = DB::table('attribute_value')
                        ->where('attribute_value_id', $color_id)
                        ->value('attribute_value_name');
                    $version_name = DB::table('attribute_value')
                        ->where('attribute_value_id', $version_id)
                        ->value('attribute_value_name');
                    $description = $color_name . ', ' . $version_name;
                    $order_detail = OrderDetail::create([
                        'order_id' => $order_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'unit_price' => $price,
                        'description' => $description,
                        'created_at' => now(),
                        'updated_at' => now(),
                        'row_delete' => 0,
                    ]);
                    $order_detail->save();
                }
            }
        }
        $categories = DB::select('SELECT category.* FROM category');
        Cookie::queue(Cookie::forget('cart'));
        return response()->view('customer.order', ['categories' => $categories, 'order' => $order ?? null, 'orderDetail' => $orderDetail ?? null, 'customer' => $customer]);
    }
    

    public function delete($id)
    {
        $cart = $this->getCartFromCookies();
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->setCartInCookies($cart);
            return redirect()->route('customer.cart')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
        } else {
            return redirect()->route('customer.cart')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }
    }
    private function getCartFromCookies()
    {
        if (Cookie::has('cart')) {
            $cart = json_decode(Cookie::get('cart'), true);
            return $cart;
        }

        return [];
    }

    private function setCartInCookies($cart)
    {
        $jsonCart = json_encode($cart);
        Cookie::queue('cart', $jsonCart, 60 * 24 * 7);
    }
    public function getProductPrice($color, $version) {
        $colorPrice = DB::table('attribute_value')
            ->where('attribute_value_id', $color)
            ->value('price');
    
        $versionPrice = DB::table('attribute_value')
            ->where('attribute_value_id', $version)
            ->value('price');
    
        $price = ($colorPrice + $versionPrice)/2;
    
        return $price;
    }
}
