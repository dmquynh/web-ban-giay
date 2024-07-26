<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ShoesShop - Thế Giới Giày</title>
  <link rel="icon" href="./assets//images//logo//logo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,600&family=Roboto:wght@300;400&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./assets//css//style.css">
  <script src="./assets//js//index.js"></script>
</head>

<body>
  <div class="container">
    <div class='header'>
      <div class="head">
        <span style="margin-left: 100px;">Ưu đãi siêu giá trị - Tiết kiệm nhiều hơn với phiếu giảm
          giá</span>
        <div class="account">
          <?php
            
            if(isset($_SESSION['user'][0][0]) && ($_SESSION['user'][0][0] > 0)){
              
                $sql = "SELECT * FROM customer WHERE id =  " . $_SESSION['user'][0][0]  ;
                $res = pdo_query($sql);
                
                $img = "./assets/images/avatar//avatar-trang.jpg";
                
                if($res[0][5] == ''){
                  $res[0][5] = $img;
                }else{
                  
                }
              echo '<div style="margin-left:-20px; display: flex">
                      <div style="width: 20px">
                        <img src="'.$res[0][5].'"" alt="" style="width: 20px; height:20px; border-radius: 50%">
                      </div>
                      <div>
                        <a href="index.php?act=user">'.$res[0][1].'</a>
                        <a href="index.php?act=logout">Đăng xuất</a>
                      </div>
                    </div>';
              }
            else{
              
          ?>
          <a href="index.php?act=login">Đăng Nhập</a>
          <a href="index.php?act=signup">Đăng Ký</a>

          <?php }?>
        </div>
      </div>
      <div class="head-below">
        <div class="logo">
          <a href="index.php">
            <img src="./assets/images/logo/ShoeShop.png
            " alt="">
          </a>
        </div>
        <div class="search">
          <form action="index.php?act=filter" method="post">
            <div style="display: flex; justify-content: center; align-items: center;">
              <input type="text" name="keyword" id=""
                value="<?php echo isset($_POST['keyword']) ? ($_POST['keyword']) : ''; ?>"
                placeholder="Tìm kiếm sản phẩm">
            </div>
          </form>
        </div>
        <div class="cart">
          <a href="index.php?act=favourite" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart"
              viewBox="0 0 16 16">
              <path
                d="m8 2.748-.717-.737C5.6.281 2.516.878 1.4 3.053c-.523 1.023-.641 2.5.316 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.316-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.163c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
            </svg>
          </a>

          <a href="index.php?act=cart">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart2"
              viewBox="0 0 16 16">
              <path
                d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H16.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.16 5l1.25 5h8.22l1.25-5H3.16zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
            </svg>
            <?php
              if(isset($_SESSION['user'][0][0])){
                $id_customer = $_SESSION['user'][0][0];
                $sql = "SELECT * , COUNT(idpro) FROM cart WHERE id_customer like '$id_customer' GROUP BY id_customer";
                $res = pdo_query($sql);
               
                if(empty($res)){
                  $res[0][10] = 0;
                }
               
            ?>
            <span class="count-cart"><?=$res[0][10]?></span>

            <?php }?>

          </a>
        </div>
      </div>
    </div>

    <div class="nav">
      <li><a href="index.php">Trang chủ</a></li>
      <li style="z-index: 1;">
        <a href="#">
          <div class="down">
            Giày nữ
            <div class="icon-down">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                class="bi bi-chevron-down" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                  d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
              </svg>
            </div>
          </div>
        </a>
        <ul class="submenu">
          <?php
            $sql = "SELECT * FROM category WHERE gender like 1";
            $res = pdo_query($sql);

            foreach ($res as $cate_female) {
              extract($cate_female);
              $t = str_replace(' ', '+', $category_name);
              echo '<li><a href="index.php?act=product&id_cate='.$t.'">'.$category_name.'</a></li>';
            }
          ?>
        </ul>
      </li>

      <li style="z-index: 1;"><a href="#" class="">
          <div class="down">
            Giày nam
            <div class="icon-down">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                class="bi bi-chevron-down" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                  d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
              </svg>
            </div>
          </div>
        </a>
        <ul class="submenu" style="margin-left:80px">
          <?php
            $sql = "SELECT * FROM category WHERE gender like 0";
            $res = pdo_query($sql);

            
            foreach ($res as $cate_male) {
              extract($cate_male);
              
              $t = str_replace(' ', '+', $category_name);
              
              echo '<li><a href="index.php?act=product&id_cate='.$t.'">'.$category_name.'</a></li>';
            }
          ?>
        </ul>
      </li>
      <li><a href="index.php?act=contact">Liên hệ</a></li>
      <li><a href="">Tin tức</a></li>
      <li><a href="">Yêu thích</a></li>
    </div>

    <hr style="margin-top:15px">