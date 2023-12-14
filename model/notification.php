<?php

class notification {
    private $idNotification;
    private $idProduct;
    private $idUser;
    private $notificationLevel;
    private $dateCreate;

    public function __construct($idNotification, $idProduct, $idUser, $notificationLevel, $dateCreate)
    {
        $this->idNotification = $idNotification;
        $this->idProduct = $idProduct;
        $this->idUser = $idUser;
        $this->notificationLevel = $notificationLevel;
        $this->dateCreate = $dateCreate;
    }

    public function getNotificationId() {
        return $this->idNotification;
    }

    public function getNotificationProductID() {
        return $this->idProduct;
    }

    public function getNotificationUserID() {
        return $this->idUser;
    }

    public function geNotificationLevel() {
        return $this->notificationLevel;
    }

    public function geNotificationDateCreate() {
        return $this->dateCreate;
    }
}

?>