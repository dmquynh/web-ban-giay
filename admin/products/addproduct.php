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
  color: rgba(0, 0, 0, 0.525);

  /* color: red; */
  font-weight: bold;
  font-size: 15px;
}

.product-description input[type=text]::placeholder {
  color: rgba(0, 0, 0, 0.425);
  /* color: red; */
  font-weight: bold;
  font-size: 15px;
}

.product-description input[type="text"]:focus {
  box-shadow: 0 0 0 4px brown;
}


.product-description h3 {
  height: 30px;
  /* margin-top: -18px; */
}

.product-description input[type=submit] {
  width: 300px;
}

button {
  cursor: pointer;
}

.imageContainer {
  background-color: red;
}
</style>

<body>
  <div class="container-products">
    <div class="head">
      <h2>Thêm sản phẩm</h2>
      <a href="index.php?act=listproduct"><button style="margin-left: -140px;">Danh sách sản phẩm</button></a>
    </div>
    <?php
        require './global.php';
        if(isset($_GET['act'])){
          echo '<div class="url">
                <a href="'.$home.'">'.$base_url.' / </a> 
                <a href="">'.$_GET['act'].'</a>
              </div>';
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
                <input type="text" name="name" id="" style="width:274px" placeholder="Tên sản phẩm">
              </p>
              <p>
                <label for="">Giảm giá 50%</label><br>
                <select name="special" id="" style="width: 270px">
                  <option value="0" selected>Không</option>
                  <option value="1">Giảm giá 50%</option>
                </select>
              </p>
            </div>
            <div class="cate1">
              <p>
                <label for="">Danh mục</label><br>
                <select name="id_category" id="">
                  <option value="" selected>Danh mục</option>
                  <?php
                    $sql = "SELECT * FROM category";
                    $res = pdo_query($sql);

                    foreach ($res as $cate) {
                      extract($cate);
                      echo '<option value='.$id.'>'.$category_name.'</option>';
                    }
                  ?>
                </select>
              </p>

            </div>
            <h3>Hình ảnh sản phẩm</h3><br>
          </div>
          <div class="cate-img">
            <img id="image" width="410" height="282" />
            <input type="file" name="image_file" id="image_file" onchange="choose(this)" />
          </div>

          <div class="cate-img">
            <h3>Ảnh mô tả</h3><br>
            <input type="file" name="image_files[]" id="image_files" multiple="multiple" />
            <div id="imageContainer"></div>

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
          <!-- <input type="text" name="size[]" id=""> -->
          <br>
          <h3>Mô tả sản phẩm</h3>
          <textarea name="des" id="" cols="60" rows="8"></textarea>
        </div>
        <div class="product-description">
          <h3>Giá sản phẩm</h3>
          <p>
            <label for="">Giá mới</label><br>
            <input type="text" name="new_price" id="v" placeholder="Giá mới">
          </p>
          <p>
            <label for="">Giá cũ</label><br>
            <input type="text" name="old_price" id="" placeholder="Giá cũ">
          </p>
          <div class="status-checkbox">
            <label for="">Trạng thái</label><br>
            <label>
              <input type="radio" name="status" id="" value="1"><span>Đăng</span>
            </label>
            <label>
              <input type="radio" name="status" id="" value="0" style="margin-left:20px"><span>Không đăng</span>
            </label>
          </div>

          <a id="myButton">Thêm chi tiết</a>
          <div id="myDiv" style="display: none;">
            <a id="myButton1">X</a>
            <h3 style="margin-top: -18px;">Chi tiết sản phẩm</h3>
            <p>
              <label for="">Kiểu dáng</label><br>
              <input type="text" name="style" id="" placeholder="Kiểu dáng">
            </p>

            <p>
              <label for="">Chiều cao</label><br>
              <input type="text" name="high" id="" placeholder="Chiều cao">
            </p>

            <p>
              <label for="">From</label><br>
              <input type="text" name="froms" id="" placeholder="From">
            </p>

            <p>
              <label for="">Chất liệu</label><br>
              <input type="text" name="material" id="" placeholder="Chất liệu">
            </p>

            <p>
              <label for="">Đế</label><br>
              <input type="text" name="sole" id="" placeholder="Đế giày">
            </p>

            <p>
              <label for="">Màu sắc</label><br>
              <input type="text" name="color" id="" placeholder="Màu sắc">
            </p>

            <div style="display: grid; grid-template-columns: repeat(2,260px);">
              <p>
                <label for="">Size</label><br>
                <input type="text" name="size" id="" placeholder="Size" style="width: 240px;">
              </p>
              <p>
                <label for="">Xuất xứ</label><br>
                <input type="text" name="origin" id="" placeholder="Xuất xứ" style="width: 240px;">
              </p>
            </div>
          </div>
          <input type="submit" value="Tạo sản phẩm" name="add">
      </form>
    </div>
  </div>

  <?php
  ?>

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
  if (myDiv.style.display === 'none') {
    myDiv.style.display = 'block';
    myDiv.style.animation = '0.3s iden linear'
  } else {
    myDiv.style.display = 'none';
  }
})

myButton1.addEventListener('click', function() {

  myDiv.style.display = 'none'

})
</script>

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