<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="icon" href="./assets//images//about//about-icons-1.svg">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="./assets//css//account.css">
</head>
<style>
body {
  background-color: white;
  height: 197vh;
}

.login-container {
  position: relative;
  left: 484px;
  margin-top: 30px;
  height: 400px;
}

.reg a {
  text-decoration: none;
  color: blue;
}

input[type=submit] {
  width: 350px;
  font-weight: bold;
}

input[type="text"],
input[type="password"] {
  border-bottom: 1px solid #ccc;
  width: 95%;
}



.icon-acc i {
  font-size: 25px;
  cursor: pointer;
}

#a {
  position: absolute;
  top: 46px;
  left: 10px;
  color: red;
  font-size: 13px;
}
.thongbao {
  color: red;
  position: absolute;
  margin-top: 40px;
  margin-left: 43px;
}
</style>

<body>
  <div class="login-container">
    <span style="position: relative; top: 20px;text-transform: uppercase; font-weight:bold ">Đăng nhập hệ thống</span>
    <?php
      if(isset($thongbao) && ($thongbao != '')){
        echo  '<p class="thongbao">' . $thongbao . '</p>';
      }
    ?>
    <form action="" method="post">
      <div class="input-container">
        <input type="text" id="name" name="name" value="<?php echo (!empty($_POST['name'])) ? $_POST['name'] : false ?>"
          placeholder="Username" />
        <?php
            echo (!empty($error['name']['required'])) ? '<span id="a">' . $error['name']['required'] . '</span>' : false;
          ?>
        <!-- <label for="username">Username</label> -->
        <div class="icon-acc">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-fill"
            viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          </svg>
        </div>
      </div>
      <div class="input-container" style="position: relative; top:90px">
        <input type="password" id="password" name="password"
          value="<?php echo (!empty($_POST['password'])) ? $_POST['password'] : false ?>" placeholder="password" />
        <?php
            echo (!empty($error['password'])) ? '<span id="a">' . $error['password'] . '</span>' : false;
          ?>
        <!-- <label for="password">Password</label> -->
        <div class="icon-acc">
          <i id='icon' class='bx bxs-lock-alt'></i>
        </div>
      </div>
      <a href="index.php?act=forget" class="forget">Quên mật khẩu ?</a>

      <input type="submit" name="login" value="Đăng nhập" style="margin-top: 119px; margin-left: 4px" />

      <div style="margin-top: 13px;">
        <p>- HOẶC -</p>
      </div>
      <div class="reg" style="margin-top: 13px;">
        Chưa có tài khoản <a href="index.php?act=signup" style="font-weight: bold;">Đăng ký ngay</a>
      </div>
    </form>
  </div>
</body>
<script src="./assets//js//account.js"></script>

</html>