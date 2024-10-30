<?php
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        echo "<script>window.location.href='index.php';</script>";
    }
    include_once('inc/database.php');
    $pnks = show("SELECT * FROM phong");
    $ks = show("SELECT * FROM khachsan");
    $pdp = show("SELECT * FROM phieudatphong");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        #collapse1 {
            overflow-y: scroll;
            height: 500px;
        }
    </style>
     <link rel="stylesheet" href="./css/common.css">
     <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <?php require('inc/links.php')?>
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row">
        <?php require('inc/admin-navbar1.php') ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Phiếu đặt phòng</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <span data-feather="calendar"></span>
                        This week
                    </button>
                </div>
            </div>
            <!-- quản lý -->
            <div class="row">
                <!-- add -->
                <div class="col-md-12">
                    <form action="inc/add-phieudatphong.php" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
    <div class="col-md-6">
        <label for="ngayNhanPhong" class="form-label">Ngày nhận phòng</label>
        <input type="date" class="form-control" id="ngayNhanPhong" name="ngayNhanPhong" placeholder="Nhập ngày nhận phòng">
    </div>
    <div class="col-md-6">
        <label for="ngayTraPhong" class="form-label">Ngày trả phòng</label>
        <input type="date" class="form-control" id="ngayTraPhong" name="ngayTraPhong" placeholder="Nhập ngày trả phòng">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="khachSan" class="form-label">Khách sạn</label>
        <select class="form-select" id="khachSan" name="khachSan" disabled>
            <option value="">Chọn khách sạn</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="soPhong" class="form-label">Số Phòng</label>
        <select class="form-select" id="soPhong" name="soPhong" disabled>
            <option value="">Chọn số phòng</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="tenPhong" class="form-label">Tên phòng</label>
        <input type="text" class="form-control" id="tenPhong" name="tenPhong" placeholder="Tên phòng" disabled>
    </div>
</div>

                    </form>
                    <?php
                    if (isset($_SESSION['response'])) {
                        $response_message = $_SESSION['response']['message'];
                        $is_success = $_SESSION['response']['success'];
                        ?>

                        <div class="responseMessage">
                            <p class="responseMessage <?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?>">
                            <p class="responseMessageText">
                                <?php echo $response_message ?>
                            </p>
                            </p>
                        </div>
                        <?php unset($_SESSION['response']); } ?>
                </div>
            </div>
            <!-- xem -->
            <div class="col-md-12 pt-5">
                <!-- Bảng danh sách phòng -->
                <!-- Bảng danh sách phòng -->
    <?php
    $khachSans = array();
    foreach ($pnks as $index => $pnk) {
        $khachSanID = $pnk['khachSanID'];
        if (!array_key_exists($khachSanID, $khachSans)) {
            $khachSans[$khachSanID] = array();
        }
        $khachSans[$khachSanID][] = $pnk;
    }
    ?>

    <?php foreach ($khachSans as $khachSanID => $phongs) { ?>
        <div class="table-responsive" id="collapse1">
            <h2>Khách Sạn: <?php echo ten_khachsan($khachSanID); ?></h2>
            <table class="table table-striped table-sm table-bordered pt-6">
                <thead>
                <tr>
                     
                    <th>Mã phòng</th>
                    <th>Tên phòng</th>
                    <th>Giá</th>
                    <th>Hạng phòng</th>
                    <th>Loại phòng</th>
                    <th>Diện tích</th>
                    <th>Số người</th>
                    <th>Trạng thái</th>
                    <th>Hình ảnh</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($phongs as $pnk) { ?>
                    <tr>
                        
                        <td><?php echo $pnk['soPhong'] ?></td>
                        <td><?php echo $pnk['tenPhong'] ?></td>
                        <td><?php echo $pnk['gia'] ?></td>
                        <td><?php
                            if ($pnk['hangPhong'] == 0)
                                echo "Thường";
                            else if ($pnk['hangPhong'] == 1)
                                echo "VIP";
                            else
                                echo "Tổng thống";
                            ?></td>
                        <td><?php echo $pnk['loaiPhong'] == 1 ? "Đôi" : "Đơn" ?></td>
                        <td><?php echo $pnk['dienTich'] ?></td>
                        <td><?php echo $pnk['soNguoi'] ?></td>
                        <td><?php echo $pnk['trangThai'] == 1 ? "Trống" : "Hết phòng" ?></td>
                        <td><?php echo "<img width=100 height=100 src='../admin/uploads/" . $pnk['hinhAnh'] . "' />"; ?></td>
                        <td>
                            <button class="btn btn-primary updateBtn"
                                    data-id="<?php echo $pnk['id'] ?>"
                                    data-khachSanID="<?php echo $pnk['khachSanID'] ?>"
                                    data-soPhong="<?php echo $pnk['soPhong'] ?>"
                                    data-tenPhong="<?php echo $pnk['tenPhong'] ?>"
                                    data-gia="<?php echo $pnk['gia'] ?>"
                                    data-hangPhong="<?php echo $pnk['hangPhong'] ?>"
                                    data-loaiPhong="<?php echo $pnk['loaiPhong'] ?>"
                                    data-dienTich="<?php echo $pnk['dienTich'] ?>"
                                    data-soNguoi="<?php echo $pnk['soNguoi'] ?>"
                                    data-trangThai="<?php echo $pnk['trangThai'] ?>"
                                    data-hinhAnh="<?php echo $pnk['hinhAnh'] ?>">
                                    <i class="bi bi-pencil-square">Sửa</i></button>


                                    <!-- Modal Bootstrap -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sửa thông tin phòng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="update-form" action="inc/update-phong.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="updateKhachSanID" class="form-label">Khách sạn ID</label>
                            <input type="text" class="form-control" id="updateKhachSanID" name="soPhong" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="updateID" class="form-label">Phòng ID</label>
                            <input type="text" class="form-control" id="updateID" name="id" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="updateSoPhong" class="form-label">Số phòng</label>
                            <input type="text" class="form-control" id="updateSoPhong" name="soPhong">
                        </div>
                        <div class="col-md-4">
                            <label for="updateTenPhong" class="form-label">Tên phòng</label>
                            <input type="text" class="form-control" id="updateTenPhong" name="tenPhong">
                        </div>
                        <div class="col-md-4">
                            <label for="updateGia" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="updateGia" name="gia">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="updateHangPhong" class="form-label">Hạng phòng</label>
                            <select class="form-select" id="updateHangPhong" name="hangPhong">
                                <option value="1">VIP</option>
                                <option value="0">Thường</option>
                                <option value="2">Tổng thống</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="updateLoaiPhong" class="form-label">Loại phòng</label>
                            <select class="form-select" id="updateLoaiPhong" name="loaiPhong">
                                <option value="0">Đơn</option>
                                <option value="1">Đôi</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="updateDienTich" class="form-label">Diện tích</label>
                            <input type="number" class="form-control" id="updateDienTich" name="dienTich">
                        </div>
                        <div class="col-md-4">
                            <label for="updateTrangThai" class="form-label">Trạng thái</label>
                            <select class="form-select" id="updateTrangThai" name="trangThai">
                                <option value="1">Trống</option>
                                <option value="0">Hết phòng</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="updateSoNguoi" class="form-label">Số người</label>
                            <input type="number" class="form-control" id="updateSoNguoi" name="soNguoi">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="updateHinhAnh" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" id="updateHinhAnh" name="hinhAnh">
                            <input type="hidden" id="updateHinhAnhCu" name="hinhAnhCu">
                        </div>
                        <div class="col-md-6">
                            <img id="previewUpdateHinhAnh" src="" alt="Preview Image" 
                            style="max-width: 200px; max-height: 200px;">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="updateUserBtn">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<button id="deletePhong" class="btn btn-danger" data-id="<?php echo $pnk['id']?>"><i class="bi bi-trash-fill"></i>Xóa</i></button>
<button id="chiTietPhong" class="btn btn-warning" data-id="<?php echo $pnk['id']?>"><i class="bi bi-cloud-plus-fill"></i>Ảnh chi tiết</i></button>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>
        </main>
    </div>
</div>
<?php include_once('inc/scripts.php')?>
<!-- <script src="./admin/js/add-room.php"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('ngayNhanPhong').addEventListener('change', updateKhachSanOptions);
document.getElementById('ngayTraPhong').addEventListener('change', updateKhachSanOptions);

function updateKhachSanOptions() {
    var ngayNhanPhong = document.getElementById('ngayNhanPhong').value;
    var ngayTraPhong = document.getElementById('ngayTraPhong').value;
    var today = new Date().toISOString().split('T')[0];

    // Kiểm tra ngày nhận phòng phải sau ngày hiện tại
    if (ngayNhanPhong <= today) {
        alert('Ngày nhận phòng phải sau ngày hiện tại.');
        document.getElementById('ngayNhanPhong').value = '';
        return;
    }

    // Kiểm tra ngày trả phòng phải sau ngày nhận phòng
    if (ngayTraPhong && ngayTraPhong <= ngayNhanPhong) {
        alert('Ngày trả phòng phải sau ngày nhận phòng.');
        document.getElementById('ngayTraPhong').value = '';
        return;
    }

    if (ngayNhanPhong && ngayTraPhong) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'inc/get_khachsan.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                var khachSanSelect = document.getElementById('khachSan');
                khachSanSelect.innerHTML = '<option value="">Chọn khách sạn</option>';
                response.khachsan.forEach(function (khachsan) {
                    khachSanSelect.innerHTML += '<option value="' + khachsan.id + '">' + khachsan.tenKhachSan + '</option>';
                });

                khachSanSelect.disabled = false;
                document.getElementById('soPhong').innerHTML = '<option value="">Chọn số phòng</option>';
                document.getElementById('soPhong').disabled = true;
                document.getElementById('tenPhong').value = '';
            }
        };

        xhr.send('ngayNhanPhong=' + ngayNhanPhong + '&ngayTraPhong=' + ngayTraPhong);
    }
}

document.getElementById('khachSan').addEventListener('change', function () {
    var khachSanId = this.value;
    var ngayNhanPhong = document.getElementById('ngayNhanPhong').value;
    var ngayTraPhong = document.getElementById('ngayTraPhong').value;

    if (khachSanId && ngayNhanPhong && ngayTraPhong) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'inc/get_phong.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                var soPhongSelect = document.getElementById('soPhong');
                soPhongSelect.innerHTML = '<option value="">Chọn số phòng</option>';
                response.phong.forEach(function (phong) {
                    soPhongSelect.innerHTML += '<option value="' + phong.id + '">' + phong.soPhong + '</option>';
                });

                soPhongSelect.disabled = false;
                document.getElementById('tenPhong').value = '';
            }
        };

        xhr.send('khachSanId=' + khachSanId + '&ngayNhanPhong=' + ngayNhanPhong + '&ngayTraPhong=' + ngayTraPhong);
    }
});

document.getElementById('soPhong').addEventListener('change', function () {
    var selectedOption = this.options[this.selectedIndex];
    var soPhong = selectedOption.value;

    // Gửi yêu cầu Ajax để lấy tên phòng tương ứng với số phòng đã chọn
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'inc/get_tenphong.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var tenPhong = xhr.responseText;

            // Cập nhật giá trị của input tenPhong
            document.getElementById('tenPhong').value = tenPhong;
        }
    };

    // Gửi số phòng đã chọn đến file PHP để xử lý
    xhr.send('soPhong=' + soPhong);
});


</script>

</body>
</html>
