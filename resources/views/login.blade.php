<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('CSS/login.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
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