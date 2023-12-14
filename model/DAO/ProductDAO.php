<?php
    include('../model/Product.php');
    

    class ProductDAO {
        private $database;

        public function __construct() {
            $this->database = new Database();
            $this->database = $this->database->getDatabase();
            $this->database->query("SET NAMES 'utf8'");
        }

        // lấy tất cả product
        public function getAllProduct() {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare('SELECT * FROM `product` ORDER BY productID DESC');
                
                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $products = [];
                        while ($row = $result->fetch_assoc()) {
                            $product = new Product($row['productID'], $row['name'], $row['categoryID'], $row['sizeID'], $row['img1'], $row['img2'], $row['img3'], $row['img4'],$row['oldPrice'],  $row['newPrice'],  $row['description']);
                            $products[] = $product;
                        }
                        return $products;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }
        // lấy product qua id
        public function getProductById($id) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare('SELECT * FROM product WHERE productID = ?');
                $query->bind_param('i', $id);

                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $product = $result->fetch_assoc();
                        return new Product($product['productID'], $product['name'], $product['categoryID'], $product['sizeID'], $product['img1'], $product['img2'], $product['img3'], $product['img4'], $product['oldPrice'], $product['newPrice'], $product['description']);
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        // lấy 4 hoặc nhiều product mới nhất
        public function getProductByArgument($argument = 4) {
            if ($this->database->connect_error) {
                return false;
            } 
            else {
                $query = $this->database->prepare("SELECT * FROM `product` ORDER BY `productID` DESC LIMIT $argument");


                if ($query->execute()) {
                    $result = $query->get_result();

                    if ($result->num_rows > 0) {
                        $fourProducts = [];
                        while ($row = $result->fetch_assoc()) {
                            $fourProduct = new Product($row['productID'], $row['name'], $row['categoryID'], $row['sizeID'], $row['img1'], $row['img2'], $row['img3'], $row['img4'], $row['oldPrice'], $row['newPrice'], $row['description']);
                            $fourProducts[] = $fourProduct;
                        }
                        return $fourProducts;
                    } else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
        }

        // lấy 4 hoặc nhiều product ngẫu nhiên
        public function getProductRamdom($argument = 4) {
            if ($this->database->connect_error) {
                return false;
            } 
            else {
                $query = $this->database->prepare("SELECT * FROM `product` ORDER BY RAND()  LIMIT $argument");


                if ($query->execute()) {
                    $result = $query->get_result();

                    if ($result->num_rows > 0) {
                        $fourProducts = [];
                        while ($row = $result->fetch_assoc()) {
                            $fourProduct = new Product($row['productID'], $row['name'], $row['categoryID'], $row['sizeID'], $row['img1'], $row['img2'], $row['img3'], $row['img4'], $row['oldPrice'], $row['newPrice'], $row['description']);
                            $fourProducts[] = $fourProduct;
                        }
                        return $fourProducts;
                    } else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
        }

           // lấy 4 hoặc nhiều product sale cũ nhất
           public function getProductBySale($argument = 4) {
            if ($this->database->connect_error) {
                return false;
            } 
            else {
                $query = $this->database->prepare("SELECT * FROM `product` WHERE oldPrice != 0 ORDER BY RAND() LIMIT $argument");


                if ($query->execute()) {
                    $result = $query->get_result();

                    if ($result->num_rows > 0) {
                        $fourProducts = [];
                        while ($row = $result->fetch_assoc()) {
                            $fourProduct = new Product($row['productID'], $row['name'], $row['categoryID'], $row['sizeID'], $row['img1'], $row['img2'], $row['img3'], $row['img4'], $row['oldPrice'], $row['newPrice'], $row['description']);
                            $fourProducts[] = $fourProduct;
                        }
                        return $fourProducts;
                    } else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
        }


        // lấy id product khi url bị phá
        public function getNewestProduct() {
            if ($this->database->connect_error) {
                return false;
            }
            else {
                $query = $this->database->prepare("SELECT * FROM `product` ORDER BY `product`.`productID` DESC LiMIT 1");

                if ($query->execute()) {
                    $result = $query->get_result();

                    if ($result->num_rows > 0) {
                        $defaultProductID = $result->fetch_assoc();
                        return new Product($defaultProductID['productID'], $defaultProductID['name'], $defaultProductID['categoryID'], $defaultProductID['sizeID'], $defaultProductID['img1'], $defaultProductID['img2'], $defaultProductID['img3'], $defaultProductID['img4'], $defaultProductID['oldPrice'], $defaultProductID['newPrice'], $defaultProductID['description']);
                    }
                    else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
        }
        // Thêm sản phẩm
        public function addProduct($name,$categoryID,$sizeID,$avatar1,$avatar2,$avatar3,$avatar4,$oldPrice,$newPrice,$description){
            if($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare('INSERT INTO product (name , categoryID , sizeID , img1 , img2 , img3 , img4 , oldPrice, newPrice , description) 
                VALUES (?,?,?,?,?,?,?,?,?,?)');
                $query->bind_param('ssssssssss',$name,$categoryID,$sizeID,$avatar1,$avatar2,$avatar3,$avatar4,$oldPrice,$newPrice,$description);
                $query->execute();
            }
        }
        // Xóa sản phẩm
        public function deleteProduct($id) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare('DELETE FROM `product` WHERE `productID` = ?');
                $query->bind_param('s' , $id);
                $query->execute();
                }
        }

        //Sửa sản phẩm
        public function updateProduct($name , $categoryId , $sizeID , $avatar1, $oldPrice , $newPrice , $description, $id) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare("UPDATE `product` SET `name`= ?, `categoryID` = ?, `sizeID` = ?, `img1` = ?, `oldPrice` = ?, `newPrice` = ?, `description` = ? WHERE  `productID` = ?");
                $query->bind_param('ssssssss' , $name , $categoryId , $sizeID , $avatar1 , $oldPrice , $newPrice , $description , $id);
                $query->execute();
                }
        }

         // lấy product qua name search
         public function getProductByName($nameSeach) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare("SELECT * FROM product WHERE name LIKE '%".$nameSeach."%' ");


                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $SearchProducts = [];
                        while($row = $result->fetch_assoc()){
                             $SearchProduct = new Product($row['productID'], $row['name'], $row['categoryID'], $row['sizeID'], $row['img1'], $row['img2'], $row['img3'], $row['img4'], $row['oldPrice'], $row['newPrice'], $row['description']);
                             $SearchProducts[] = $SearchProduct;
                            }
                            return $SearchProducts;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        // lấy product qua id
        public function getProductByCategory($id) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare("SELECT * FROM product WHERE categoryID = ? ");
                $query->bind_param('s' , $id);

                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $products = [];
                        while ($row = $result->fetch_array()) {
                            $product = new Product($row['productID'], $row['name'], $row['categoryID'], $row['sizeID'], $row['img1'], $row['img2'], $row['img3'], $row['img4'],$row['oldPrice'],  $row['newPrice'],  $row['description']);
                            $products[] = $product;
                        }
                        return $products;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

    }
?>
