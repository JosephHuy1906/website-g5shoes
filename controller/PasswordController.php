<?php
include_once('../Utils/Database.php');
include_once('../Utils/Utils.php');
include_once('../Utils/Mail.php');
include_once('../model/DAO/UserDAO.php');
//action passwordController.php
// <input name='method' value='password' hidden>
//<input name='email' value='asdfasdf@gmail.com'>
//url.com/PasswordController.php?method=password&email=usermail

$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : 'error'; 
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : 'error';

function forgotPassword($email) {
    $resp = [];
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByMail($email);
    if($user == false) $resp['status'] = 'not-exist';
    else {
        $utils = new Utils();
        $mail = new Mail();

        $password = $utils->generateRandomString();

        if($userDAO->updateUserPasswordByID($user->getID(), $password)) {
            $resp['status'] = $mail->sendMail($email, "Quên mật khẩu?", "Vui lòng truy cập vào link để thay đổi mật khẩu: http://localhost/G5-Shoes/view/UpdatePassword.php<br>
                                                                        Mã code: $password") ? 'success' : 'fail';
        } 
    }
    return $resp;
}

switch ($method) {
    case 'password':
        if($email != 'error')  
            if(forgotPassword($email)['status'] == 'success') {
                echo '<script language="javascript">alert("Thay đổi password thành công vui lòng truy cậpvaof mail!")</script>';
                header("location: ../view/login_regin.php");
            }
        else header("location: ../view/login_regin.php");
        break;
}

?>