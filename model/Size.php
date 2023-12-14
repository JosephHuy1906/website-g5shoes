<?php

class Size {
    private $sizeID;
    private $size;
    private $sizeAmount;

    public function __construct($sizeID, $size, $sizeAmount)
    {
        $this->sizeID = $sizeID;
        $this->size = $size;
        $this->sizeAmount = $sizeAmount;
    }

    public function getSizeID() {
        return $this->sizeID;
    }

    public function getSize() {
        return $this->size;
    }

    public function getSizeAmount() {
       return $this->sizeAmount;
    }


}

?>