<?php
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        echo "<script>window.location.href='index.php';</script>";
    }
    include_once('inc/database.php');
    $gdv = show("SELECT * FROM khachhang");
    $ks = show("SELECT * FROM khachsan");
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
                <h1 class="h2">Quản lý khách hàng</h1>
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
                    <form action="inc/add-user-khachhang.php" method="post" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ho" class="form-label">Họ: </label>
                                <input type="text" class="form-control" id="ho" name="ho" placeholder="Nhập họ">
                            </div>
                            <div class="col-md-6">
                                <label for="ten" class="form-label">Tên: </label>
                                <input type="text" class="form-control" id="ten" name="ten" placeholder="Nhập tên">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                    <label for="soDT" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" id="soDT" name="soDT" placeholder="Nhập SĐT">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Nhập email">
                                </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                    <label for="diaChi" class="form-label">Địa chỉ</label>
                                    <textarea class="form-control" id="diaChi" name="diaChi" placeholder="Nhập Địa chỉ"></textarea>    
                                </div>
                        </div>
                        <label for="" class="form-label">*Mật khẩu mặc định khi tạo cho khách hàng là : 1111</label><br>
                        <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
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
                
            <div class="table-responsive" id="collapse1">
                <h2>Danh sách tài khoản admin</h2>
                <table class="table table-striped table-sm table-bordered pt-6">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ</th>
                            <th>Tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                <tbody>
                <?php foreach ($gdv as $pnk) { ?>
                    <tr>
                        <td><?php echo $pnk['id'] ?></td>
                        <td><?php echo $pnk['ho'] ?></td>
                        <td><?php echo $pnk['ten'] ?></td>
                        <td><?php echo $pnk['sdt'] ?></td>
                        <td><?php echo $pnk['email'] ?></td>
                        <td><?php echo $pnk['diaChi'] ?></td>
                        <td><?php echo $pnk['date'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </main>
    </div>
</div>

<?php include_once('inc/scripts.php')?>
<!-- <script src="./admin/js/add-room.php"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
<script>
    
    // SỬA gói dịch vụ
    document.addEventListener('DOMContentLoaded', function () {
        var updateButtons = document.querySelectorAll('.updateBtn');
        updateButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var modal = new bootstrap.Modal(document.getElementById('myModal'), {});
                document.getElementById('updateID').value = button.getAttribute('data-id');
                document.getElementById('updateTrangThai').value = button.getAttribute('data-trangThai');
                document.getElementById('updateTenAdmin').value = button.getAttribute('data-tenAdmin');
                document.getElementById('updateMatKhau').value = button.getAttribute('data-matKhau');
                
                modal.show();
            });
        });
        
        
        // Lắng nghe sự kiện click cho nút "Cập Nhật"
        $(document).on('click', '#updateUserBtn', function() {
            // Lấy dữ liệu từ các input trong modal
            var updateID = $('#updateID').val();
            var updatetrangThai = $('#updateTrangThai').val();
            var updatetenAdmin = $('#updateTenAdmin').val();
            var updatematKhau = $('#updateMatKhau').val();

            // Kiểm tra các giá trị đầu vào trước khi gửi yêu cầu Ajax
            if (!updateID || !updatetrangThai || !updatetenAdmin || !updatematKhau) {
                alert('Vui lòng điền đầy đủ thông tin.');
                return;
            }

            // Tạo formData để gửi dữ liệu và file hình ảnh lên server
            var formData = new FormData();
            formData.append('id', updateID);
            formData.append('trangThai', updatetrangThai);
            formData.append('admin_name', updatetenAdmin);
            formData.append('admin_pass', updatematKhau);

                // Gửi request Ajax
                $.ajax({
                    url: 'inc/update-user-admin.php',
                    method: 'POST',
                    data: formData,
                    processData: false, // Không xử lý dữ liệu (formData) thành chuỗi query
                    contentType: false, // Không thiết lập header 'Content-Type'
                    success: function(data) {
                        // Xử lý phản hồi từ server
                        alert(data.message);
                        if (data.status === 'success') {
                            // Đóng modal sau khi cập nhật thành công
                            var modal = bootstrap.Modal.getInstance(document.getElementById('myModal'));
                            modal.hide();
                            // Reload trang để cập nhật dữ liệu mới
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra trong quá trình xử lý yêu cầu.');
                    }
                });
            });


        
        //lắng nghe sự kiện cho nút XÓA gói dịch vụ
        $(document).on('click', '#deleteBtn', function(e) {
                e.preventDefault();
                // Lấy mã kho từ thuộc tính data
                var id = $(this).data('id');
                // console.log(maKho)
                // Kiểm tra nếu người dùng chắc chắn muốn xóa
                var isConfirmed = confirm('Bạn có chắc chắn muốn xóa?');

                if (isConfirmed && id) {
                    // Thực hiện Ajax request khi người dùng nhấp vào nút xóa
                    $.ajax({
                        url: 'inc/delete-user-admin.php', // Đường dẫn tới file PHP xử lý xóa trên server
                        method: 'POST',
                        data: { id: id },
                        dataType: 'json',
                        success: function(response) {
                            // Xử lý phản hồi từ server
                            alert(response.message);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert('Có lỗi xảy ra trong quá trình xử lý yêu cầu.');
                            console.error('Error:', error);
                        }
                    });
                }
            });

        

   

    });
</script>


</body>
</html>
