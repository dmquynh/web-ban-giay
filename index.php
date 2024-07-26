<?php require 'visit.php' ?>
<div style="margin: 0 auto; width:1349px">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="path/to/fontawesome-free-5.x.x.min.css" />

  <style>
  div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm {
    margin-top: 130px;
  }

  div:where(.swal2-container) div:where(.swal2-popup) {
    height: 340px;
  }
  </style>
  <?php
      if(!isset($_SESSION)) 
      { 
          session_start(); 
      } 
      ob_start();
      
      require_once './dao/customer.php';
      require './dao/cart.php';
      require './dao/order.php';
      require './view/header.php';
      require './dao/detail_product.php';
      if(isset($_GET['act'])){
        switch ($_GET['act']) {
          case 'contact':
            require './view/contact/concact.php';
            break;

          case 'login':
            if(isset($_POST['login']) && ($_POST['login'])){
              $name = $_POST['name'];
              $password = $_POST['password'];
  
              $res = login_customer($name, $password);
  
              if (empty($_POST['name'])) {
                  $error['name']['required'] = "Vui lòng nhập tên đăng nhập";
              }

              if (empty($_POST['password'])) {
                  $error['password'] = "Vui lòng nhập mật khẩu";
              }
             
              if (empty($error)) {
                  if (empty($res)) {
                      $thongbao = 'Tài khoản hoặc mật khẩu không chính xác';
                  }
                  if(!empty($res)){
                    $_SESSION['user'] = $res;
                    if($res[0][12] == 1){
                      header('location: /shoes/admin/');
                    }else{
                      header('location: ./index.php');
                    }
                  }
              }else{
                // $thongbao = 'Vui lòng nhập vào tài khoản và mật khẩu';
              }
            
            }
            
            require './view/account/login.php';
            break;

          case 'signup':
            if(isset($_POST['signup']) && ($_POST['signup'])){
              $name = $_POST['name'];
              $email = $_POST['email'];
              $password = $_POST['password'];
              $role = 0;

              $error = [];
                // check tên đăng nhập
                if (empty($_POST['name'])) {
                    $error['name']['required'] = "*Vui lòng nhập tên tài khoản";
                } else {
                    if (strlen(trim($_POST['name'])) < 6) {
                        $error['name']['min'] = "*Tên tài khoản phải từ 6 ký tự";
                    // } else {
                    //     // $par = '/^[a-zA-Z 0-9]+$/';
                    //     // $par = '/^(?=.*[a-z0-9])(?=.*[A-Z])[a-zA-Z0-9]+$/';
                    //     $par = '/^(?=.*[A-Z])(?=.*\d).+$/';
                    //     if (!preg_match($par, $_POST['name'])) {
                    //         $error['name']['check'] = "*Tên tài khoản phải có một ký tự viết hoa và có một chữ số";
                    //     }
                     }
                }

                // check email
                if (empty($_POST['email'])) {
                    $error['email']['required'] = "*Vui lòng nhập email của bạn";
                } else {
                    $par = '/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/';
                    if (!preg_match($par, $_POST['email'])) {
                        $error['email']['check'] = "*Vui lòng nhập email hợp lệ";
                    }
                }

                // check mật khẩu
                if (empty($_POST['password'])) {
                    $error['password']['required'] = "*Vui lòng nhập mật khẩu của bạn";
                } else {
                    $par = '/^(?=.*[A-Z])(?=.*\d)(?=.*\W)/'; //phải chứa ít nhất một chữ hoa ([A-Z]), một chữ số (\d) và một ký tự đặc biệt (\W) 
                    if (!preg_match($par, $_POST['password'])) {
                        $error['password']['check'] = "*Mật khẩu phải có 1 ký tự đặt biệt và chữ sỗ, chữ hoa";
                    } else {
                        if (strlen(trim($_POST['password'])) < 8) {
                            $error['password']['min'] = "*Vui lòng nhập mật khẩu từ 8 ký tự";
                        }
                    }
                }

                // check xác nhận mật khẩu
                if (empty($_POST['password1'])) {
                    $error['password1']['required'] = "*Vui lòng xác nhận lại mật khẩu của bạn";
                } else {
                    if ($_POST['password1'] != $_POST['password']) {
                        $error['password']['check'] = "*Mật khẩu không khớp";
                    }
                }

                if (empty($error)) {
                    $sql = "SELECT * FROM customer WHERE name='" . $name . "'";
                    $data = pdo_query($sql);

                    if ($_POST['name'] != empty($data)) {
                        $thongbao = 'Tên tài khoản đã tồn tại';
                    } else {
                      customer_insert($name, $email, $password, $role);
                      header('location: index.php?act=login');
                    }
                } else {
                    $thongbao =  'Đăng ký thất bại';
                }
            }
            require './view/account/signup.php';
            break;
          case 'logout':
            session_unset();
            header('location: ./index.php');
            break;

          case 'cart':
            if(isset($_POST['add_cart'])){
              if(isset($_POST['size']) && !empty($_POST['size'])){
              // Đoạn mã trước khi thêm vào giỏ hàng
              $id_customer = $_SESSION['user'][0][0];
              $idpro = $_POST['idpro'];

              // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng của người dùng hay chưa
              $sql_check = "SELECT * FROM cart WHERE id_customer = ? AND idpro = ?";
              $result = pdo_query($sql_check, $id_customer, $idpro);
             
              if ($result && count($result) > 0){
                echo '<script>
                        Swal.fire({
                            title: "Thông báo",
                            text: "Sản phẩm đã có trong giỏ hàng của bạn",
                            icon: "warning",
                            confirmButtonText: "OK"
                        });
                      </script>';
                // echo 'đã có';
              }else{
                $name = $_POST['name'];
                $category_name = $_POST['category_name'];
                $image_file = $_POST['image_file'];
                $new_price = $_POST['new_price'];
                $quantity = $_POST['quantity'];
                $money = ((float)$quantity)  * ((float)$new_price); 

                if(isset($_SESSION['user'])){
                  $id_customer = $_SESSION['user'][0][0];
                }
                $idpro = $_POST['idpro'];
                $size = $_POST['size'];

                if(!isset($_SESSION['user'])){
                  header('location: index.php?act=login');
                }else{
                  insert_cart($name, $category_name, $image_file, $new_price, $size, $quantity, $money,	$id_customer, $idpro);
                  header('location: index.php?act=cart');
                }
              }
             
            }else{
              echo '<script>
                  Swal.fire({
                      title: "Thông báo",
                      text: "Vui lòng chọn size trước khi thêm vào giỏ hàng",
                      icon: "warning",
                      confirmButtonText: "OK"
                  }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back(); // Go back to the previous page
                    }
                });
                </script>';
            }
          }
            require './view/cart/cart.php';
          break;

          case 'delcart':
            if(isset($_GET['id_pro'])){
              $del_pro = $_GET['id_pro'];
             
              del_cart($del_pro);
              header('Location: index.php?act=cart');
              exit(); 
            }
            require './view/cart/cart.php';
          break;

          case 'productdetail':
            if(isset($_GET['idpro']) && ($_GET['idpro'] > 0)){
              $idpro = $_GET['idpro'];
              $res = select_detail_product($idpro);
            }
            require './view/productdetail/productdetail.php';
          break;

          case 'product':
            require './view/product/product.php';
          break;

          case 'checkout':
            if(isset($_POST['pay'])){
              $name = $_POST['name'];
              $email = $_POST['email'];
              $phone = $_POST['phone'];
              $province = $_POST['province'];
              $district = $_POST['district'];
              $ward = $_POST['ward'];
              $address = $_POST['address'];
              $money = $_POST['money'];
              $id_customer = $_POST['id_customer'];
              $payment = $_POST['payment'];
              $ma_dh = '#100' . rand(0, 999999);

              $tongtien = 0;
              $sql = "SELECT * FROM orders WHERE id_customer = $id_customer";
              $res = pdo_query($sql);
              extract($res);

              if($payment == 1){
                if(isset($_POST['payment'])){
                  $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                  $vnp_TmnCode = "CGXZLS0Z";//Mã website tại VNPAY 
                  $vnp_HashSecret = "XNBCJFAKAZQSGTARRLGCHVZWCIOIGSHN"; //Chuỗi bí mật
                  $vnp_Returnurl = "http://localhost/shoes/index.php?act=thanks";
                  $vnp_TxnRef = rand(0, 9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
                  $vnp_OrderInfo = 'Nội dung thanh toán';
                  $vnp_OrderType = 'billpayment';
                  $vnp_Amount = $money * 100;
                  $vnp_Locale = 'vn';
                  $vnp_BankCode = 'NCB';
                  $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
                  
                  $inputData = array(
                      "vnp_Version" => "2.1.0",
                      "vnp_TmnCode" => $vnp_TmnCode,
                      "vnp_Amount" => $vnp_Amount,
                      "vnp_Command" => "pay",
                      "vnp_CreateDate" => date('YmdHis'),
                      "vnp_CurrCode" => "VND",
                      "vnp_IpAddr" => $vnp_IpAddr,
                      "vnp_Locale" => $vnp_Locale,
                      "vnp_OrderInfo" => $vnp_OrderInfo,
                      "vnp_OrderType" => $vnp_OrderType,
                      "vnp_ReturnUrl" => $vnp_Returnurl,
                      "vnp_TxnRef" => $vnp_TxnRef, 
                  );

                  if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                  }
  
                  ksort($inputData);
                  $query = "";
                  $i = 0;
                  $hashdata = "";
                  foreach ($inputData as $key => $value) {
                      if ($i == 1) {
                          $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                      } else {
                          $hashdata .= urlencode($key) . "=" . urlencode($value);
                          $i = 1;
                      }
                      $query .= urlencode($key) . "=" . urlencode($value) . '&';
                  }

                  $vnp_Url = $vnp_Url . "?" . $query;
                  if (isset($vnp_HashSecret)) {
                      $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                      $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                  }
                  $returnData = array('code' => '00'
                      , 'message' => 'success'
                      , 'data' => $vnp_Url);
                      if (isset($_POST['payment'])) {
                        $id_order = orders_insert($name, $email, $phone, $province,	$district, $ward,	$address,	$money,	$id_customer,	$payment, $ma_dh);
                        $_SESSION['id_order'] = $id_order;
                        if(isset($_SESSION['user'][0][0])){
                          if(isset($_GET['idpro'])) {
                            $selectedProductIds = explode(',', $_GET['idpro']);
                            $tong = 0;
                            foreach ($selectedProductIds as $product_id) {
                              $id_customer = $_SESSION['user'][0][0];
                              $sql = "SELECT * FROM cart WHERE id_customer =  $id_customer AND idpro = $product_id order by id desc" ;
                              $res = pdo_query($sql);
        
                              foreach ($res as $cart_order) {
                                extract($cart_order);
                                
                                $sql = "INSERT INTO order_cart (name,	image,	new_price, size,	quantity,	money,	id_order)
                                VALUES ('$name'	,'$image',	'$new_price', '$size',	'$quantity',	'$money',	'$id_order')";
                                pdo_execute($sql);
                              }
                            }
                            // xoá cart khi thanh toán thành công
                            del_cart_pay($id_customer, $product_id);
                          }
                          foreach ($selectedProductIds as $product_id) {
                            // xoá cart khi thanh toán thành công
                            del_cart_pay($id_customer, $product_id);
                          }
                        }
                          header('Location: ' . $vnp_Url);
                          die();
                      } else {
                          echo json_encode($returnData);
                      }
                }
                
              }
              else if($payment == 0){
                $id_order = orders_insert($name, $email, $phone, $province,	$district, $ward,	$address,	$money,	$id_customer,	$payment, $ma_dh);

                if(isset($_SESSION['user'][0][0])){
                  if(isset($_GET['idpro'])) {
                    $selectedProductIds = explode(',', $_GET['idpro']);
                    
                    $tong = 0;
                    foreach ($selectedProductIds as $product_id) {
                      $id_customer = $_SESSION['user'][0][0];
                      $sql = "SELECT * FROM cart WHERE id_customer =  $id_customer AND idpro = $product_id order by id desc" ;
                      $res = pdo_query($sql);
                      $money = $money * 1000;

                      foreach ($res as $cart_order) {
                        extract($cart_order);
                        $sql = "INSERT INTO order_cart (name,	image,	new_price, size,	quantity,	money,	id_order)
                        VALUES ('$name'	,'$image',	'$new_price', '$size',	'$quantity',	'$money',	'$id_order')";
                        pdo_execute($sql);
                      } 
                    }
                  }
                  foreach ($selectedProductIds as $product_id) {
                     // xoá cart khi thanh toán thành công
                     del_cart_pay($id_customer, $product_id);
                  }
                }
                echo '<script>
                      Swal.fire({
                          title: "Thông báo",
                          text: "Đặt hàng thành công",
                          icon: "success",
                          confirmButtonText: "OK"
                      }).then((result) => {
                        // Xử lý khi người dùng nhấn vào nút "OK"
                        if (result.isConfirmed) {
                            // Thực hiện hành động mong muốn khi người dùng nhấn vào nút "OK" ở đây
                            console.log("Người dùng đã nhấn vào nút OK");
                            // Ví dụ: chuyển hướng đến trang cụ thể
                            window.location.href = "http://localhost/shoes/index.php?act=success";
                        }
                      });
                    </script>';
                }else{
                  echo 'momo';
                }
            }
            require './view/cart/checkout.php';
          break;

          case 'success':
            require './view/cart/success.php';
          break;

          case 'order_detail':
            require './view/cart/order_detail.php';
          break;

          case 'view_order_detail':
            require './view/cart/view_order_detail.php';
          break;

          case 'thanks':
            require './view/cart/thanks.php';
          break;

          case 'user':
            require './view/user/index.php';
          break;

          case 'update_info':
            if(isset($_SESSION['user'][0][0])){
              $id_customer = $_SESSION['user'][0][0];
              $sql = "SELECT * FROM customer WHERE  id = $id_customer";
              $res = pdo_query($sql);
            }
           
            if(isset($_POST['update_info'])){
              $name = $_POST['name'];
              $firstname = $_POST['firstname'];
              $phone = $_POST['phone'];
              $email = $_POST['email'];
              $gender = $_POST['gender'];
              $day_birth = $_POST['day_birth'];
              $month_birth = $_POST['month_birth'];
              $year_birth = $_POST['year_birth'];
              $id_customer = $_POST['id_customer'];
             
              if(!empty($_FILES["image_file"]["name"])){
                $target_dir = "./uploads/";
                $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
                $image = $target_file;
                $uploadOk = 1;
                move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file);
                update_info_customer($name, $phone, $email, $image, $gender, $firstname, $day_birth, $month_birth, $year_birth, $id_customer);
              }else{
                $image = $res[0][5];
                update_info_customer($name, $phone, $email, $image, $gender, $firstname, $day_birth, $month_birth, $year_birth, $id_customer);
              }
              echo '<script>
                      Swal.fire({
                          title: "Thông báo",
                          text: "Đã lưu thay đổi",
                          icon: "success",
                          confirmButtonText: "OK"
                      }).then((result) => {
                        // Xử lý khi người dùng nhấn vào nút "OK"
                        if (result.isConfirmed) {
                            // Thực hiện hành động mong muốn khi người dùng nhấn vào nút "OK" ở đây
                            console.log("Người dùng đã nhấn vào nút OK");
                            // Ví dụ: chuyển hướng đến trang cụ thể
                            window.location.href = "https://localhost/shoes//index.php?act=user";
                        }
                      });
                    </script>';
            }
            require './view/user/index.php';
          break;

          case 'order':
            require './view/user/index.php';
          break;

          case 'change_pass':
            require './view/user/index.php';
          break;

          case 'view_order':
            require './view/user/index.php';
          break;

          case 'forget':
            function guimatkhaumoi($email, $matkhaumoi)
            {
                require "./PHPMailer/PHPMailer/src/PHPMailer.php";
                require "./PHPMailer/PHPMailer/src/SMTP.php";
                require "./PHPMailer/PHPMailer/src/Exception.php";
                $mail = new PHPMailer\PHPMailer\PHPMailer(true); //true:enables exceptions
                try {
                    $mail->SMTPDebug = 0; //0,1,2: chế độ debug
                    $mail->isSMTP();
                    $mail->CharSet  = "utf-8";
                    $mail->Host = 'smtp.gmail.com';  //SMTP servers
                    $mail->SMTPAuth = true; // Enable authentication
                    $mail->Username = 'phatnvps33455@fpt.edu.vn'; // SMTP username
                    $mail->Password = 'dtaijqpbihmjtbnw';   // SMTP password
                    $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
                    $mail->Port = 465;  // port to connect to                
                    $mail->setFrom('phatnvps33455@fpt.edu.vn', 'ShoesShop');
                    $mail->addAddress($email);
                    $mail->isHTML(true);  // Set email format to HTML
                    $mail->Subject = 'Thư gửi lại mật khẩu mới';
                    $noidungthu = "<p style='color: black'>Chào bạn, Bạn nhận được thư này, do bạn gửi yêu cầu mật khẩu mới từ website của chúng tôi</p>
                        Mật khẩu mới của bạn là <p style='color: red; font-weight: bold; font-size: 20px'>{$matkhaumoi}</p>";
                    $mail->Body = $noidungthu;
                    $mail->smtpConnect(array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                            "allow_self_signed" => true
                        )
                    ));
                    $mail->send();
                    echo '<script>
                            Swal.fire({
                                title: "Thông báo",
                                text: "Mật khẩu đã được gửi đến địa chỉ email '.$email.'. Vui lòng kiểm tra email.",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then((result) => {
                              // Xử lý khi người dùng nhấn vào nút "OK"
                              if (result.isConfirmed) {
                                  // Thực hiện hành động mong muốn khi người dùng nhấn vào nút "OK" ở đây
                                  console.log("Người dùng đã nhấn vào nút OK");
                                  // Ví dụ: chuyển hướng đến trang cụ thể
                                  window.location.href = "http://localhost/shoes/index.php?act=login";
                              }
                            });
                          </script>';
                } catch (Exception $e) {
                    echo 'Error: ', $mail->ErrorInfo;
                }
            }
              if (isset($_POST['forget']) && ($_POST['forget']) == true) {
                $email = $_POST['email'];
                $sql = "SELECT * FROM customer WHERE email = '$email'";
                $r = pdo_query($sql);

                $matkhaumoi = $r[0][11];

                if (empty($r)) {
                    echo 'Email không tồn tại trong hệ thống';
                } else {
                    guimatkhaumoi($email, $matkhaumoi);   
                }
              }
            require './view/account/forget.php';
          break;

          case 'filter':
            if(isset($_POST['keyword'])){
              $keyword = $_POST['keyword'];
             
              if($keyword != ""){

                // Truy vấn này tính tổng số lượng của mỗi sản phẩm dựa trên bảng 'order_cart' và lưu kết quả vào biến $res_sold.
                $sql_sold = "SELECT name, SUM(quantity) AS total_sold
                            FROM order_cart
                            GROUP BY name";
                $res_sold = pdo_query($sql_sold);
                // Truy vấn này lấy thông tin của các sản phẩm và danh mục từ bảng 'product' và 'category' dựa trên 'keyword' và lưu vào biến $res.
                  $sql = "SELECT po.id, po.image, po.name, ca.category_name, po.status, po.new_price, po.old_price, po.date, po.status, po.special
                          FROM category as ca, product as po 
                          WHERE ca.id=po.id_category 
                          AND po.status = 1 
                          AND po.name like '%$keyword%'
                          ORDER BY po.date desc limit 10";
                  $res = pdo_query($sql);
                  // Hiển thị một grid chứa thông tin của các sản phẩm được lấy từ $res.
                echo '<div style="display: grid;
                          grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
                          margin-left: 122px;
                          margin-right: 122px;
                          gap: 14px; margin-top: 30px">';
                  foreach ($res as $list_pro) {
                    extract($list_pro); // Chuyển các giá trị của mảng thành các biến riêng lẻ
                    if($special == 1){
                      $special = '<p class="sale1">- 50%</p>';
                    }else{
                      $special = '';
                    }
                    
                    echo '<div class="product-section">
                            <div style="padding: 15px;">
                              <div class="product-img">
                                <img src="./assets/'.$image.'" alt="">
                                <p >'.$special.'</p>
                              </div>
                              <a href="">
                                <span>'.$category_name.'</span>
                              </a>
                              <a href="index.php?act=productdetail&idpro='.$id.'">
                                <h4>'.$name.'</h4>
                              </a>

                              <div class="star" style="display: flex; align-items: center;">
                              </div>';
                              
                             echo ' <div class="price">
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
                              // Hiển thị số lượng đã bán của mỗi sản phẩm đã bán:
                              foreach ($res_sold as $sold_item) {
                                if ($list_pro['name'] === $sold_item['name']) {
                                    echo '<p style="margin-top: -10px; font-size: 12px; margin-left: 129px; color: #0000008c;">Đã bán ' . $sold_item['total_sold'] . '</p>';
                                    break;
                                }
                              }
                              echo '
                            </div>
                          </div>';
                       
                  }
                echo  '</div>'; 
                  // Nếu 'keyword' rỗng, chuyển hướng người dùng về trang chủ.
              }else{
                header('location:index.php');
              }
              // Chuyển hướng nếu không có 'keyword':
            }else{
              header('location:index.php');
              
            }
          break;
            require './view/product/product.php';
          
          case 'cate_sale';
            require './view/cate_sale/cate_sale.php';
          break;

          default:
            # code...
            break;
        }
      }else{
        require './view/banner.php';
        require './view/hot.php';
        require './view/home.php';
        require './view/timesale.php';
      }
      require './view/footer.php';
  ?>
</div>