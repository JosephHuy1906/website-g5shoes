<?php
    include('../model/status.php');

    class StatusDAO {
        private $database;

        public function __construct() {
            $this->database = new Database();
            $this->database = $this->database->getDatabase();
            $this->database->query("SET NAMES 'utf8'");
        }

        //Lấy tất cả size
        public function getAllStatus() {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare("SELECT * FROM `status`");

                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $statuses = [];
                        while ($row = $result->fetch_assoc()) {
                            $status = new status($row['statusID'], $row['status']);
                            $statuses[] = $status;
                        }
                        return $statuses;
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
        public function getStatusById($idStatus) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare('SELECT * FROM status WHERE statusID = ?');
                $query->bind_param('s', $idStatus);

                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $status = $result->fetch_assoc();
                        return new status($status['statusID'], $status['status']);
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
