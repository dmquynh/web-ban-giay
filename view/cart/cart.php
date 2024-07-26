<?php
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
  if(isset($_SESSION['user'])){
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
  <link rel="stylesheet" href="./assets//css//cart.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<style>
.clicksize {
  cursor: pointer;
}
</style>

<body>
  <div class="container-cart">
    <h3>Giỏ hàng của bạn</h3>
    <hr style="background-color: brown;">
    <?php
      if(isset($_SESSION['size_error'])){
        $t = $_SESSION['size_error'];
        echo $t;
        unset($_SESSION['size_error']); // Xóa thông báo sau khi hiển thị
      }
    ?>
    <table border="1">
      <tr style="height:40px">
        <th width="40px"><input type="checkbox" name="checkall1" id="checkall1"></th>
        <th class="title" style="border-right: 1px solid white;">Thông tin sản phẩm</th>
        <th style="border-right: 1px solid white;">Đơn giá</th>
        <th style="border-right: 1px solid white;">Số lượng</th>
        <th>Thành tiền</th>
      </tr>
      <?php
        if(isset($_SESSION['user'][0][0])){
          $id_customer = $_SESSION['user'][0][0];
          $sql = "SELECT * FROM cart WHERE id_customer =  $id_customer order by id desc" ;
          $res = pdo_query($sql);

          $tong = 0;
          foreach ($res as $cart) {
            extract($cart);
            $money = $money * 1000;
            $tong = $tong + $money;
            echo '<tr>
                    <td style="text-align:center"><input type="checkbox" class="product-checkbox" name="selected_products[]" value="'.$idpro.'"></td>
                    <td style="border-right: 1px solid white;">
                      <div class="pro-info">
                        <img src="./assets/'.$image.'" alt="">
                        <div class="content">
                          <a href="index.php?act=productdetail&idpro='.$idpro.'">
                            <h5>'.$name.'</h5>
                          </a>
                          <p>'.$category_name.'</p>
                          <p class="clicksize" data-idpro="'.$idpro.'">Size: '.$size.'</p>
                            <form class="form-size" action="update_size.php" method="post" style="display: none;">
                              <div class="box-size">
                                <div>Kích thước</div>
                                <div class="size">';
                                  $sql = "SELECT * FROM product
                                  JOIN img_products ON img_products.id_product = product.id
                                  JOIN detail_product ON detail_product.id_product = product.id
                                  JOIN category ON category.id=product.id_category
                                  WHERE detail_product.id_product = $idpro
                                  GROUP BY product.id";
                                  $res = pdo_query($sql);

                                  $size = explode(' -',$res[0][23]);
                                  foreach ($size as $sizes) {
                                  echo '<li>'.$sizes.'</li>';
                                  }
                                  echo '<input type="hidden" name="size" id="inputSize">';
                                  echo '</div>
                              </div>
                            </form>
                            <span><a href="index.php?act=delcart&id_pro='.$idpro.'">Xoá</a></span>
                        </div>
                        </div>
                        </td>
                        <td style="text-align: center; font-weight: bold; color:brown; border-right: 1px solid white;">'.$new_price.'</td>
                        <td style="text-align: center; border-right: 1px solid white;">
                          <div class="quantity">
                            <form method="post" action="update_quantity.php">
                              <input type="hidden" name="idpro" value="'.$idpro.'">
                              <div id="sl">
                                <div class="span1" id="decrease()" onclick="decrease('.$idpro.')"><i class="bx bx-minus"></i></div>
                                <input type="text" name="quantity" id="quantity_'.$idpro.'" value="'.$quantity.'">
                                <div class="span1" id="increase" onclick="increase('.$idpro.')"><i class="bx bx-plus"></i></div>
                              </div>
                              <input type="submit" name="update_quantity" value="Cập nhật">
                            </form>
                          </div>
                        </td>
                        <td style="text-align: center; font-weight: bold; color:brown;">'.$money.'</td>
                        </tr>';
                        }

                        echo '<tr>
                          <td colspan="5" style="padding: 20px; transform: translateX(700px);">
                            <div style="font-weight: bold;">
                              <span style="color: #454745;">Tổng tiền: <span style="margin-left: 240px; color: brown">'.$tong.'
                                </span></span>
                              <div class="pay"><a href="#" onclick="checkBox()">Thanh toán</a></div>
                            </div>
                          </td>
                        </tr>';
        }
  ?>
    </table>
  </div>
</body>

</html>
<?php } else {
  header('location: index.php?act=login');
}?>

<script src="./assets//js//cart.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>


<script>
$(document).ready(function() {
  $('.size li').click(function() {
    $('.size li').removeClass('active')
    $(this).addClass('active');
    var selectedSize = $(this).text().trim();
    // console.log(selectedSize);
    $('#inputSize').val(selectedSize);

    // lấy phần tử cha gần nhất sau đó tìm class con là .clicksize và lấy idpro
    var productId = $(this).closest('.pro-info').find('.clicksize').data('idpro');

    window.location.href = 'update_size.php?id_product=' + productId + '&size=' + selectedSize;
  })
})
</script>