<?php
if(isset($_GET['id']) && ($_GET['id']) > 0){
  $id = $_GET['id'];
  $sql = "SELECT po.id, po.name, po.image, po.new_price, po.old_price, po.des, po.view, po.special, po.date, po.likes, po.status, ca.category_name, po.id_category
  FROM category as ca, product as po WHERE ca.id= po.id_category AND po.id = $id";
  $product = pdo_query($sql);
  
  $sql = "SELECT  * FROM img_products WHERE id_product = $id";
  $img_pro = pdo_query($sql);

  $sql = "SELECT  * FROM detail_product WHERE id_product = $id";
  $det_pro = pdo_query($sql);

  $sql = "SELECT * FROM category";
  $category = pdo_query($sql);

  if(isset($_POST['edit']) && ($_POST['edit'])){
    $name = $_POST['name'];
    $special = $_POST['special'];
    $id_category = $_POST['id_category'];
    $des = $_POST['des'];
    $new_price = $_POST['new_price'];
    $old_price = $_POST['old_price'];
    $status = $_POST['status'];

    if(isset($_FILES['image_files'])){
      $files = $_FILES['image_files'];
      $file_names = $files['name'];

      if(!empty($file_names[0])){
        product_delete($id);
        foreach ($file_names as $key => $value) {
          move_uploaded_file($files['tmp_name'][$key], '../uploads/' . $value);
        }
        foreach ($file_names as $key => $value) {
          $sql = "INSERT INTO img_products(id_product	, image_pro) VALUES ('$id', '$value')";
          pdo_execute($sql);
          product_update($name, $image, $new_price, $old_price, $des, $special, $status, $id_category, $id);
        }
      }
    }

    //Kiểm tra nếu có file ảnh được tải lên
    if (!empty($_FILES["image_file"]["name"])) {
      // Nếu file ảnh không rỗng thực hiện upload
      $target_dir = "../uploads/";
      $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
      $image = $target_file;
      $uploadOk = 1;

      move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file);
      product_update($name, $image, $new_price, $old_price, $des, $special, $status, $id_category, $id);
      } else {
      // Nếu rỗng thì lấy ảnh cũ
      $image = $product[0][2]; // URL của hình ảnh cũ
      product_update($name, $image, $new_price, $old_price, $des, $special, $status, $id_category, $id);
    }

      $style = $_POST['style'];
      $high = $_POST['high'];
      $froms = $_POST['froms'];
      $material = $_POST['material'];
      $sole = $_POST['sole'];
      $color = $_POST['color'];
      $size = $_POST['size'];
      $origin = $_POST['origin'];

      detail_update($style, $high, $froms, $material, $sole, $color, $size, $origin, $id);
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
                    window.location.href = "http://localhost/shoes/admin/index.php?act=listproduct";
                }
              });
            </script>';
      
    }
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <link rel="stylesheet" href="../assets/css/add.css">
  <link rel="stylesheet" href="../assets/css/list.css">


  <!-- <link rel="stylesheet" href="../../assets/css/add.css"> -->
</head>

<style>
.cate1 input[type="text"],
.cate1 input[type="date"],
select {
  width: 289px;
}

textarea {
  padding-left: 30px;
  padding-top: 10px;
  outline: none;
  border: 1px solid rgba(0, 0, 0, 0.102);
  font-size: 16px;
  margin-top: 10px;
  border-radius: 10px;
  margin-bottom: 30px;
}

.content-right {
  width: 313px;
  height: 253px;
}

.fix {
  display: grid;
  grid-template-columns: 659px auto;
}

.product-description {
  width: 313px;
  height: 303px;
  padding-left: 20px;
  border: 1px solid rgba(0, 0, 0, 0.102);
  border-radius: 10px;
}

.product-description p label {
  font-weight: bold;
  color: rgba(0, 0, 0, 0.63);
}

.product-description p {
  height: 90px;
}

.product-description input[type=text] {
  height: 41px;
  width: 265px;
  margin-top: 10px;
  outline: none;
  padding-left: 10px;
  border: 1px solid rgba(0, 0, 0, 0.112);
  border-radius: 10px;
}

.product-description input[type="text"]:focus {
  box-shadow: 0 0 0 5px rgb(238, 127, 127);
}

.product-description input[type=text]::placeholder {
  font-weight: bold;
  color: rgba(0, 0, 0, 0.425);
}

.product-description h3 {
  height: 30px;
}

.product-description input[type=submit] {
  width: 300px;
}
</style>

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
      <h2>Chỉnh sửa sản phẩm</h2>
      <button style="margin-left: -200px;"><a href="index.php?act=addproduct">Danh sách sản phẩm</a></button>
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
      <form action="" method="post" class="fix" enctype="multipart/form-data">
        <div>
          <h3>Thông tin sản phẩm</h3>
          <div class="cate-info">
            <div class="cate1">
              <p>
                <label for="">Tên sản phẩm</label><br>
                <input type="text" name="name" id="" style="width:274px" placeholder="Tên sản phẩm"
                  value="<?php echo $product[0][1]?>">
              </p>
              <p>
                <label for="">Giảm giá 50%</label>
                <select name="special" id="">
                  <option value="0" <?php echo ($product[0]['special'] == 0) ? 'selected' : ''; ?>>Không giảm giá
                  </option>
                  <option value="1" <?php echo ($product[0]['special'] == 1) ? 'selected' : ''; ?>>Có giảm giá</option>
                </select>
              </p>
            </div>
            <div class="cate1">
              <p>
                <label for="">Danh mục</label><br>
                <select name="id_category" id="">
                  <option value="" selected>Tên danh mục</option>
                  <?php foreach ($category as $key => $value) {?>
                  <option value="<?php echo $value['id']?>"
                    <?php echo (($value['id'] == $product[0][12]) ? 'selected' : '') ?>>
                    <?php echo $value['category_name']?></option>
                  <?php }?>
                </select>
              </p>

            </div>
            <h3>Hình ảnh sản phẩm</h3><br>
          </div>
          <div class="cate-img" style="margin-top: 20px;">
            <img id="image" width="410" height="242" src="<?php echo $product[0][2]?>" />
            <input type="file" style="margin-top: 20px;" name="image_file" id="image_file" onchange="choose(this)" />
          </div>

          <div class="cate-img">
            <h3>Hình ảnh cũ</h3>
            <br>
            <div style="display: flex;">
              <?php foreach ($img_pro as $key => $value) { ?>
              <img style="width:100px; height:100px; margin-left:10px;display: inline-block;"
                src="../uploads/<?php echo $value['image_pro'] ?>" alt=""><br>
              <?php } ?>
            </div>
            <br>
            <h3>Hình ảnh mô tả</h3>
            <div id="imageContainer"></div>
            <br>

            <input type="file" name="image_files[]" id="image_files" multiple="multiple" />
            <script>
            const fileInput = document.getElementById("image_files");
            const imageContainer = document.getElementById("imageContainer");

            fileInput.addEventListener("change", function() {
              const files = fileInput.files;

              if (files.length > 0) {
                imageContainer.innerHTML = ""; // Xóa các hình ảnh trước khi hiển thị mới

                for (let i = 0; i < files.length; i++) {
                  const file = files[i];
                  const reader = new FileReader();

                  reader.onload = function(e) {
                    const imageUrl = e.target.result;
                    const img = document.createElement("img");
                    img.src = imageUrl;
                    img.style.maxWidth = "100px";
                    img.style.height = "100px";
                    img.style.marginLeft = "10px";
                    img.style.marginTop = "20px"; // Tùy chỉnh kích thước hình ảnh tại đây

                    imageContainer.appendChild(img);
                  };

                  reader.readAsDataURL(file);
                }
              } else {
                imageContainer.innerHTML = "Không có hình ảnh được chọn";
              }
            });
            </script>
          </div>

          <br>
          <h3>Mô tả sản phẩm</h3>
          <textarea name="des" id="" cols="60" rows="6" value=""><?php echo $product[0][5]?></textarea>
        </div>
        <div class="product-description">
          <h3>Giá sản phẩm</h3>
          <p>
            <label for="">Giá mới</label><br>
            <input type="text" name="new_price" id="" placeholder="Giá mới" value="<?php echo $product[0][3]?>">
          </p>
          <p>
            <label for="">Giá cũ</label><br>
            <input type="text" name="old_price" id="" placeholder="Giá cũ" value="<?php echo $product[0][4]?>">
          </p>
          <div class="status-checkbox">
            <label for="">Trạng thái</label><br>
            <label>
              <input type="radio" name="status" id="" value="1" <?php echo ($product[0][10] == 1) ? 'checked' : ''; ?>>
              <span>Đăng </span>
            </label>
            <label>
              <input type="radio" name="status" id="" value="0" <?php echo ($product[0][10] == 0) ? 'checked' : "";?>
                style="margin-left:20px">
              <span>Không đăng</span>
            </label>
          </div>


          <a id="myButton">Chỉnh sửa chi tiết</a>
          <div id="myDiv" style="display: none;">
            <a id="myButton1">X</a>
            <h3>Chỉnh sửa chi tiết sản phẩm</h3>
            <p>
              <label for="">Kiểu dáng</label><br>
              <input type="text" name="style" id="" placeholder="Kiểu dáng" value="<?php echo $det_pro[0][2]?>">
            </p>
            <p>
              <label for="">Chiều cao</label><br>
              <input type="text" name="high" id="" placeholder="Chiều cao" value="<?php echo $det_pro[0][3]?>">
            </p>
            <p>
              <label for="">From</label><br>
              <input type="text" name="froms" id="" placeholder="From" value="<?php echo $det_pro[0][4]?>">
            </p>
            <p>
              <label for="">Chất liệu</label><br>
              <input type="text" name="material" id="" placeholder="Chất liệu" value="<?php echo $det_pro[0][5]?>">
            </p>
            <p>
              <label for="">Đế</label><br>
              <input type="text" name="sole" id="" placeholder="Đế giày" value="<?php echo $det_pro[0][6]?>">
            </p>
            <p>
              <label for="">Màu sắc</label><br>
              <input type="text" name="color" id="" placeholder="Màu sắc" value="<?php echo $det_pro[0][7]?>">
            </p>
            <div style="display: grid; grid-template-columns: repeat(2,260px);">
              <p>
                <label for="">Size</label><br>
                <input type="text" name="size" id="size" placeholder="Size" style="width: 240px;"
                  value="<?php echo $det_pro[0][8]?>">
              </p>
              <p>
                <label for="">Xuất xứ</label><br>
                <input type="text" name="origin" id="origin" placeholder="Xuất xứ" style="width: 240px;"
                  value="<?php echo $det_pro[0][9]?>">
              </p>
            </div>
          </div>

          <input type="submit" value="Chỉnh sủa" name="edit">
        </div>
      </form>
    </div>
  </div>

</body>

</html>
<script>
$(document).ready(function() {
  $('.bi-three-dots-vertical').click(function() {
    $('.manage').toggle();
  })
})
</script>

<script>
var myButton = document.getElementById('myButton');
var myDiv = document.getElementById('myDiv');
var myButton1 = document.getElementById('myButton1');

myButton.addEventListener('click', function() {
  if (myDiv.style.display === 'none')
    myDiv.style.display = 'block'
  else(myDiv.style.display = 'none')
})

myButton1.addEventListener('click', function() {
  myDiv.style.display = 'none'
})
</script>