<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="icon" href="./assets//images//about//about-icons-1.svg">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="./assets//css//account.css">
  <script src="./assets//js//account.js"></script>

</head>
<style>
body {
  background-color: white;
  height: 213vh;
}

.login-container {
  height: 500px;
}

.login-container {
  margin-left: 500px;
  margin-top: 30px;
}

.reg a {
  text-decoration: none;
  color: blue;
}

input[type=submit] {
  width: 350px;
  margin-top: 90px;
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

#b,
#c {
  position: absolute;
  top: 47px;
  left: 8px;
  font-size: 13px;
  color: red;
}
.thongbao {
  color: red;
  position: absolute;
  margin-top: 40px;
  margin-left: 90px;
}
</style>

<body>
  <div class="login-container">
    <span style="position: relative; top: 20px;text-transform: uppercase; font-weight:bold ">Đăng ký thành viên</span>
    <?php
      if(isset($thongbao) && ($thongbao != '')){
        echo  '<p class="thongbao">' . $thongbao . '</p>';
      }
    ?>
    <form action="" method="post" style="margin-top: -35px;">
      <div class="input-container" style="margin-top:20px">
        <input type="text" name="name" id="name" value="<?php echo (!empty($_POST['name'])) ? $_POST['name'] : false ?>"
          placeholder="Username" />
        <?php echo (!empty($error['name']['required'])) ? '<span id="a">' . $error['name']['required'] . '</span>' : false;?>
        <?php echo (!empty($error['name']['min'])) ? '<span id="a">' . $error['name']['min'] . '</span>' : false;?>


        <!-- <label for="username" id="name-label">Username</label> -->
        <div class="icon-acc">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-fill"
            viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          </svg>
        </div>
      </div>
      <div class="input-container" style="margin-top:20px">
        <input type="text" name="email" value="<?php echo (!empty($_POST['email'])) ? $_POST['email'] : false ?>"
          placeholder="Email" />
        <?php echo (!empty($error['email']['required'])) ? '<span id="a">' . $error['email']['required'] . '</span>' : false;?>
        <?php echo (!empty($error['email']['check'])) ? '<span id="a">' . $error['email']['check'] . '</span>' : false;?>

        <!-- <label for="username" id="phone-label">Số điện thoại</label> -->
        <div class="icon-acc">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-telephone-fill" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
          </svg>
        </div>
      </div>
      <div class="input-container">
        <input type="password" id="password" name="password"
          value="<?php echo (!empty($_POST['password'])) ? $_POST['password'] : false ?>" placeholder="Password" />
        <?php echo (!empty($error['password']['required'])) ? '<span id="b" >' . $error['password']['required'] . '</span>' : false;?>
        <?php echo (!empty($error['password']['check'])) ? '<span id="b" >' . $error['password']['check'] . '</span>' : false;?>

        <!-- <label for="password" id="password-label">Password</label> -->
        <div class="icon-acc">
          <i id="icon" class='bx bxs-lock-alt'></i>
        </div>
      </div>
      <div class="input-container">
        <input type="password" id="password1" name="password1"
          value="<?php echo (!empty($_POST['password1'])) ? $_POST['password1'] : false ?>" placeholder="Password" />
        <?php echo (!empty($error['password1']['required'])) ? '<span id="c">' . $error['password1']['required'] . '</span>' : false;?>
        <!-- <label for="password" id="password1-label">Xác nhận mật khẩu</label> -->
        <div class="icon-acc">
          <i id="icon1" class='bx bxs-lock-alt'></i>
        </div>
      </div>
      <input type="submit" name="signup" value="Đăng ký" style="margin-top: 109px;margin-left: -3px;" />

      <div style="margin-top: 13px;">
        <p>- HOẶC -</p>
      </div>

      <div class="reg" style="margin-top: 15px;">
        Đã có tài khoản <a href="index.php?act=login" style="font-weight: bold;">Đăng nhập</></a>
      </div>
    </form>
  </div>
</body>

</html>