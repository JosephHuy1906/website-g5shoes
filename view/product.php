<?php
    include('./header.php');

    
?>
    <link rel="stylesheet" href="./css/product.css"/>
    <div class="main">

        <div class="main__product">
                        <div class="main__product-wrapper">
                            <div class="main__product-content">
                                <div class="row">
        <!-- Nếu tồn tại id category thì lấy sản phẩm theo id -->
                                    <?php     
                                        if(isset($_GET['id'])){
                                        $id = $_GET['id']; 
                                    ?>

                                    <div class="grid wide">
                                    <h3 class="main-part">Trang chủ > sản phẩm > 
                                                <?php
                                                    $categoryproduct = $categoryDAO->getCategoryById($id);
                                                    echo $categoryproduct->getcategory();
                                                ?>
                                    </h3>
                                </div>
                                    <?php
                                        $categoryproduct = $productDAO->getProductByCategory($id);
                                        foreach($categoryproduct as $productNew) {           
                                    ?>
                                    
                                    <div class="col l-3">
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
                                                <span class="main__product-box-current-price"><?php echo $productNew->getNewPrice(); ?>đ</span>
                                                <span class="main__product-box-old-price"><?php  if($productNew->getOldPrice()!= 0){echo $productNew->getOldPrice().'đ';} ?></span>
                                            </div>
                                            <div class="main__product-box-color">
                                                <a href="<?php echo './detail.php?id='.$productNew->getId() ?>" class="main__product-box-color-title">Xem chi tiết</a>
                                            </div>
                                        </a>
                                    </div>
        <!-- Nếu không tồn tại id thì lấy tất cả sản phẩm -->
                                    <?php 
                                            } 
                                        }else{
                                            echo '
                                                <div class="grid wide">
                                                    <h3 class="main-part">Trang chủ > sản phẩm </h3>
                                                </div>
                                            ';
                                            $productNews = $productDAO->getAllProduct();
                                            foreach ($productNews as $productNew) {
                                    ?>
                                        <div class="col l-3">
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
                                                    <span class="main__product-box-current-price"><?php echo $productNew->getNewPrice(); ?>đ</span>
                                                    <span class="main__product-box-old-price"><?php  if($productNew->getOldPrice()!= 0){echo $productNew->getOldPrice().'đ';} ?></span>
                                                </div>
                                                <div class="main__product-box-color">
                                                    <a href="<?php echo './detail.php?id='.$productNew->getId() ?>" class="main__product-box-color-title">Xem chi tiết</a>
                                                </div>
                                            </a>
                                        </div>
                                    <?php
                                        }}
                                    ?>
                                </div>
                            </div>
                        </div>                
        </div>
    </div>

<?php
    include('./footer.php');
?>