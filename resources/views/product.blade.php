<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Image/logo.png')}}" />
    <link rel="stylesheet" href="{{ asset('CSS/homepage.css') }}">
</head>

<body>
    <header class="header">
        <div class="container header__container">
            <div class="header__logo">
                <img class="header__img" src="{{asset('Image/logo.png')}}">
                <h1 class="header__title">Nahinn<span class="header__light">.com</span></h1>
            </div>
            <div class="header__menu">
                <nav id="navbar" class="header__nav collapse">
                    <ul class="header__elenco">
                        <li class="header__el"><a href="{{route('homepage')}}" class="header__link">Home</a></li>
                        <li class="header__el header__el--category">
                            <a href="#" class="header__link" id="category-link">Category</a>
                            <ul class="category-list" id="category-list">
                                @foreach ($categories as $category)
                                <li class="header__el">
                                    <a href="{{ route('searchByCategory', ['id' => $category->category_id]) }}" class="header__link">{{ $category->category_name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="header__el"><a href="{{route('customer.cart')}}" class="header__link">Cart</a></li>
                        <li class="header__el"><a href="{{route('contact')}}" class="header__link">Contact us</a></li>
                        @if(auth()->check())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn--white">Logout →</button>
                        </form>
                        @else
                        <li class="header__el header__el--blue"><a href="{{ route('login') }}" class="btn btn--white">Sign In →</a></li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="sect sect--white">
        <div class="container">
            <div class="row">
                <h1 class="row__title">
                    Product in {{$category_select->category_name}}
                </h1>
            </div>
            <div class="box-product">
                @foreach($products as $products)
                <div class="row hind row--text-center ">
                    <div class="col-md-4 col-sm-4 price-box price-box--purple">
                        <div class="price-box__wrap">

                            <div class="price-box__img">
                                <img src="{{ asset('storage/' . $products->image) }}" width="350px" alt="{{ $products->product_name }}">
                            </div>
                            <h1 class="price-box__title">
                                {{ $products->product_name }}
                            </h1>
                            <p class="price-box__people">
                                {{ $products->category_name }}
                            </p>
                            <div class="price-box__btn">
                                <a class="btn btn--purple btn--width" href="{{ route('product.show', ['id' => $products->product_id]) }}">Buy now</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
<script>
    $("#myCarousel").carousel({
        interval: false
    });
</script>

</html>