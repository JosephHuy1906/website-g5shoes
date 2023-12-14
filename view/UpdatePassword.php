<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/resetpass.css">
    <title>Quên mật khẩu</title>
</head>
<body>
    <div class="container">
        <div class="form-reset">
            <img src="./images/logo-chinh.jpg" alt="">
            <form id="resetpass">
                <h2>Đặt lại mật khẩu</h2>
                <input placeholder="Nhập email" type="email" name="email" id="email" required><br/><br/>
                <input placeholder="Nhập mã code" type="text" name="code" id="code" required><br/>
                <button>Gửi</button>
            </form>
        </div>
    </div>
</body>
</html>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="./js/jquery.validate.min.js"></script>
<script src="./js/ajaxResetPass.js"></script>

