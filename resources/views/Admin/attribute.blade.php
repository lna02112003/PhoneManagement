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
                <li><a href="{{ route('admin.product') }}">PRODUCT</a></li>
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
                        <a href="{{ route('attribute.create', ['id' => $product->product_id]) }}" class="btn btn-primary">Add Attribute</a>
                        <a href="{{route('attribute_value.create', ['id' => $product->product_id])}}" class="btn btn-primary ">Add Attribute Value</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%;">STT</th> 
                                <th style="width: 20%;">Product Name</th>
                                <th style="width: 20%;">Attribute Name</th>
                                <th style="width: 10%;">Attribute Value Name</th>
                                <th style="width: 10%;">Price</th>
                                <th style="width: 10%;">Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attribute as $attribute)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $attribute->product_name}}</td>
                                    <td>{{ $attribute->attribute_name}}</td>
                                    <td>{{ $attribute->attribute_value_name}}</td>
                                    <td>{{ $attribute->price }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Actions">
                                            <form method="GET" action="{{ route('attribute.edit', ['product_id' => $product->product_id, 'attribute_id' => $attribute->attribute_id]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">
                                                    Sửa
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('attribute.destroy', ['product_id' => $product->product_id, 'attribute_value_id' => $attribute->attribute_value_id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    Xóa
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