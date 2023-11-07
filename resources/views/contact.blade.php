<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Image/logo.png')}}" />
    <link rel="stylesheet" href="{{ asset('CSS/contact.css') }}">
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
                                    <a href="{{ route('searchByCategory', ['id' => $category->id]) }}" class="header__link">{{ $category->category_name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="header__el"><a href="{{route('user.cart')}}" class="header__link">Cart</a></li>
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
    <div class="background">
        <div class="container">
            <div class="screen">
                <div class="screen-header">
                    <div class="screen-header-left">
                        <div class="screen-header-button close"></div>
                        <div class="screen-header-button maximize"></div>
                        <div class="screen-header-button minimize"></div>
                    </div>
                    <div class="screen-header-right">
                        <div class="screen-header-ellipsis"></div>
                        <div class="screen-header-ellipsis"></div>
                        <div class="screen-header-ellipsis"></div>
                    </div>
                </div>
                <div class="screen-body">
                    <div class="screen-body-item left">
                        <div class="app-title">
                            <span>CONTACT</span>
                            <span>US</span>
                        </div>
                        <div class="app-contact">CONTACT INFO : Lê Nam Anh</br>CONTACT INFO : 0969325914</div>
                    </div>
                    <div class="screen-body-item">
                        <form >
                            @csrf
                            <div class="app-form">
                                <div class="app-form-group">
                                    <input class="app-form-control" type="text" name="name" placeholder="NAME" >
                                </div>
                                <div class="app-form-group">
                                    <input class="app-form-control" type="email" name="email" placeholder="EMAIL">
                                </div>
                                <div class="app-form-group">
                                    <input class="app-form-control" type="text" name="contact-no" placeholder="CONTACT NO">
                                </div>
                                <div class="app-form-group message">
                                    <textarea class="app-form-control" placeholder="MESSAGE"></textarea>
                                </div>
                                <div class="app-form-group buttons">
                                    <button type="reset" name="btn-reset" class="app-form-button">CANCEL</button>
                                    <button type="submit" name="btn-submit" class="app-form-button">SEND</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
<script>
    $("#myCarousel").carousel({
        interval: false
    });
</script>

</html>