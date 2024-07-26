<?php
   if(!isset($_SESSION)) 
   { 
       session_start(); 
   } 
   require './dao/pdo.php';
   require './dao/comment.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700&family=Poppins:wght@300;400;600;700&family=Roboto&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="./assets//css//productdetail.css">
</head>
<style>
body {
  font-family: "Inter", sans-serif;
  font-family: "Poppins", sans-serif;
  font-family: "Roboto", sans-serif;
}
</style>

<body>
  <div id="menu_2" class="tab-content-item">
    <?php
    if(isset($_SESSION['user'])){
      
    }else{
      $_SESSION['user'] = '0';
    }
      $sql = "SELECT * FROM customer WHERE id = ".$_SESSION['user'][0][0];
      $res = pdo_query($sql); 
  ?>
    <form action="" method="post">
      <div style="display: flex;">
        <p>
          <label for="">Họ tên</label><br>
          <input type="text" name="name" id="" placeholder="Họ tên"
            value="<?php if(isset($res[0][1]) == '') echo $res[0][1] = ''; else echo $res[0][1] ?>">
        </p>

        <input type="hidden" name="id_product" id="" placeholder="Họ tên" value="<?=$_GET['idpro']?>">

        <p>
          <label for="">Số điện thoại</label><br>
          <input type="text" name="phone" id="" placeholder="Số điện thoại"
            value="<?php if(isset($res[0][2]) == '') echo $res[0][2] = ''; else echo $res[0][2] ?>">
        </p>
        <p>
          <label for="">Email</label><br>
          <input type="text" name="email" id="" placeholder="Email">
        </p>
      </div>
      <div style="margin-top: 20px;">
        <p>
          <label for="">Tiêu đề</label><br>
          <input style="width: 98.5%;" type="text" name="title" id="" placeholder="">
        </p>
      </div>
      <div>
        <p style="margin-top: 20px;">Số sao đánh giá</p>
        <div class="star">
          <i class="far fa-star" data-value="1"></i>
          <i class="far fa-star" data-value="2"></i>
          <i class="far fa-star" data-value="3"></i>
          <i class="far fa-star" data-value="4"></i>
          <i class="far fa-star" data-value="5"></i>
        </div>
        <input type="hidden" name="star" id="take_star">

      </div>
      <div style="margin-top: 30px;">
        <p>Nội dung</p>
        <textarea name="text" id="" cols="135" rows="5"></textarea>
      </div>
      <input type="submit" name="send" value="Gửi">
    </form>
    <?php
      if(isset($_GET['idpro'])){
        $idpro = $_GET['idpro'];
      }
      if(isset($_POST['send'])){
        $name = $_POST['name'];
        $id_product = $_POST['id_product'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $title = $_POST['title'];
        $star = $_POST['star'];
        $text = $_POST['text'];
        $id_customer = $_SESSION['user'][0][0];
        
        $id_comment = comment_insert($name, $id_product,	$phone, $email, $title, $text, $id_customer);
        $sql = "INSERT INTO vote_star( id_comment, star) VALUE ('$id_comment', '$star')";
        pdo_execute($sql);
        echo '<script>
                Swal.fire({
                    title: "Thông báo",
                    text: "Đã gửi bình luận",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                  // Xử lý khi người dùng nhấn vào nút "OK"
                  if (result.isConfirmed) {
                      // Thực hiện hành động mong muốn khi người dùng nhấn vào nút "OK" ở đây
                      console.log("Người dùng đã nhấn vào nút OK");
                      // Ví dụ: chuyển hướng đến trang cụ thể
                      window.parent.location.href = "http://localhost/shoes/index.php?act=productdetail&idpro='.$idpro.'";
                  }
                });
                
        </script>';
        
              
      }
    ?>
  </div>

</body>

</html>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script>
$(document).ready(function() {
  $(".star i").click(function() {
    let value = $(this).attr("data-value");
    $(".star i").removeClass("fas").addClass("far"); // Đặt lại tất cả sao về trạng thái không chọn
    $(this).prevAll().addBack().removeClass("far").addClass("fas"); // Chọn sao và các sao trước đó
    $('#take_star').val(value);
  });
});
</script>