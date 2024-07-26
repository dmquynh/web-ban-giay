<?php
session_start(); // Bắt đầu session (nếu chưa bắt đầu)
require '../dao/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order'])) {
    $id = $_POST['id'];
    $newStatus = $_POST['status'];

    echo '<pre>';
    print_r($_POST);

    //Lấy giá sản phẩm từ cơ sở dữ liệu
    

    
    // // Tạo biến chứa giá mới
    // $newMoney = $productInfo[0][4] * $newQuantity;
    
    // // // cập nhật số lượng và tổng tiền mới vào cơ sở dữ liệu
    $sqlUpdate = "UPDATE orders SET status = $newStatus WHERE id= $id";
    pdo_execute($sqlUpdate);

    header("Location: index.php?act=list-order"); 
    // exit();
}
?>