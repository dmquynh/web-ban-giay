<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<div>
  <div class="time-sale">
    <h2>Khung Giờ Sale</h2>

    <div class="sale-section">
      <div class="sale-col">
        <div class="banner-sale">
          <img src="./assets/images//banner/banner-sale.jpg" alt="">
          <div>
            <div id="countdown" style="margin: 0 auto; top: -442px; left: -2px;"></div>
          </div>
        </div>

      </div>

      <?php
        $sql_sold = " SELECT product.special, order_cart.name, SUM(quantity) AS total_sold
        FROM order_cart
        JOIN product ON product.name=order_cart.name WHERE product.special = 1
        GROUP BY name";
        $res_sold = pdo_query($sql_sold);

        $sql = "SELECT p.id AS product_id, p.name AS product_name, MAX(vs.star) AS max_star, p.special
              FROM product p
              LEFT JOIN comment c ON p.id = c.id_product
              LEFT JOIN vote_star vs ON c.id = vs.id_comment WHERE p.special = 1
              GROUP BY p.id, p.name";
        $res1 = pdo_query($sql);

        $sql = "SELECT  po.id, po.image, po.name, ca.category_name, po.status, po.new_price, po.old_price, po.date, po.status, po.special, po.view
                FROM category as ca, product as po 
                WHERE ca.id=po.id_category AND po.status = 1 AND po.special = 1 ORDER BY po.date desc limit 3";
        $res = pdo_query($sql);
  
        foreach ($res as $time_sale) {
          extract($time_sale);
          echo '<div class="sale-col">
                  <div style="padding: 7px;">
                    <div class="sale-img">
                      <img src="./assets/'.$image.'" alt="">
                    </div>
                    <div style="margin-top:20px">
                      <a href="" style="top: -3px;">
                        <span>'.$category_name.'</span>
                      </a>
                      <a href="index.php?act=productdetail&idpro='.$id.'" style="margin-top: 37px;
                      font-size: 15px;">
                        <h4 style="font-size: 17px">'.$name.'</h4>
                      </a>';
                      
                      echo '<div style="position: absolute; top: 2557px;">';
                      foreach ($res1 as $star) {
                        if ($time_sale['id'] === $star['product_id']) {
                            $max_star = $star['max_star'];
                            for ($i = 1; $i <= $max_star; $i++) {
                                echo '<i class="bx bxs-star" style="color: gold;" data-value="'.$i.'"></i>';
                            }
                            break;
                        }
                      }
                     echo '</div>';
                      
                     echo '
                    </div>
                    <div class="price-sale1">
                      <div class="price-new-old">
                        <span style="color: brown;
                        font-weight: bold;">'.$new_price.'</span>
                        <del style="top: 15px;">'.$old_price.'</del>
                      </div>
                    </div>';

                    
                    foreach ($res_sold as $sold_item) {
                      if ($time_sale['name'] === $sold_item['name']) {
                          echo '<p style="font-size: 13px;
                          margin-left: 192px;
                          color: #0000007d;">Đã bán ' . $sold_item['total_sold'] . '</p>';
                          break;
                      }
                    }
                    echo'
                    <div class="view" style="right: -99px; display: none">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye"
                        viewBox="0 0 16 16">
                          <path
                              d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                          <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                      </svg> '.$view.'
                    </div> 
                </div>
              </div>';
          }
        
      ?>
    </div>
  </div>
</div>