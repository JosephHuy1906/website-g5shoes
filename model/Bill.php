<?php

class Bill {
    private $billID;
    private $userID;
    private $dateCreate;
    private $total;

    private $address;
    private $statusID;

    public function __construct($billID, $userID, $dateCreate, $total, $address, $statusID)
    {
        $this->billID = $billID;
        $this->userID = $userID;
        $this->dateCreate = $dateCreate;
        $this->total = $total;
        $this->address = $address;
        $this->statusID = $statusID;
    }

    public function getBillID() {
        return $this->billID;
    }

    public function getUserIDFromBill() {
        return $this->userID;
    }

   
    public function getDateCreate() {
        return $this->dateCreate;
    }

     public function getTotalFromBill() {
        return $this->total;
    }

    public function getStatusIDFromBill() {
        return $this->statusID;
    }

   

    public function getAddressIDFromBill() {
        return $this->address;
    }
}

?>