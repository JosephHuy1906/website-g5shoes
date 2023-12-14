<?php

class status {
    private $statusID;
    private $status;

    public function __construct($statusID, $status)
    {
        $this->statusID = $statusID;
        $this->status = $status;
    }

    public function getstatusID() {
        return $this->statusID;
    }

    public function getstatus() {
        return $this->status;
    }
}

?>