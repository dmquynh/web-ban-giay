<?php
session_start(); // Bắt đầu session (nếu chưa bắt đầu)
require './dao/pdo.php';
  if(isset($_GET['id_product'])){
    $id_product = $_GET['id_product'];
    $newSize = $_GET['size'];
    
    $sqlUpdate = "UPDATE cart SET size = $newSize  WHERE idpro = $id_product";
    pdo_execute($sqlUpdate);

    header("Location: index.php?act=cart"); 
    exit();
  }
?>