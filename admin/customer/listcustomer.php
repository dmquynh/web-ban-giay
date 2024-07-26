<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/css/list.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<style>
button {
  cursor: pointer;
}

.ava {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  margin-right: 5px;
}
</style>

<body>
  <div class="container-products">
    <div class="head">
      <h2>Tài khoản</h2>
      <a href="index.php?act=addcustomer"><button style="left: 720px; position: relative;">Thêm tài
          khoản mới</button></a>
    </div>
    <?php
        require './global.php';
        if(isset($_GET['act'])){
          echo '
          <div class="url">
            <a href="'.$home.'">'.$base_url.' / </a> 
            <a href="">'.$_GET['act'].'</a>
          </div>
          ';
        }
      ?>

    <div class="container-content">
      <div class="search-filter">
        <form action="" method="post">
          <input type="text" name="keyword" id="" placeholder="Tìm kiếm tài khoản">
        </form>

        <form action="" style="display: none;">
          <div class="filter">
            <select name="" id="">
              <option value="" selected>Trạng thái</option>
              <option value="">Đã đăng</option>
              <option value="">Chưa đăng</option>
            </select>
          </div>
        </form>
      </div>

      <div class="list-products">
        <table>
          <?php
            if(isset($_POST['keyword'])){
              $keyword = $_POST['keyword'];

              if($keyword != ''){
                $sql = "SELECT * FROM customer WHERE name like '%$keyword%'";
                $res = pdo_query($sql);

                
                echo '<tr>
                        <th><input type="checkbox" name="" id=""></th>
                        <th>Tên</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th></th>
                      </tr>';
                foreach ($res as $cate) {
                  extract($cate);
                  if($role == 0){
                    $role = "<span style='color: #2b752b; background: #bcf5bc; padding: 2px 5px 2px 5px; border-radius: 5px'>Thành viên</span>";
                  }else{
                    $role = "<span style='color: #962b1d; background: #de9187; padding: 2px 5px 2px 5px; border-radius: 5px'>Admin</span>";
                  }
                  $img = "../assets/images//avatar//avatar-trang.jpg";
                  if($image == ''){
                    $image = $img;
                  }else{
                    $image = $image;
                  }
                  
                  echo '<tr class="hover-products" style="text-align: center;">
                          <th><input type="checkbox" name="" id=""></th>
                          <td style="display:flex; justify-content: center; align-items: center;"><img class="ava" src="'.$img.'" > '.$name.'</td>
                          <td>'.$email.'</td>
                          <td>'.$role.'</td>
                          <td>'.$create_at.'</td>
                          <td class="dots">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                              class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                              <path
                                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                            </svg>
                          <div style="position:relative">
                            <nav class="manage" style="margin-left:15px">
                              <a href="index.php?act=delcustomer&id='.$id.'">
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
                              <a href="index.php?act=editcustomer&id='.$id.'">
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
                header('location: index.php?act=listcategories');
              }
            }else{

            
          ?>
        </table>
      </div>
      <br>
      <div class="list-products" style="position:relative; top:0px;">
        <table>
          <tr>
            <th><input type="checkbox" name="" id=""></th>
            <th>Tên</th>
            <th>Email</th>
            <th>Vai trò</th>
            <th>Ngày tạo</th>
            <th></th>
          </tr>
          <?php
            $sql = "SELECT * FROM customer";
            $res = pdo_query($sql);

            foreach ($res as $list_cate) {
              extract($list_cate);
              if($role == 0){
                $role = "<span style='color: #2b752b; background: #bcf5bc; padding: 2px 5px 2px 5px; border-radius: 5px'>Thành viên</span>";
              }else{
                $role = "<span style='color: #962b1d; background: #de9187; padding: 2px 5px 2px 5px; border-radius: 5px'>Admin</span>";
              }

              if($image == ""){
                $image= './assets//images//avatar//avatar-trang.jpg';
              }else{
                $image = $image; 
              }
              echo '<tr class="hover-products" style="text-align: center;">
                      <td><input type="checkbox" name="" id=""></td>
                      <td style="display:flex; justify-content: center; align-items: center;"><img class="ava" src="../'.$image.'" > '.$name.'</td>
                      <td>'.$email.'</td>
                      <td>'.$role.'</td>
                      <td>'.$create_at.'</td>
                      <td class="dots">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                          class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                          <path
                            d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                        </svg>
                        <div style="position:relative">
                          <nav class="manage" style="margin-left:15px">
                            <a href="index.php?act=delcustomer&id='.$id.'">
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
                            <a href="index.php?act=editcustomer&id='.$id.'">
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