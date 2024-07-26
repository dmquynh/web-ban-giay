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
      <h2>Thêm mới danh mục</h2>
      <a href="index.php?act=listcategories"><button style="left: 565px; position: relative;">Danh sách danh
          mục</button></a>
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
        <h3>Hình ảnh danh mục</h3>
        <div class="cate-img">
          <img id="image" width="112" height="112" />
          <input type="file" name="image_file" id="image_file" onchange="choose(this)" />
        </div>
        <h3>Thông tin danh mục</h3>
        <div class="cate-info">
          <div class="cate1">
            <p>
              <label for="">Tên danh mục</label><br>
              <input type="text" name="category_name" id="" placeholder="Tên danh mục">
            </p>
            <p>
              <label for="">Phân loại</label>
              <select name="gender" id="">
                <option value="" selected>Phân loại</option>
                <option value="0">Nam</option>
                <option value="1">Nữ</option>
              </select>
            </p>
          </div>
          <div class="cate1">
            <p>
              <label for="">Sale</label><br>
              <select name="sale" id="">
                <option value="0">Not sale</option>
                <option value="1">Sale</option>
              </select>
            </p>

          </div>
          <div class="status-checkbox">
            <label for="">Trạng thái</label><br>
            <label>
              <input type="radio" checked name="status" id="" value="1"><span>Đăng</span>
            </label>
            <label>
              <input type="radio" name="status" id="" value="0" style="margin-left:20px"><span>Không đăng</span>
            </label>
          </div>
        </div>
        <input type="submit" value="Thêm danh mục" name="add-product">
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