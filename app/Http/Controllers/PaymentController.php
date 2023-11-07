<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $orderID = $request->input('order_id');
        $orderDesc = $request->input('order_desc');
        $amount = $request->input('amount');

        $requestData = [
            'vnp_TmnCode' => env('VNPAY_TMNCODE'),
            'vnp_Amount' => $amount * 100,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $_SERVER['REMOTE_ADDR'],
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => $orderDesc,
            'vnp_OrderType' => 'other',
            'vnp_ReturnUrl' => env('VNPAY_RETURNURL'),
            'vnp_TxnRef' => $orderID,
        ];

        $vnpUrl = env('VNPAY_TESTURL') . '?' . http_build_query($requestData);

        return redirect()->away($vnpUrl);
    }

    public function returnPayment(Request $request)
    {
        // Xử lý khi người dùng quay lại từ VNPAY
        // Kiểm tra trạng thái giao dịch và hiển thị kết quả cho người dùng
        $vnpResponse = $request->all();

        // Thực hiện kiểm tra và xử lý dữ liệu trả về từ VNPAY

        return view('payment.return', compact('vnpResponse'));
    }
}
