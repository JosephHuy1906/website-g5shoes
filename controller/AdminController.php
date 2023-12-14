<?php
session_start();
include_once('../Utils/Database.php');
include_once('../model/DAO/UserDAO.php');
include_once('../model/DAO/ProductDAO.php');
include_once('../model/DAO/SizeDAO.php');
include('../model/DAO/CategoryDAO.php');
include('../model/DAO/CommentDAO.php');
include('../model/DAO/FeedbackDAO.php');
include('../model/DAO/notificationDAO.php');
include('../model/DAO/BillDetailsDAO.php');

$productDAO = new ProductDAO();
$userDAO = new UserDAO();
$sizeDAO = new SizeDAO();
$commentDAO = new CommentDAO();
$categoryDAO = new CategoryDAO();
$feedBackDAO = new FeedbackDAO();
$notificationDAO = new notificationDAO();
$BillDetailsDAO = new BillDetailsDAO();

if(isset($_GET['act'])){
    $act = $_GET['act'];
}

switch ($act) {
    // Xóa sản phẩm 
    case 'deleteProduct':
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $productDAO->deleteProduct($id);
            echo '<script language="javascript">alert("Xóa thành công!")</script>';
            header('Refresh: 0; ../view/admin.php');
        }
        break;
    // Thêm sản phẩm
    case 'addProduct':
            $name = $_POST["namePro"];
            $sizeID = $_POST['sizePro'];
            $categoryID = $_POST['category'];
            $newPrice = $_POST['giaMoi'];
            $oldPrice = $_POST['oldprice'];
            $description = $_POST['mota'];
            $target = "../view/images/";

            $avatar1 = $_FILES['img1']['name'];
                $target_file1 = $target . $avatar1;
                move_uploaded_file($_FILES["img1"]["tmp_name"], $target_file1);

            $avatar2 = $_FILES['img2']['name'];
                $target_file2 = $target . $avatar2;
                move_uploaded_file($_FILES["img2"]["tmp_name"], $target_file2);

            $avatar3 = $_FILES['img3']['name'];
                $target_file3 = $target . $avatar3;
                move_uploaded_file($_FILES["img3"]["tmp_name"], $target_file3);

            $avatar4 = $_FILES['img4']['name'];
                $target_file4 = $target . $avatar4;
                move_uploaded_file($_FILES["img4"]["tmp_name"], $target_file4);
            $productDAO->addProduct($name,$categoryID,$sizeID,$avatar1,$avatar2,$avatar3,$avatar4,$oldPrice,$newPrice,$description);
            echo '<script language="javascript">alert("Thêm sản phẩm thành công!")</script>';
            header('Refresh: 0; ../view/admin.php');
        
        break;

    // Show sửa sản phẩm
    case 'showUpdateProduct':
        $id = $_GET['id'];
        $productUpdate = $productDAO->getProductById($id);
        
        break;
    // Sửa sản phẩm
    case 'updateProduct':
            $id = $_POST['productId'];
            $name = $_POST['namePro'];
            $sizeID = $_POST['size'];
            $categoryID = $_POST['brand'];
            $oldPrice = $_POST['priceOld'];
            $newPrice = $_POST['price'];
            $description = $_POST['describe'];
            $target = "../view/images/";
            
            $avatar1 = $_FILES['img1']['name'];
            $target_file = $target . $avatar1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $product = $productDAO->getProductById($id);
            if($categoryID <= 0 && $categoryID > 4){
                echo '<script language="javascript">alert("Danh mục nằm từ 1 đến 4!")</script>';
                header('Refresh: 0; ../view/admin.php'); 
            }elseif($sizeID <= 0 && $sizeID > 4){
                echo '<script language="javascript">alert("Size nằm từ 1 đến 4!")</script>';
                header('Refresh: 0; ../view/admin.php'); 
            }elseif($_FILES['img1']['name'] == ''){
                $avatar1 =  $product->getImg1();         
                $productDAO->updateProduct($name , $categoryID , $sizeID , $avatar1 , $oldPrice , $newPrice , $description, $id);
                echo '<script language="javascript">alert("Sửa thành công!")</script>';
                header('Refresh: 0; ../view/admin.php');    
            }elseif($imageFileType != "jpg" && $imageFileType != "png") {
                echo '<script language="javascript">alert("Định dạng hình avatar không đúng!")</script>';
                header('Refresh: 0.5; ../view/admin.php');
            }else{
                move_uploaded_file($_FILES["img1"]["tmp_name"], $target_file);
                $productDAO->updateProduct($name , $categoryID , $sizeID , $avatar1 , $oldPrice , $newPrice , $description, $id);
                echo '<script language="javascript">alert("Sửa thành công!")</script>';
                header('Refresh: 0; ../view/admin.php'); 
            }
        break;

        case 'updateAdmin':
            $userID = $_SESSION['userId'];
            $fullName = $_POST['fullname'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            if($_FILES['avatar']['name'] == ''){
                $us = $userDAO->getUserByIDUS($userID);
                $avatar =  $us->getAvatar();
                $userDAO->UpdateAdmin($fullName,$password,$avatar,$userID);
                echo '<script language="javascript">alert("Cập nhập thông tin thành công")</script>';
                header('Refresh: 0; ../view/admin.php');  
            }
            else{
                $avatar = $_FILES['avatar']['name'];
                $target = "../view/images/";
                $target_file = $target . $avatar;
                move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
                $userDAO->UpdateAdmin($fullName,$password,$avatar,$userID);
                echo '<script language="javascript">alert("Cập nhập thông tin thành công")</script>';
                header('Refresh: 0; ../view/admin.php');  
            }
            break;

        case 'deleteUser':
                $id = $_GET['id'];
                $userDAO->DeleteUser($id);
                header('Refresh: 0; ../view/admin.php');

            break;
        case 'deleteComment':
            if(isset($_GET['commentID'])){
                $commentID = $_GET['commentID'];
                $commentDAO->DeleteComment($commentID);
                echo '<script language="javascript">alert("Xóa Bình luận thành công!")</script>';
                header('Refresh: 0; ../view/admin.php');
            }
            break;

        case 'deleteCategory':
            if(isset($_GET['id'])){
                $categoryID = $_GET['id'];
                $categoryDAO->DeleteCategory($categoryID);
                echo '<script language="javascript">alert("Xóa danh mục thành công!")</script>';
                header('Refresh: 0; ../view/admin.php');
            }
            break;

        case 'addCategory':
                $nameCategory = $_POST['nameCategory'];
                $categoryDAO->AddCategory($nameCategory);
                echo '<script language="javascript">alert("Thêm danh mục thành công!")</script>';
                header('Refresh: 0; ../view/admin.php');
            break;

        case 'feedback':
            if(isset($_POST['content']) && $_POST['content'] != ''){
                $commentID = $_POST['commentId'];
                $postdate = $_POST['postdate'];
                $userID = $_POST['userid'];
                $content = $_POST['content'];
                $notificationLevel= 1 ;
                $coment =  $commentDAO->getCommentById($commentID);
                $idProduct = $coment->getproductID();

                $feedBackDAO->AddFeedback($userID,$commentID,$postdate,$content);
                $notificationDAO->addNotification($idProduct, $userID, $notificationLevel);
                echo '<script language="javascript">alert("Phản hồi comment thành công!")</script>';
                header('Refresh: 0; ../view/admin.php');
                
            }
            break;
        case 'updateDetail':
            if(isset($_POST['submit'])){
                $detailID = $_POST['detailId'];
                $statusID = $_POST['status-id-input'];
                $BillDetailsDAO->updateDetail($statusID , $detailID);
                echo '<script language="javascript">alert("Thay đổi trạng thái đơn hàng thành công!")</script>';
                header('Refresh: 0; ../view/admin.php');
            }
            break;
}


// Function to validate and move uploaded file
function handleImageUpload($inputName)
{
    $target = "../view/images/";
    $avatar = $_FILES[$inputName]['name'];
    $target_file = $target . $avatar;

    if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $target_file)) {
        return $avatar;
    } else {
        return null;
    }
}
?>