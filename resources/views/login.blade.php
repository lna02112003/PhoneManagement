<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('CSS/login.css') }}">
    <link rel="stylesheet" href="{{asset('CSS/homepage.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<header class="header">
        <div class="container header__container">
            <div class="header__logo">
                <img class="header__img" src="{{asset('Image/logo.png')}}">
                <h1 class="header__title">Nahinn<span class="header__light">.com</span></h1>
            </div>
            <div class="header__menu">
                <nav id="navbar" class="header__nav">
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
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="card">
            <div class="body">
                <div class="background_left">
                    <div class="img">
                        <img src="{{ asset('/Image/logo.png') }}" class="logo" alt="logo">
                    </div>
                </div>
                <div class="background_right">
                    <div class="header-right">
                        <img src="{{ asset('/Image/user.png') }}" class="logo_user" alt="logo user">
                        <p class="h4">LOGIN</p>
                    </div>
                    <form action="{{route('login')}}" method="POST" onsubmit="return validateForm()">
                        @csrf
                        <div class="col mb-3">
                            <label class="form-label" for="email">Email:</label>
                            <input type="email" name="email" placeholder="Email" class="form-control" required>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label" for="password">Password:</label>
                            <input type="password" name="password" placeholder="Password" class="form-control" required>
                        </div>
                        <div class="col mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Login</button><br>
                            <a href="{{route('register')}}">I don't have account</a>
                        </div>
                    </form>
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
<script>
    function validateForm() {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            
            // Kiểm tra email có đúng định dạng
            var emailPattern = /^\S+@\S+\.\S+$/;
            if (!emailPattern.test(email)) {
                alert('Email không hợp lệ');
                return false;
            }
            if (password === "") {
                alert('Vui lòng nhập Password');
                return false;
            }
            return true;
        }
</script>
</body>
</html>