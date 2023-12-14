    <?php
        include('./header.php');
        
        $id = isset($_GET['id']) ? $_GET['id'] : false;
        $productID;
        $detailProduct = $productDAO->getNewestProduct();

        if ((int)$id) {

            if ((int)$id > (int)$detailProduct->getID()) {
                $productID = $detailProduct->getID();
            }
            else {
                $productID = $id;
            }
        
        } 
        else {
            $productID = $detailProduct->getID();
        }
        

    ?>
<link rel="stylesheet" href="./css/detailProduct.css"/>
    <div class="main">
        <div class="grid wide">
            <h3 class="main-part">Trang chủ > Chi tiết sản phẩm</h3>
            <div class="main__content">
                <?php 
                    $detailProduct = $productDAO->getProductById($productID);
                    $productAll = $productDAO->getAllProduct(); 
                ?>
                <h3 id="id-product" hidden><?php echo $detailProduct->getId(); ?></h3>
                <div class="row">
                    <div class="col l-6 m-6 c-12">
                        <div class="main__show">
                            <div class="main__show-img"
                                style="background-image: url(<?php echo $detailProduct->getAvatar1() ?>)"></div>
                            <div class="main__show-control">
                                <div class="main__show-control-box active">
                                    <img id="img-root" src="<?php echo $detailProduct->getAvatar1() ?>" alt="" class="main__show-control-img">
                                </div>
                                <div class="main__show-control-box">
                                    <img src="<?php echo $detailProduct->getAvatar2() ?>" alt="" class="main__show-control-img">
                                </div>
                                <div class="main__show-control-box">
                                    <img src="<?php echo $detailProduct->getAvatar3() ?>" alt="" class="main__show-control-img">
                                </div>
                                <div class="main__show-control-box">
                                    <img src="<?php echo $detailProduct->getAvatar4() ?>" alt="" class="main__show-control-img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col l-6 m-6 c-12">
                        <div class="main__information">
                            <form id="form-action-detail" method="post">
                                <!-- product title -->
                                <h1 class="main__information-title"><?php echo $detailProduct->getName(); ?></h1>
                                <!-- product price -->
                                <div class="main__information-price">
                                    <span class="main__information-old-price" value="<?php echo $detailProduct->getOldPrice() ?>"><?php if($detailProduct->getOldPrice()!= 0){echo $detailProduct->getOldPrice().'đ';} ?></span>
                                    <span class="main-information-price-default" hidden><?php echo $detailProduct->getNewPrice(); ?></span>
                                    <span class="main__information-current-price" value="<?php echo $detailProduct->getNewPrice(); ?>"><?php echo $detailProduct->getNewPrice(); ?>đ</span>
                                    <span class="price__store" hidden><?php echo $detailProduct->getNewPrice(); ?></span>
                                    <span class="main__information-sale"> Sale: 
                                        <span class="main__information-sale-number">
                                            <?php
                                                if($detailProduct->getOldPrice()!= 0){
                                                $giamgia = ( ($detailProduct->getOldPrice() - $detailProduct->getNewPrice()) / $detailProduct->getOldPrice() ) * 100 ;
                                                echo  round($giamgia,0);
                                                }else{
                                                    echo '0';
                                                }
                                            ?>%
                                        </span>
                                    </span>
                                </div>
                                <!-- product size -->
                                <div class="main__information-size">
                                    <h3 class="main__information-size-title">Kích thước giày: </h3>
                                    <div class="main__information-size-wrapper">
                                        <?php
                                            $sizes = $sizeDAO->getAllSize();
                                            foreach ($sizes as $size) {
                                        ?>
                                            <div class="main__information-size-box">
                                                <span class="main__information-size-number"><?php echo $size->getSize() ?></span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="main__information-size-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span class="main__information-size-error-text"></span>
                                    </div>
                                </div>
                                <!-- product amount -->
                                <div class="main__information-amount">
                                    <h3 class="main__information-amount-title">Số lượng: </h3>
                                    <div class="main__information-amount-quantity">
                                        <label for="" class="main__information-amount-quantity-decrease">
                                            <i class="fa-solid fa-minus"></i>
                                        </label>
                                        <input type="text" value="1" min="1" max="99" name="input-amount"
                                            class="main__information-amount-quantity-input">
                                        <label for="" class="main__information-amount-quantity-increase">
                                            <i class="fa-solid fa-plus"></i>
                                        </label>
                                    </div>
                                </div>
        
                                <!-- product order -->
                                <div class="main__information-order">
                                    <button id="add-cart" type="submit" class="main__information-order-add-cart">
                                        <i class="fa-solid fa-cart-plus main__information-order-add-cart-icon"></i>
                                        <span>Thêm vào giỏ hàng</span>
                                    </button>
                                    <button id="buy-now" type="submit" class="main__information-buy-now">Mua ngay</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php ?>
            </div>
            <div class="main__detail">
                <h2 class="main__detail-title">Chi tiết sản phẩm</h2>
                <p class="main__detail-desc"><?php echo $detailProduct->getDescription(); ?></p>
            
            </div>
            <div class="main__review">
                <?php ?>
                <h2 class="main__review-title">Đánh giá</h2>
                <div class="main__review-wrapper">
                    <?php
                    if (isset($_GET['id'])) {
                        $_SESSION['idsp'] = $_GET['id'];
                        $productID = $_SESSION['idsp'];
                    }
                    if (isset($_SESSION['userId'])) {
                        echo '
                            <div class="binhluan">
                            <form id="comment" action="../controller/UserController.php?act=comment" method="POST">
                            <h4>THÊM ĐÁNH GIÁ</h4>
                                <div class="user">
                                <input type="hidden" name="userid" value="' . $_SESSION['userId'] . '">
                                <input type="hidden" name="idsp" value="' . $productID . '">
                                <input type="hidden" name="date" value="' . date("d/m/Y") . '">
                                <textarea name="content" id="content"></textarea>
                                </div>
                                <input type="submit" value="Gửi" name="gui">
                            </form>
                            ';
                    }
                    $query = $commentDAO->getCommentByIDProduct($productID);
                    if ($query != null) {
                        foreach ($query as $row) {
                    ?>
                        
                            <div class="main__review-content">
                                    <div class="main__review-content-avatar">
                                        <img src="images/<?php
                                                    $id = $row->getuserID();
                                                    $user = $userDAO->getUserByID($id);
                                                    echo $user->getAvatar();
                                                    ?>" alt="" class="main__review-content-img">
                                    </div>
                                    <div class="main__review-content-text">
                                        <h3 class="main__review-content-name">
                                            <?php
                                            $id = $row->getuserID();
                                            $user = $userDAO->getUserByID($id);
                                            echo $user->getFullName();
                                            ?>
                                        </h3>
                                        <p class="main__review-content-timer"><?php echo $row->getpostdate(); ?></p>
                                        <p class="main__review-content-comment"><?php echo $row->getcontent(); ?></p>
                                        <div class="main__review-content-interactive">
                                            <button class="main__review-content-interactive-btn like">
                                                <i class="fa-regular fa-thumbs-up"></i>
                                            </button>
                                            <button class="main__review-content-interactive-btn dislike">
                                                <i class="fa-regular fa-thumbs-down"></i>
                                            </button>
                                       
                                        </div>
                                    </div>
                            </div>
                            <?php
                                $commentID = $row->getcommentID();
                                $Feedback = $feedBackDAO->getFeedbacktByCommentId($commentID);
                                if(isset($Feedback) && $Feedback != FALSE   ){
                                    foreach($Feedback as $row){
                            ?>
                      
                                <div class="main__review_feedback">
                                        <div class="main__review-content-avatar">
                                            <img src="./images/logo-chinh.jpg" alt="" class="main__review-content-img">
                                        </div>
                                        <div class="main__review-content-text">
                                            <h3 class="main__review-content-name">G5 Shoes</h3>
                                            <p class="main__review-content-timer"><?php echo $row->getpostdate(); ?></p>
                                            <p class="main__review-content-comment"><?php echo $row->getcontent(); ?></p>
                                            <div class="main__review-content-interactive">
                                                <button class="main__review-content-interactive-btn like">
                                                    <i class="fa-regular fa-thumbs-up"></i>
                                                </button>
                                                <button class="main__review-content-interactive-btn dislike">
                                                    <i class="fa-regular fa-thumbs-down"></i>
                                                </button>
                                                
                                            </div>
                                        </div>
                                </div>
                    <?php 
                        }}} }
                    ?>


                </div>
              
            </div>
        </div>
    </div>

    <script src="./js/detail.js"></script>

    <?php
        include('./footer.php');
    ?>