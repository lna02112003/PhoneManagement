<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Image/logo.png')}}" />
    <link rel="stylesheet" href="{{ asset('CSS/homepageadmin.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="sidebar">
        <div class="user">
            <img src="{{asset('Image/logo.png')}}" alt="logo">
            <span class="username">NAHINN</span>
        </div>
        <nav role='navigation'>
            <ul>
                <li><a href="{{route('admin.homepage')}}">HOMEPAGE</a></li>
                <li><a href="{{route('admin.category')}}">CATEGORY</a></li>
                <li><a href="{{ route('admin.product') }}" class="dropbtn">PRODUCT</a></li>
                <li><a href="{{route('admin.order')}}">ORDER</a></li>
                <li><a href="#">REPORT</a></li>
                <li><a href="#">STATISTIC</a></li>
            </ul>
        </nav>
    </div>

    <!-- MAIN -->
    <div class="main">
        <header>
            <!-- HEADER BOTTOM -->
            <div class="bottom">
                <!-- identity -->
                <div class="identity">
                    <img src="{{asset('Image/logo.png')}}" alt="logo">
                    <span class="name">NAHINN</span> <br />
                </div>
                <!-- actions -->
                <a href="{{route('logout')}}"><span class="logout">Log out</span></a>
            </div>
        </header>

        <!-- PAGE -->
        <div class="page group">
            <div class="section">
                <div class="col span_2">
                    <div>
                        <a href="{{route('product.create')}}" class="btn btn-primary ">Add Product</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%;">STT</th>
                                <th style="width: 15%;">Category Name</th>
                                <th style="width: 15%;">Product Name</th>
                                <th style="width: 10%;">Mô tả</th>
                                <th style="width: 10%;">Hình ảnh</th>
                                <th style="width: 20%;">Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product as $product)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$product->category_name}}</td>
                                <td>{{$product->product_name}}</td>
                                <td>
                                    @if (strlen($product->description) > 100) {{-- Kiểm tra nếu độ dài lớn hơn 100 ký tự --}}
                                        {{ substr($product->description, 0, 100) }}... {{-- Hiển thị 100 ký tự đầu và thêm dấu ba chấm --}}

                                    @else
                                        {{ $product->description }} {{-- Nếu độ dài nhỏ hơn hoặc bằng 100 ký tự, hiển thị toàn bộ nội dung --}}
                                    @endif
                                </td>
                                <td><a href="{{ asset('storage/' . $product->image) }}">Link to Image</a></td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <form method="GET" action="{{ route('product.update', ['id' => $product->product_id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                Sửa
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('product.destroy', ['id' => $product->product_id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                Xóa
                                            </button>
                                        </form><br>
                                        <form method="GET" action="{{ route('admin.attribute', ['id' => $product->product_id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                Add Attribute
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-xs-6">
                    <img class="footer__img" width="100px" src="{{asset('/Image/logo.png')}}">
                    <h1 class="footer__title">Nahinn<span class="footer__light">.com</span></h1>
                </div>
            </div>
        </div>
    </footer>
</body>


</html>