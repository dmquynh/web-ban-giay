<?php
  if(isset($_GET['id']) && ($_GET['id']) > 0){
    $id = $_GET['id'];
    
    $sql = "DELETE FROM customer WHERE id = $id";
    pdo_execute($sql);

    header('location: index.php?act=listcustomer');
    // $sql = "SELECT * FROM category WHERE id = $id";
    // $res = pdo_query($sql);

    
    
    // header('location: index.php?act=listcategories');
  }
?>