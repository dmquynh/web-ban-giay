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
  <link rel="stylesheet" href="./assets//css//change_pass.css">
</head>

<body>
  <div class="container-changepass">
    <div style="line-height: 35px;">
      <h2>Đổi mật khẩu</h2>
      <span>Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác</span>
      <hr>
      <form action="" method="post">
        <?php
          if(isset($thongbao) && ($thongbao != '')){
            echo '<h3 style="color: red">'.$thongbao.'</h3>';
          }
        ?>
        <p>
          <label for="">Mật khẩu cũ</label>
          <input type="password" name="old_pass" id="input1" placeholder="Nhập mật khẩu cũ">
        </p>
        <p>
          <label for="">Mật khẩu mới</label>
          <input type="password" name="new_pass" id="input2" placeholder="Nhập mật khẩu mới">
        </p>
        <p>
          <label for="">Xác nhận mật khẩu</label>
          <input type="password" name="" id="input3" placeholder="Xác nhận mật khẩu">
        </p>
        <input type="submit" id="xacnhan" name="confirm" value="Xác nhận">
      </form>
    </div>
  </div>
</body>

</html>