<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Image/logo.png')}}" />
    <link rel="stylesheet" href="{{ asset('CSS/signup.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="body">
        <div class="hind">
        </div>
        <div class="form">
            <header>
                <img src="{{asset('/Image/logo.png')}}" alt="logo" class="logo">
            </header>
            <div class="button">
                <a href="/signup" class="EdgeButton EdgeButton--medium EdgeButton--primary HomePage-buttonSignup">Sign Up</a>
                <a href="/login" class="EdgeButton EdgeButton--medium EdgeButton--secondary HomePage-buttonLogin">Log in</a>
            </div>
            <form action="{{route('register')}}" method="post" onsubmit="return validateForm()" id="form">
                @csrf
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" id="username">
                    <span id="usernameError" class="error-message"></span>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" id="email">
                    <span id="emailError" class="error-message"></span>
                </div>
                <div class="mb-3">
                    <input type="number" name="phone" class="form-control" placeholder="Phone" id="phone">
                    <span id="phoneError" class="error-message"></span>
                </div>
                <div class="mb-3">
                    <input type="text" name="address" class="form-control" placeholder="Address" id="address">
                    <span id="addressError" class="error-message"></span>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" id="password">
                    <span id="passwordError" class="error-message"></span>
                </div>
                <div class="mb-3">
                    <input type="submit" class="EdgeButton EdgeButton--secondary EdgeButton--medium submit" value="Log in">
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    function validateForm() {
        var username = document.getElementById("username").value;
        var email = document.getElementById("email").value;
        var phone = document.getElementById("phone").value;
        var address = document.getElementById("address").value;
        var password = document.getElementById("password").value;

        // Xóa các thông báo lỗi cũ trước khi kiểm tra lại
        document.getElementById("usernameError").innerText = "";
        document.getElementById("emailError").innerText = "";
        document.getElementById("phoneError").innerText = "";
        document.getElementById("addressError").innerText = "";
        document.getElementById("passwordError").innerText = "";

        // Kiểm tra trường username không để trống
        if (username === "") {
            document.getElementById("usernameError").innerText = "Vui lòng điền tên người dùng.";
            return false;
        }

        // Kiểm tra trường email không để trống
        if (email === "") {
            document.getElementById("emailError").innerText = "Vui lòng điền địa chỉ email.";
            return false;
        }

        // Kiểm tra trường phone không để trống và là số có 10 chữ số
        if (phone === "") {
            document.getElementById("phoneError").innerText = "Vui lòng điền số điện thoại.";
            return false;
        } else if (!(/^\d{10}$/.test(phone))) {
            document.getElementById("phoneError").innerText = "Số điện thoại không hợp lệ (10 chữ số).";
            return false;
        }

        // Kiểm tra trường address không để trống
        if (address === "") {
            document.getElementById("addressError").innerText = "Vui lòng điền địa chỉ.";
            return false;
        }

        // Kiểm tra trường password không để trống
        if (password === "") {
            document.getElementById("passwordError").innerText = "Vui lòng nhập mật khẩu.";
            return false;
        }

        return true; // Nếu tất cả điều kiện đều hợp lệ, cho phép gửi form
    }
</script>
</html>