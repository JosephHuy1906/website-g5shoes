<?php
    include_once('../model/Bill.php');
    class BillDAO {
        private $database;

        public function __construct() {
            $this->database = new Database();
            $this->database = $this->database->getDatabase();
            $this->database->query("SET NAMES 'utf8'");
        }


        public function getAllBill() {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare("SELECT * FROM `bill` ORDER BY billID DESC");

                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $bills = [];
                        while ($row = $result->fetch_assoc()) {
                            $bill = new Bill(
                                $row['billID'], 
                                $row['userID'], 
                                $row['dateCreate'], 
                                $row['total'], 
                                $row['address'],
                                $row['statusID']);
                            $bills[] = $bill;
                        }
                        return $bills;
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
         public function getBillByUserId($userID) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare('SELECT * FROM bill WHERE userID  = ?');
                $query->bind_param('s', $userID);

                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $Bill = $result->fetch_assoc();
                        return new Bill(
                            $Bill['billID'], 
                            $Bill['userID'],  
                            $Bill['dateCreate'], 
                            $Bill['total'], 
                            $Bill['address'],
                            $Bill['statusID']);
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        public function getLastInsertedBill() {
            $query = "SELECT * FROM `bill` ORDER BY `billID` DESC LIMIT 1";
            $result = $this->database->query($query);
            $lastInsertedBill = $result->fetch_assoc();
    
            return $lastInsertedBill;
        }


        public function addBill($userID, $total,  $address) {
            if($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare('INSERT INTO bill(userID , total , address) VALUES (?,?,?)');
                $query->bind_param('sss',$userID, $total,  $address);
                
                $query->execute();
                
            }
        }
    }       
?>
