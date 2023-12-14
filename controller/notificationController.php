<?php
session_start();
include_once('../Utils/Database.php');
include('../model/DAO/notificationDAO.php');

   $notificationDAO = new notificationDAO();
        $idNotification  = $_GET['idNotification'];
        $notificationDAO->Deletenotification($idNotification);
        header('Refresh: 0; ../view/index.php');
    
?>