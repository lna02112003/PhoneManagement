<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VNPAY RESPONSE</title>
    <link href="{{asset('/assets/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/jumbotron-narrow.css')}}" rel="stylesheet">
    <script src="{{asset('/assets/jquery-1.11.3.min.js')}}"></script>
</head>

<body>
    <!--Begin display -->
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">VNPAY RESPONSE</h3>
        </div>
        <div class="table-responsive">
            <div class="form-group">
                <label>Mã đơn hàng:</label>

                <label>{{$orderId}}</label>
            </div>
            <div class="form-group">

                <label>Số tiền:</label>
                <label>{{$amount}}</label>
            </div>
            <div class="form-group">
                <label>Nội dung thanh toán:</label>
                <label>{{$paymentContent}}</label>
            </div>
            <div class="form-group">
                <label>Mã phản hồi (vnp_ResponseCode):</label>
                <label>{{$responseCode}}</label>
            </div>
            <div class="form-group">
                <label>Mã GD Tại VNPAY:</label>
                <label>{{$transactionId}}</label>
            </div>
            <div class="form-group">
                <label>Mã Ngân hàng:</label>
                <label>{{$bankCode}}</label>
            </div>
            <div class="form-group">
                <label>Thời gian thanh toán:</label>
                <label>{{$paymentTime}}</label>
            </div>
            <div class="form-group">
                <label>Kết quả:</label>
                <label>
                    @if ($paymentStatus == 'error')
                        <span style="color: red">Chu ky khong hop le</span>
                    @else
                        @if ($responseCode == '00')
                            <span style="color: blue">GD thành công</span>
                        @else
                            <span style="color: red">GD Không thành công</span>
                        @endif
                    @endif
                </label>
            </div>
            <form action="{{route('homepage')}}" method="get">
                @csrf
                <button type="submit" name="btn" class="btn btn-success">Quay lại trang chủ</button>
            </form>
        </div>
        <footer class="footer">
        </footer>
    </div>
</body>
</html>