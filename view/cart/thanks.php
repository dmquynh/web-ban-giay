<?php
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 

  if(isset($_SESSION['id_order'])){
    if(isset($_GET['vnp_Amount'])){
    $vnp_Amount= $_GET['vnp_Amount'];
    $vnp_BankCode=$_GET['vnp_BankCode'];
    $vnp_BankTranNo=$_GET['vnp_BankTranNo'];
    $vnp_OrderInfo=$_GET['vnp_OrderInfo'];
    $vnp_PayDate=$_GET['vnp_PayDate'];
    $vnp_TmnCode=$_GET['vnp_TmnCode'];
    $vnp_TransactionNo=$_GET['vnp_TransactionNo'];
    $vnp_CardType=$_GET['vnp_CardType'];
    $id_order = $_SESSION['id_order'];
    
    $sql = "INSERT INTO vn_pay(vnp_amount,	vnp_bankCode,	vnp_banktranno,	vnp_orderinfo,	vnp_paydate,	vnp_tmncode,	vnp_transactionno,	vnp_cardtype,	id_order)
    VALUES ('$vnp_Amount',	'$vnp_BankCode',	'$vnp_BankTranNo',	'$vnp_OrderInfo',	'$vnp_PayDate',	'$vnp_TmnCode',	'$vnp_TransactionNo',	'$vnp_CardType',	'$id_order')";
    pdo_execute($sql);

    header('location: index.php?act=success');
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
  .container-thanks {
    margin-left: 90px;
    margin-right: 90px;
    margin-top: 20px;
  }
  </style>
</head>

<body>
  <div class="container-thanks">
    <p>Cảm ơn bạn đã mua hàng</p>
  </div>
</body>

</html>