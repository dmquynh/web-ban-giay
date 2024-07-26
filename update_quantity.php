<?php
session_start(); // Bắt đầu session (nếu chưa bắt đầu)
require './dao/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $idpro = $_POST['idpro'];
    $newQuantity = $_POST['quantity'];

    //Lấy giá sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM cart WHERE idpro = $idpro";
    $productInfo = pdo_query($sql);

    // Tạo biến chứa giá mới
    $newMoney = $productInfo[0][4] * $newQuantity;
    
    // // cập nhật số lượng và tổng tiền mới vào cơ sở dữ liệu
    $sqlUpdate = "UPDATE cart SET quantity = $newQuantity, money = $newMoney  WHERE idpro = $idpro";
    pdo_execute($sqlUpdate);

    header("Location: index.php?act=cart"); 
    exit();
}
?>