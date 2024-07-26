<?php 
if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="home">
  <div style="display: none;">
    <div>
      <div class="banner" style="display: none;">
        <img src="../assets//images//banner//grocery-banner.png" alt="">
      </div>
      <div class="banner-content" style="display: none;">
        <h2>Chào mừng đến với ShoesShop</h2>
        <p>ShoesShop là thiết kế đơn giản và gọn gàng dành cho nhà phát triển và nhà thiết kế.</p>
        <button>
          <a href="">Tạo sản phẩm</a>
        </button>
      </div>
    </div>
  </div>
  <div class="statistical">
    <div class="box1">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#348feb" class="bi bi-cart-check-fill"
        viewBox="0 0 16 16">
        <path
          d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z" />
      </svg>
      <?php
        $sql = "SELECT count(id) as orders FROM `orders`";
        $count_order = pdo_query($sql);
      ?>
      <p style="font-size: 40px; font-weight: bold; margin-top: 5px; padding: 5px 0px"><?=$count_order[0]['orders']?>
      </p>
      <p style="font-size: 14px;">NEW ORDERS</p>
    </div>

    <div class="box1">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#f2a813" class="bi bi-chat-dots-fill"
        viewBox="0 0 16 16">
        <path
          d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
      </svg>
      <?php
        $sql = "SELECT COUNT(id) as comment FROM `comment`";
        $count_comment = pdo_query($sql);
      ?>
      <p style="font-size: 40px; font-weight: bold; margin-top: 5px; padding: 5px 0px"><?=$count_comment[0]['comment']?>
      </p>
      <p style="font-size: 14px;">COMMENTS</p>
    </div>

    <div class="box1">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#1ee369" class="bi bi-people-fill"
        viewBox="0 0 16 16">
        <path
          d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
      </svg>
      <?php
        $sql = "SELECT COUNT(id) as customer FROM `customer` WHERE role = 0";
        $count_customer = pdo_query($sql);
      ?>
      <p style="font-size: 40px; font-weight: bold; margin-top: 5px; padding: 5px 0px">
        <?=$count_customer[0]['customer']?></p>
      <p style="font-size: 14px;">NEW USERS</p>
    </div>

    <div class="box1">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#f2351f" class="bi bi-search"
        viewBox="0 0 16 16">
        <path
          d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
      </svg>
      <?php 
        $sql = "SELECT * FROM visit";
        $res = pdo_query($sql);
        $visit = number_format($res[0][1])
      ?>
      <p style="font-size: 40px; font-weight: bold; margin-top: 5px; padding: 5px 0px"><?=$visit ?></p>
      <p style="font-size: 14px;">PAGE SEARCH</p>
    </div>
  </div>
  <div class="chart">
    <div>
      <?php
        // Truy vấn dữ liệu
        $sql = "SELECT category.category_name as id_category, COUNT(*) as product_count
                FROM product
                JOIN category ON category.id=product.id_category GROUP BY id_category";
        $result = pdo_query($sql);

        // Xử lý dữ liệu
        $categories = [];
        $productCounts = [];

       foreach ($result as $ok) {
        $categories[] = $ok['id_category'];
        $productCounts[] = $ok['product_count'];
       }
      ?>
      <canvas id="myChart" width="350" height="350"></canvas>
      <script>
      // Dữ liệu sản phẩm từ PHP
      var categories = <?php echo json_encode($categories); ?>;
      var productCounts = <?php echo json_encode($productCounts); ?>;

      // Tạo biểu đồ bằng Chart.js
      var ctx = document.getElementById('myChart').getContext('2d');

      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: categories, // Nhãn danh mục
          datasets: [{
            label: 'Số Lượng Sản Phẩm',
            data: productCounts, // Dữ liệu số lượng sản phẩm
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
          }],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                font: {
                  size: 14 // Kích thước font chữ trên trục y
                },
                callback: function(value, index, values) {
                  if (Number.isInteger(value)) {
                    return value;
                  } else {
                    return ''; // Trả về chuỗi rỗng để ẩn số không phải số nguyên
                  }
                }
              }
            },
            x: {
              ticks: {
                font: {
                  size: 10,
                },
              }
            }
          },

          plugins: {
            title: {
              display: true,
              text: 'Biểu đồ thống kê số lượng sản phẩm theo danh mục' // Tiêu đề của biểu đồ
            }
          }
        },

      });
      </script>
    </div>
    <div>
      <canvas id="myChart1" width="350" height="350"></canvas>
      <?php
          // Thực hiện truy vấn SQL để lấy doanh thu mỗi ngày
          $sql = "SELECT Months.Month AS month, IFNULL(SUM(`orders`.`money`), 0) AS revenue
                  FROM (
                      SELECT 1 AS Month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12
                  ) AS Months
                  LEFT JOIN `orders` ON MONTH(`orders`.`date`) = Months.Month
                GROUP BY Months.Month
                ORDER BY Months.Month ASC;";

          // Thực hiện truy vấn và lấy dữ liệu
          $result = pdo_query($sql);

          // Khởi tạo mảng để lưu trữ dữ liệu
          $month = [];
          $revenue = [];

          // Lặp qua kết quả và lưu vào mảng
          foreach ($result as $row) {
            $month[] = $row['month'];
            $revenue[] = $row['revenue'];
          }          
      ?>
      <script>
      // Dữ liệu sản phẩm từ PHP
      var month = <?php echo json_encode($month); ?>;
      var revenue = <?php echo json_encode($revenue); ?>;

      // Tạo biểu đồ bằng Chart.js
      var ctx = document.getElementById('myChart1').getContext('2d');

      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: month, // Nhãn danh mục
          datasets: [{
            label: 'Doanh thu mỗi tháng',
            data: revenue, // Dữ liệu số lượng sản phẩm
            backgroundColor: 'green',
            borderColor: 'green',
            borderWidth: 2,
            fill: false, // Không tô màu dưới đường line
            tension: 0.2, // Điều chỉnh độ cong của đường line
          }],
        },

        options: {
          elements: {
            point: {
              radius: 5, // Kích thước điểm
              backgroundColor: 'rgba(255, 99, 132, 1)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 2
            }
          },

          plugins: {
            legend: {
              display: true,
              position: 'top' // Vị trí hiển thị legend
            }
          },
          scales: {
            x: {
              display: true,
              title: {
                display: true,
                text: 'Tháng'
              }
            },
            y: {
              display: true,
              title: {
                display: true,
                text: 'Doanh thu'
              }
            }
          },

        }
      });
      </script>
    </div>
    <h2>4</h2>
    <h2>4</h2>

  </div>
</div>