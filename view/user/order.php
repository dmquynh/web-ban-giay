<?php
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
  if(isset($_SESSION['user'])){
    $_SESSION['user'];
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./assets//css//order_detail.css">
</head>
<style>

</style>

<body>
  <div class="container-order" style="margin-left: 6px;">
    <h2>Đơn hàng của tôi</h2>
    <?php
      if(isset($_SESSION['user'])){
        $id_customer = $_SESSION['user'][0][0];
        $sql = "SELECT * FROM orders WHERE id_customer = $id_customer order by date desc";
        $res = pdo_query($sql);
      }
      if(empty($res)){
        echo '<p style="padding: 20px">Chưa có đơn hàng nào</p>';
      }else{

    ?>
    <table border="1">
      <tr>
        <th>Mã đơn hàng</th>
        <th>Ngày mua</th>
        <th>Người nhận</th>
        <th>Tổng Tiền</th>
        <th>Trạng thái </th>
        <th></th>
      </tr>
      <?php
        if(isset($_SESSION['user'])){
          $id_customer = $_SESSION['user'][0][0];
          $sql = "SELECT * FROM orders WHERE id_customer = $id_customer order by date desc";
          $res = pdo_query($sql);

          foreach ($res as $orders) {
            extract($orders);
            switch ($status) {
              case '0':
                $status = "<span id='status'>Đang xử lý</span>";
                break;
              case '1':
                $status = "<span id='status1'>Đang giao hàng</span>";
              break;
              case '2':
                $status = "<span id='status2' style='background: #1cb009'>Đã giao hàng</span>";
              break;
              default:
                # code...
                break;
              }
          ?>
      <tr>
        <td><?=$ma_dh?></td>
        <td><?=$date?></td>
        <td><?=$name?></td>
        <td><?=$money?></td>
        <td><?=$status?></td>
        <td><a href="index.php?act=view_order&id_order=<?=$id?>">Xem chi tiết</a></td>
      </tr>
      <?php }}?>
    </table>
  </div>

  <?php }?>
</body>

</html>