<?php
// Kết nối đến cơ sở dữ liệu và truy vấn để lấy danh sách huyện/quận tương ứng với tỉnh/thành phố được chọn
require './dao/pdo.php';

if (isset($_POST['id_province'])) {
    $provinceId = $_POST['id_province'];
    // Thực hiện truy vấn để lấy danh sách huyện/quận từ cơ sở dữ liệu dựa trên $provinceId

    $sql = "SELECT * FROM district WHERE id_province = $provinceId";
    $districts = pdo_query($sql);

    // // // Trả về danh sách huyện/quận dưới dạng các option cho dropdown
    echo '<option value="0">Quận/huyện</option>';
    foreach ($districts as $district) {
        echo '<option value="' . $district['id'] . '">' . $district['name'] . '</option>';
    }
}
?>