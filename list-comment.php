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

  <div class="comment">
    <?php
    if(isset($_GET['idpro'])){
      $idpro = $_GET['idpro'];
      
      $sql = "SELECT com.id, cus.image, com.name, com.title, com.text, com.prefer, com.comment_date, com.id_product, vo.star as star
      FROM customer as cus 
      JOIN comment as com ON cus.id=com.id_customer 
      JOIN vote_star as vo ON vo.id_comment=com.id
      AND com.id_product = $idpro
      ORDER BY com.comment_date desc";
      $res = pdo_query($sql);
      

      if(empty($res)){
        echo '<div style="width: 200px; padding:40px 40px; ">Không có bình luận</div>';
      }

      foreach ($res as $list_com) {
        extract($list_com);
          $img_null = './assets//images//avatar//avatar-trang.jpg';
          if(empty($image)){
            $image = $img_null;
          }else{
            
          }
          echo '<div class="customer-comment1">
                  <img src="'.$image.'" alt="">
                </div>
                <div class="customer-comment" style="padding-left:10px;">
                    <p>'.$name.'</p>';
                    for ($i = 1; $i <= $star; $i++) {
                      echo '<i class="fas fa-star" style="color: gold; margin-top:10px" data-value="'.$i.'"></i>';
                  }
                  echo '
                    <div style="margin-top: 10px;"><span>'.$comment_date.'</span></div>
                    <p style="font-size: 14px; margin-top: 16px;">'.$text.'</p>
                    <div class="likes">
                      <form action="" method="post" id="likeForm">
                        <input type="submit" style="cursor: point" name="likeCount" id="likeButton" value="&#128077;" class="like-btn" onclick="toggleLike()">
                        <span style="font-size: 14px;">Thích</span>
                        </input>
                        <span id="likeStatus" style="font-size: 14px;">'.$prefer.'</span>
                        <input type="hidden" value='.$id.' name="id_comment">
                        <input type="hidden" id="likeCount" name="likeCount" />
                      </form>
                    </div>
                </div>';
      }
    }
  ?>
    <?php
      if(isset($_POST['likeCount'])){
        $id_comment = $_POST['id_comment'];
        // echo $id_comment;
        $sql = "UPDATE comment SET prefer = prefer + 1 WHERE id=$id_comment";
        pdo_execute($sql);

        echo '<script>window.location.href = "list-comment.php?idpro='.$idpro.'";</script>';
    exit();
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

<?php
  // Code PHP hiện có của bạn...
?>
<!-- Phần mã HTML và PHP của bạn -->