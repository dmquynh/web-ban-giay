<?php
  if(isset($_GET['id']) && ($_GET['id']) > 0){
    $id = $_GET['id'];
    $sql = "SELECT * FROM category WHERE id = $id";
    $cate = pdo_query($sql);
  }
?>

<?php
  if(isset($_POST['edit']) && ($_POST['edit'])){
    $category_name = $_POST['category_name'];
    $gender = $_POST['gender'];
    $sale = $_POST['sale'];
    $status = $_POST['status'];

    if(!empty($_FILES["image_file"]["name"])){
      $target_dir = "../uploads/";
      $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
      $image = $target_file;
      $uploadOk = 1;
      move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file);

      $sql = "UPDATE category SET category_name=?, gender=?, image=?, sale=?, status=? WHERE id=$id";
      pdo_execute($sql, $category_name, $gender, $image, $sale, $status);
    }else{
      $image = $cate[0][3];
      $sql = "UPDATE category SET category_name=?, gender=?, image=?, sale=?, status=? WHERE id=$id";
      pdo_execute($sql, $category_name, $gender, $image, $sale, $status);
    }
    echo '<script>
            Swal.fire({
                title: "Thông báo",
                text: "Thành công",
                icon: "success",
                confirmButtonText: "OK"
            }).then((result) => {
              // Xử lý khi người dùng nhấn vào nút "OK"
              if (result.isConfirmed) {
                  // Thực hiện hành động mong muốn khi người dùng nhấn vào nút "OK" ở đây
                  console.log("Người dùng đã nhấn vào nút OK");
                  // Ví dụ: chuyển hướng đến trang cụ thể
                  window.location.href = "http://localhost/shoes/admin/index.php?act=listcategories";
              }
            });
          </script>';
    
    // header('location: index.php?act=listcategories');
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
      <h2>Chỉnh sửa danh mục</h2>
      <button style="left: 565px; position: relative;"><a href="index.php?act=listcategories">Danh sách danh
          mục</a></button>
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
          <img id="image" width="112" height="112" src="<?php echo $cate[0][3]?>" />
          <input type="file" name="image_file" id="image_file" onchange="choose(this)" />
        </div>
        <h3>Thông tin danh mục</h3>
        <div class="cate-info">
          <div class="cate1">
            <p>
              <label for="">Tên danh mục</label><br>
              <input type="text" name="category_name" id="" placeholder="Tên danh mục" value="<?php echo $cate[0][1]?>">
            </p>
            <p>
              <label for="">Phân loại</label>
              <select name="gender" id="">
                <option value="0" <?php echo ($cate[0][2] == 0) ? 'selected' : '';?>>Nam</option>
                <option value="1" <?php echo ($cate[0][2] == 1) ? 'selected' : '';?>>Nữ</option>
              </select>
            </p>
          </div>
          <div class="cate1">
            <p>
              <label for="">Sale</label><br>
              <select name="sale" id="">
                <option value="0" <?php echo ($cate[0][4] == 0) ? 'selected' : '';?>>Not sale</option>
                <option value="1" <?php echo ($cate[0][4] == 1) ? 'selected' : '';?>>Sale</option>
              </select>
            </p>

          </div>
          <div class="status-checkbox">
            <label for="">Trạng thái</label><br>
            <label>
              <input type="radio" checked name="status" id="" value="1"
                <?php echo ($cate[0][6]) == 1 ? 'checked' : ''?>><span>Đã đăng</span>
            </label>
            <label>
              <input type="radio" name="status" id="" value="0" style="margin-left:20px"
                <?php echo ($cate[0][6]) == 0 ? 'checked' : ''?>><span>Không đăng</span>
            </label>
          </div>
        </div>
        <input type="submit" value="Chỉnh sửa" name="edit">
      </form>
    </div>
  </div>

</body>

</html>