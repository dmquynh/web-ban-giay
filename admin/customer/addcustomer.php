<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets//css//add.css">
  <link rel="stylesheet" href="../assets//css//list.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<script>
function choose(fileInput) {
  if (fileInput.files && fileInput.files[0]) {
    var render = new FileReader();

    render.onload = function(e) {
      $("#image").attr("src", e.target.result);
    };
    render.readAsDataURL(fileInput.files[0]);
  }
}
</script>
<style>
button {
  cursor: pointer;
}

.thongbao {
  color: rgba(0, 0, 0, 0.526);
}

.thongbao a {
  text-decoration: none;
  color: brown;
}
</style>

<body>
  <div class="container-products">
    <div class="head">
      <h2>Thêm tài khoản</h2>
      <a href="index.php?act=listcustomer"><button style="left: 625px; position: relative;">Danh sách thành
          viên</button></a>
    </div>
    <?php
        require './global.php';
        if(isset($_GET['act'])){
          echo '
          <div class="url">
            <a href="'.$home.'">'.$base_url.' / </a> 
            <a href="">'.$_GET['act'].'</a>
          </div>
          ';
        }
      ?>

    <div class="container-content" style="height:450px">
      <form action="" method="post" enctype="multipart/form-data">
        <div style="display: none;">
          <h3></h3>
          <div class="cate-img">
            <img id="image" width="112" height="112" />
            <input type="file" name="image_file" id="image_file" onchange="choose(this)" />
          </div>
        </div>
        <h3>Thông tin tài khoản</h3>
        <div class="cate-info">
          <div class="cate1">
            <p>
              <label for="">Tài khoản</label><br>
              <input type="text" name="name" id="" placeholder="Tên tài khoản">
            </p>
            <p>
              <label for="">Mật khẩu</label><br>
              <input type="text" name="password" id="" placeholder="Mật khẩu">
            </p>
          </div>
          <div class="cate1">
            <p>
              <label for="">Email</label><br>
              <input type="text" name="email" id="" placeholder="Email">
            </p>
            <p>
              <label for="">Xác nhận mật khẩu</label><br>
              <input type="text" name="password1" id="" placeholder="Xác nhận mật khẩu">
            </p>
          </div>
          <div class="status-checkbox">
            <label for="">Vai trò</label><br>
            <label>
              <input type="radio" checked name="role" id="" value="0"><span>Thành viên</span>
            </label>
            <label>
              <input type="radio" name="role" id="" value="1" style="margin-left:20px"><span>Admin</span>
            </label>
          </div>
        </div>
        <input type="submit" value="Tạo tài khoản" name="addcustomer">
      </form>
      <?php
            if (isset($thongbao) && ($thongbao != '')) {
                echo  '<h3 class="thongbao">' . $thongbao . '</h3>';
            }
          ?>
    </div>

  </div>

</body>

</html>