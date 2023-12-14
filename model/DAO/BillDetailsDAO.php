<?php
include_once('../model/billDetails.php');
class BillDetailsDAO
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
        $this->database = $this->database->getDatabase();
        $this->database->query("SET NAMES 'utf8'");
    }


    public function getAllBillDetails()
    {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare("SELECT * FROM `billdetails` ORDER BY detailID DESC");

            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows > 0) {
                    $billDetails = [];
                    while ($row = $result->fetch_assoc()) {
                        $billDetail = new billDetails(
                            $row['detailID'],
                            $row['billID'],
                            $row['productID'],
                            $row['price'],
                            $row['size'],
                            $row['userID'],
                            $row['dateCreate'],
                            $row['quantity']
                        );
                        $billDetails[] = $billDetail;
                    }
                    return $billDetails;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    // lấy bill details qua bill id
    public function getBillDetailByBillId($billID)
    {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM billdetails WHERE billID = ? ');
            $query->bind_param('s', $billID);

            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows > 0) {
                    $billDetail = $result->fetch_assoc();
                    return new billDetails(
                        $billDetail['detailID'],
                        $billDetail['billID'],
                        $billDetail['productID'],
                        $billDetail['price'],
                        $billDetail['size'],
                        $billDetail['userID'],
                        $billDetail['dateCreate'],
                        $billDetail['quantity']
                    );
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function getBillDetailByBillIdAll($billID)
    {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare("SELECT * FROM billdetails  WHERE billID=?");
            $query->bind_param('s', $billID);

            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows > 0) {
                    $billDetails = [];
                    while ($row = $result->fetch_assoc()) {
                        $billDetail = new billDetails(
                            $row['detailID'],
                            $row['billID'],
                            $row['productID'],
                            $row['price'],
                            $row['size'],
                            $row['userID'],
                            $row['dateCreate'],
                            $row['quantity']
                        );
                        $billDetails[] = $billDetail;
                    }
                    return $billDetails;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function getBillDetailsByProduct($userID)
    {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare("SELECT * FROM billdetails  WHERE userID=? ORDER BY detailID DESC");
            $query->bind_param('s', $userID);

            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows > 0) {
                    $billDetails = [];
                    while ($row = $result->fetch_assoc()) {
                        $billDetail = new billDetails(
                            $row['detailID'],
                            $row['billID'],
                            $row['productID'],
                            $row['price'],
                            $row['quantity'],
                            $row['size'],
                            $row['userID'],
                            $row['dateCreate'],
                        );
                        $billDetails[] = $billDetail;
                    }
                    return $billDetails;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }


    public function addBillDetails($billID, $productID, $price, $size, $quantity, $statusID, $userID)
    {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('INSERT INTO billdetails(billID, productID, price, size, quantity, userID) VALUES (?,?,?,?,?,?,?)');
            $query->bind_param('siiiisi', $billID, $productID, $price, $size, $quantity, $statusID, $userID);
            $query->execute();
        }
    }

    //update trạng thái đơn hàng
    public function updateDetail($statusID, $detailID)
    {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare("UPDATE billdetails SET statusID=?  WHERE  billID = ?");
            $query->bind_param('ss', $statusID, $detailID);
            $query->execute();
        }
    }
}
