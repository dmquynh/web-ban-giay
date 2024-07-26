<div style="margin-top: 200px;">
  <div class="category">
    <h2>Danh mục</h2>
    <div class="category1">
      <?php
        // $sql = "SELECT * FROM category";
        // $res = pdo_query($sql);
        $sql = "SELECT ca.id, ca.category_name, ca.image, po.status , ca.status
                FROM category as ca, product as po 
                WHERE ca.id=po.id_category AND po.status = 1 AND ca.status = 1 GROUP BY ca.id";
        $res = pdo_query($sql);

        foreach ($res as $list_cate) {
          extract($list_cate);
          $t = str_replace(' ', '+', $category_name);

          echo ' <a href="index.php?act=product&id_cate='.$t.'" style="text-decoration: none; color: #6f7580" class="category-section">
                    <div class="cate-img">
                      <img src="./assets/'.$image.'" alt="">
                    </div>
                    <div class="cate-title">
                      <span>'.$category_name.'</span>
                    </div>
                  </a>';
            }
      ?>
    </div>
  </div>

  <div class="hot">
    <div class="hot-col">
      <?php
         $sql = "SELECT * FROM category WHERE sale = 1 limit 2";
         $res = pdo_query($sql);

         foreach ($res as $cate_sale) {
          extract($cate_sale);
          echo '<div class="hot-col-banner1">
                  <div class=" hot-banner-img">
                    <img style="width: 200px; margin-left: 300px; height: 200px" src="./assets/'.$image.'" alt="">
                  </div>
                  <div class="content-hot">
                    <h2>'.$category_name.'</h2>
                    <p>Giảm giá 50%</p>
                    <button><a href="index.php?act=cate_sale&idcate='.$id.'">Mua Ngay</a></button>
                  </div>
                </div>';
         }
      ?>
    </div>
  </div>
</div>
</div>