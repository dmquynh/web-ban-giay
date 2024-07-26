<?php
 
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
  if(isset($_SESSION['user'])){
    $_SESSION['user'];
  }
?>
<?php
  if(isset($_SESSION['user'][0][0])){
    if(isset($_GET['idpro'])) {
      $selectedProductIds = explode(',', $_GET['idpro']);
      $phi = 19000 ;
      
      $tong = 0;
      foreach ($selectedProductIds as $product_id) {
        $id_customer = $_SESSION['user'][0][0];
        $sql = "SELECT * FROM cart WHERE id_customer =  $id_customer AND idpro = $product_id order by id desc" ;
        $res = pdo_query($sql);
       
        foreach ($res as $cart) {
          extract($cart);
          $money = $money * 1000;
          $tong += $money;

          echo '<div style="display: none"><tr>
                  <td style="border-right: 1px solid white;">
                    <div class="pro-info">
                      <img style="" src="./assets/'.$image.'" alt="">
                      <div class="content">
                        <a href="index.php?act=productdetail&idpro='.$idpro.'">
                          <h5>'.$name.'</h5>
                        </a>
                        <p>'.$category_name.'</p>
                        <p>'.$size.'</p>
                      </div>
                    </div>
                  </td>
                  <td style="text-align: center; font-weight: bold; color:brown; border-right: 1px solid white;">'.$new_price.'</td>
                  <td style="text-align: center; border-right: 1px solid white;">
                    <div class="quantity">
                        <div id="sl">
                          <input type="text" name="quantity" id="quantity_'.$idpro.'" value="'.$quantity.'">
                        </div>
                    </div>
                  </td>
                  <td style="text-align: center; font-weight: bold; color:brown;">'.$money.'</td>
                  </tr>
          </div>';
        }
      }
      $sum = $tong + $phi;
      echo '<div style="display: none"><tr>
            <td colspan="5" style="padding: 20px; transform: translateX(700px);">
              <div style="font-weight: bold;">
                <span style="color: #454745;">Tổng tiền: <span style="margin-left: 240px; color: brown">'.$tong.'
                  </span></span>
                
              </div>
            </td>
          </tr></div>';
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./assets//css//checkout.css">
  <link rel="stylesheet" href="./assets//css//cart.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
  $('#province').change(function() {
    var provinceId = $(this).val();
    $.ajax({
      type: 'POST',
      url: 'get_district.php', // Đường dẫn đến tệp xử lý AJAX
      data: {
        id_province: provinceId
      },
      success: function(data) {
        $('#district').html(data);
      }
    });
  });
});
</script>

<script>
$(document).ready(function() {
  $('#district').change(function() {
    var districtId = $(this).val();
    $.ajax({
      type: 'POST',
      url: 'get_wards.php', // Đường dẫn đến tệp xử lý AJAX
      data: {
        districtId: districtId
      },
      success: function(data) {
        $('#ward').html(data);
      }
    });
  });
});
</script>

<body>
  <div class="container-checkout">
    <h4 style="padding: 20px;">ĐỊA CHỈ GIAO HÀNG</h4>
    <hr>
    <form action="" method="post">
      <div class="box-wrapper">
        <div class="left">
          <p>Họ tên người nhận</p>
          <p>Email</p>
          <p>Số điện thoại</p>
          <p>Tỉnh/Thành phố</p>
          <p>Quận/Huyện</p>
          <p>Phường/Xã</p>
          <p>Địa chỉ nhận hàng</p>
        </div>
        <div class="right">
          <p><input type="text" name="name" id="" placeholder="Nhập họ và tên người nhận"></p>
          <p><input type="text" name="email" id="" placeholder="Nhập Email"> </p>
          <p><input type="text" name="phone" id="" placeholder="Ví dụ: 0979123xxx (10 ký tự số)"></p>
          <p>
            <select name="province" id="province" class="province">
              <option value="0">Tỉnh/thành phố</option>
              <?php
                $sql = "SELECT * FROM province";
                $province = pdo_query($sql);

                foreach ($province as $list_province) {
                  extract($list_province);
                
              ?>
              <option value="<?=$id?>"><?=$name?></option>
              <?php }?>
            </select>
          </p>

          <p>
            <select name="district" id="district" class="district">
              <option value="0">Quận/huyện</option>
            </select>
          </p>

          <p>
            <select name="ward" id="ward">
              <option value="0">Phường/xã</option>
            </select>
          </p>

          <p><input type="text" name="address" id="" placeholder="Nhập địa chỉ nhận hàng"> </p>
          <input type="hidden" name="money" id="" value="<?=$sum?>">

          <?php
            if(isset($_SESSION['user'][0][0])){
              if(isset($_GET['idpro'])) {
                $selectedProductIds = explode(',', $_GET['idpro']);
                // print_r($selectedProductIds) ;
                foreach ($selectedProductIds as $k) {
                  echo '<input type="hidden" name="idpro[]" value="'.$k.'">';
                }
              }
            }
          ?>
          <input type="hidden" name="id_customer" id="" value="<?=$_SESSION['user'][0][0]?>">

        </div>
      </div>


      <div style="margin-top: 50px; background: #e9f0ea;">
        <h4 style="padding: 20px;">PHƯƠNG THỨC THANH TOÁN</h4>
        <div class="payment">
          <label>
            <input type="radio" name="payment" id="" value="2">
            <img src="./assets//images//svg//ico_cashondelivery.svg" alt="" style="margin-left: 10px;">
            <span>Thanh toán Momo</span>
          </label>

          <label>
            <input type="radio" name="payment" id="d" value="1">
            <img src="./assets//images//svg//ico_vnpay.svg" alt="" style="margin-left: 10px;">
            <span>VNPAY</span>
          </label>

          <label>
            <input type="radio" name="payment" checked id="" value="0">
            <img src="./assets//images//svg//ico_cashondelivery.svg" alt="" style="margin-left: 10px;">
            <span>Thanh toán bằng tiền mặt khi nhận hàng</span>
          </label>
        </div>

        <div class="confirm">
          <div style="float: right; margin-right: -20px; margin-top: 10px;">
            <div class="paid">
              <div class="paid1" style="margin-left: -50px;">
                <p>Thành tiền</p>
                <p>Phí vận chuyển (Giao hàng tiêu chuẩn)</p>
                <p><b>Tổng Số Tiền (gồm VAT)</b></p>
              </div>
              <div class="paid1">
                <p style="display: flex; justify-content: right; margin-right: 106px;"><?=$tong?>đ</p>
                <p style="display: flex; justify-content: right; margin-right: 106px;"><?=$phi?> đ</p>
                <p style="font-weight: bold; color:brown; font-size: 20px; margin-left: 18px;"><?=$sum?> đ</p>
              </div>
            </div>
            <p><input type="submit" value="Xác nhận thanh toán" name="pay"></p>
            <hr>
          </div>
          <div class="back">
            <a href="index.php?act=cart"><i class='bx bx-arrow-back'></i> Quay về giỏ hàng</a>
          </div>
        </div>
      </div>
    </form>


    <div style=" margin-top: 60px; background: #e9f0ea;">
      <h4 style="padding: 20px;">KIỂM TRA LẠI ĐƠN HÀNG</h4>
      <table border="1">
        <tr style="height:40px">
          <th class="title" style="border-right: 1px solid white;">Thông tin sản phẩm</th>
          <th style="border-right: 1px solid white;">Đơn giá</th>
          <th style="border-right: 1px solid white;">Số lượng</th>
          <th>Thành tiền</th>
        </tr>
        <?php
          if(isset($_SESSION['user'][0][0])){
            if(isset($_GET['idpro'])) {
              $selectedProductIds = explode(',', $_GET['idpro']);
              $tong = 0;
              foreach ($selectedProductIds as $product_id) {
                $id_customer = $_SESSION['user'][0][0];
                $sql = "SELECT * FROM cart WHERE id_customer =  $id_customer AND idpro = $product_id order by id desc" ;
                $res = pdo_query($sql);
                
                foreach ($res as $cart) {
                  extract($cart);
                  $money = $money * 1000;
                  $tong += $money;

                  echo '<tr>
                          <td style="border-right: 1px solid white;">
                            <div class="pro-info">
                              <span>'.$id.'</span>
                              <img src="./assets/'.$image.'" alt="">
                              <div class="content">
                                <a href="index.php?act=productdetail&idpro='.$idpro.'">
                                  <h5>'.$name.'</h5>
                                </a>
                                <p>'.$category_name.'</p>
                                <p>Size: '.$size.'</p>
                              </div>
                            </div>
                          </td>
                          <td style="text-align: center; font-weight: bold; color:brown; border-right: 1px solid white;">'.$new_price.'</td>
                          <td style="text-align: center; border-right: 1px solid white;">
                            <div class="quantity">
                                <div id="sl">
                                  <input type="text" name="quantity" id="quantity_'.$idpro.'" value="'.$quantity.'">
                                </div>
                            </div>
                          </td>
                          <td style="text-align: center; font-weight: bold; color:brown;">'.$money.'</td>
                          </tr>';
                }
              }
              $phi = 19000;
              $sum = $tong + $phi;
              echo '<tr>
                    <td colspan="5" style="padding: 20px; transform: translateX(700px);">
                      <div style="font-weight: bold;">
                        <span style="color: #454745;">Tổng tiền: <span style="margin-left: 240px; color: brown">'.$sum.' 
                          </span></span>
                        
                      </div>
                    </td>
                  </tr>';
            }
          }
        ?>
      </table>
    </div>

  </div>
</body>

</html>