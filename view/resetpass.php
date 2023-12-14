<?php 
    include './header.php';   
?>
<link rel="stylesheet" href="./css/resetpass.css">

<div class="container">
    <div class="form-reset">
        <form action="..\controller\PasswordController.php" id="resetpass">
            <h2>Đặt lại mật khẩu</h2>
            <p>
            Chúng tôi sẽ gửi cho bạn một email để kích hoạt việc đặt lại mật khẩu.
            </p>
            <input type="text" name="method" value="password" hidden>
            <input placeholder="exam@gmail.com" type="email" name="email" id="email" required><br>
            <button>Gửi</button>
        </form>
    </div>
</div>


<?php 
    include './footer.php'; 
?>