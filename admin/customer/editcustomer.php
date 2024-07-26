<?php
  if(isset($_GET['id']) && ($_GET['id']) > 0){
    $id = $_GET['id'];
    $sql = "SELECT * FROM customer WHERE id = $id";
    $cus = pdo_query($sql);
  }
?>

<?php
  if(isset($_POST['edit']) && ($_POST['edit'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $password1 = $_POST['password1'];

    $sql = "UPDATE customer SET name=?, phone=?, password=?, role=?  WHERE id=$id";
    pdo_execute($sql, $name, $phone, $password, $role);

    header('location: index.php?act=listcustomer');
    // $conn = pdo_get_connection();
    // $sql = "UPDATE tbl_loai SET ten_loai='$ten_loai' WHERE id=$id";
    // $stmt = $conn->prepare($sql);
    // $stmt->execute();
    // header('location: index.php?act=adddm');
    // $conn = null;

  }
?>



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

<body>
  <div class="container-products">
    <div class="head">
      <h2>Chỉnh sửa tài khoản</h2>
      <button style="left: 565px; position: relative;"><a href="index.php?act=listcustomer">Danh sách thành
          viên</a></button>
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

    <div class="container-content">
      <form action="" method="post" enctype="multipart/form-data">
        <div style="display: none;">
          <h3>Hình ảnh danh mục</h3>
          <div class="cate-img">
            <img id="image" width="112" height="112" src="<?php echo $cus[0][3]?>" />
            <input type="file" name="image_file" id="image_file" onchange="choose(this)" />
          </div>
        </div>
        <h3>Thông tin tài khoản</h3>
        <div class="cate-info">
          <div class="cate1">
            <p>
              <label for="">Tên tài khoản</label><br>
              <input type="text" name="name" id="" placeholder="Tên tài khoản" value="<?php echo $cus[0][1]?>">
            </p>
            <p>
              <label for="">Mật khẩu</label><br>
              <input type="text" name="password" id="" placeholder="Mật khẩu" value="<?php echo $cus[0][11]?>">
            </p>
          </div>
          <div class="cate1">
            <p>
              <label for="">Email</label><br>
              <input type="text" name="phone" id="" placeholder="Số điện thoại" value="<?php echo $cus[0][3]?>">
            </p>
            <p>
              <label for="">Xác nhận mật khẩu</label><br>
              <input type="text" id="date" name="password1" placeholder="Xác nhận mật khẩu"
                value="<?php echo $cus[0][11]?>">
            </p>
          </div>
          <div class="status-checkbox">
            <label for="">Trạng thái</label><br>
            <label>
              <input type="radio" name="role" id="" value="0"
                <?php echo ($cus[0][12]) == 0 ? 'checked' : ''?>><span>Thành viên</span>
            </label>
            <label>
              <input type="radio" name="role" id="" value="1" <?php echo ($cus[0][12]) == 1 ? 'checked' : ''?>
                style="margin-left:20px"><span>Admin</span>
            </label>
          </div>
        </div>
        <input type="submit" value="Chỉnh sửa" name="edit">
      </form>
    </div>
  </div>

</body>

</html>