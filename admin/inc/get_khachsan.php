<?php
include_once('database.php');

if (isset($_POST['ngayNhanPhong']) && isset($_POST['ngayTraPhong'])) {
    $ngayNhanPhong = $_POST['ngayNhanPhong'];
    $ngayTraPhong = $_POST['ngayTraPhong'];

    // Truy vấn danh sách khách sạn có phòng còn trống trong khoảng thời gian này
    $khachsan = showTK("SELECT DISTINCT ks.id, ks.tenKhachSan FROM khachsan ks
                      JOIN phong p ON ks.id = p.khachSanID
                      WHERE p.id NOT IN (
                          SELECT phongID FROM phieudatphong 
                          WHERE (ngayNhanPhong <= ? AND ngayTraPhong >= ?)
                      )", array($ngayTraPhong, $ngayNhanPhong));

    echo json_encode(array('khachsan' => $khachsan));
}
?>
