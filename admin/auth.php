<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<?php
session_start();
require '../dao/pdo.php';
// Xác minh thông tin đăng nhập của người dùng
if(isset($_POST['login'])){
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM customer WHERE name = '$username' AND password = '$password'";
  $res = pdo_query($sql);

  if (empty($res)) {
    // nếu không tồn tại $res thì thông báo tài khoản mật khẩu không chính xác
    echo 'Tài khoản hoặc mật khẩu không chính xác';
    header('Location: /shoes/admin/login/?error=1');
  }else{
    $_SESSION['user_admin'] = $res;
    if($res[0][12] == 1){
      // nếu role bằng 1 thì vào trang admin
      header('Location: http://localhost/shoes/admin/index.php');
    }else{
      // nếu role bằng 0 thì thông báo không được vào trang này
      header('Location: /shoes/admin/login/?error=2');
    }
  }
}
?>