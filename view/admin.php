<?php
session_start();
include_once('../Utils/Database.php');
include_once('../model/DAO/UserDAO.php');
include_once('../model/DAO/ProductDAO.php');
include_once('../model/DAO/SizeDAO.php');
include('../model/DAO/CategoryDAO.php');
include('../model/DAO/CommentDAO.php');
include('../model/DAO/LevelDAO.php');
include('../model/DAO/BillDAO.php');
include('../model/DAO/BillDetailsDAO.php');
include('../model/DAO/StatusDAO.php');

$productDAO = new ProductDAO();
$userDAO = new UserDAO();
$sizeDAO = new SizeDAO();
$commentDAO = new CommentDAO();
$categoryDAO = new CategoryDAO();
$LevelDAO = new LevelDAO();
$BillDAO = new BillDAO();
$BillDetailsDAO = new BillDetailsDAO();
$StatusDAO = new StatusDAO();
if (!(isset($_SESSION['name']))) {
    header('Refresh: 0; ./index.php');
} elseif ($_SESSION['levelID'] != 1) {
    header('Refresh: 0; ./index.php');
} else {


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@200;300;400;500;600;700&family=Poppins:ital,wght@0,200;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./fontawesome-free-6.1.1-web/css/all.css">
        <link rel="stylesheet" type="text/css" href="./css/globalStyle.css">
        <link rel="icon" href="./images/logo-chinh.jpg">
    </head>

    <body>
        <div id="root">
            <header class="header">
                <h2 class="header__logo">G5 Shoes Admin</h2>
                <div class="header__admin">
                    <h3 class="header__admin-title">Hello admin, <?php echo $_SESSION['name']; ?></h3>
                    <div class="header__admin-avatar">
                        <img src="./images/<?php echo $_SESSION['avatar']; ?>" class="header__admin-img" />
                    </div>

                    <div class="header__tippy">
                        <ul class="header__tippy-list">
                            <li class="header__tippy-item">
                                <a href="../" class="header__tippy-link">
                                    <span class="header__icon">
                                        <i class="fa-solid fa-house header__icon"></i>
                                    </span>
                                    <span class="header__tippy-title">Home</span>
                                </a>
                            </li>
                            <li class="header__tippy-item js-btn-modal">
                                <span href="#" class="header__tippy-link">
                                    <span class="header__icon">
                                        <i class="fa-solid fa-id-badge header__icon"></i>
                                    </span>
                                    <span class="header__tippy-title">Edit Profile</span>
                                </span>
                            </li>
                            <li class="header__tippy-item">
                                <a href="../controller/UserController.php?act=logout" class="header__tippy-link">
                                    <span class="header__icon">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    </span>
                                    <span class="header__tippy-title">Log out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            <div class="main">
                <div class="sidebar">
                    <h2 class="sidebar__title">Category</h2>
                    <ul class="category__list">
                        <li class="category__item active">
                            <p class="category__content">
                                <i class="fa-brands fa-product-hunt category__icon"></i>
                                <span class="category__text">Manage Product</span>
                            </p>
                        </li>
                        <li class="category__item">
                            <p class="category__content">
                                <i class="fa-solid fa-message category__icon"></i>
                                <span class="category__text">Manage Comment</span>
                            </p>
                        </li>
                        <li class="category__item">
                            <p class="category__content">
                                <i class="fa-solid fa-user-group category__icon"></i>
                                <span class="category__text">Manage Account</span>
                            </p>
                        </li>
                        <li class="category__item">
                            <p class="category__content">
                                <i class="fa-solid fa-sitemap category__icon"></i>
                                <span class="category__text">Manage Category</span>
                            </p>
                        </li>
                        <li class="category__item">
                            <p class="category__content">
                                <i class="fa-solid fa-wallet category__icon"></i>
                                <span class="category__text">Manage Bill Product</span>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="content">
                    <div class="manage-product js-tab-content active">
                        <nav class="content__nav">
                            <ul class="content__nav-list">

                                <li class="content__nav-item active">
                                    <p class="category__content">
                                        <i class="fa-solid fa-square-plus category__icon"></i>
                                        <span class="category__text">Add Product</span>
                                    </p>
                                </li>
                                <li class="content__nav-item">
                                    <p class="category__content">
                                        <i class="fa-solid fa-file-pen category__icon"></i>
                                        <span class="category__text">Edit Product</span>
                                    </p>
                                </li>
                            </ul>

                            <div class="nav__line"></div>
                        </nav>
                        <div class="manage-content">



                            <div class="manage-content-tab active">
                                <h1 class="manage-content__title">Manage Add Product</h1>
                                <div class="manage-content__wrapper">
                                    <form id="form-add-product" action="../controller/AdminController.php?act=addProduct" method="post" enctype="multipart/form-data">
                                        <div class="form-box">
                                            <div class="manage-content__box-left">
                                                <div class="form-group">
                                                    <label class="form-group__title">Name Product</label>
                                                    <input type="text" name="namePro" id="namePro" class="form-group__input" placeholder="Ex: Nike Air" />
                                                    <span class="form-group__error"></span>
                                                </div>
                                                <div class="form-group mt-40">
                                                    <label class="form-group__title">Price Product</label>
                                                    <input type="number" name="giaMoi" class="form-group__input isPrice" placeholder="Ex: 700000" />
                                                    <span class="form-group__error"></span>
                                                </div>
                                                <div class="form-group mt-40">
                                                    <label class="form-group__title">Size Product</label>
                                                    <select name="sizePro" class="form-group__input">
                                                        <?php
                                                        $size = $sizeDAO->getAllSize();
                                                        foreach ($size as $sz) {
                                                        ?>
                                                            <option value="<?php echo $sz->getSizeID() ?>"><?php echo $sz->getSize() ?></option>

                                                        <?php } ?>

                                                    </select>
                                                    <span class="form-group__error"></span>
                                                </div>

                                                <div class="form-group mt-40">
                                                    <label class="form-group__title ">Image 1 Product</label>
                                                    <label for="#upload" class="file-upload">
                                                        <i class="fa-solid fa-image"></i>
                                                        Upload Image
                                                    </label>
                                                    <input id="upload" type="file" name="img1" class="form-group__input input-file" placeholder="Ex: Nike Cortez SP">
                                                    <span class="form-group__error"></span>
                                                </div>

                                                <div class="form-group mt-40">
                                                    <label class="form-group__title ">Image 2 Product</label>
                                                    <label for="#upload" class="file-upload">
                                                        <i class="fa-solid fa-image"></i>
                                                        Upload Image
                                                    </label>
                                                    <input id="upload" type="file" name="img2" class="form-group__input input-file" placeholder="Ex: Nike Cortez SP">
                                                    <span class="form-group__error"></span>
                                                </div>

                                            </div>

                                            <div class="manage-content__box-right">
                                                <div class="form-group">
                                                    <label class="form-group__title">Category Product</label>
                                                    <select name="category" class="form-group__input">
                                                        <?php
                                                        $category = $categoryDAO->getAllCategory();
                                                        foreach ($category as $cate) {
                                                        ?>
                                                            <option value="<?php echo $cate->getCategoryID() ?>"><?php echo $cate->getCategory() ?></option>

                                                        <?php } ?>
                                                    </select>
                                                    <span class="form-group__error"></span>
                                                </div>


                                                <div class="form-group  mt-40">
                                                    <label class="form-group__title ">Image 3 Product</label>
                                                    <label for="#upload" class="file-upload">
                                                        <i class="fa-solid fa-image"></i>
                                                        Upload Image
                                                    </label>
                                                    <input id="upload" type="file" name="img3" class="form-group__input input-file" placeholder="Ex: Nike Cortez SP">
                                                    <span class="form-group__error"></span>
                                                </div>

                                                <div class="form-group mt-40">
                                                    <label class="form-group__title ">Image 4 Product</label>
                                                    <label for="#upload" class="file-upload">
                                                        <i class="fa-solid fa-image"></i>
                                                        Upload Image
                                                    </label>
                                                    <input id="upload" type="file" name="img4" class="form-group__input input-file" placeholder="Ex: Nike Cortez SP">
                                                    <span class="form-group__error"></span>
                                                </div>

                                                <div class="form-group mt-40">
                                                    <label class="form-group__title">Old Price</label>
                                                    <input type="number" name="oldprice" class="form-group__input" placeholder="Ex: 1562000">
                                                    <span class="form-group__error"></span>
                                                </div>

                                                <div class="form-group mt-40">
                                                    <label class="form-group__title">Describe</label>
                                                    <input type="text" name="mota" class="form-group__input" placeholder="Ex: Với chất liệu 100% Poly được xử lý hoàn thiện..." />
                                                    <span class="form-group__error"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-footer">
                                            <button type="submit" name="submit" class="btn-submit">Add Product</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="manage-content-tab">
                                <h1 class="manage-content__title">Manage Edit Product</h1>
                                <div class="content-tab-edit">
                                    <table class="table table-border">
                                        <thead>
                                            <tr>
                                                <th class="table__product-id">ID</th>
                                                <th class="table__product-name">Name Product</th>
                                                <th class="table__product-image">Image Product</th>
                                                <th class="table__product-price">Price Product</th>
                                                <th class="table__product-price">Price Old Product</th>
                                                <th class="table__product-brand">Category Product</th>
                                                <th class="table__product-describe">Describe Product</th>
                                                <th class="table__product-location">Size</th>
                                                <th class="table__product-edit">Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $productNews = $productDAO->getAllProduct();
                                            foreach ($productNews as $productNew) {

                                            ?>
                                                <tr class="product-items">
                                                    <td>
                                                        <span class='table__tbody-id'><?php echo $productNew->getID(); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class='table__tbody-name'><?php echo $productNew->getName(); ?></span>
                                                    </td>
                                                    <td>
                                                        <div class='table__tbody-img'>

                                                            <img width="150px" src="<?php echo $productNew->getAvatar1(); ?>" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class='table__tbody-price'><?php echo $productNew->getNewPrice(); ?>đ</span>
                                                    </td>
                                                    <td>
                                                        <span class='table__tbody-price'><?php if ($productNew->getOldPrice() != 0) {
                                                                                                echo $productNew->getOldPrice() . 'đ';
                                                                                            } ?></span>
                                                    </td>
                                                    <td>
                                                        <span class='table__tbody-brand'>
                                                            <?php
                                                            $id = $productNew->getCategoryID();
                                                            $category = $categoryDAO->getCategoryById($id);
                                                            echo $category->getcategory();
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class='table__tbody-describe'><?php echo $productNew->getDescription(); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class='table__tbody-location'>
                                                            <?php
                                                            $id = $productNew->getSizeID();
                                                            $size = $sizeDAO->getSizeById($id);
                                                            echo $size->getSize();
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $id = $productNew->getID();
                                                        $dellink = "./controller/AdminController.php?act=deleteProduct&id=" . $id;
                                                        ?>
                                                        <a class='table__tbody-link edit-each-product' href='#'>Sửa</a>
                                                        <a class='table__tbody-link' href='.<?php echo $dellink; ?>.' onclick="return delete_Product();">Xoá</a>
                                                    </td>
                                                    <td class='table__td-modal'>
                                                        <div class="modal__edit-product">
                                                            <div class="modal__edit-overlay"></div>
                                                            <div class="modal__edit-auth">
                                                                <div class="modal__edit-product-close">
                                                                    <i class="fa-solid fa-circle-xmark modal__edit-product-close-icon"></i>
                                                                </div>
                                                                <h2 class="modal__edit-auth-title">Edit Product Method > ID: <?php echo $productNew->getID(); ?></h2>
                                                                <div class="modal__edit-wrapper-img">
                                                                    <div class="modal__edit-avatar">
                                                                        <img src="<?php echo $productNew->getAvatar1(); ?>" alt="Image Preview" class="modal__edit-img" id="imagePreview" />
                                                                    </div>
                                                                </div>
                                                                <form action="../controller/AdminController.php?act=updateProduct" method="post" enctype="multipart/form-data" class="form__edit-product">
                                                                    <div class="form-group-edit">
                                                                        <label class="form-group-edit-label">Name Product</label>
                                                                        <div class="form-group-content">
                                                                            <input type="hidden" name="productId" value="<?php echo $productNew->getID(); ?>" />
                                                                            <input type="text" class="form-group-edit-input" name="namePro" value="<?php echo $productNew->getName(); ?>" />
                                                                            <div class="form-group-edit-btn-edit">
                                                                                <i class="fa-regular fa-pen-to-square form-group-edit-btn-edit-icon"></i>
                                                                            </div>
                                                                            <span class="form-group-edit-error"></span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group-edit">
                                                                        <label class="form-group-edit-label">Price Product</label>
                                                                        <div class="form-group-content">
                                                                            <input type="number" class="form-group-edit-input" name="price" value="<?php echo $productNew->getNewPrice(); ?>" />
                                                                            <div class="form-group-edit-btn-edit">
                                                                                <i class="fa-regular fa-pen-to-square form-group-edit-btn-edit-icon"></i>
                                                                            </div>
                                                                            <span class="form-group-edit-error"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group-edit">
                                                                        <label class="form-group-edit-label">Price Old Product</label>
                                                                        <div class="form-group-content">
                                                                            <input type="number" class="form-group-edit-input" name="priceOld" value="<?php echo $productNew->getOldPrice(); ?>" />
                                                                            <div class="form-group-edit-btn-edit">
                                                                                <i class="fa-regular fa-pen-to-square form-group-edit-btn-edit-icon"></i>
                                                                            </div>
                                                                            <span class="form-group-edit-error"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group-edit">
                                                                        <label class="form-group-edit-label">Category Product</label>
                                                                        <div class="form-group-content">
                                                                            <input type="number" class="form-group-edit-input" name="brand" value="<?php echo $productNew->getCategoryID(); ?>" />

                                                                            <div class="form-group-edit-btn-edit">
                                                                                <i class="fa-regular fa-pen-to-square form-group-edit-btn-edit-icon"></i>
                                                                            </div>
                                                                            <span class="form-group-edit-error"></span>
                                                                            <span class="form-group-edit-error"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group-edit ">
                                                                        <label class="form-group-edit-label">Describe Product</label>
                                                                        <div class="form-group-content">
                                                                            <input type="text" name="describe" class="form-group-edit-input" value="<?php echo $productNew->getDescription(); ?>" />
                                                                            <div class="form-group-edit-btn-edit">
                                                                                <i class="fa-regular fa-pen-to-square form-group-edit-btn-edit-icon"></i>
                                                                            </div>
                                                                            <span class="form-group-edit-error"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group-edit">
                                                                        <label class="form-group-edit-label">Size Product</label>
                                                                        <div class="form-group-content">
                                                                            <input type="number" class="form-group-edit-input" name="size" value="<?php echo $productNew->getSizeID(); ?>" />
                                                                            <div class="form-group-edit-btn-edit">
                                                                                <i class="fa-regular fa-pen-to-square form-group-edit-btn-edit-icon"></i>
                                                                            </div>
                                                                            <span class="form-group-edit-error"></span>
                                                                            <span class="form-group-edit-error"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group-edit">
                                                                        <label class="form-group-edit-label">Image Product</label>
                                                                        <div class="form-group-content">
                                                                            <input value="<?php echo $productNew->getAvatar1(); ?>" name="img1" type="file" class="form-group-edit-input-file edit-input-file" id="imageInput" />
                                                                            <span class="form-group-edit-error"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group-actions">
                                                                        <button class="form-group-actions-btn cancel">Cancel</button>
                                                                        <button type="submit" class="form-group-actions-btn submit">Save Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- content manage product -->
                    </div>
                    <div class="js-tab-content">
                        <nav class="content__nav">
                            <ul class="content__nav-list">
                                <li class="content__nav-comment-item active">
                                    <p class="category__content">
                                        <i class="fa-solid fa-border-all category__icon"></i>
                                        <span class="category__text">All Comment</span>
                                    </p>
                                </li>
                                <li class="content__nav-comment-item">
                                    <p class="category__content">
                                        <i class="fa-solid fa-comment category__icon"></i>
                                        <span class="category__text">Feedback Comment</span>
                                    </p>
                                </li>
                            </ul>

                            <div class="nav__line-comment"></div>
                        </nav>
                        <div class="manage-content">
                            <div class="manage-content-comment-tab active">
                                <h1 class="manage-content__title">Manage All Comment</h1>
                                <div class="comment-all__wrapper">
                                    <div class="scroll-comment">
                                        <div class="comment-all__box">
                                            <?php
                                            $commet = $commentDAO->getAllComment();
                                            foreach ($commet as $com) {
                                            ?>
                                                <div class="comment-all__content">
                                                    <div class="comment-all__content-index"><?php echo $com->getcommentID(); ?></div>
                                                    <div class="comment-all__content-info">
                                                        <div class="comment-all__content-info-avatar">
                                                            <img src="./images/<?php $id = $com->getuserID();
                                                                                $us = $userDAO->getUserByID($id);
                                                                                echo $us->getAvatar(); ?>" alt="" class="comment-all__content-info-img">
                                                        </div>
                                                        <div class="comment-all__content-info-text">
                                                            <h3 class="comment-all__content-info-name"><?php $id = $com->getuserID();
                                                                                                        $us = $userDAO->getUserByID($id);
                                                                                                        echo $us->getFullName(); ?></h3>
                                                            <p class="comment-all__content-info-time"><?php echo $com->getpostdate(); ?></p>
                                                            <p class="comment-all__content-info-content-comment"><?php echo $com->getcontent(); ?></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $commentID = $com->getcommentID();

                                                    ?>
                                                    <!-- actions remove -->
                                                    <div class="comment-all__actions">
                                                        <a href="../controller/AdminController.php?act=deleteComment&commentID=<?php echo $commentID; ?>"> <button class="comment-all__actions-btn" onclick="return delete_Comment();">Xoá</button></a>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="manage-content-comment-tab">
                                <h1 class="manage-content__title">Manage Feedback Comment User</h1>
                                <?php
                                $commet = $commentDAO->getAllComment();
                                foreach ($commet as $com) {
                                ?>
                                    <div class="feedback-wrapper">
                                        <div class="feedback-wrapper-content">
                                            <div class="feedback-wrapper-content-info-user">
                                                <div class="feedback-wrapper-content-avatar">
                                                    <img src="./images/<?php $id = $com->getuserID();
                                                                        $us = $userDAO->getUserByID($id);
                                                                        echo $us->getAvatar(); ?>" alt="" class="feedback-wrapper-content-img">
                                                </div>
                                                <div class="feedback-wrapper-content-text">
                                                    <h3 class="feedback-wrapper-content-name"><?php $id = $com->getuserID();
                                                                                                $us = $userDAO->getUserByID($id);
                                                                                                echo $us->getFullName(); ?></h3>
                                                    <p class="feedback-wrapper-content-text-content"><?php echo $com->getcontent(); ?></p>
                                                </div>
                                            </div>
                                            <!-- feedback -->
                                            <div class="wrapper-box-feedback">
                                                <div class="wrapper-actions">
                                                    <p class="feedback-wrapper-content-actions">
                                                        <span class="feedback-wrapper-content-actions-text">Phản hồi</span>
                                                        <i class="fa-solid fa-angle-down feedback-wrapper-content-actions-icon active"></i>
                                                        <i class="fa-solid fa-angle-up feedback-wrapper-content-actions-icon"></i>
                                                    </p>
                                                    <button class="wrapper-actions-remove" onclick="return delete_Comment();">Xoá</button>
                                                </div>
                                                <!-- phải đặt id: khác nhau để ko bị warning gg: lấy id của bình luận trong database, vd: form-feedback-id{id database = 1}-->
                                                <form action="../controller/AdminController.php?act=feedback" method="post" class="form-feedback">
                                                    <input type="hidden" name="commentId" value=" <?php echo $com->getcommentID(); ?>" />
                                                    <input type="hidden" name="postdate" value=" <?php echo date("d/m/Y"); ?>" />
                                                    <input type="hidden" name="userid" value=" <?php echo $com->getuserID(); ?>" />
                                                    <textarea class="form-feedback-text" name="content" placeholder="Viết lời muốn phải hồi tại đây..."></textarea>
                                                    <p class="form-feedback-message">
                                                        <i class="fa-solid fa-triangle-exclamation form-feedback-icon"></i>
                                                        <span class="form-feedback-error"></span>
                                                    </p>
                                                    <div class="btn-wrapper-feedback">
                                                        <button type="submit" class="send-feedback">Gửi</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="js-tab-content">
                        <nav class="content__nav">
                            <ul class="content__nav-list">
                                <li class="content__nav-account-item active">
                                    <p class="category__content">
                                        <i class="fa-solid fa-file-lines category__icon"></i>
                                        <span class="category__text">User Account</span>
                                    </p>
                                </li>
                                <li class="content__nav-account-item">
                                    <p class="category__content">
                                        <i class="fa-solid fa-file-lines category__icon"></i>
                                        <span class="category__text">Member Admin</span>
                                    </p>
                                </li>
                            </ul>

                            <div class="nav__line-account"></div>
                        </nav>
                        <div class="manage-content">
                            <div class="manage-content-account-tab active">
                                <h1 class="manage-content__title">Manage User</h1>
                                <div class="user-wrapper">
                                    <div class="user-box">
                                        <table class="table-user">
                                            <thead class="thead-user">
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Birthday</th>
                                                <th>Phone</th>
                                                <th>Actions</th>
                                            </thead>

                                            <tbody class="tbody-user">

                                                <?php

                                                $query = $userDAO->getAllUsers();

                                                foreach ($query as $row) {

                                                ?>
                                                    <tr class="tbody-row">
                                                        <td>
                                                            <span><?php echo $row->getID(); ?></span>
                                                        </td>
                                                        <td class="col-user-info">
                                                            <div class="user-avatar">
                                                                <img src="./images/<?php echo $row->getAvatar(); ?>" alt="" class="user-img">
                                                            </div>
                                                            <h3 class="user-name"><?php echo $row->getFullName(); ?></h3>
                                                        </td>

                                                        <td>
                                                            <span><?php echo $row->getEmail(); ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $row->getAddress(); ?></span>
                                                        </td>

                                                        <td>
                                                            <span><?php echo $row->getBirthday(); ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $row->getPhoneNumber(); ?></span>
                                                        </td>
                                                        <?php
                                                        $userid = $row->getID();

                                                        ?>
                                                        <td>
                                                            <a href="../controller/AdminController.php?act=deleteUser&id=<?php echo $userid; ?>"> <button class="action-btn-remove" onclick="return delete_User();">Xoá</button></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="manage-content-account-tab">
                                <h1 class="manage-content__title">All Member Admin</h1>
                                <div class="user-wrapper">
                                    <div class="user-box">
                                        <table class="table-user">
                                            <thead class="thead-user">
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Decentralization</th>
                                                <th>Mission</th>
                                            </thead>

                                            <tbody class="tbody-user">
                                                <?php
                                                $admin = $userDAO->getAllUsersAdmin();
                                                foreach ($admin as $row) {
                                                ?>
                                                    <tr class="tbody-row">
                                                        <td>
                                                            <span><?php echo $row->getID(); ?></span>
                                                        </td>
                                                        <td class="col-user-info">
                                                            <div class="user-avatar">
                                                                <img src="./images/<?php echo $row->getAvatar(); ?>" alt="" class="user-img">
                                                            </div>
                                                            <h3 class="user-name"><?php echo $row->getFullName(); ?></h3>
                                                        </td>

                                                        <td>
                                                            <span><?php echo $row->getEmail(); ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php $levelID = $row->getLevelId();
                                                                    $qr = $LevelDAO->getlevelById($levelID);
                                                                    echo $qr->getRole(); ?></span>
                                                        </td>

                                                        <td>
                                                            <span>Quản lý trang</span>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="js-tab-content">
                        <nav class="content__nav">
                            <ul class="content__nav-list">
                                <li class="content__nav-category-item active">
                                    <p class="category__content">
                                        <i class="fa-solid fa-file-lines category__icon"></i>
                                        <span class="category__text">Add Category</span>
                                    </p>
                                </li>
                                <li class="content__nav-category-item">
                                    <p class="category__content">
                                        <i class="fa-solid fa-file-lines category__icon"></i>
                                        <span class="category__text">All Category</span>
                                    </p>
                                </li>
                            </ul>

                            <div class="nav__line-category"></div>
                        </nav>
                        <div class="manage-content">
                            <div class="manage-content-category-tab active">
                                <h1 class="manage-content__title">Add Category</h1>
                                <div class="manage-content__wrapper">
                                    <form id="form-add-product" action="../controller/AdminController.php?act=addCategory" method="post" enctype="multipart/form-data">
                                        <div class="form-box">
                                            <div class="manage-content__box-left">
                                                <div class="form-group">
                                                    <label class="form-group__title">Id Category</label><br>
                                                    <p>AUTO INCREMENT</p>
                                                    <span class="form-group__error"></span>
                                                </div>
                                            </div>
                                            <div class="manage-content__box-right">
                                                <div class="form-group">
                                                    <label class="form-group__title">Name Category</label>
                                                    <input type="text" name="nameCategory" class="form-group__input" placeholder="Ex: Nike Air" required>
                                                    <span class="form-group__error"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-footer">
                                            <button type="submit" name="submit" class="btn-submit">Add Category</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="manage-content-category-tab">
                                <h1 class="manage-content__title">Manage Edit Product</h1>
                                <div class="content-tab-edit">
                                    <table class="table table-border">
                                        <thead>
                                            <tr>
                                                <th class="table__product-id">ID</th>
                                                <th class="table__product-name">Name Category</th>
                                                <th class="table__product-edit">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $category = $categoryDAO->getAllCategory();
                                            foreach ($category as $categorys) {

                                            ?>
                                                <tr class="">
                                                    <td>
                                                        <span class='table__tbody-id'><?php echo $categorys->getcategoryID(); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class='table__tbody-name'><?php echo $categorys->getcategory(); ?></span>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $id = $categorys->getcategoryID();
                                                        $dellink = "./controller/AdminController.php?act=deleteCategory&id=" . $id;
                                                        ?>
                                                        <a class='table__tbody-link' href='.<?php echo $dellink; ?>.' onclick="return delete_Category();">Xoá</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="js-tab-content">
                        <nav class="content__nav">
                            <ul class="content__nav-list">
                                <li class="content__nav-bill-item active">
                                    <p class="category__content">
                                        <i class="fa-solid fa-file-lines category__icon"></i>
                                        <span class="category__text">All Bill</span>
                                    </p>
                                </li>
                            </ul>

                            <div class="nav__line-bill"></div>
                        </nav>
                        <div class="manage-content">
                            <div class="manage-content-bill-tab active">
                                <h1 class="manage-content__title">Manage All Bill</h1>
                                <div class="comment-all__wrapper">
                                    <div class="scroll-comment">
                                        <div class="comment-all__box">
                                            <?php
                                            $detail = $BillDetailsDAO->getAllBillDetails();
                                            $bill = $BillDAO->getAllBill();
                                            foreach ($bill as $bills) {
                                                //    foreach($detail as $details){
                                            ?>
                                                <div class="comment-all__content js-tab-bill">
                                                    <div class="comment-all__content-index"><?php echo $bills->getBillID(); ?></div>
                                                    <div class="comment-all__content-info bill">
                                                        <div class="comment-all__content-info-avatar">
                                                            <img src="./images/<?php
                                                                                $Userid = $bills->getUserIDFromBill();
                                                                                $user = $userDAO->getUserByID($Userid);
                                                                                echo $user->getAvatar();
                                                                                ?>" alt="" class="comment-all__content-info-img">
                                                        </div>
                                                        <div class="comment-all__content-info-text bill">
                                                            <h3 class="comment-all__content-info-name">
                                                                <?php

                                                                echo $user->getFullName();
                                                                ?>
                                                            </h3>
                                                            <p class="comment-all__content-info-time"></p>
                                                            <div class="bill__content">
                                                                <div class="bill__content-line">
                                                                    <h3 class="bill__content-line-one-title">
                                                                        <span class="bill__content-line-one-text">Bill id: </span>
                                                                        <span class="bill__content-line-one-text">
                                                                            <?php
                                                                            echo $bills->getBillID();
                                                                            ?>
                                                                        </span>
                                                                    </h3>
                                                                    <h3 class="bill__content-line-one-title">
                                                                        <span class="bill__content-line-one-text">User id: </span>
                                                                        <span class="bill__content-line-one-text">
                                                                            <?php
                                                                            echo $user->getID();
                                                                            ?>
                                                                        </span>
                                                                    </h3>
                                                                    <h3 class="bill__content-line-one-title">
                                                                        <span class="bill__content-line-one-text">Phone number: </span>
                                                                        <span class="bill__content-line-one-text">
                                                                            <?php
                                                                            echo $user->getPhoneNumber();
                                                                            ?>
                                                                        </span>
                                                                    </h3>


                                                                    <h3 class="bill__content-line-one-title">
                                                                        <span class="bill__content-line-one-text">Purchase Date: </span>
                                                                        <span class="bill__content-line-one-text">
                                                                            <?php
                                                                            echo $bills->getDateCreate();
                                                                            ?>
                                                                        </span>
                                                                    </h3>
                                                                </div>
                                                                <div class="bill__content-line">

                                                                    <h3 class="bill__content-line-one-title ml0">
                                                                        <span class="bill__content-line-one-text">Total Bill: </span>
                                                                        <span class="bill__content-line-one-text">
                                                                            <?php
                                                                            echo $bills->getTotalFromBill();
                                                                            ?>đ
                                                                        </span>
                                                                    </h3>
                                                                    <h3 class="bill__content-line-one-title ml0">
                                                                        <span class="bill__content-line-one-text">Address Bill: </span>
                                                                        <span class="bill__content-line-one-text">
                                                                            <?php
                                                                            echo $bills->getAddressIDFromBill();
                                                                            ?>
                                                                        </span>
                                                                    </h3>

                                                                </div>

                                                            </div>

                                                            <div class="form__bill-chitiet">
                                                                <?php
                                                                $billID = $bills->getBillID();
                                                                $querybillDetail = $BillDetailsDAO->getBillDetailByBillIdAll($billID);
                                                                foreach ($querybillDetail as $querybillDetails) {
                                                                    $productID = $querybillDetails->getProductIDFromBillDetail();
                                                                    $product = $productDAO->getProductById($productID);
                                                                ?>
                                                                    <div class="bill_chitiet">
                                                                        <img src="<?php echo $product->getAvatar1(); ?>" alt="">
                                                                        <div class="Bill_chitiets">
                                                                            <h4><?php echo $product->getName(); ?></h4>
                                                                            <div class="chitiets_nameProduct">

                                                                                <p>Giá: <?php echo $product->getNewPrice(); ?>đ</p>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                <?php } ?>

                                                            </div>

                                                            <div class="form__bill-wrapper">
                                                                <form action="../controller/AdminController.php?act=updateDetail" method="post" class="form__bill">
                                                                    <input type="hidden" value="<?php echo $bills->getBillID(); ?>" name="detailId">
                                                                    <input type="hidden" value="2" name="status-id-input">
                                                                    <button type="submit" name="submit" class="form__bill-btn confirmed">Đã xác nhận</button>
                                                                </form>
                                                                <form action="../controller/AdminController.php?act=updateDetail" method="post" class="form__bill">
                                                                    <input type="hidden" value="<?php echo $bills->getBillID(); ?>" name="detailId">
                                                                    <input type="text" value="3" name="status-id-input" hidden>
                                                                    <button type="submit" name="submit" class="form__bill-btn delivering">Đang giao hàng</button>
                                                                </form>
                                                                <form action="../controller/AdminController.php?act=updateDetail" method="post" class="form__bill">
                                                                    <input type="hidden" value="<?php echo $bills->getBillID(); ?>" name="detailId">
                                                                    <input type="text" value="4" name="status-id-input" hidden>
                                                                    <button type="submit" name="submit" class="form__bill-btn delivered">Đã giao hàng thành công</button>
                                                                </form>
                                                                <form action="../controller/AdminController.php?act=updateDetail" method="post" class="form__bill">
                                                                    <input type="hidden" value="<?php echo $bills->getBillID(); ?>" name="detailId">
                                                                    <input type="text" value="5" name="status-id-input" hidden>
                                                                    <button type="submit" name="submit" class="form__bill-btn order-cancellation">Đã huỷ</button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="bill_trangthai">
                                                        <?php
                                                        $idStatus = $bills->getStatusIDFromBill();
                                                        if ($idStatus == 2) {
                                                            echo '<p class="bill_trangthai_xacnhan" >Đã xác nhận</p>';
                                                        } elseif ($idStatus == 3) {
                                                            echo '<p class="bill_trangthai_giaohang" >Đang giao hàng</p>';
                                                        } elseif ($idStatus == 4) {
                                                            echo '<p class="bill_trangthai_thanhcong" >Đã giao hàng thành công</p>';
                                                        } elseif ($idStatus == 5) {
                                                            echo '<p class="bill_trangthai_huy" >Đã huỷ</p>';
                                                        } else {
                                                            echo '<p>Chờ xác nhận</p>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <!-- actions remove -->
                                                    <div class="comment-all__actions">
                                                        <button class="bill-all__actions-btn">Actions</button>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-profile">
                <div class="modal-overlay"></div>
                <div class="modal-wrapper">
                    <div class="modal-wrapper-close">
                        <i class="fa-solid fa-circle-xmark modal-wrapper-close-icon"></i>
                    </div>
                    <?php
                    if (isset($_SESSION['userId'])) {
                        $userID = $_SESSION['userId'];
                        $queryUser = $userDAO->getUserByIDUS($userID);
                    }
                    ?>
                    <h1 class="modal-title">Change Profile</h1>
                    <div class="modal-info-current">
                        <div class="modal-info-current-avatar">
                            <img src="./images/<?php echo $queryUser->getAvatar(); ?>" alt="" class="modal-info-current-img" />
                        </div>
                        <h3 class="modal-info-current-name"><?php echo $queryUser->getFullName(); ?></h3>
                        <p class="modal-info-current-desc">Admin</p>
                    </div>
                    <form id="form-profile" action="../controller/AdminController.php?act=updateAdmin" enctype="multipart/form-data" method="post" class="modal-form-profile">
                        <div class="form-group-modal">
                            <label class="form-modal-title">New Your Name</label>
                            <input type="text" name="fullname" value="<?php echo $queryUser->getFullName(); ?>" autocomplete="username" class="form-modal-input" placeholder="enter new your name">
                            <sapn class="form-modal-error"></sapn>
                        </div>
                        <div class="form-group-modal modal-file">
                            <label class="form-modal-title">New Your Image</label><br><br>
                            <input type="file" name="avatar" class="input-modal-file" placeholder="enter new your image">
                            <sapn class="form-modal-error"></sapn>
                            <label class="sticker-file">
                                <i class="fa-solid fa-image"></i>
                                Upload image
                            </label>
                        </div>
                        <div class="form-group-modal">
                            <label class="form-modal-title">New Your Password</label>
                            <input type="password" name="password" value="<?php echo $queryUser->getPassword(); ?>" autocomplete="new-password" class="form-modal-input js-modal-password" placeholder="enter new your password">
                            <sapn class="form-modal-error"></sapn>
                        </div>
                        <div class="form-group-modal">
                            <label class="form-modal-title">Enter New Your Password</label>
                            <input type="password" name="repassword" autocomplete="new-password" class="form-modal-input js-modal-enter-password" placeholder="retype new your password">
                            <sapn class="form-modal-error"></sapn>
                        </div>
                        <div class="modal-submit">
                            <button type="submit" class="modal-btn-submit">Done!</button>
                        </div>
                    </form>
                </div>
            </div>
    </body>

    </html>
<?php
}
?>

<script src="./js/admin.js"></script>
<script src="./js/delete.js"></script>

<script>
    // Function to handle file input change event
    function handleFileInputChange() {
        // Get the file input and image preview elements
        var input = document.getElementById('imageInput');
        var preview = document.getElementById('imagePreview');

        // Check if a file is selected
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            // Set the source attribute of the image preview to the selected file
            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            // Read the file as a data URL
            reader.readAsDataURL(input.files[0]);
        } else {
            // If no file is selected, keep the existing image
            preview.src = "<?php echo $productNew->getAvatar1(); ?>";
        }
    }

    // Add event listener to the file input
    document.getElementById('imageInput').addEventListener('change', handleFileInputChange);
</script>