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
    public function cartData(Request $request){
        $customer = Auth::guard('customer')->user();
        $price = $this->getProductPrice($request->color_id, $request->version_id);
        $color_name = DB::table('attribute_value')
            ->select('attribute_value_name')
            ->where('attribute_value_id', $request->color_id)
            ->first();

        $version_name = DB::table('attribute_value')
            ->select('attribute_value_name')
            ->where('attribute_value_id', $request->version_id)
            ->first();
        $cartItem = [
            'productId' => $request->product_id,
            'color' => $color_name->attribute_value_name,
            'color_id' =>$request->color_id,
            'version_id' => $request->version_id,
            'version' => $version_name->attribute_value_name,
            'quantity' => $request->hidden_quantity,
            'cartTotal' => $request->cart_total,
            'customer' =>$customer,
            'price' =>$price,
        ];
        Cookie::queue('cartOrder', json_encode($cartItem), 30); 
        if (Cookie::has('cart')) {
            Cookie::queue(Cookie::forget('cart'));
        }
        dd($cartItem);
        $categories = DB::select('SELECT category.* FROM category');
        return response()->view('customer.order', ['categories' => $categories, 'cart' => $cartItem]);
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
