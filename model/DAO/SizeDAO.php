<?php
    include('../model/Size.php');

    class SizeDAO {
        private $database;

        public function __construct() {
            $this->database = new Database();
            $this->database = $this->database->getDatabase();
            $this->database->query("SET NAMES 'utf8'");
        }

        //Lấy tất cả size
        public function getAllSize() {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare("SELECT * FROM `size`");

                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $sizes = [];
                        while ($row = $result->fetch_assoc()) {
                            $size = new Size($row['sizeID'], $row['size'], $row['sizeAmount']);
                            $sizes[] = $size;
                        }
                        return $sizes;
                    } else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
        }

        // lấy Size qua id
        public function getSizeById($id) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare('SELECT * FROM size WHERE sizeID = ?');
                $query->bind_param('s', $id);

                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $size = $result->fetch_assoc();
                        return new Size($size['sizeID'], $size['size'], $size['sizeAmount'] );
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }
            //Lấy tất cả size
            public function getAllSizebyId($id) {
                if ($this->database->connect_error) {
                    return false;
                } else {
                    $query = $this->database->prepare("SELECT * FROM `size` WHERE sizeID=?");
                    $query->bind_param('s', $id);
                    
                    if ($query->execute()) {
                        $result = $query->get_result();
                        if ($result->num_rows > 0) {
                            $sizes = [];
                            while ($row = $result->fetch_assoc()) {
                                $size = new Size($row['sizeID'], $row['size'], $row['sizeAmount']);
                                $sizes[] = $size;
                            }
                            return $sizes;
                        } else {
                            return false;
                        }
                    }
                    else {
                        return false;
                    }
                }
            }

    }       
?>
