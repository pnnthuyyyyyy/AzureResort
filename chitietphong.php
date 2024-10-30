<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết phòng - <?php echo isset($row_phong['tenPhong']) ? $row_phong['tenPhong'] : ''; ?></title>
    <?php require('inc/links.php'); ?>
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
    <!-- Header -->
    <?php require('inc/header.php'); ?>

    <?php
    if (isset($_REQUEST['id'])) {
        $id_phong_details = $_REQUEST['id'];
        $id = $id_phong_details;
        $sql_phong = "SELECT * FROM phong p JOIN image_phong imgp on p.id = imgp.id_phong WHERE p.id = '$id_phong_details'";
        $result_phong = mysqli_query($conn, $sql_phong);
        if (mysqli_num_rows($result_phong) > 0) {
            $row_phong = mysqli_fetch_assoc($result_phong);
            $hangPhong = $row_phong['hangPhong'];
            if ($hangPhong == 0) {
                $hangPhong = "Thường";
            } elseif ($hangPhong == 1) {
                $hangPhong = "VIP";
            } else {
                $hangPhong = "Tổng Thống";
            }
            $gia = $row_phong['gia'];
            $loaiPhong = $row_phong['loaiPhong'] == 0 ? "Giường Đơn" : "Giường Đôi";
            $dienTich = $row_phong['dienTich'];
            $songuoi = $row_phong['songuoi'];
            mysqli_data_seek($result_phong, 0);
        } else {
            echo "Không tìm thấy phòng.";
            exit;
        }
    } else {
        header('location: index.php');
        exit;
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">Chi Tiết Phòng - <?php echo $row_phong['tenPhong'] ?></h2>
                <div style="font-size: 14px;">
                    <a href="rooms.php" class="text-secondary text-decoration-none;">Phòng</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none;">Chi Tiết Phòng</a>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 px-4">
                <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $active = 'active';
                        while ($row_img = mysqli_fetch_assoc($result_phong)) {
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
            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                        echo '
                            <div class="row g-0 p-4 align-items-center">
                                <div class="col-md-12">
                                    <div class="info-group">
                                        <h6>Loại Phòng:</h6>
                                        <span class="badge rounded-pill bg-info text-dark text-wrap lh-base">' . $loaiPhong . '</span>
                                    </div>
                                    <div class="info-group">
                                        <h6>Giá:</h6>
                                        <span class="badge rounded-pill bg-info text-dark text-wrap lh-base">' . number_format($gia) . ' VND per night</span>
                                    </div>
                                    <div class="info-group">
                                        <h6>Diện Tích:</h6>
                                        <span class="badge rounded-pill bg-info text-dark text-wrap lh-base">' . $dienTich . ' m²</span>
                                    </div>
                                    <div class="info-group">
                                        <h6>Hạng Phòng:</h6>
                                        <span class="badge rounded-pill bg-info text-dark text-wrap lh-base">' . $hangPhong . '</span>
                                    </div>
                                    <div class="info-group">
                                        <h6>Số Người:</h6>
                                        <span class="badge rounded-pill bg-info text-dark text-wrap lh-base">' . $songuoi . '</span>
                                    </div>
                                    <a href="booking.php?id=' . $id . '" class = "btn w-100 text-while custom-bg shadow-none mb-2">Đặt Ngay</a>
                                    <a href="rooms.php" class="btn btn-sm w-100 btn-outline-dark" role="button">Quay Lại</a>
                                </div>
                            </div>
                            ';
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                        if ($hangPhong == "Thường") {
                            echo '<h5>MÔ TẢ:</h5>';
                            echo '<p>' . $row_phong['mota'] . '</p>';
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
                        } else if ($hangPhong == "VIP") {
                            echo '<h5>MÔ TẢ:</h5>';
                            echo '<p>' . $row_phong['mota'] . '</p>';
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
                            echo '<h5>MÔ TẢ:</h5>';
                            echo '<p>' . $row_phong['mota'] . '</p>';
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
    </div>

    <!-- Footer -->
    <?php require('inc/footer.php'); ?>
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