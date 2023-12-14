<?php

class billDetails {
    private $detailID;
    private $billID;
    private $productID;
    private $price;
    private $userID;
    private $quantity;
    private $size;
    private $dateCreate;

    public function __construct($detailID, $billID, $productID, $price, $quantity, $size, $userID, $dateCreate)
    {
        $this->detailID = $detailID;
        $this->billID = $billID;
        $this->productID = $productID;
        $this->dateCreate = $dateCreate;
        $this->price = $price;
        $this->userID = $userID;
        $this->size = $size;
        $this->quantity = $quantity;
    }

    public function getDetailID() {
        return $this->detailID;
    }
    public function getSize() {
        return $this->size;
    }

    public function getBillID() {
        return $this->billID;
    }

    public function getUserIDFromBillDetail() {
        return $this->userID;
    }
    public function getDateCreate() {
        return $this->dateCreate;
    }
    public function getProductIDFromBillDetail() {
       return $this->productID;
    }


     public function getPriceFromBillDetail() {
        return $this->price;
    }
    public function getQuantity() {
        return $this->quantity;
    }


}

?>