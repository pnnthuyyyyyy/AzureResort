<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Booking</title>
    <?php require('inc/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>

<body>
    <?php
    require('inc/header.php');
    ?>
    <?php
    include("./config/connect.php");
    if (!isset($_SESSION['user'])) {
        echo '<script>
    alert("Vui lòng đăng nhập để xem phòng đã đặt.");
    window.location.href = "index.php";
    </script>';
        exit;
    }
    $user = $_SESSION['user'];
    ?>
    <?php
    if (isset($_REQUEST['phong']) && isset($_REQUEST['phieu'])) {
        $id_phong = $_REQUEST['phong'];
        $id_phieu = $_REQUEST['phieu'];
        $sql_huyphieu = "DELETE FROM phieudatphong WHERE id = '$id_phieu'";
        $sql_huyphong = "UPDATE phong SET trangThai = 0 WHERE id = '$id_phong'";
        $result_huyphieu = mysqli_query($conn, $sql_huyphieu);
        $result_huyphong = mysqli_query($conn, $sql_huyphong);
        if ($result_huyphieu && $result_huyphong) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Hủy Phòng Thành Công!',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            willClose: () => {
                                window.location.href = 'mybooking.php';
                            }
                        });
                    });
                </script>";
        } else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hủy Phòng Thất Bại!',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            willClose: () => {
                                window.location.href = 'mybooking.php';
                            }
                        });
                    });
                </script>";
        }
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">My Booking</h2>
                <div style="font-size: 14px;">
                    <a href="rooms.php" class="text-secondary text-decoration-none;">My Booking</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none;">List Booking</a>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <table class="table table-bordered border-primary">
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên Phòng</th>
                                <th class="text-center">Tổng Tiền</th>
                                <th class="text-center">Thanh Toán Bằng</th>
                                <th class="text-center">Thao Tác</th>
                            </tr>
                            <?php
                            $i = 0;
                            $id_user = $user['id'];
                            $sql_mybooking = "SELECT pdp.id as id_phieu, p.id as id_phong , p.tenPhong as tenPhong, pdp.tongTien as tongTien, pdp.ngayDatPhong as ngayDatPhong, pdp.ngayNhanPhong as ngayNhanPhong, pdp.ngayTraPhong as ngayTraPhong, pdp.payment_method as trangThai FROM phieudatphong pdp JOIN phong p 
                                ON pdp.phongID = p.id
                                WHERE pdp.khachHangID = '$id_user' AND pdp.trangThai = '1'
                                ";
                            $result = mysqli_query($conn, $sql_mybooking);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $i++;
                                    echo '<tr>
                                        <td class="text-center">' . $i . '</td>
                                        <td>' . $row['tenPhong'] . '</td>
                                        <td class="text-center">' . number_format($row['tongTien']) . '</td>
                                        <td class="text-center">' . $row['trangThai'] . '</td>
                                        <td class="text-center"><a href="mybooking.php?phong=' . $row['id_phong'] . '&phieu=' . $row['id_phieu'] . '" class="btn btn-sm w-40 btn-outline-dark">Huỷ Phòng</a>
                                        <a href="detailbooking.php?phieu='.$row['id_phieu'].'" class="btn btn-sm w-40 btn-outline-dark">Chi Tiết</a>
                                        </td>';
                                }
                            } else {
                                echo 'Chưa Đặt Phòng';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    require('inc/footer.php');
    ?>
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