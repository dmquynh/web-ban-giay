<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<div class="con" style="margin-top: 10px;">
  <div class="product">
    <div style="display: flex; padding-top: 40px">
      <div><img src="./assets//images//logo//sale.png" alt=""></div>
      <div style="margin-left: 30px;">
        <div id="countdown1"></div>
      </div>
    </div>
    <div class="product-list">
      <?php
        if(isset($_GET['idcate'])){
          $idcate = $_GET['idcate'];
        }
        $sql = "SELECT po.id, po.image, po.name, ca.category_name, po.status, po.new_price, po.old_price, po.date, po.status, po.special, po.view, po.id_category
                FROM category as ca, product as po 
                WHERE ca.id=po.id_category 
                AND po.status = 1 
                AND po.special = 1 
                AND po.id_category = $idcate
                ORDER BY po.date desc limit 10";
        $res = pdo_query($sql);

        // truy vấn lấy sao
        $idproduct = array_column($res, 'id');
        $idproduct_String = implode(',', $idproduct);
       
        $vote = "SELECT id_product, star, star_ratings
                         FROM (
                             SELECT c.id_product, vs.star, COUNT(*) AS star_ratings,
                                    ROW_NUMBER() OVER(PARTITION BY c.id_product ORDER BY COUNT(*) DESC) AS rn
                             FROM comment c
                             INNER JOIN vote_star vs ON c.id = vs.id_comment
                             WHERE c.id_product IN ($idproduct_String)
                             GROUP BY c.id_product, vs.star
                         ) ranked
                         WHERE rn = 1";
        $res1 = pdo_query($vote);
       
        $ratingsData = [];
        foreach ($res1 as $rating) {
            $productId = $rating['id_product'];
            $ratingsData[$productId] = $rating;
        }

        foreach ($res as $list_pro) {
          extract($list_pro);
          
          echo '<div class="product-section">
                  <div style="padding: 15px;">
                    <div class="product-img">
                      <img src="./assets/'.$image.'" alt="">
                    </div>
                    <a href="">
                      <span>'.$category_name.'</span>
                    </a>
                    <a href="index.php?act=productdetail&idpro='.$id.'">
                      <h4>'.$name.'</h4>
                    </a>
                      <div class="star" style="display: flex; align-items: center;">
                  </div>';
                  
                  // hiện thị sao
                  if (isset($ratingsData[$id])) {
                    $rating = $ratingsData[$id];
                    $star = $rating['star'];
                    $total = $rating['star_ratings'];
                   
                    for ($i = 1; $i <= $star; $i++) {
                      echo '<i class="bx bxs-star" style="color: gold;" data-value="'.$i.'"></i>';
                    }
                    echo '<span class="total" style="top: -2px; left: 12px;">('.$total.')</span>';
                  }
                 
                   echo '<div class="price">
                    
                      <div class="price-sale">
                        <span style="color: brown; font-weight: bold;">'.$new_price.'</span>
                        <del>'.$old_price.'</del>
                      </div>
                      <div class="add-cart">
                      <div class="view">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye"
                          viewBox="0 0 16 16">
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg> '.$view.'
                      </div>
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

<script>
function updateCountdown() {
  const targetDate = new Date("2023-12-21T15:00:00").getTime();
  const now = new Date().getTime();
  const distance = targetDate - now;

  if (distance <= 0) {
    document.getElementById("countdown1").innerHTML = "Kết thúc";
    return;
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor(
    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  const countdownString = `${days} : ${hours} : ${minutes} : ${seconds}`;

  document.getElementById("countdown1").innerHTML = countdownString;
  document.getElementById("countdown1").style.fontSize = "20px";
  document.getElementById("countdown1").style.fontWeight = "bold";
  document.getElementById("countdown1").style.color = "#63666b";
}

setInterval(updateCountdown, 1000);
</script>