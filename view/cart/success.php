<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./assets//css//success.css">

</head>

<body>
  <?php
    if(isset($_SESSION['user'][0][0])){
      $id_customer = $_SESSION['user'][0][0];
      $sql = "SELECT * FROM orders WHERE id_customer = $id_customer ORDER BY date desc limit 1";
      $res = pdo_query($sql);
    }
  ?>
  <div class="success">
    <div style="text-align: center;">
      <img src="./assets//images//svg//ico_successV2.svg" alt="">
      <h3 style="color: #32a838; margin-top: 20px; font-size: 26px;">Đơn hàng của bạn đã được tiếp nhận</h3>
      <div style="margin-top: 20px; line-height: 30px;">
        <p>Cảm ơn bạn đã mua hàng tại ShoesShop</p>
        <p>Mã đơn hàng của bạn là: <a href="" style="color:brown; font-weight: bold"><?=$res[0][13]?></a></p>
        <p>Bạn sẽ sớm nhận được email xác nhận đơn hàng từ chúng tôi.</p>
      </div>
      <div style="margin-top: 20px;">
        <div><a class="continue" href="index.php?act=cart">Tiếp tục mua sắm</a></div>
        <div style="margin-top: 30px;"><a class="view" href="index.php?act=order">Xem chi tiết đơn hàng</a></div>
      </div>
    </div>


  </div>
</body>

</html>