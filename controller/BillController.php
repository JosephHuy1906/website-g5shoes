<?php
session_start();
include_once('../Utils/Database.php');
include_once('../model/DAO/BillDAO.php');
include_once('../model/DAO/BillDetailsDAO.php');
include('../model/DAO/notificationDAO.php');
include_once('../model/DAO/ProductDAO.php');
$billDAO = new BillDAO();
$billDetailsDAO = new BillDetailsDAO();
$notificationDAO = new notificationDAO();
$ProductDAO = new ProductDAO();

$userID;
if (isset($_SESSION['userId'])) {
    $userID = (int)$_SESSION['userId'];
} else {
    if (isset($_POST['submit'])) {
        header("location: ../view/login_regin.php");
        exit();
    }
}

$address = $_POST['address'];
$listData = json_decode($_POST['list-data'], true);

$totalPrice = 0; 

foreach ($listData as $datas) {
    $priceProduct = $datas[1];

    $totalPrice += $priceProduct;
}

$billDAO->addBill($userID, $totalPrice, $address);
$lastInsertedBill = $billDAO->getLastInsertedBill();
print_r($listData);
if ($lastInsertedBill) {
    $billID = $lastInsertedBill['billID'];
    foreach ($listData as $datas) {
        $productID =  $datas[0];
        $priceProduct = $datas[1];
        $sizeProductId = $datas[2];
        $quantity = $datas[3];

        $queryProduct = $ProductDAO->getProductById($productID);
        $statusID = '1';
        $notificationLevel = 2;
        $billDetailsDAO->addBillDetails($billID, $productID, $priceProduct, $sizeProductId, $quantity, $statusID, $userID);
        $notificationDAO->addNotification($productID, $userID, $notificationLevel);
    }
}


header('Location: ../view/template/message.html');
exit();
