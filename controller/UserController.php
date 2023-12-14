<?php
session_start();
include_once('../Utils/Database.php');
include_once('../model/DAO/UserDAO.php');
include_once('../model/DAO/ProductDAO.php');
include_once('../model/DAO/SizeDAO.php');
include('../model/DAO/CategoryDAO.php');
include('../model/DAO/CommentDAO.php');
include('../model/DAO/notificationDAO.php');

$productDAO = new ProductDAO();
$userDAO = new UserDAO();
$sizeDAO = new SizeDAO();
$commentDAO = new CommentDAO();
$categoryDAO = new CategoryDAO();
$notificationDAO = new notificationDAO();

if(isset($_GET['act'])){
    $act = $_GET['act'];
}

switch ($act) {
    
    case 'profile':
        if (isset($_POST['save'])) {
           
            $userID = $_SESSION['userId'];
            $fullName = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['pass'];
            $gender = $_POST['gender'];
            $phoneNumber = $_POST['soDT'];
            $birthday = $_POST['birthday'];
            $address = $_POST['diaChi'];

            $avatar = $_FILES['avatar']['name'];
            $target = "../view/images/";
            $target_file = $target . $avatar;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $us = $userDAO->getUserByIDUS($userID);
          
            if($_FILES['avatar']['name'] == ''){
                $avatar =  $us->getAvatar();
                $target = "../view/images/";
                $target_file = $target . $avatar;
                move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
                $userDAO->UpdateUser($fullName, $email,$gender, $password, $phoneNumber, $birthday, $address, $avatar, $userID);
                $_SESSION['userId'] = $userID;
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $fullName;
                $_SESSION['avatar'] = $avatar;
                $_SESSION['phone'] = $phoneNumber;
                $_SESSION['address'] = $address;
                header('Refresh: 0.5; ../view/profile.php');
            }elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                echo '<script language="javascript">alert("Định dạng hình avatar không đúng!")</script>';
                header('Refresh: 0.5; ../view/profile.php');
            }else{
                $avatar = $_FILES['avatar']['name'];
                $target = "../view/images/";
                $target_file = $target . $avatar;
                move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
                $userDAO->UpdateUser($fullName, $email,$gender, $password, $phoneNumber, $birthday, $address, $avatar, $userID);
                $_SESSION['userId'] = $userID;
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $fullName;
                $_SESSION['avatar'] = $avatar;
                $_SESSION['phone'] = $phoneNumber;
                $_SESSION['address'] = $address;
                header('Refresh: 0.5; ../view/profile.php');
            }
           
          
        }
        break;
    // Hiển thị comment
    case 'comment':
        if(isset($_POST['gui'])){
            if(isset($_SESSION['userId']) && isset($_SESSION['name'])){
                if(isset($_SESSION['email'])){
                    $email = $_SESSION['email'];
                    $name = $_SESSION['name'];
                }else{
                    $user = "";
                    $name = "";
                }

                if(isset($_POST['userid']) && isset($_POST['idsp']) && isset($_POST['date']) && isset($_POST['content'])){
                    $productID = $_POST['idsp'];
                    $content = $_POST['content'];
                    $userID = $_POST['userid'];
                    $postdate = $_POST['date'];

                    $commentDAO->AddComment($userID,$productID,$postdate,$content);
                    header('location: ../view/detail.php?id='. $productID .'');
                }
            }
        }
        break;
    // Xử lý đăng nhập
     case 'login':
        $error = false;
        if(isset($_POST['email']) || isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $us = $userDAO->getUserByMailAndPassword($email,$password);
           
                if($error !== false || !$us){
                    echo json_encode(array(
                        'status'=> 0,
                        'message' => 'Password nhập không đúng'
                    ));
                    exit;
                }else{
                    echo json_encode(array(
                        'status'=> 1,
                        'message' => 'Đăng Nhập thành công'
                    ));
                    $_SESSION['userId'] = $us->getID();
                    $_SESSION['email'] = $us->getEmail();
                    $_SESSION['name'] = $us->getFullName();
                    $_SESSION['avatar'] = $us->getAvatar();
                    $_SESSION['phone'] = $us->getPhoneNumber();
                    $_SESSION['address'] = $us->getAddress();
                    $_SESSION['levelID'] = $us->getLevelId();
                    exit;
                }
        } else{
                echo json_encode(array(
                    'status'=> 0,
                    'message' => 'Thông tin đăng nhập không đúng'
                ));
              
                exit;
            }
        break;
        
    case 'register':
        $error = false;
            if(isset($_POST['email']) || isset($_POST['name']) || isset($_POST['password']) || isset($_POST['repassword'])){
                $email = $_POST['email'];
                $password = $_POST['password'];
                $fullName = $_POST['name'];
                $repassword = $_POST['repassword'];
                $gender =1;
                $birthday = "1999-01-01";
                $address = "";
                $phoneNumber ="";
                $avatar = "";
                $code = "";
                $levelID = 2;
                    $userDAO->AddUser($fullName,$email,$password,$gender,$birthday,$address,$phoneNumber,$avatar,$levelID,$code);
                    
                    if($error !== false){
                        echo json_encode(array(
                            'status'=> 0,
                            'message' => 'có lỗi khi đăng ký, xin thử lại'
                        ));
                        exit;
                    }else{
                        echo json_encode(array(
                            'status'=> 1,
                            'message' => 'Đăng ký thành công'
                        ));
                      
                        exit;
                    }
            }
              
            break;
    case 'logout':
        session_destroy();
        header('Refresh: 0;  ../view/index.php');
        break;
    case 'check_mail':
        $email = $_GET['email'];
        $query = $userDAO->getUserByMail($email);
        if($query != null){
            echo json_encode(false);
        }else{
            echo json_encode(true);
        }
        break;
    case 'check_mail_login':
        $email = $_GET['email'];
        $query = $userDAO->getUserByMail($email);
        if($query != null){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
        break;
 
        case 'check_code_user':
            $error = false;
            $code = $_POST['code'];
            $email = $_POST['email'];
            $query = $userDAO->getUserByMail($email);
       
            if($query->getcode() != $code){
                echo json_encode(array(
                    'status'=> 0,
                    'message' => 'Mã code bạn nhập sai'
                ));
                exit;
            }else{
                echo json_encode(array(
                    'status'=> 1,
                    'message' => 'Nhập đúng'
                ));
                $_SESSION['code'] = $code;
                $_SESSION['Reset_emailID'] = $email;
                exit;
            }
            break;
        case 'update_password':
            $email = $_SESSION['Reset_emailID'];
            $password = $_POST['password'];
            $query = $userDAO->updateUserPasswordByemail($email, $password);
            if($query == true){
                
                session_destroy();
            }else{
                echo json_encode(array(
                    'status'=> 0,
                    'message' => 'Thay đổi mật khẩu thất bại'
                ));
            }
            break;
}
?>