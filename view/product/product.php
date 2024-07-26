<?php
    if(!isset($_SESSION)) 
    { 
      session_start(); 
    } 
?>
<style>
.sale {
  color: white;
  position: absolute;
  background: brown;
  font-size: 13px;
  padding: 2px 4px;
  top: 20px;
  left: 6px;
}

.sale::before {
  content: '';
  position: absolute;
  width: 0px;
  height: 0px;
  border-top: 8px solid #731d03;
  border-left: 5px solid transparent;
  top: 19px;
  left: 0px;
}

.sale1 {
  background: brown;
  position: relative;
  bottom: 188px;
  font-size: 13px;
  padding: 2px 4px;
  color: white;
  left: -5px;
  width: 33px;
}

.sale1::before {
  content: '';
  position: absolute;
  border-top: 8px solid #731d03;
  border-left: 5px solid transparent;
  top: 19px;
  left: 0px;
}
</style>
<div class="con">
  <div class="product">
    <?php
        if(isset($_GET['id_cate'])){
          $name_cate = $_GET['id_cate'];
          echo '<h2 style="margin-top: 20px">'.$name_cate.'</h2>';
        }
      ?>
    <?php if(isset($_GET['id_cate'])){?>
    <form action="" method="post" style="margin-top: 20px;">
      <div style="display: flex; margin-left: -28px">
        <div class="fil" style="display: none;">
          <label for=""><i>Chọn Size Giày</i></label>
          <p>
            <select name="fil1" id="">
              <option value="">Tất cả</option>
              <option value="1">48</option>
              <option value="2">47</option>
              <option value="3">46</option>
              <option value="4">45</option>
            </select>
          </p>
        </div>
        <div class="fil" style="margin-left: 30px;">
          <label for=""><i>Khoảng Giá</i></label>
          <p>
            <select name="fil1" id="">
              <option value="" <?php if (empty($_POST['fil1'])) echo 'selected'; ?>>Tất cả</option>
              <option value="1" <?php if (!empty($_POST['fil1']) && $_POST['fil1'] === '1') echo 'selected'; ?>>Dưới
                100.000đ</option>
              <option value="2" <?php if (!empty($_POST['fil1']) && $_POST['fil1'] === '2') echo 'selected'; ?>>100.000đ
                - 200.000đ</option>
              <option value="3" <?php if (!empty($_POST['fil1']) && $_POST['fil1'] === '3') echo 'selected'; ?>>200.000đ
                - 300.000đ</option>
              <option value="4" <?php if (!empty($_POST['fil1']) && $_POST['fil1'] === '4') echo 'selected'; ?>>Trên
                300.000đ</option>
            </select>
          </p>
        </div>
        <div class="fil" style="margin-left: 30px;">
          <label for=""><i>Sắp Xếp theo</i></label>
          <p>
            <select name="fil2" id="">
              <option value="" <?php  if(empty($_POST['fil2'])) echo 'selected';?>>Tất cả</option>
              <option value="1" <?php if(!empty($_POST['fil2']) && $_POST['fil2'] === '1') echo 'selected' ?>>Giá từ
                thấp đến cao</option>
              <option value="2" <?php if(!empty($_POST['fil2']) && ($_POST['fil2']) === '2') echo 'selected' ?>>Giá cao
                đến thấp</option>
            </select>
          </p>
        </div>
        <div><input type="submit" value="Tìm ngay" name="gui"></div>
      </div>
    </form>

    <?php
            $name_cate = $_GET['id_cate'];
            if (isset($_POST['gui'])) {
              $priceFilter = "";
              $orderFilter = "";
          
              $selectedPrice = "";
              if (!empty($_POST['fil1'])) {
                  switch ($_POST['fil1']) {
                      case '1':
                          $priceFilter = "AND po.new_price >= 100000 AND po.new_price <= 200000";
                          $selectedPrice = 'Dưới 100.000đ';
                          break;
                      case '2':
                        $priceFilter = "AND po.new_price BETWEEN 100.000 AND 200.000";
                        $selectedPrice = '100.000đ - 200.000đ';
                        break;
                      case '3':
                        $priceFilter = "AND po.new_price BETWEEN 200.000 AND 300.000";
                        $selectedPrice = '200.000đ - 300.000đ';
                        break;
                      case '4':
                        $priceFilter = "AND po.new_price > 300.000";
                        $selectedPrice = 'Trên 300.000đ';
                        break;
                      // Thêm các trường hợp khác nếu cần thiết
                  }
              }
          
              if (!empty($_POST['fil2'])) {
                  switch ($_POST['fil2']) {
                      case '1':
                          $orderFilter = "ORDER BY po.new_price ASC";
                          break;
                      case '2':
                          $orderFilter = "ORDER BY po.new_price DESC";
                          break;
                  }
              }

              $sql_sold = "SELECT name, SUM(quantity) AS total_sold
                          FROM order_cart
                          GROUP BY name";
              $res_sold = pdo_query($sql_sold);
          
              $sql = "SELECT po.id, ca.category_name, po.name, po.image, po.new_price, po.old_price, po.date , po.special, po.id_category, po.status, po.view
                      FROM category as ca, product as po
                      WHERE ca.id=po.id_category
                      AND po.status = 1
                      AND ca.category_name = '$name_cate' $priceFilter $orderFilter LIMIT 10";
              $res = pdo_query($sql);

              $sql = "SELECT p.id AS product_id, p.name AS product_name, MAX(vs.star) AS max_star
                      FROM product p
                      LEFT JOIN comment c ON p.id = c.id_product
                      LEFT JOIN vote_star vs ON c.id = vs.id_comment
                      GROUP BY p.id, p.name";
              $res1 = pdo_query($sql);

  
              $filterResultMessage = '';
              if(empty($res)){
                $filterResultMessage = 'Không tìm thấy dữ liệu';
              }else{
                $t = count($res);
                $filterResultMessage = 'Kết quả tìm kiếm <span style="color: brown; font-size: 22px; font-weight: bold"> ' . $t . ' </span> Sản phẩm giá  <span style="color: brown; font-size: 22px; font-weight: bold"> ' . $selectedPrice. ' </span>';
              }
  
              echo '<div class="filter-result" style="margin-top: 31px;
              font-size: 17px;">' . $filterResultMessage . '</div>';
              
              echo '<div style="display: grid;
              grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
              margin-top: 30px;">';
              foreach ($res as $list_pro) {
                extract($list_pro);
                if($special == 1){
                  $special = '<p class="sale1">- 50%</p>';
                }else{
                  $special = '';
                }
                echo '<div class="product-section">
                        <div style="padding: 7px;">
                          <div class="product-img">
                            <img src="./assets/'.$image.'" alt="">
                            <p >'.$special.'</p>
                          </div>
                          <a href="">
                            <span>'.$category_name.'</span>
                          </a>
                          <a href="index.php?act=productdetail&idpro='.$id.'">
                            <h4>'.$name.'</h4>
                          </a>';
                          echo '<div style="position: 
                          absolute; bottom: -160px;">';
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
                       echo ' <div class="star" style="display: flex; align-items: center;">
                        </div>';
              
                      echo'<div class="price" padding-top: 1px>
                            <div class="price-sale">
                              <span style="color: brown; font-weight: bold">'.$new_price.'</span>
                              <del>'.$old_price.'</del>
                            </div>
                            <div class="add-cart">
                              <form action="index.php?act=cart" method="post">
                                <input type="hidden" name="name" value="'.$name.'">
                                <input type="hidden" name="category_name" value="'.$category_name.'">
                                <input type="hidden" name="image_file" value="'.$image.'">
                                <input type="hidden" name="new_price" value="'.$new_price.'">
                                <input type="submit" value="+ Add" name="add_cart" style="display: none"> 
                              </form>
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
                                    echo '<p style="font-size: 13px;
                                    color: #00000099;
                                    margin-top: 39px;
                                    margin-left: 28px;">Đã bán ' . $sold_item['total_sold'] . '</p>';
                                    break;
                                }
                              }
                              echo '
                            </div>
                          </div>
                        </div>
                      </div>';
                    
              }
              echo '</div>';
            }else{
          
          
      ?>
    <div class="product-list">
      <?php
        if(isset($_GET['id_cate'])){
          $id_cate = $_GET['id_cate'];

          $sql_sold = "SELECT name, SUM(quantity) AS total_sold
                      FROM order_cart
                      GROUP BY name";
          $res_sold = pdo_query($sql_sold);

          $sql = "SELECT po.id, ca.category_name, po.name, po.image, po.new_price, po.old_price, po.date , po.special, po.id_category, po.status, po.view
                  FROM category as ca, product as po
                  WHERE ca.id=po.id_category
                  AND po.status = 1
                  AND ca.category_name = '$id_cate' ORDER BY po.date DESC LIMIT 10";
          $res = pdo_query($sql);

          $sql = "SELECT p.id AS product_id, p.name AS product_name, MAX(vs.star) AS max_star
              FROM product p
              LEFT JOIN comment c ON p.id = c.id_product
              LEFT JOIN vote_star vs ON c.id = vs.id_comment
              GROUP BY p.id, p.name";
          $res1 = pdo_query($sql);

          

          foreach ($res as $list_pro) {
            extract($list_pro);
            if($special == 1){
              
              $special = '<p class="sale">- 50%</p>';
            }else{
              $special = '';
            }
            echo '<div class="product-section">
                    <div style="padding: 7px;">
                      <div class="product-img">
                        <img src="./assets/'.$image.'" alt="">
                        <p>'.$special.'</p>
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
                     echo '<div class="star" style="display: flex; align-items: center;">
                        </div>';
                     echo ' <div class="price">
                        <div class="price-sale">
                          <span style="color: brown; font-weight: bold">'.$new_price.'</span>
                          <del>'.$old_price.'</del>
                        </div>
                        <div class="add-cart">
                          <form action="index.php?act=cart" method="post">
                            <input type="hidden" name="name" value="'.$name.'">
                            <input type="hidden" name="category_name" value="'.$category_name.'">
                            <input type="hidden" name="image_file" value="'.$image.'">
                            <input type="hidden" name="new_price" value="'.$new_price.'">
                            <input type="submit" value="+ Add" name="add_cart" style="display: none">
                          </form>
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
                        </div>
                      </div>
                    </div>
                  </div>';
          }
        }
         
        ?>
    </div>
    <?php }?>
  </div>
</div>
<?php }?>