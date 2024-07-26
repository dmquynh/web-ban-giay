<?php
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
  if(isset($_SESSION['user'])){
    $id_user = $_SESSION['user'][0][0];

    $sql = "SELECT * FROM customer WHERE id = $id_user";
    $res = pdo_query($sql);

    if($res[0][5] == ""){
      $res[0][5] = './assets//images//avatar//avatar-trang.jpg';
    }else{
      $res[0][5] = $res[0][5]; 
    }
  }
?>

<div class="content">
  <div class="title">
    <h3 style="font-weight: 500;">Hồ Sơ Của Tôi</h3>
    <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
  </div>
  <hr>
  <form action="index.php?act=update_info" method="post" enctype="multipart/form-data">
    <div class="form-info">
      <div class="form-info1">
        <p>Tên đăng nhập</p>
        <p>Tên*</p>
        <p>Số điện thoại</p>
        <p>Email</p>
        <p>Giới tính*</p>
        <p>Ngày sinh*</p>
      </div>
      <div class="form-info2">
        <p><input type="text" name="name" id="" placeholder="Nhập tên đăng nhập" value="<?=$res[0][1]?>"></p>
        <p><input type="text" name="firstname" id="" placeholder="Nhập tên"
            value="<?php echo empty($res[0][7]) ? $res[0][7] = "" : $res[0][7] ?>"></p>
        <p><input type="text" name="phone" id="phone" onfocus="clearDefaultValue()"
            value="<?php echo empty($res[0][2]) ? $res[0][2] = "Chưa có số điện thoại" : $res[0][2] ?>"></p>
        <p>
        <p><input type="text" name="email" id="email" placeholder="Nhập Email" value="<?=$res[0][3]?>"></p>

        <p><input type="hidden" name="id_customer" id="" value="<?=$res[0][0]?>"></p>
        <label><input type="radio" name="gender" id="" value="0" <?php echo ($res[0][6] == 0) ? 'checked' : ''; ?>>
          Nam</label>

        <label><input type="radio" name="gender" id="" value="1" <?php echo ($res[0][6] == 1) ? 'checked' : ''; ?>>
          Nữ</label>
        <label><input type="radio" name="gender" id="" value="2" <?php echo ($res[0][6] == 2) ? 'checked' : ''; ?>>
          Khác</label>
        </p>
        <p style="margin-top: 26px;">
          <input type="text" name="day_birth" id="" placeholder="Nhập ngày sinh" style="width:150px"
            value="<?php echo empty($res[0][8]) ? $res[0][8] = "" : $res[0][8] ?>">
          <input type="text" name="month_birth" id="" placeholder="Nhập thánh sinh" style="width:150px"
            value="<?php echo empty($res[0][9]) ? $res[0][9] = "" : $res[0][9] ?>">
          <input type="text" name="year_birth" id="" placeholder="Nhập năm sinh" style="width:150px"
            value="<?php echo empty($res[0][10]) ? $res[0][10] = "" : $res[0][10] ?>">
        </p>
      </div>
      <div class="form-info3">
        <div class="up-img">
          <img id="image" width="100" src="<?=$res[0][5]?>" height="100" alt="">
          <input type="file" name="image_file" id="" style="width:70px" onchange="choose(this)">
          <div style="padding: 15px 30px; margin-top: 5px; line-height: 27px;">
            <p>Dụng lượng file tối đa 1 MB</p>
            <p>Định dạng:.JPEG, .PNG</p>
          </div>
        </div>
      </div>
    </div>
    <input type="submit" name="update_info" value="Lưu Thay Đổi">
    <img src="" alt="">
  </form>
</div>

<script>
function clearDefaultValue() {
  var emailField = document.getElementById('phone');

  if (emailField.value === "Chưa có số điện thoại") {
    emailField.value = '';
  } else {
    // emailField.value = 'Chưa có số điện thoại';
  }
}
</script>