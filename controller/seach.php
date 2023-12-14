<?php
include_once('../Utils/Database.php');
include_once('../model/DAO/SizeDAO.php');
include_once('../model/DAO/ProductDAO.php');
$productDAO = new ProductDAO();
$sizeDAO = new SizeDAO();
    if(isset($_POST['action'])){
         $nameSeach = $_POST['search_name'];
         $query = $productDAO->getProductByName($nameSeach);

        if( $query != ''){
            foreach($query as $qr){
                ?>
                    <li class="list_search">
                       <a href="<?php echo './detail.php?id='.$qr->getId() ?>">
                       <div class="avatar_seach">
                       <img src="<?php echo $qr->getAvatar1(); ?>" alt="">
                       <h4><?php echo $qr->getName(); ?></h4>
                       </div>
                       <div class="size_price">
                            <span>Size: <?php $id = $qr->getSizeID();
                                $size = $sizeDAO->getSizeById($id);
                                echo $size->getSize();
                                ?>
                            </span>
                            <p><?php echo $qr->getNewPrice(); ?>đ</p>
                       </div>
                       </a>
                       
                    </li>
    <?php
             }
        }else{
            echo '<P>Không tìm thấy sản phẩm</P>';
        }
    }
    ?>
