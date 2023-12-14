<?php

class User {
    private $id;
    private $email;
    private $fullName;
    private $gender;
    private $birthday;
    private $address;
    private $phoneNumber;
    private $password;
    private $avatar;
    private $levelID;
    private $code;
    public function __construct($id, $email, $fullName, $gender, $birthday, $address, $phoneNumber, $password, $avatar, $levelID, $code)
    {
        $this->id = $id;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->gender = $gender;
        $this->birthday = $birthday;
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
        $this->password = $password;
        $this->avatar = $avatar;
        $this->levelID = $levelID;
        $this->code = $code;
    }

    public function getID() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getAvatar() {
        return $this->avatar;
    }
    
    public function getLevelId() {
        return $this->levelID;
    }
    public function getcode() {
        return $this->code;
    }
}

?>