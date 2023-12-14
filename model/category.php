<?php

class category {
    private $categoryID ;
    private $category ;

    public function __construct($categoryID, $category)
    {
        $this->categoryID = $categoryID;
        $this->category = $category;
    }

    public function getcategoryID() {
        return $this->categoryID;
    }

    public function getcategory() {
        return $this->category;
    }
}

?>