<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
    
class PaymentController extends Controller
{
    public function createPayment($order_id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order = Order::find($order_id);
        $customer = Auth::guard('customer')->user();
        $vnp_TmnCode = '96PV39NC';
        $vnp_HashSecret = 'ZYCTQITJBJSIYKRGUROFFNJHNQGCRSPZ';
        $vnp_ReturnUrl = 'http://127.0.0.1:8000/customer/payment/return';
        $vnp_TestUrl = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $expire = date('YmdHis', strtotime('+1 hour'));
        $orderAmount =(int)$order->order_total * 24000;  
        $inputData = [
            "vnp_Version" => "2.1.0",
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_Amount' => $orderAmount*100,
            'vnp_Command' => "pay",
            'vnp_CreateDate' => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_ExpireDate"=>$expire,
            'vnp_IpAddr' => request()->ip(),
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => 'Payment for Order #' . $order->order_id,
            "vnp_OrderType" => "other",
            'vnp_ReturnUrl' => $vnp_ReturnUrl,
            'vnp_TxnRef' => $order->order_id,
            "vnp_Bill_Mobile"=>$customer->phone,
            "vnp_Bill_Email"=>$customer->email,
            "vnp_Bill_FirstName"=>$customer->firstname,
            "vnp_Bill_LastName"=>$customer->middlename.' '.$customer->lastname,
            "vnp_Bill_Address"=>$customer->address,
            "vnp_Bill_City"=>$customer->address,
            "vnp_Bill_Country"=>"Viet Nam",
            "vnp_Inv_Phone"=>"0969325914",
            "vnp_Inv_Email"=>"namanhle02112003@gmail.com",
            "vnp_Inv_Customer"=>"Lê Nam Anh",
            "vnp_Inv_Address"=>"Cổ Nhuế, Bắc Từ Liêm, Hà Nội",
            "vnp_Inv_Company"=>"NahinnStore",
            "vnp_Inv_Taxcode"=>"02112003",
            "vnp_Inv_Type"=>"BillPayment"
        ];
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_TestUrl . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }
    public function returnPayment(Request $request)
    {
        $vnpSecureHash = $request->get('vnp_SecureHash');
        $vnp_HashSecret = 'ZYCTQITJBJSIYKRGUROFFNJHNQGCRSPZ';
        $inputData = [];

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'vnp_') === 0) {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);

        ksort($inputData);

        $hashData = '';

        $i = 0;

        foreach ($inputData as $key => $value) {
            if ($i === 1) {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }

        $calculatedSecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($vnpSecureHash === $calculatedSecureHash) {
            $order = DB::table('order')
                ->where('order_id', $inputData['vnp_TxnRef'])
                ->update(['status' => 'Giao dịch thành công', 'row_delete' => '1']);
            $order_detail = DB::table('order_detail')
                ->where('order_id', $inputData['vnp_TxnRef'])
                ->update(['row_delete' => '1']);
            $orderId = $inputData['vnp_TxnRef'];
            $amount = $inputData['vnp_Amount'] / 100;
            $paymentContent = $inputData['vnp_OrderInfo'];
            $responseCode = $inputData['vnp_ResponseCode'];
            $transactionId = $inputData['vnp_TransactionNo'];
            $bankCode = $inputData['vnp_BankCode'];
            $paymentTime = $inputData['vnp_PayDate'];
            $paymentStatus = 'success';
        } else {
            $orderId = null;
            $amount = null;
            $paymentContent = null;
            $responseCode = null;
            $transactionId = null;
            $bankCode = null;
            $paymentTime = null;
            $paymentStatus = 'error';
        }

        return view('vnpay_return', compact(
            'orderId',
            'amount',
            'paymentContent',
            'responseCode',
            'transactionId',
            'bankCode',
            'paymentTime',
            'paymentStatus'
        ));
    }
}
