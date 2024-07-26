<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - ShoesShop</title>
  <link rel="icon" href="../assets//images//logo//logo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,600&family=Roboto:wght@300;400&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="../assets//css//admin.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<script>
$(document).ready(function() {
  $('.user').click(function() {
    $('.menu-admin').toggle();
  })
})
</script>

<body>
  <div class="container">
    <header>
      <div class="head-top">
        <form action="" method="post">
          <input type="text" name="" id="" placeholder="Tìm kiếm">
        </form>
        <div class="user">
          <?php
            if(isset($_SESSION['user_admin'])){
              $sql = "SELECT * FROM customer WHERE id = " . $_SESSION['user_admin'][0][0];
              $res = pdo_query($sql);

              $img = '../assets//images//avatar//avatar-trang.jpg';
              if($res[0][5] == ''){
                $res[0][5] = $img;
              }
          ?>
          <img src="<?=$res[0][5] ?>" alt="">
        </div>
      </div>
      <div class="menu-admin">
        <div class="account">
          <h4>ShoesShop Admin</h4>
          <p><?=$res[0][3] ?></p>
          <?php }?>

        </div>
        <hr>
        <div class="sub-menu">
          <li><a href="">Trang chủ</a></li>
          <li><a href="">Thông tin</a></li>
          <li><a href="">Cài đặt</a></li>
        </div>
        <hr>
        <div class="logout">
          <li><a href="">Đăng xuất</a></li>
        </div>
      </div>
    </header>