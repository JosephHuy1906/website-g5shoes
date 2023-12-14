<?php

class feedback {
    private $feedbackID  ;
    private $commentID ;
    private $userID;
    private $postdate;
    private $content;

    public function __construct( $feedbackID, $commentID, $postdate, $content, $userID)
    {
        $this->feedbackID = $feedbackID;
        $this->commentID = $commentID;
        $this->postdate = $postdate;
        $this->content = $content;
        $this->userID = $userID;
    }

    
    public function getcommentID() {
        return $this->commentID;
    }
    
    public function getuserID() {
        return $this->userID;
    }

    public function getfeedbackID() {
        return $this->feedbackID;
    }

    public function getpostdate() {
        return $this->postdate;
    }

    public function getcontent() {
       return $this->content;
    }


}

?>