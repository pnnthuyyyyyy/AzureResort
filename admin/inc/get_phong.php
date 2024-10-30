<?php
include_once('database.php');

if (isset($_POST['khachSanId']) && isset($_POST['ngayNhanPhong']) && isset($_POST['ngayTraPhong'])) {
    $khachSanId = $_POST['khachSanId'];
    $ngayNhanPhong = $_POST['ngayNhanPhong'];
    $ngayTraPhong = $_POST['ngayTraPhong'];

    // Truy vấn danh sách phòng còn trống
    $phong = showTK("SELECT id, soPhong, tenPhong, soNguoi FROM phong 
                   WHERE khachSanID = ? AND id NOT IN (
                       SELECT phongID FROM phieudatphong 
                       WHERE (ngayNhanPhong <= ? AND ngayTraPhong >= ?)
                   )", array($khachSanId, $ngayTraPhong, $ngayNhanPhong));

    echo json_encode(array('phong' => $phong));
}
?>
