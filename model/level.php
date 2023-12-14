<?php

class level {
    private $levelID ;
    private $role ;

    public function __construct($levelID, $role)
    {
        $this->levelID = $levelID;
        $this->role = $role;
    }

    public function getLevelID() {
        return $this->levelID;
    }

    public function getRole() {
        return $this->role;
    }
}

?>