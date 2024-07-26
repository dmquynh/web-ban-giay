<?php
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
  if(isset($_SESSION['user'])){
    $id_user = $_SESSION['user'][0][0];

    $sql = "SELECT * FROM customer WHERE id = $id_user";
    $res = pdo_query($sql);

    $img = "./assets//images//avatar//avatar-trang.jpg";
    if(empty($res[0][5])){
      $res[0][5] = $img;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="./assets//css//user.css">
</head>

<body>
  <div class="container-user">

    <div class="box">
      <?php 
            if(isset($_GET['act'])){
              switch ($_GET['act']) {
                case 'user':
                  require 'menu.php';
                  require 'home.php';
                  break;
                case 'order':
                  require 'menu.php';
                  require 'order.php';
                break;
                case 'change_pass':
                  if(isset($_POST['confirm'])){
                    $old_pass = $_POST['old_pass'];
                    $new_pass = $_POST['new_pass'];

                    $sql = "SELECT * FROM customer WHERE password = '$old_pass'";
                    $res1 = pdo_query($sql);

                    if(empty($res1)){
                      $thongbao = 'Mật khẩu không chính xác';
                    }else{
                      $sql = "UPDATE customer SET password = '$new_pass' WHERE id = $id_user";
                      pdo_execute($sql);
                      $thongbao = "Đổi mật khẩu thành công";
                    }
                  }
                  require 'menu.php';
                  require 'change_pass.php';
                break;
                case 'view_order':
                  require 'menu.php';
                  require 'view_order.php';
                break;

                default:
                  # code...
                  break;
              }
            }else{
              require 'home.php';

            }
          ?>
    </div>
  </div>

  </div>

</body>

</html>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
$(document).ready(function() {
  $('nav li:first-child').click(function() {
    $('nav li ul').toggle();

  })
})
</script>

<script>
function choose(fileInput) {
  if (fileInput.files && fileInput.files[0]) {
    var render = new FileReader();
    render.onload = function(e) {
      $('#image').attr('src', e.target.result);
    };
    render.readAsDataURL(fileInput.files[0])
  }
}
</script>