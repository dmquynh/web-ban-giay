<?php
  require '../global.php';
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrator System</title>
  <link rel="icon" href="../..//assets//images//about//about-icons-1.svg">
  <link rel="stylesheet" href="../..//assets//css//account.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <div class="login-container">
    <div><img src="../../assets//images//avatar//icon-user.png" alt="" /></div>
    <span style="position: relative; top: 20px">Đăng nhập hệ thống</span>
    <form action="../auth.php" method="post">
      <div class="input-container">
        <input type="text" name="username" placeholder="Username" />
        <!-- <label for="username">Username</label> -->
        <div class="icon-acc">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-fill"
            viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          </svg>
        </div>
      </div>
      <div class="input-container">
        <input type="password" name="password" placeholder="Password" />
        <!-- <label for="password">Password</label> -->
        <div class="icon-acc">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-lock-fill"
            viewBox="0 0 16 16">
            <path
              d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
          </svg>
        </div>
      </div>
      <input type="submit" value="Login" name="login" />
    </form>
    <?php
    
    if(isset($_GET['error'])){
        if($_GET['error'] == 1){
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
            echo '<script>Swal.fire("Login Error", "Tài khoản không chính xác", "error");</script>';
        } elseif ($_GET['error'] == 2) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
            echo '<script>Swal.fire("Login Error", "Không thể đăng nhập trang nay", "error");</script>';
        }
    }
    ?>
  </div>
</body>

</html>