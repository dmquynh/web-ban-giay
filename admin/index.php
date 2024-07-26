<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<?php
  require './global.php';
 
  ob_start();

  require '../dao/pdo.php';
  require '../dao/category.php';
  require '../dao/product.php';

  require './view/header.php';
  require './view/menu.php';
  if(isset($_GET['act'])){
    
    switch ($_GET['act']) {
      case 'listproduct':
        require './products/listproduct.php';
      break;

      case 'addproduct':
        if(isset($_POST['add']) && ($_POST['add'])){
          // lấy dữ liệu từ form
          $name = $_POST['name'];
          $special = $_POST['special'];
          $id_category = $_POST['id_category'];
          $des = $_POST['des'];
          $new_price = $_POST['new_price'];
          $old_price = $_POST['old_price'];
          $status = $_POST['status'];

          $sql = "SELECT * FROM product WHERE name = '$name'";
          $result = pdo_query($sql);

          if($result && count($result) > 0){
            echo '<script>
                    Swal.fire({
                        title: "Thông báo",
                        text: "Đã có sản phẩm",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                  </script>';
          }else{
            // uploads ảnh chi tiết sản phẩm
          if(isset($_FILES['image_files'])){
            $files = $_FILES['image_files'];
            $file_names = $files['name'];
            foreach ($file_names as $key => $value) {
              move_uploaded_file($files['tmp_name'][$key], '../uploads/' . $value);
            }
          }
  
          // upload ảnh sản phẩm lấy id
          $target_dir = "../uploads/";
          $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
          $image = $target_file;
          $uploadOk = 1;
          move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file);
          $id_pro = product_insert($name,	$image,	$new_price,	$old_price,	$des,	$special, $status,	$id_category);
          foreach ($file_names as $key => $value) {
            insert_img_products($id_pro, $value);
            $conn = null;
          }
          
          // insert chi tiết sản phẩm
          $style = $_POST['style'];
          $high = $_POST['high'];
          $froms = $_POST['froms'];
          $material = $_POST['material'];
          $sole = $_POST['sole'];
          $color = $_POST['color'];
          $size = $_POST['size'];
          $origin = $_POST['origin'];
         
          insert_detail_product($id_pro,	$style,	$high, $froms,	$material, $sole,	$color,	$size,	$origin);
          echo '<script>
                  Swal.fire({
                      title: "Thông báo",
                      text: "Thêm thành công",
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
          // header('location: index.php?act=listproduct');
          }
        }
        require './products/addproduct.php';
      break;

      case 'delcate':
        require_once './categories/delcate.php';
      break;

      case 'editcate':

        require_once './categories/editcate.php';
      break;

      case 'listcategories':
        require './categories/listcategories.php';
      break;

      case 'addcategories':
        if(isset($_POST['add-product']) && ($_POST['add-product'])){
          $category_name = $_POST['category_name'];
          $gender = $_POST['gender'];
          $sale = $_POST['sale'];
          $status = $_POST['status'];

          $target_dir = "../uploads/";
          $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
          $image = $target_file;
          $uploadOk = 1;
          move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file);

          category_insert( $category_name, $gender, $image, $sale, $status);
          echo '<script>
                  Swal.fire({
                      title: "Thông báo",
                      text: "Thêm thành công",
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
          // $thongbao = 'Thêm thành công đi đến trang<a href="index.php?act=addproduct"> Thêm sản phẩm</a>';
        }

        require './categories/addcategories.php';
      break;

      case 'delproduct':
        require './products/delproduct.php';
      break;

      case 'editproduct':
        require './products/editproduct.php';
      break;
      
      case 'listcustomer':
        require './customer/listcustomer.php';
      break;

      case 'addcustomer':
        if(isset($_POST['addcustomer']) && ($_POST['addcustomer'])){
          $name = $_POST['name'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $role = $_POST['role'];
          $password1 = $_POST['password1'];

          $sql = "INSERT INTO customer (name, email, password, role) VALUES (?,?,?,?)";
          pdo_execute($sql, $name, $email, $password, $role);
          header('location: index.php?act=listcustomer');
        }
        require './customer/addcustomer.php';
      break;

      case 'delcustomer':
        require_once './customer/delcustomer.php';
      break;

      case 'editcustomer':
        require_once './customer/editcustomer.php';
      break;

      case 'list-order':
        require './order/list-order.php';
      break;

      case 'edit-order':
        require './order/edit-order.php';
      break;

      case 'listcomment':
        require './comment/listcomment.php';
      break;
      
      default:
        # code...
        break;
    }
  }else{
    require './view/home.php';
  }
  
  require './view/footer.php';

?>