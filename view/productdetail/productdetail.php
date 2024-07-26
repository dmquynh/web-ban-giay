<?php
   if(!isset($_SESSION)) 
   { 
       session_start(); 
   } 
   require './dao/product.php';
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
  <link rel="stylesheet" href="./assets//css//productdetail.css">
</head>

<style>
.product {
  margin-left: 0%;
}
</style>

<body>

  <div class="container-detail">
    <?php 
      foreach ($res as $detail) {
    ?>
    <div class="product-detail">
      <div class="left">
        <div class="slideshow-container">
          <div class="slides">
            <?php
              $sql = "SELECT po.id, po.image, img.image_pro 
                      FROM product as po, img_products as img 
                      WHERE po.id = img.id_product AND id_product = $idpro";
              $slide_img = pdo_query($sql);
              
              foreach ($slide_img as $imgs) {
                extract($imgs);
                echo '<img class="active" src="./uploads/'.$image_pro.'" alt="Slide 1" />';
              }
            ?>
          </div>
          <p class="prev1" href="#">&#10094;</p>
          <p class="next1" href="#">&#10095;</p>
        </div>
        <div class="gallery">
          <?php
            $sql = "SELECT po.id, po.image, img.image_pro 
            FROM product as po, img_products as img 
            WHERE po.id = img.id_product AND id_product = $idpro";
            $slide_img = pdo_query($sql);
            
            foreach ($slide_img as $imgs) {
              extract($imgs);
              echo '<img src="./uploads/'.$image_pro.'" alt="Slide 1" />';
            }
          ?>
        </div>
      </div>
      <div class="right">
        <h4><?=$res[0][1]?></h4>
        <div style="font-size: 15px;">
          <!-- SELECT * , COUNT(text) as reviews FROM `comment` GROUP BY id_product; -->
          <?php
          if(isset($_GET['idpro'])){
            $idpro = $_GET['idpro'];

            $sql = "UPDATE product SET view = view + 1 WHERE id = $idpro";
            pdo_execute($sql);
            
            $sql = "SELECT id_product, star, star_ratings 
                    FROM ( SELECT c.id_product, vs.star, COUNT(*) AS star_ratings, ROW_NUMBER() 
                    OVER(PARTITION BY c.id_product ORDER BY COUNT(*) DESC) AS rn 
                    FROM comment c INNER JOIN vote_star vs ON c.id = vs.id_comment 
                    GROUP BY c.id_product, vs.star ) ranked 
                    WHERE rn = 1 AND id_product = $idpro";
            $res1 = pdo_query($sql);

            foreach ($res1 as $vote) {
              extract($vote);
              for ($i = 1; $i <= $star; $i++) {
                echo '<i class="bx bxs-star" style="color: gold;" data-value="'.$i.'"></i>';
              }
              echo '<span style="margin-left:20px">'.$star_ratings.' Đánh giá</span>';
            }
          }
        ?>

        </div>
        <div class="price1">
          <h3><?=$res[0][3]?></h3>
          <del><?=$res[0][4]?></del>
        </div>
        <form action="" method="post" style="margin-top: 7px;">
          <div class="box-size">
            <div>Kích thước</div>
            <div class="size">
              <?php
                $size = explode(' -',$res[0][23]);
                foreach ($size as $sizes) {
                  echo '<li>'.$sizes.'</li>';
                }
              ?>
            </div>
          </div>
        </form>

        <p style="margin-top: 30px;"><a href="">Hướng Dẫn Tính Size</a></p>
        <form action="index.php?act=cart" method="post" style="margin-left: 20px; ">
          <div class="box-quantity">
            <div
              style="display: flex; justify-content: center; align-items: center; margin-left: -45px; margin-top: -30px;">
              <a style="margin-right: 10px;">Số lượng</a>
              <span onclick="decrease()"><i class='bx bx-minus'></i></span>
              <input type="text" name="quantity" value="1" id="quantity">
              <span onclick="increase()"><i class='bx bx-plus'></i></span>
            </div>
          </div>
          <div style="display: flex; margin-top: 23px; margin-left: -45px;">
            <form action="" method="post">
              <input type="submit" id="buy" name="add_cart" value="Mua ngay" style="width:200px">
            </form>
            <input type="hidden" name="idpro" value="<?=$res[0][0]?>">
            <input type="hidden" name="name" value="<?=$res[0][1]?>">
            <input type="hidden" name="category_name" value="<?=$res[0][26]?>">
            <input type="hidden" name="image_file" value="<?=$res[0][2]?>">
            <input type="hidden" name="new_price" value="<?=$res[0][3]?>">
            <input type="hidden" name="size" id="inputSize">
            <a href=""><input type="submit" value="Thêm vào giỏ hàng" id="add_cart" name="add_cart"></a>
        </form>
      </div>
    </div>
  </div>
  <?php }?>

  <div class="wrapper">
    <div class="tabs">
      <ul class="nav-tabs">
        <li class="active"><a href="#menu_1"> CHI TIẾT SẢN PHẨM</a></li>
        <li><a href="#menu_2">ĐÁNH GIÁ</a></li>
        <li><a href="#menu_3">BÌNH LUẬN</a></li>
      </ul>
      <div class="tab-content">
        <div id="menu_1" class="tab-content-item">
          <h5 style="font-size: 15px; color: #1c1c1c; margin-left: 10px; margin-top: 15px;">MÔ TẢ SẢN PHẨM : Giày
            Sandal Nam MWC - 7071
          </h5>
          <div style="margin-left: 20px; margin-top: 10px; font-size: 14px; line-height: 30px;">
            <?=$res[0][5]?>
          </div>
          <h5 style="font-size: 15px; color: #1c1c1c; margin-left: 10px; margin-top: 10px;">CHI TIẾT SẢN PHẨM</h5>
          <div style="margin-left: 20px; margin-top: 10px; font-size: 14px; line-height: 30px;">
            <li>Kiểu dáng : <?=$res[0][17]?></li>
            <?php
              if($res[0][19] == ''){
                $res[0][19] = '';
              }else{
            ?>
            <li>From : <?=$res[0][19]?></li>
            <?php }?>
            <li>Chất liệu : <?=$res[0][20]?> </li>
            <li>Đế : <?=$res[0][21]?></li>
            <li>Màu sắc : <?=$res[0][22]?></li>
            <li>Size : <?=$res[0][23]?></li>
            <li>Xuất sứ thương hiệu : <?=$res[0][24]?></li>
          </div>
        </div>
        <div id="menu_2" class="tab-content-item">
          <?php
            if(isset($_SESSION['user'])){

          ?>
          <iframe src="comment.php?idpro=<?=$_GET['idpro']?>" width="100%" height="505px" target="_page"
            frameborder="0"></iframe>
          <?php } else {
            echo '<div class="not">Vui lòng đăng nhập để bình luận & đánh giá sản phẩm!</div>';
          }?>
        </div>

        <div id="menu_3" class="tab-content-item">
          <div>
            <?php
              if(isset($_SESSION['user'])){
            ?>
            <iframe src="list-comment.php?idpro=<?=$_GET['idpro']?>" target="_page" width="100%" height="400px"
              frameborder="0" id="ko"></iframe>
            <?php } else {
              if(isset($_GET['idpro'])){
                $idpro = $_GET['idpro'];      
                $sql = "SELECT cus.image, com.name, com.title, com.text, com.prefer, com.comment_date, com.id_product 
                        FROM customer as cus, comment as com 
                        WHERE cus.id=com.id_customer AND com.id_product = $idpro
                        ORDER BY com.comment_date desc";
                $res = pdo_query($sql);
                if(empty($res)){
                  echo '<div class="not" id="show">Không có Bình luận</div>';
                }
              } 
            }?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
  <div class="con">
    <div class="product">
      <h2>Có thể bạn cũng thích</h2>
      <div class="product-list">
        <?php
          $sql_sold = "SELECT product.special, order_cart.name, SUM(quantity) AS total_sold
          FROM order_cart
          JOIN product ON product.name=order_cart.name WHERE product.special = 0
          GROUP BY name";
          $res_sold = pdo_query($sql_sold);
          // echo '<pre>';
          // print_r($res_sold);
          
          if(isset($_GET['idpro'])){
            $idpro = $_GET['idpro'];
          }
            $sql = "SELECT po.id, po.image, po.name, ca.category_name, po.status, po.new_price, po.old_price, po.date, po.status, po.special
                    FROM category as ca, product as po 
                    WHERE ca.id=po.id_category 
                    AND po.status = 1 
                    AND po.special = 0 
                    AND po.id NOT IN ('$idpro') 
                    ORDER BY po.date desc limit 5";
            $res = pdo_query($sql);

            $sql = "SELECT p.id AS product_id, p.name AS product_name, MAX(vs.star) AS max_star
              FROM product p
              LEFT JOIN comment c ON p.id = c.id_product
              LEFT JOIN vote_star vs ON c.id = vs.id_comment
              GROUP BY p.id, p.name";
        $res1 = pdo_query($sql);
  
            echo '<div style="display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
            
            gap: 25px; margin-top: 10px">';
              foreach ($res as $list_pro) {
                extract($list_pro);
                
                echo '<div class="product-section">
                        <div style="padding: 7px;">
                          <div class="product-img">
                            <img src="./assets/'.$image.'" alt="">
                          </div>
                          <a href="">
                            <span>'.$category_name.'</span>
                          </a>
                          <a href="index.php?act=productdetail&idpro='.$id.'">
                            <h4>'.$name.'</h4>
                          </a>';
                          echo '<div style="position: absolute; bottom: 70px;">';
                          foreach ($res1 as $star) {
                            if ($list_pro['id'] === $star['product_id']) {
                                $max_star = $star['max_star'];
                                for ($i = 1; $i <= $max_star; $i++) {
                                    echo '<i class="bx bxs-star" style="color: gold;" data-value="'.$i.'"></i>';
                                }
                                break;
                            }
                          }
                          echo '</div>';
                          echo '
                          <div class="star" style="display: flex; align-items: center;">
                          </div>';
                            
                          echo '<div class="price">
                            <div class="price-sale">
                              <span style="color: brown; font-weight: bold;">'.$new_price.'</span>
                              <del>'.$old_price.'</del>
                            </div>
                            <div class="add-cart">
                              <form action="index.php?act=cart" method="post">
                                <input type="hidden" name="name" value="'.$name.'">
                                <input type="hidden" name="category_name" value="'.$category_name.'">
                                <input type="hidden" name="image_file" value="'.$image.'">
                                <input type="hidden" name="new_price" value="'.$new_price.'">
                                <input style="display: none;" type="submit" value="+ Add" name="add_cart">
                              </form>
                            </div>
                          </div>';
                          foreach ($res_sold as $sold_item) {
                            if ($list_pro['name'] === $sold_item['name']) {
                                echo '<p style="margin-top: -1px; font-size: 12px; margin-left: 144px; color: #0000008c;">Đã bán ' . $sold_item['total_sold'] . '</p>';
                                break;
                            }
                          }
                          echo '
                        </div>
                      </div>';
                  
              }
            echo  '</div>'; 
          ?>
      </div>
    </div>
  </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script>
$(document).ready(function() {
  $('.tab-content-item').hide();
  $('.tab-content-item:first-child').fadeIn();
  $('.nav-tabs li').click(function() {
    $('.nav-tabs li').removeClass('active');
    $(this).addClass('active');
    let id_tab_content = $(this).children('a').attr('href');
    $('.tab-content-item').hide();
    $(id_tab_content).fadeIn();
    return false;
  })
})
</script>

<script>
$(document).ready(function() {
  $('.size li').click(function() {
    $('.size li').removeClass('active')
    $(this).addClass('active');
    var selectedSize = $(this).text();
    $('#inputSize').val(selectedSize);
  })
})
</script>

<script>
let likeCount = 0;

function toggleLike() {
  const likeButton = document.getElementById("likeButton");
  const likeStatus = document.getElementById("likeStatus");
  const likeForm = document.getElementById("likeForm");
  const likeCountInput = document.getElementById("likeCount");

  if (likeButton.innerHTML === "Like") {
    likeCount++;
    likeButton.innerHTML = "Unlike";
    likeStatus.textContent = likeCount + " person likes this.";
  } else {
    likeCount--;
    likeButton.innerHTML = "Like";
    likeStatus.textContent =
      likeCount > 0 ?
      likeCount + " people like this." :
      "Be the first one to like this.";
  }

  likeCountInput.value = likeCount;
}
</script>

<script>
var i = 1;
var sl = document.getElementById('quantity');

function increase() {
  i++;
  sl.value = i;
}

function decrease() {
  if (i > 1) {
    i--;
    sl.value = i;
  }
}
</script>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script>
$(document).ready(function() {
  var slideIndex = 0;
  showSlides(slideIndex);

  $(".prev1").click(function() {
    slideIndex--;
    showSlides(slideIndex);
  });

  $(".next1").click(function() {
    slideIndex++;
    showSlides(slideIndex);
  });

  $(".gallery img").click(function() {
    slideIndex = $(".gallery img").index(this);
    // console.log(slideIndex);
    showSlides(slideIndex);
  });

  function showSlides(n) {
    var slides = $(".slides img");
    var thumbnails = $(".gallery img");
    if (n >= slides.length) {
      slideIndex = 0;
    }
    if (n < 0) {
      slideIndex = slides.length - 1;
    }
    slides.hide();
    slides.eq(slideIndex).show();
    // khi gallery được click thì add active
    thumbnails.removeClass("active");
    thumbnails.eq(slideIndex).addClass("active");

    // khi next hình ảnh tiếp theo thì ẩn hình ảnh trước đó
    thumbnails.hide();
    var thumbnailSlice = thumbnails.slice(slideIndex, slideIndex + 4);
    thumbnailSlice.show();
  }
});
</script>


</html>