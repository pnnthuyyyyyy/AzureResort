<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <!-- Links -->
    <?php require('inc/links.php'); ?>
    <style>
        .pop:hover {
            border-top-color: var(--teal_hover) !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }

        .info-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .info-group h6 {
            margin-bottom: 0;
        }

        .info-group .badge {
            margin-left: 0.5rem;
        }
    </style>
</head>

<body>
    <?php
    require('inc/header.php');
    ?>
    <div class="my-5 px-4">
        <h2 class="mt-5 pt-4 text-center fw-bold">FILTERS ROOMS</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3 text-center">
            Chúng tôi luôn sẵn lòng hỗ trợ bạn với mọi thắc mắc và yêu cầu. </p>
        <p class="text-center mt-3 text-center">
            Đừng ngần ngại liên hệ với chúng tôi bất cứ lúc nào để có thông tin chi tiết về các dịch vụ của Nha Trang
            Azure hoặc để đặt chỗ.
        </p>
    </div>
    <?php
    if (isset($_POST['searchrooms'])) {
        $checkinroom = $_POST['checkinroom'];
        $checkoutroom = $_POST['checkoutroom'];
        $numberpeople = $_POST['numberpeople'];
        $sql_filer_rooms = "
        SELECT * FROM phong 
        WHERE soNguoi >= $numberpeople AND id NOT IN (
            SELECT phongID FROM phieudatphong 
            WHERE (ngayNhanPhong <= '$checkinroom' AND ngayTraPhong >= '$checkoutroom')
        )";

        $query_filer_rooms = mysqli_query($conn, $sql_filer_rooms);
        $rows = mysqli_fetch_assoc($query_filer_rooms);
    }
    ?>
    <div class="container">
        <div class="row">
            <!-- cards -->
            <div class="col-lg-12 col-md-12 px-4">
                <?php
                $sql_rooms = "SELECT * FROM phong WHERE trangThai = 1";
                $query_rooms = mysqli_query($conn, $sql_rooms);
                if (mysqli_num_rows($query_rooms) > 0) {
                    while ($row_rooms = mysqli_fetch_assoc($query_rooms)) {
                        $id = $row_rooms['id'];
                        $tenPhong = $row_rooms['tenPhong'];
                        $gia = $row_rooms['gia'];
                        $hangPhong = $row_rooms['hangPhong'];
                        if ($hangPhong == 0) {
                            $hangPhong = "Thường";
                        } elseif ($hangPhong == 1) {
                            $hangPhong = "VIP";
                        } else {
                            $hangPhong = "Tổng Thống";
                        }
                        $loaiPhong = $row_rooms['loaiPhong'];
                        if ($loaiPhong == 0) {
                            $loaiPhong = "Giường Đơn";
                        } else {
                            $loaiPhong = "Giường Đôi";
                        }
                        $dienTich = $row_rooms['dienTich'];
                        $songuoi = $row_rooms['songuoi'];
                        $hinhAnh = $row_rooms['hinhAnh'];
                        echo '
                            <div class="card mb-4 border-0 shadow">
                                <div class="row g-0 p-4 align-items-center">
                                    <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                        <img src="./admin/uploads/' . $hinhAnh . '" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                        <h5 class="mb-3">' . $tenPhong . '</h5>
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
                                            <h6 >Số Người:</h6>
                                            <span class="badge rounded-pill bg-info text-dark text-wrap lh-base">' . $songuoi . '</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                                        <a href="booking.php?id=' . $id . '" class="btn btn-sm w-100 text-white custom-bg mb-2">Đặt Phòng</a>
                                        <a href="chitietphong.php?id=' . $id . '" class="btn btn-sm w-100 btn-outline-dark">Chi Tiết Phòng</a>
                                    </div>
                                </div>
                            </div>
                            ';
                    }
                } else {
                    echo 'ERROR ROOMS';
                }

                ?>
            </div>
        </div>
    </div>
    <!-- footer -->
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