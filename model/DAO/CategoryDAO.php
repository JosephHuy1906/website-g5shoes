<?php
    include('../model/category.php');

    class CategoryDAO {
        private $database;

        public function __construct() {
            $this->database = new Database();
            $this->database = $this->database->getDatabase();
            $this->database->query("SET NAMES 'utf8'");
        }

        //Lấy toàn bộ Category
        public function getAllCategory() {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare("SELECT * FROM category");

                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $categorys = [];
                        while ($row = $result->fetch_assoc()) {
                            $category  = new category($row['categoryID'], $row['category']);
                            $categorys[] = $category;
                        }
                        return $categorys;
                    } else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
        }
        // lấy category qua id
        public function getCategoryById($id) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare('SELECT * FROM category WHERE categoryID  = ?');
                $query->bind_param('s', $id);

                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $category = $result->fetch_assoc();
                        return new category($category['categoryID'], $category['category']);
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        //Lấy toàn bộ Category theo id
        public function getAllCategorybyID($id) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare("SELECT * FROM category WHERE categoryID = ?");
                $query->bind_param('s', $id);
                
                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $categorys = [];
                        while ($row = $result->fetch_assoc()) {
                            $category  = new category($row['categoryID'], $row['category']);
                            $categorys[] = $category;
                        }
                        return $categorys;
                    } else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
        }
        //Thêm category mới
    public function AddCategory($category)
    {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('INSERT INTO category(category) VALUES (?)');
            $query->bind_param('s', $category);
            $query->execute();
        }
    }
          // xoá comment theo id
    public function DeleteCategory($categoryID){
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('DELETE FROM category WHERE categoryID=?');
            $query->bind_param('s', $categoryID);
            $query->execute();
        }
    }
    }       
?>
