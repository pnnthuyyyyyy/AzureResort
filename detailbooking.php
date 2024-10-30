<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking</title>
    <?php require('inc/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }

        .carousel-inner {
            border-radius: 8px;
            overflow: hidden;
        }

        .card {
            margin-top: 20px;
        }

        .info-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .info-group h6 {
            margin: 0;
            font-weight: bold;
        }

        .info-group span {
            padding: 10px;
            font-size: 14px;
        }

        .badge {
            padding: 10px;
            font-size: 14px;
        }

        .container h2 {
            margin-bottom: 20px;
        }

        .utility-icons-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .utility-icons-container>div {
            flex: 1;
            margin: 10px;
            text-align: center;
            max-width: 200px;
        }
    </style>
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
    if (isset($_REQUEST['phieu']) && $user) {
        $id_user = $user['id'];
        $phieu = $_REQUEST['phieu'];
        $sql_detail = "SELECT pdp.*, p.*, gdv.*, u.*, ip.*, p.gia as GiaPhong, gdv.gia as GiaDichVu FROM phieudatphong pdp JOIN phong p 
                            ON pdp.phongID = p.id JOIN goidichvu gdv 
                            ON pdp.goiDichVuID = gdv.id JOIN uudai u
                            ON pdp.uuDaiID = u.id JOIN image_phong ip
                            ON p.id = ip.id_phong 
                            WHERE pdp.id = '$phieu' AND pdp.khachHangID = '$id_user'";
        $result_detail = mysqli_query($conn, $sql_detail);
        $row_detail = mysqli_fetch_assoc($result_detail);
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">Detail My Booking</h2>
                <div style="font-size: 14px;">
                    <a href="mybooking.php" class="text-secondary text-decoration-none;">My Booking</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none;">Detail My Booking</a>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="col-lg-12 col-md-12 px-4">
                            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    $active = 'active';
                                    while ($row_img = mysqli_fetch_assoc($result_detail)) {
                                        echo '<div class="carousel-item ' . $active . '">
                                <img src="./admin/uploads/' . $row_img['anh_phong'] . '" class="d-block w-100" alt="...">
                            </div>';
                                        $active = '';
                                    }
                                    ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form class="row g-3">
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Tên Phòng</span>
                                <input type="text" class="form-control" aria-describedby="basic-addon3" value="<?php echo $row_detail['tenPhong']; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Hạng Phòng</span>
                                <input type="text" class="form-control" aria-describedby="basic-addon3" value="<?php
                                                                                                        if ($row_detail['hangPhong'] == 0) {
                                                                                                            echo 'Thường';
                                                                                                        } else if ($row_detail['hangPhong'] == 1) {
                                                                                                            echo 'VIP';
                                                                                                        } else {
                                                                                                            echo 'Tổng Thống';
                                                                                                        }
                                                                                                        ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Loại Phòng</span>
                                <input type="text" class="form-control" aria-describedby="basic-addon3" value="<?php
                                                                                                        if ($row_detail['loaiPhong'] == 0) {
                                                                                                            echo 'Giường Đơn';
                                                                                                        } else {
                                                                                                            echo 'Giường Đôi';
                                                                                                        }
                                                                                                        ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Diện Tích Phòng</span>
                                <input type="text" class="form-control" aria-describedby="basic-addon3" value="<?php echo $row_detail['dienTich'] . ' m²'; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Số Người</span>
                                <input type="text" class="form-control" aria-describedby="basic-addon3" value="<?php echo $row_detail['songuoi']; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Gói Dịch Vụ Phòng</span>
                                <input type="text" class="form-control" aria-describedby="basic-addon3" value="<?php
                                                                                                        echo $row_detail['tenGoi'];
                                                                                                        ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Ưu Đãi</span>
                                <input type="text" class="form-control" aria-describedby="basic-addon3" value="<?php echo $row_detail['tenUuDai']; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Ngày Đặt Phòng</span>
                                <input type="text" class="form-control" aria-describedby="basic-addon3" value="<?php echo date("d-m-Y", strtotime($row_detail['ngayDatPhong'])); ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Ngày Nhận Phòng</span>
                                <input type="text" class="form-control" aria-describedby="basic-addon3" value="<?php echo date("d-m-Y", strtotime($row_detail['ngayNhanPhong'])); ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Ngày Trả Phòng</span>
                                <input type="text" class="form-control" aria-describedby="basic-addon3" value="<?php echo date("d-m-Y", strtotime($row_detail['ngayTraPhong'])); ?>" readonly>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-hover table-borderless">
                                    <tr>
                                        <th>Giá Phòng</th>
                                        <th>Giá Gói Dịch Vụ</th>
                                        <th>Giảm Giá %</th>
                                        <th>Tổng Tiền</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo number_format($row_detail['GiaPhong']); ?></td>
                                        <td><?php echo number_format($row_detail['GiaDichVu']); ?></td>
                                        <td><?php echo number_format($row_detail['giaGiam']); ?></td>
                                        <td><?php echo number_format($row_detail['tongTien']); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                        if ($row_detail['hangPhong'] == "Thường") {
                            echo '<h5>Tiện Ích:</h5>';
                            echo '<div class="utility-icons-container">
                                <div><span class="icon"><i class="fas fa-heartbeat"></i></span> Cân sức khỏe</div>
                                <div><span class="icon"><i class="fas fa-phone"></i></span> Điện thoại</div>
                                <div><span class="icon"><i class="fas fa-shower"></i></span> Vòi sen</div>
                                <div><span class="icon"><i class="fas fa-snowflake"></i></span> Điều hoà không khí</div>
                                <div><span class="icon"><i class="fas fa-bed"></i></span> Dép đi trong nhà</div>
                                <div><span class="icon"><i class="fas fa-utensils"></i></span> Máy sấy tóc</div>
                                <div><span class="icon"><i class="fas fa-wifi"></i></span> Mạng tốc độ cao</div>
                                <div><span class="icon"><i class="fas fa-bath"></i></span> Áo choàng tắm</div>
                                <div><span class="icon"><i class="fas fa-tv"></i></span> Flat-screen TV</div>
                                <div><span class="icon"><i class="fas fa-tshirt"></i></span> Tủ quần áo</div>
                                <div><span class="icon"><i class="fas fa-lock"></i></span> Két sắt điện tử</div>
                                <div><span class="icon"><i class="fas fa-wifi"></i></span> Wifi miễn phí</div>
                                <div><span class="icon"><i class="fas fa-temperature-high"></i></span> Ấm điện</div>
                                <div><span class="icon"><i class="fas fa-coffee"></i></span> Trà & Cafe miễn phí</div>
                                <div><span class="icon"><i class="fas fa-bath"></i></span> Bồn tắm</div>
                                <div><span class="icon"><i class="fas fa-laptop"></i></span> Bàn làm việc</div>
                                <div><span class="icon"><i class="fas fa-bath"></i></span> Khăn tắm</div>
                                <div><span class="icon"><i class="fas fa-swimming-pool"></i></span> Bể bơi</div>
                                <div><span class="icon"><i class="fas fa-umbrella"></i></span> Ô dù</div>
                                <div><span class="icon"><i class="fas fa-cocktail"></i></span> Minibar</div>
                                <div><span class="icon"><i class="fas fa-bed"></i></span> Giường lớn</div>
                            </div>';
                        } else if ($row_detail['hangPhong'] == "VIP") {
                            echo '<h5>Tiện Ích:</h5>';
                            echo '<div class="utility-icons-container">
                                <div><span class="icon"><i class="fas fa-heartbeat"></i></span> Cân sức khỏe</div>
                                <div><span class="icon"><i class="fas fa-phone"></i></span> Điện thoại</div>
                                <div><span class="icon"><i class="fas fa-shower"></i></span> Vòi sen</div>
                                <div><span class="icon"><i class="fas fa-snowflake"></i></span> Điều hoà không khí</div>
                                <div><span class="icon"><i class="fas fa-bed"></i></span> Dép đi trong nhà</div>
                                <div><span class="icon"><i class="fas fa-utensils"></i></span> Máy sấy tóc</div>
                                <div><span class="icon"><i class="fas fa-wifi"></i></span> Mạng tốc độ cao</div>
                                <div><span class="icon"><i class="fas fa-bath"></i></span> Áo choàng tắm</div>
                                <div><span class="icon"><i class="fas fa-tv"></i></span> Flat-screen TV</div>
                                <div><span class="icon"><i class="fas fa-tshirt"></i></span> Tủ quần áo</div>
                                <div><span class="icon"><i class="fas fa-lock"></i></span> Két sắt điện tử</div>
                                <div><span class="icon"><i class="fas fa-coffee"></i></span> Wifi miễn phí</div>
                                <div><span class="icon"><i class="fas fa-temperature-high"></i></span> Ấm điện</div>
                                <div><span class="icon"><i class="fas fa-bath"></i></span> Trà & Cafe miễn phí</div>
                                <div><span class="icon"><i class="fas fa-laptop"></i></span> Bồn tắm</div>
                                <div><span class="icon"><i class="fas fa-bath"></i></span> Bàn làm việc</div>
                                <div><span class="icon"><i class="fas fa-swimming-pool"></i></span> Khăn tắm</div>
                                <div><span class="icon"><i class="fas fa-umbrella"></i></span> Ô dù</div>
                                <div><span class="icon"><i class="fas fa-cocktail"></i></span> Minibar</div>
                                <div><span class="icon"><i class="fas fa-bed"></i></span> Giường lớn</div>
                            </div>';
                        } else {
                            echo '<h5>Tiện Ích:</h5>';
                            echo '<div class="utility-icons-container">
                                <div><span class="icon"><i class="fas fa-heartbeat"></i></span> Cân sức khỏe</div>
                                <div><span class="icon"><i class="fas fa-phone"></i></span> Điện thoại</div>
                                <div><span class="icon"><i class="fas fa-shower"></i></span> Vòi sen</div>
                                <div><span class="icon"><i class="fas fa-snowflake"></i></span> Điều hoà không khí</div>
                                <div><span class="icon"><i class="fas fa-bed"></i></span> Dép đi trong nhà</div>
                                <div><span class="icon"><i class="fas fa-utensils"></i></span> Máy sấy tóc</div>
                                <div><span class="icon"><i class="fas fa-wifi"></i></span> Mạng tốc độ cao</div>
                                <div><span class="icon"><i class="fas fa-bath"></i></span> Áo choàng tắm</div>
                                <div><span class="icon"><i class="fas fa-tv"></i></span> Flat-screen TV</div>
                                <div><span class="icon"><i class="fas fa-tshirt"></i></span> Tủ quần áo</div>
                                <div><span class="icon"><i class="fas fa-couch"></i></span> Phòng khách</div>
                                <div><span class="icon"><i class="fas fa-lock"></i></span> Két sắt điện tử</div>
                                <div><span class="icon"><i class="fas fa-wifi"></i></span> Wifi miễn phí</div>
                                <div><span class="icon"><i class="fas fa-temperature-high"></i></span> Ấm điện</div>
                                <div><span class="icon"><i class="fas fa-coffee"></i></span> Trà & Cafe miễn phí</div>
                                <div><span class="icon"><i class="fas fa-bath"></i></span> Bồn tắm</div>
                                <div><span class="icon"><i class="fas fa-laptop"></i></span> Bàn làm việc</div>
                                <div><span class="icon"><i class="fas fa-bath"></i></span> Khăn tắm</div>
                                <div><span class="icon"><i class="fas fa-swimming-pool"></i></span> Bể bơi</div>
                                <div><span class="icon"><i class="fas fa-umbrella"></i></span> Ô dù</div>
                                <div><span class="icon"><i class="fas fa-cocktail"></i></span> Minibar</div>
                                <div><span class="icon"><i class="fas fa-bed"></i></span> Giường lớn</div>
                                <div><span class="icon"><i class="fas fa-temperature-low"></i></span> Tủ lạnh</div>
                            </div>';
                        }

                        ?>
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