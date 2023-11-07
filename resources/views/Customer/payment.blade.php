<!DOCTYPE html>
<html>
<head>
    <title>Payment Return</title>
</head>
<body>
    <h1>Payment Return</h1>
    <p>Trạng thái thanh toán:</p>
    <pre>{{ json_encode($vnpResponse, JSON_PRETTY_PRINT) }}</pre>
</body>
</html>
