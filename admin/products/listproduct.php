<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/css//list.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<style>
button {
  cursor: pointer;
}
</style>

<body>
  <div class="container-products" style="height:auto">
    <div class="head">
      <h2>Sản phẩm</h2>
      <a href="index.php?act=addproduct" style="margin-left: -20px;"><button>Thêm sản phẩm</button></a>
    </div>
    <?php
        require './global.php';
        if(isset($_GET['act'])){
          echo '<div class="url">
                <a href="'.$home.'">'.$base_url.' / </a> 
                <a href="">'.$_GET['act'].'</a>
              </div>';
        }
    ?>
    <div class="container-content">
      <div class="search-filter">
        <form action="" method="post">
          <input type="text" name="keyword" id="" placeholder="Tìm kiếm sản phẩm">
        </form>
        <div class="filter">
          <select name="status" id="">
            <option value="0" selected>Trạng thái</option>
            <option value="1">Hoạt động</option>
            <option value="2">Ngưng hoạt động</option>
          </select>
        </div>
      </div>

      <div class="list-products">
        <table>
          <?php
            if(isset($_POST['keyword']) && ($_POST['keyword'])){
              $keyword = $_POST['keyword'];

              if($keyword != ''){
                $sql = "SELECT po.id, po.image, po.name, ca.category_name, po.status, po.new_price, po.old_price, po.date
                FROM category as ca, product as po WHERE ca.id=po.id_category AND po.name like '%$keyword%'";
                $res = pdo_query($sql);

                echo '<tr>
                        <th><input type="checkbox" name="" id=""></th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Giá mới</th>
                        <th>Giá cũ</th>
                        <th>Ngày tạo</th>
                        <th></th>
                      </tr>';

                foreach ($res as $product) {
                  extract($product);
                  if($status == 1){
                    $status = "<span style='color: #2b752b; background: #bcf5bc; padding: 2px 5px 2px 5px; border-radius: 5px'>Đã đăng</span>";
                  }else{
                    $status = "<span style='color: #962b1d; background: #de9187; padding: 2px 5px 2px 5px; border-radius: 5px'>Chưa đăng</span>";
                  }
                  echo '<tr class="hover-products" style="text-align: center;">
                  <td><input type="checkbox" name="" id=""></td>
                  <td><img src="'.$image.'" alt="" width="112px" height="112px"></td>
                  <td>'.$name.'</td>
                  <td>'.$category_name.'</td>
                  <td>'.$status.'</td>
                  <td>'.$new_price.'</td>
                  <td>'.$old_price.'</td>
                  <td>'.$date.'</td>
                  <td class="dots">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                      class="bi bi-three-dots-vertical " viewBox="0 0 16 16">
                      <path
                        d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                    </svg>
                    <div style="position:relative">
                      <nav class="manage">
                        <a href="index.php?act=delproduct&id='.$id.'">
                          <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                              class="bi bi-trash" viewBox="0 0 16 16">
                              <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                              <path
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                            </svg>
                            <span>Delete</span>
                          </li>
                        </a>
                        <a href="index.php?act=editproduct&id='.$id.'">
                          <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                              class="bi bi-pencil-square" viewBox="0 0 16 16">
                              <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                              <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                            <span>Edit</span>
                          </li>
                        </a>
                      </nav>
                    </div>
                  </td>
                  
                </tr>';
                }
                
              }else{
                header('location: index.php?act=listproduct');
              }
            }else{

            
          ?>
        </table>
      </div>
      <br>
      <div class="list-products">
        <table>
          <tr>
            <th><input type="checkbox" name="" id=""></th>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Trạng thái</th>
            <th>Giá mới</th>
            <th>Giá cũ</th>
            <th>Ngày tạo</th>
            <th></th>
          </tr>

          <?php
            $sql = "SELECT po.id, po.image, po.name, ca.category_name, po.status, po.new_price, po.old_price, po.date
                    FROM category as ca, product as po 
                    WHERE ca.id=po.id_category ORDER BY po.date desc"; 
            $res = pdo_query($sql);

            foreach ($res as $product) {
              extract($product);
            
              if($status == 1){
                $status = "<span style='color: #2b752b; background: #bcf5bc; padding: 2px 5px 2px 5px; border-radius: 5px'>Đã đăng</span>";
              }else{
                $status = "<span style='color: #962b1d; background: #de9187; padding: 2px 5px 2px 5px; border-radius: 5px'>Chưa đăng</span>";
              }
              echo '<tr class="hover-products" style="text-align: center;">
                    <td><input type="checkbox" name="" id=""></td>
                    <td><img style="padding: 10px" src="'.$image.'" alt="" width="82px" height="82px"></td>
                    <td>'.$name.'</td>
                    <td>'.$category_name.'</td>
                    <td>'.$status.'</td>
                    <td>'.$new_price.'</td>
                    <td>'.$old_price.'</td>
                    <td>'.$date.'</td>
                    <td class="dots">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-three-dots-vertical " viewBox="0 0 16 16">
                        <path
                          d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                      </svg>
                      <div style="position:relative">
                        <nav class="manage">
                          <a href="index.php?act=delproduct&id='.$id.'">
                            <li>
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-trash" viewBox="0 0 16 16">
                                <path
                                  d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                <path
                                  d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                              </svg>
                              <span>Delete</span>
                            </li>
                          </a>
                          <a href="index.php?act=editproduct&id='.$id.'">
                            <li>
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path
                                  d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd"
                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                              </svg>
                              <span>Edit</span>
                            </li>
                          </a>
                        </nav>
                      </div>
                    </td>
                    
                  </tr>';
            }
          ?>
        </table>
      </div>
      <?php }?>
    </div>
  </div>

</body>

</html>