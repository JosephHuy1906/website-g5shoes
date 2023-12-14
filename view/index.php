<?php
    include './header.php';
?>

        <main class="main__wrapper">
        <link rel="stylesheet" href="./css/index.css"/>
            <div class="grid wide">
                <!-- banner -->
                <div class="banner">
                    <div class="slide">
                        <a class="banner__btn left" href="#">
                            <button>
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                        </a>
                        <div class="slide__show-img" style="background-image: url(./images/banner.jpg)"></div>
                        <a class="banner__btn right" href="">
                            <button>
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </a>
                    </div>
                </div>
                <!-- product -->
                <div class="main__product">
                    <!-- new product -->
                    <div class="main__product-wrapper">
                        <h1 class="main__product-title">Sản phẩm mới</h1>
                        <div class="main__product-content">
                            <div class="row">
                                <!-- product 1 -->
                                <?php 
                                    $productNews = $productDAO->getProductByArgument(4);
                                    foreach ($productNews as $productNew) {
                                        
                                ?>
                                    <div class="col l-3 m-6 c-6">
                                        <a href="<?php echo './detail.php?id='.$productNew->getId() ?>" class="main__product-box">
                                            <div class="main__product-box-picture">
                                            
                                                <div class="new">
                                                    <p>New</p>
                                                </div>
                                            
                                                <div class="main__product-box-img" style="background-image: url(<?php echo $productNew->getAvatar1(); ?>)"></div>
                                            </div>
                                            <h3 class="main__product-box-title"><?php echo $productNew->getName(); ?></h3>
                                            <div class="main__product-box-price">
                                                <span class="main__product-box-current-price"><?php echo $productNew->getNewPrice(); ?></span>
                                                <span class="main__product-box-old-price"><?php if($productNew->getOldPrice()!= 0){echo $productNew->getOldPrice().'đ';}?></span>
                                            </div>
                                            <div class="main__product-box-color">
                                                <a href="<?php echo './detail.php?id='.$productNew->getId() ?>" class="main__product-box-color-title">Xem chi tiết</a>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                               
                            </div>
                        </div>
                    </div>

                    <!-- hot product -->
                    <div class="main__product-wrapper">
                        <h1 class="main__product-title">Sản phẩm xem nhiều nhất</h1>
                        <div class="main__product-content">
                            <div class="row">
                                <!-- product 1 -->
                                <?php 
                                    $productNews = $productDAO->getProductRamdom(4);
                                    foreach ($productNews as $productNew) {
                                        
                                ?>
                                    <div class="col l-3 m-6 c-6">
                                        <a href="<?php echo './detail.php?id='.$productNew->getId() ?>" class="main__product-box">
                                            <div class="main__product-box-picture">
                                            
                                                <div class="giamgia">
                                                    <p>Hot</p>
                                                </div>
                                            
                                                <div class="main__product-box-img" style="background-image: url(<?php echo $productNew->getAvatar1(); ?>)"></div>
                                            </div>
                                            <h3 class="main__product-box-title"><?php echo $productNew->getName(); ?></h3>
                                            <div class="main__product-box-price">
                                                <span class="main__product-box-current-price"><?php echo $productNew->getNewPrice(); ?></span>
                                                <span class="main__product-box-old-price"><?php if($productNew->getOldPrice()!= 0){echo $productNew->getOldPrice().'đ';}?></span>
                                            </div>
                                            <div class="main__product-box-color">
                                                <a href="<?php echo './detail.php?id='.$productNew->getId() ?>" class="main__product-box-color-title">Xem chi tiết</a>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- promotion product -->
                    <div class="main__product-wrapper">
                        <h1 class="main__product-title">Sản phẩm khuyến mãi</h1>
                        <div class="main__product-content">
                            <div class="row">
                                <!-- product 1 -->
                                <?php 
                                    $productNews = $productDAO->getProductBySale(4);
                                    foreach ($productNews as $productNew) {
                                        
                                ?>
                                    <div class="col l-3 m-6 c-6">
                                        <a href="<?php echo './detail.php?id='.$productNew->getId() ?>" class="main__product-box">
                                            <div class="main__product-box-picture">
                                            <?php if($productNew->getOldPrice()!= 0){
                                                ?>
                                                <div class="giamgia">
                                                    <p>
                                                        <?php
                                                            $giamgia = ( ($productNew->getOldPrice() - $productNew->getNewPrice()) / $productNew->getOldPrice() ) * 100 ;
                                                            echo round($giamgia,0);
                                                        ?>%
                                                    </p>
                                                </div>
                                            <?php
                                                }
                                            ?>
                                                <div class="main__product-box-img" style="background-image: url(<?php echo $productNew->getAvatar1(); ?>)"></div>
                                            </div>
                                            <h3 class="main__product-box-title"><?php echo $productNew->getName(); ?></h3>
                                            <div class="main__product-box-price">
                                                <span class="main__product-box-current-price"><?php echo $productNew->getNewPrice(); ?></span>
                                                <span class="main__product-box-old-price"><?php if($productNew->getOldPrice()!= 0){echo $productNew->getOldPrice().'đ';}?></span>
                                            </div>
                                            <div class="main__product-box-color">
                                                <a href="<?php echo './detail.php?id='.$productNew->getId() ?>" class="main__product-box-color-title">Xem chi tiết</a>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                              
                            </div>
                        </div>
                    </div>

                    <div class="main__product-wrapper">
                        <h1 class="main__product-title">Tin tức</h1>
                        <div class="main__product-content">
                            <div class="row">
                                <!-- product 1 -->
                                <div class="col l-3 m-6 c-6">
                                    <a href="#" class="main__product-box">
                                        <div class="main__product-box-picture news">
                                            <div class="main__product-box-img news" style="background-image: url(https://file.hstatic.net/1000282067/file/new-balance-550-release-date_8142186bc207493da37ac410f95bbb11_1024x1024.jpg)"></div>
                                        </div>
                                        <h3 class="main__product-box-title news">Aimé Leon Dore là gì? Tại sao bản collab New Blance 550 x Aimé Leon Dore lại có giá lên</h3>
                                        <div class="main__product-box-color">
                                            <a href="#" class="main__product-box-color-title">Xem chi tiết</a>  
                                        </div>
                                    </a>
                                </div>
                                <!-- news 2 -->
                                <div class="col l-3 m-6 c-6">
                                    <a href="#" class="main__product-box">
                                        <div class="main__product-box-picture news">
                                            <div class="main__product-box-img news" style="background-image: url(http://file.hstatic.net/1000282067/file/_off-white-nike-dunk-low-the-50-black-silver-dm1602-001-release-info-2_d2452dc3498c4b7f8f7b134700d8c976_2048x2048.jpg)"></div>
                                        </div>
                                        <h3 class="main__product-box-title news">Những sự thật bí ẩn đằng sau thương hiệu thời trang nổi tiếng của Đức - Adidas</h3>
                                        <div class="main__product-box-color">
                                            <a href="#" class="main__product-box-color-title">Xem chi tiết</a>  
                                        </div>
                                    </a>
                                </div>
                                <!-- news 3 -->
                                <div class="col l-3 m-6 c-6">
                                    <a href="#" class="main__product-box">
                                        <div class="main__product-box-picture news">
                                            <div class="main__product-box-img news" style="background-image: url(https://file.hstatic.net/1000282067/article/www.highsnobiety__42__26b858ec8fae436aa8031e79948bf05b_large.png)"></div>
                                        </div>
                                        <h3 class="main__product-box-title news">OFF-WHITE ™ x Church's: có gì phía sau bản hợp tác cuối cùng của Virgil Abloh</h3>
                                        <div class="main__product-box-color">
                                            <a href="#" class="main__product-box-color-title">Xem chi tiết</a>  
                                        </div>
                                    </a>
                                </div>
                                <!-- news 4 -->
                                <div class="col l-3 m-6 c-6 ">
                                    <a href="#" class="main__product-box">
                                        <div class="main__product-box-picture news">
                                            <div class="main__product-box-img news" style="background-image: url(https://file.hstatic.net/1000282067/article/www.highsnobiety__38__c6388e678d784f40ac3cd421e97ce6a2_large.png)"></div>
                                        </div>
                                        <h3 class="main__product-box-title news">BST Dior x Travis Scott ra mắt hoành tráng tại tuần lễ thời trang Paris</h3>
                                        <div class="main__product-box-color">
                                            <a href="#" class="main__product-box-color-title">Xem chi tiết</a>  
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
       
        <script src="./js/index.js"></script>
       
        <?php include './footer.php'; ?>