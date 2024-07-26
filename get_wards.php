<?php
require './dao/pdo.php';

if (isset($_POST['districtId'])) {
    $districtId = $_POST['districtId'];
    // Kết nối đến cơ sở dữ liệu của bạn và thực hiện truy vấn để lấy danh sách phường/xã tương ứng với huyện/quận được chọn

    $sql = "SELECT * FROM ward WHERE id_district = $districtId";
    $wards = pdo_query($sql);

    // Trả về danh sách phường/xã dưới dạng các option cho dropdown
    foreach ($wards as $ward) {
        echo '<option value="' . $ward['id'] . '">' . $ward['name'] . '</option>';
    }
}
?>