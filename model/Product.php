<?php

class Product {
    private $id;
    private $name;
    private $categoryId;
    private $sizeID;
    private $avatar1;
    private $avatar2;
    private $avatar3;
    private $avatar4;
    private $oldPrice;
    private $newPrice;
    private $description;
    public function __construct($id, $name, $categoryId, $sizeID, $avatar1, $avatar2, $avatar3, $avatar4, $oldPrice, $newPrice, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->sizeID = $sizeID;
        $this->avatar1 = $avatar1;
        $this->avatar2 = $avatar2;
        $this->avatar3 = $avatar3;
        $this->avatar4 = $avatar4;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
        $this->description = $description;
    }

    public function getID() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getCategoryID() {
        return $this->categoryId;
    }

    public function getSizeID() {
        return $this->sizeID;
    }
    
    public function getAvatar1() {
        return './images/'.$this->avatar1;
    }
    public function getImg1() {
        return $this->avatar1;
    }

    public function getAvatar2() {
        return './images/'.$this->avatar2;
    }

    public function getAvatar3() {
        return './images/'.$this->avatar3;
    }

    public function getAvatar4() {
        return './images/'.$this->avatar4;
    }

    public function getOldPrice() {
        return $this->oldPrice;
    }

    public function getNewPrice(){
        return $this->newPrice;
    }
    public function getDescription() {
        return $this->description;
    }

}

?>