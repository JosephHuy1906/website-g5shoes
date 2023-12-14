
<?php
session_start();
include_once('../Utils/Database.php');
include_once('../model/DAO/UserDAO.php');
include_once('../model/DAO/ProductDAO.php');
include_once('../model/DAO/SizeDAO.php');
include_once('../model/DAO/CategoryDAO.php');
include_once('../model/DAO/CommentDAO.php');
include_once('../model/DAO/FeedbackDAO.php');
include_once('../model/DAO/BillDAO.php');
include_once('../model/DAO/BillDetailsDAO.php');
include_once('../model/DAO/notificationDAO.php');

$notificationDAO = new notificationDAO();
$billDAO = new BillDAO();
$billDetailsDAO = new BillDetailsDAO();
$productDAO = new ProductDAO();
$userDAO = new UserDAO();
$sizeDAO = new SizeDAO();
$commentDAO = new CommentDAO();
$categoryDAO = new CategoryDAO();
$feedBackDAO = new FeedbackDAO();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>G5-Shoes</title>
    <link rel="stylesheet" href="fontawesome-free-6.1.1-web/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="icon" href="./images/logo-chinh.jpg">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/grid.css">
    <link rel="stylesheet" href="./css/header.css"/>
    <link rel="stylesheet" href="./css/sidebar.css"/>    
</head>

<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="grid wide">
                <div class="header__wrapper">
                    <div class="header__actions">
                        <div class="header__actions-menu">
                            <i class="fa-solid fa-bars header__actions-menu-icon"></i>
                            <h3 class="header__actions-menu-title">Menu</h3>
                        </div>
                        <div class="header__actions-search">
                            <button class="header__actions-btn-search">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            </button>
                            <input type="text" class="header__actions-search-input" placeholder="Search">
                            <div class="header__list-search">
                                <h3 class="header__list-search-title">Kết quả tìm kiếm</h3>
                                <div class="header__no-result">
                                    <div class="header__no-result-avatar">
                                        <img src="https://thumbs.dreamstime.com/z/no-found-symbol-unsuccessful-search-vecotr-upset-magnifying-glass-cute-not-zoom-icon-suitable-results-oops-page-failure-122786031.jpg" alt="" class="header__no-result-img">
                                    </div>
                                    <h3 class="header__list-search-no-result">Không thấy kết quả tìm kiếm của bạn</h3>
                                </div>
                                <ul class="header__list-search-ul"></ul>
                                
                            </div>
                        </div>
                    </div>
                    <!-- header logo -->
                    <a href="./index.php" class="header__logo">
                        <img src="./images/logo-chinh.jpg" alt="" class="header__logo-img">
                    </a>
                    <!-- header actions information-->
                    <div class="header__information">
                        <ul class="header__information-list">
                            <li class="header__information-item">
                                <?php
                                    if(isset($_SESSION['name'])){
                                        echo '<a href="./profile.php" class="header__information-link">
                                        <i class="fa-regular fa-user"></i>
                                    </a>';
                                    }else{
                                        echo '<a href="./login_regin.php" class="header__information-link">
                                        <i class="fa-regular fa-user"></i>
                                    </a>';
                                    }
                                ?>
                                
                            </li>
                            <li class="header__information-item">
                                <div class="header__information-link ting">
                                    <i class="fa-regular fa-bell"></i>
                                    <span class="header__information-count-information">
                                        <?php 
                                                if(isset($_SESSION['userId'])){
                                                     $idUser = $_SESSION['userId'];
                                                     $notification = $notificationDAO->getNotificationByUser($idUser);
                                                     if($notification == true){
                                                        echo count( $notification );
                                                     }else{
                                                        echo '0';
                                                    }
                                                }else{
                                                    echo '0';
                                                }
                                        ?>
                                    </span>
                                    <div class="header__notification">
                                        <h3 class="header__notification-title">Thông báo</h3>
                                        <ul class="header__notification-list">
                                            <?php
                                                if(isset($_SESSION['userId']))
                                                {
                                                    $idUser = $_SESSION['userId'];
                                                
                                                    $notification = $notificationDAO->getNotificationByUser($idUser);
                                                    if($notification == true){
                                                    foreach($notification as $noti){
   
                                                    if($noti->geNotificationLevel() == 2){
                                                       $id = $noti->getNotificationProductID();
                                                        $product = $productDAO->getProductById($id);
                                                    
                                            ?>
                                                    <li class="header__notification-item">
                                                        <a href="./profile.php" class="header__notification-link">
                                                            <div class="header__notification-avatar">
                                                                <img src="<?php echo $product->getAvatar1(); ?>" alt="" class="header__notification-img">
                                                            </div>
                                                            <div class="header__notification-info">
                                                                <h3 class="header__notification-info-title">Bạn đã đặt thành công đơn hàng <span><?php echo $product->getName();?></span></h3>
                                                                <p class="header__notification-info-desc"><?php echo $noti->geNotificationDateCreate();?></p>
                                                            </div>
                                                            <form action="../controller/notificationController.php">
                                                               <button type="submit">
                                                                    <div class="header__notification-remove">
                                                                        <input type="hidden" name="idNotification"  value="<?php echo $noti->getNotificationId();?>">
                                                                        <i class="fa-regular fa-trash-can"></i>
                                                                    </div>
                                                               </button>
                                                            </form>
                                                                
                                                               
                                                            
                                                        </a>
                                                    </li>
                                                    <?php }elseif($noti->geNotificationLevel() == 1){ 
                                                        
                                                    ?>
                                                    <li class="header__notification-item">
                                                        <a href="<?php echo './detail.php?id='.$noti->getNotificationProductID() ?>" class="header__notification-link">
                                                            <div class="header__notification-avatar-user">
                                                                <img src="./images/logo-chinh.jpg" alt="" class="header__notification-user-img">
                                                            </div>
                                                            <div class="header__notification-info">
                                                                <h3 class="header__notification-info-title-user">
                                                                    <span class="header__notification-comment-user">G5 Shoes</span> 
                                                                    đã nhắc đến bạn trong một bình luận
                                                                </h3>
                                                                <p class="header__notification-info-desc"><?php echo $noti->geNotificationDateCreate();?></p>
                                                            </div>
                                                            <div class="header__notification-remove">
                                                                <i class="fa-regular fa-trash-can"></i>
                                                            </div>
                                                        </a>
                                                    </li>
                                            <?php }} }}?>
                                        </ul>
                                    </div>
                                </div>
                            </li>
             
                            <li class="header__information-item">
                                <div class="header__information-link cart">
                                    <svg viewBox="0 0 26.6 25.6" class="header__information-link-cart">
                                        <polyline fill="none" points="2 1.7 5.5 1.7 9.6 18.3 21.2 18.3 24.6 6.1 7 6.1"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                            stroke-width="2.5"></polyline>
                                        <circle cx="10.7" cy="23" r="2.2" stroke="none"></circle>
                                        <circle cx="19.7" cy="23" r="2.2" stroke="none"></circle>
                                    </svg>
                                    <span class="header__information-count-cart">2</span>
                                    <div class="header__cart">
                                        <h3 class="header__cart-title">Giỏ hàng</h3>
                                        <ul class="header__cart-list">
                
                                        </ul>
                                        <div class="header__cart-link-box">
                                            <a href="./cart.php" class="header__cart-link-navigation">Xem giỏ hàng</a>
                                        </div>
                                    </div> 
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
               
            </div>

            <?php 
                $listData = $productDAO->getAllProduct();
                foreach($listData as $data) {
            ?>
                <div class="data-parent" hidden>
                    <div class="data-id"><?php echo $data->getID(); ?></div>
                    <div class="data-name"><?php echo $data->getName(); ?></div>
                    <div class="data-size"><?php echo $data->getSizeID(); ?></div>
                    <div class="data-price"><?php echo $data->getNewPrice(); ?></div>
                    <div class="data-img"><?php echo $data->getAvatar1(); ?></div>
                </div>
            <?php } ?>

        </header>
        <!-- end Header -->