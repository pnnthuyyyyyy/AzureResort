<?php
session_start();
include('./config/connect.php');


include("./config/connect.php");
if (!isset($_SESSION['user'])) {
    echo '<script>
    alert("Vui lòng đăng nhập để thanh toán phòng.");
    window.location.href = "index.php";
    </script>';
    exit;
}
$user = $_SESSION['user'];


$magiamgiabooking = $_SESSION['magiamgiabooking'];
$goidichvubooking = $_SESSION['goidichvubooking'];
$id_user = $_SESSION['id_user'];
$id_phong = $_SESSION['id_phong'];
$total_amout = $_SESSION['total'];
$ngaydatphongbooking = $_SESSION['ngaydatphong'];
$ngaynhanphongbooking = $_SESSION['ngaynhanphong'];
$ngaytraphongbooking = $_SESSION['ngaytraphong'];

if (isset($_GET['resultCode'])) {
    $result_code = $_GET['resultCode'];
    switch ($result_code) {
        case '0':
            $sql_phieudatphong = "INSERT INTO phieudatphong (uuDaiID, goiDichVuID, khachHangID, phongID, tongTien, ngayDatPhong, ngayTraPhong, trangThai, ngayNhanPhong, payment_method) VALUES ('$magiamgiabooking', '$goidichvubooking', '$id_user', '$id_phong', '$total_amout', '$ngaydatphongbooking', '$ngaytraphongbooking', '1', '$ngaynhanphongbooking', 'momo')";
            $sql_update_phong = "UPDATE phong SET trangThai = '1' WHERE id = '$id_phong'";

            $result_phieudatphong = mysqli_query($conn, $sql_phieudatphong);
            $result_update_phong = mysqli_query($conn, $sql_update_phong);

            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Đặt phòng thành công!',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'index.php';
                        }
                    });
                });
            </script>";
            break;
        case '1006':
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Đặt phòng thất bại!',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'rooms.php';
                        }
                    });
                });
            </script>";
            break;
        default:
            break;
    }
} elseif(isset($_GET['vnp_ResponseCode'])) {
    $vnp_ResponseCode = $_GET['vnp_ResponseCode'];
    switch ($vnp_ResponseCode) {
        case '00':
            $sql_phieudatphong = "INSERT INTO phieudatphong (uuDaiID, goiDichVuID, khachHangID, phongID, tongTien, ngayDatPhong, ngayTraPhong, trangThai, ngayNhanPhong, payment_method) VALUES ('$magiamgiabooking', '$goidichvubooking', '$id_user', '$id_phong', '$total_amout', '$ngaydatphongbooking', '$ngaytraphongbooking', '1', '$ngaynhanphongbooking', 'vnpay')";
            $sql_update_phong = "UPDATE phong SET trangThai = '1' WHERE id = '$id_phong'";

            $result_phieudatphong = mysqli_query($conn, $sql_phieudatphong);
            $result_update_phong = mysqli_query($conn, $sql_update_phong);

            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Đặt phòng thành công!',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'index.php';
                        }
                    });
                });
            </script>";
            break;
        case '24':
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Đặt phòng thất bại!',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            willClose: () => {
                                window.location.href = 'rooms.php';
                            }
                        });
                    });
                </script>";
            break;
        default:
            break;
    }
} else {
    echo "Error";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Thành Công</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>

<body>
        <!-- Chatra {literal} -->
        <script>
        (function(d, w, c) {
            w.ChatraID = 'CBQ3fukS8PFGnSbiW';
            var s = d.createElement('script');
            w[c] = w[c] || function() {
                (w[c].q = w[c].q || []).push(arguments);
            };
            s.async = true;
            s.src = 'https://call.chatra.io/chatra.js';
            if (d.head) d.head.appendChild(s);
        })(document, window, 'Chatra');
    </script>
    <!-- /Chatra {/literal} -->
</body>

</html>