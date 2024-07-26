<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<div class="con" style="margin-top: 10px;">
  <div class="product">
    <h2>Sản Phẩm Phổ Biến</h2>
    <div class="product-list">
      <?php
        $sql_sold = "SELECT name, SUM(quantity) AS total_sold
                    FROM order_cart
                    GROUP BY name";
        $res_sold = pdo_query($sql_sold);
        
        $sql = "SELECT po.id, po.image, po.name, ca.category_name, po.status, po.new_price, po.old_price, po.date, po.status, po.special, po.view
                FROM category as ca, product as po 
                WHERE ca.id=po.id_category AND po.status = 1 AND po.special = 0  ORDER BY po.date desc limit 10";
        $res = pdo_query($sql);

        $sql = "SELECT p.id AS product_id, p.name AS product_name, MAX(vs.star) AS max_star
              FROM product p
              LEFT JOIN comment c ON p.id = c.id_product
              LEFT JOIN vote_star vs ON c.id = vs.id_comment
              GROUP BY p.id, p.name";
        $res1 = pdo_query($sql);
        
        foreach ($res as $list_pro) {
          extract($list_pro);
          
          echo '<div class="product-section">
                  <div style="padding: 7px;">
                    <div class="product-img">
                      <img src="./assets/'.$image.'" alt="" >
                    </div>
                    <a href="">
                      <span>'.$category_name.'</span>
                    </a>
                    <a href="index.php?act=productdetail&idpro='.$id.'">
                      <h4>'.$name.'</h4>
                    </a>';
                    echo '<div style="position: absolute; bottom: 457px;">';
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
                        <div class="view" style="display: none">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye"
                            viewBox="0 0 16 16">
                              <path
                                  d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                              <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                          </svg> '.$view.'
                        </div>';
                        foreach ($res_sold as $sold_item) {
                          if ($list_pro['name'] === $sold_item['name']) {
                              echo '<p style="margin-top: 42px; font-size: 12px; margin-left: 25px; color: #0000008c;">Đã bán ' . $sold_item['total_sold'] . '</p>';
                              break;
                          }
                        }
                        echo '
                        
                        <form action="index.php?act=cart" method="post">
                          <input type="hidden" name="name" value="'.$name.'">
                          <input type="hidden" name="category_name" value="'.$category_name.'">
                          <input type="hidden" name="image_file" value="'.$image.'">
                          <input type="hidden" name="new_price" value="'.$new_price.'">
                          <input style="display: none;" type="submit" value="+ Add" name="add_cart">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>';
        }
      ?>

    </div>
  </div>
</div>