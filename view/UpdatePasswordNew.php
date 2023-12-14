<?php
session_start();

if(isset($_SESSION['code'])){

?>
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
            <form  id="resetpassnew">
                <h2>Đặt lại mật khẩu</h2>
                <input placeholder="Nhập password mới" type="password" name="password" id="password"><br/><br/>
                <input placeholder="Nhập lại password mới" type="password" name="repassword" id="repassword"><br/>
                <button>Gửi</button>
            </form>
        </div>
    </div>
</body>
</html>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="./js/jquery.validate.min.js"></script>
<script src="./js/ajaxResetPass.js"></script>
<?php   
}else{
    header("location: ./index.php");
}

?>
