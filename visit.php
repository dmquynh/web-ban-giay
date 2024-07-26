<?php
  require './dao/pdo.php';

  session_start();

  // Kiểm tra xem session lượt truy cập đã được khởi tạo chưa
 
  // Cập nhật vào cơ sở dữ liệu
  $sql = "UPDATE visit SET visit = visit + 1 WHERE id = 1";
  pdo_execute($sql);
?>