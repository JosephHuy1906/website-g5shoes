<?php

class comment {
    private $commentID;
    private $userID;
    private $productID;
    private $postdate;
    private $content;

    public function __construct($commentID, $userID, $productID, $postdate, $content)
    {
        $this->commentID = $commentID;
        $this->userID = $userID;
        $this->productID = $productID;
        $this->postdate = $postdate;
        $this->content = $content;
    }

    
    public function getcommentID() {
        return $this->commentID;
    }

    public function getuserID() {
        return $this->userID;
    }

    public function getproductID() {
        return $this->productID;
    }

    public function getpostdate() {
        return $this->postdate;
    }

    public function getcontent() {
       return $this->content;
    }


}

?>