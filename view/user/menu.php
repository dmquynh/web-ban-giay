<?php ob_start()?>
<div class="wrapper">
  <div class="menu">
    <div class="avatar">
      <img src="<?=$res[0][5]?>" alt="">
      <div style="margin-left: 16px; line-height: 26px; ">
        <h4><?=$res[0][1]?></h4>
        <a style="text-decoration: none; color: #9B9B9B" href="index.php?act=user" style="font-size: 15px; "><svg
            xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="#9B9B9B" class="bi bi-pencil-fill"
            viewBox="0 0 16 16">
            <path
              d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
          </svg>
          Sửa Hồ Sơ
        </a>
      </div>
    </div>
    <nav>
      <li>
        <a href="#">
          <img src="./assets/images//icon//user.png" alt="">
          <span>Tài Khoản Của Tôi</span>
        </a>
        <ul>
          <li><a href="index.php?act=user">Hồ Sơ</a></li>
          <li><a href="index.php?act=change_pass">Đổi Mật Khẩu</a></li>
        </ul>
      </li>
      <li>
        <a href="index.php?act=order">
          <img src="./assets/images//icon//order.png" alt="">
          <span>Đơn mua</span>
        </a>
      </li>
      <li>
        <a href="">
          <img src="./assets/images//icon//rung.png" alt="">
          <span>Thông báo</span>
        </a>
      </li>
    </nav>
  </div>