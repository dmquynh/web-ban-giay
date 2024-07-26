<?php
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
  if(isset($_SESSION['user'])){
    $id_user = $_SESSION['user'][0][0];

   
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./assets//css//view_order.css">
</head>
<style>
#status {
  color: #ffffff;
  background: #e93219;
}

#status1,
#status2 {
  color: #ffffff;
}
</style>

<body>
  <div class="container_viewl">
    <div class="order-view-content">
      <h4>CHI TIẾT ĐƠN HÀNG</h4>
      <?php
        if(isset($_GET['id_order'])){
          $id_order = $_GET['id_order'];
          $sql = "SELECT * FROM orders WHERE id_customer=$id_user AND id=$id_order";
          $res1 = pdo_query($sql);

          foreach ($res1 as $order_view) {
            extract($order_view);
          
            if($status == 0){
              $status = "<span id='status'>Đang xử lý</span>";
            }elseif($status == 1){
              $status = "<span id='status1'>Đang giao hàng</span>";
            }else{
              $status = "<span id='status2'>Đã giao hàng</span>";
            }
        }
        
      ?>
      <span style="line-height: 40px;"><?=$status?></span>
      <p>Mã đơn hàng: <b><?=$ma_dh?></b></p>
      <p>Ngày mua: <b><?=$date?></b></p>
      <p>Tổng Tiền: <b><?=$money?> đ</b></p>
      <?php }?>
    </div>
    <hr>
    <div class="order-box-title">
      <?php
        if(isset($_GET['id_order'])){
          $id_order = $_GET['id_order'];
          $sql = "SELECT orders.id, orders.name, orders.address, province.name as province, district.name as district, ward.name as ward, orders.payment
                  FROM orders 
                  JOIN province on province.id=orders.province
                  JOIN district on district.id=orders.district
                  JOIN ward on ward.id=orders.ward WHERE orders.id = $id_order";
          $res2 = pdo_query($sql);

          foreach ($res2 as $info) {
            extract($info);
            if($payment == 0){
              $payment = "Thanh toán bằng tiền mặt khi nhận hàng";
            }else{
              $payment = 'Thanh toán VNPAY';
            }
        }
      ?>
      <div class="order-view-box">
        <p style="font-weight: bold; padding: 10px; font-size: 0.9em; padding: 15px 20px">THÔNG TIN NGƯỜI NHẬN</p>
        <hr style="width: 290px; margin-left: 10px;">
        <div class="order-view-info">
          <p><?=$name?></p>
          <p><?=$address?></p>
          <p><?=$ward?> , <?=$district?> , <?=$province?></p>
          <p>Tel: <?=$phone?></p>
        </div>
      </div>
      <div class="order-view-box">
        <p style="font-weight: bold; padding: 10px; font-size: 0.9em; padding: 15px 20px">PHƯƠNG THỨC VẬN CHUYỂN</p>
        <hr style="width: 290px; margin-left: 10px;">
        <div class="order-view-info">
          <p>Giao hàng tiêu chuẩn</p>
        </div>
      </div>
      <div class="order-view-box">
        <p style="font-weight: bold; padding: 10px; font-size: 0.9em; padding: 15px 20px">PHƯƠNG THỨC THANH TOÁN</p>
        <hr style="width: 290px; margin-left: 10px;">
        <div class="order-view-info">
          <p><?=$payment?></p>
        </div>
      </div>
      <?php }?>
    </div>

    <hr style="margin-top: 30px;">

    <div class="order-subOrder-container">
      <?php
        if(isset($_GET['id_order'])){
          $id_order = $_GET['id_order'];
          $sql = "SELECT orders.id, orders.ma_dh, orders.money as moneysum, order_cart.quantity, order_cart.image, order_cart.name, order_cart.new_price, order_cart.money as thanhtien
                  FROM orders
                  JOIN order_cart ON orders.id = order_cart.id_order WHERE orders.id = $id_order";
          $res3 = pdo_query($sql);

          foreach ($res3 as $view_detail_cart) {
            extract($view_detail_cart);
            $phi = 19000;
        }
      ?>
      <div style="line-height: 30px; font-size: 14px;">
        <p>1. Đơn hàng: <b style="color: brown"><?=$ma_dh?></b></p>
        <p>Tổng tiền: <b><?=$moneysum?></b></p>
      </div>
      <table border="1">
        <tr>
          <th>Hình ảnh</th>
          <th>Tên sản phẩm</th>
          <th>Giá bán</th>
          <th>Số lượng</th>
          <th>Thành tiền</th>
        </tr>
        <?php
          $tien = $moneysum - 19000;
          $sql = "SELECT * FROM order_cart WHERE id_order = $id_order";
          $res4 = pdo_query($sql);

          foreach ($res4 as $order_cart) {
            extract($order_cart);
            $money = $money * 1000;
        ?>
        <tr>
          <td><img src="./uploads/<?=$image?>" alt=""></td>
          <td><?=$name?><p style="margin-top: 10px; margin-left: -110px;">Size <?=$size?></p>
          </td>
          <td><?=$new_price?></td>
          <td><?=$quantity?></td>
          <td><?=$money?></td>
          <?php }?>
        </tr>
      </table>
      <div class="order-subOrder-total-desktop">
        <div style="display: grid; grid-template-columns: 180px 80px;">
          <div>
            <p style="display: flex;justify-content: right;margin-right: 26px;"><span>Thành tiền:</span></p>
            <p style="display: flex;justify-content: right;margin-right: 26px;"><span>Phí vận chuyển:</span></p>
            <p><span>Tổng Số Tiền (gồm VAT):</span></p>

          </div>
          <div>
            <p style="display: flex;justify-content: right;"><b><?=$tien?></b></p>
            <p style="display: flex;justify-content: right;"><b><?=$phi?></b></p>
            <p style="display: flex;justify-content: right;"><b><?=$moneysum?></b></p>
          </div>
        </div>
      </div>
      <?php }?>
    </div>
  </div>

</body>

</html>