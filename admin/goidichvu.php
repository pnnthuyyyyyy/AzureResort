<?php
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        echo "<script>window.location.href='index.php';</script>";
    }
    include_once('inc/database.php');
    $gdv = show("SELECT * FROM goidichvu");
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
                <h1 class="h2">Gói dịch vụ</h1>
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
                    <form action="inc/add-goidichvu.php" method="post" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tenGoi" class="form-label">Tên gói dịch vụ</label>
                                <input type="text" class="form-control" id="tenGoi" name="tenGoi" placeholder="Nhập tên gói dịch vụ">
                            </div>
                            <div class="col-md-6">
                                <label for="gia" class="form-label">Giá</label>
                                <input type="number" class="form-control" id="gia" name="gia" placeholder="Nhập giá">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                    <label for="moTa" class="form-label">Mô tả</label>
                                    <textarea class="form-control" id="moTa" name="moTa" placeholder="Nhập mô tả"></textarea>
                            </div>
                            
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm gói dịch vụ</button>
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
                <h2>Danh sách các gói dịch vụ</h2>
                <table class="table table-striped table-sm table-bordered pt-6">
                    <thead>
                        <tr>
                            <th>Mã gói dịch vụ</th>
                            <th>Tên gói dịch vụ</th>
                            <th>Giá</th>
                            <th>Mô tả</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                <tbody>
                <?php foreach ($gdv as $pnk) { ?>
                    <tr>
                        <td><?php echo $pnk['id'] ?></td>
                        <td><?php echo $pnk['tenGoi'] ?></td>
                        <td><?php echo number_format($pnk['gia'], 0, '.', '.'); ?></td>
                        <td><?php echo $pnk['moTa'] ?></td>
                        <td>
                            <button class="btn btn-primary updateBtn"
                                    data-id="<?php echo $pnk['id'] ?>"
                                    data-moTa="<?php echo $pnk['moTa'] ?>"
                                    data-tenGoi="<?php echo $pnk['tenGoi'] ?>"
                                    data-gia="<?php echo $pnk['gia'] ?>">
                                <i class="fa fa-pencil">Sửa</i></button>


                                    <!-- Modal Bootstrap -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sửa thông tin gói dịch vụ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="update-form" action="inc/update-phong.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                        
                        <div class="col-md-6">
                            <label for="updateID" class="form-label">gói dịch vụ ID</label>
                            <input type="text" class="form-control" id="updateID" name="id" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="updateTenGoi" class="form-label">Tên gói dịch vụ</label>
                            <input type="text" class="form-control" id="updateTenGoi" name="tenGoi">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="updateGia" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="updateGia" name="gia">
                        </div>
                        <div class="col-md-6">
                            <label for="updateMoTaoTa" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="updateMoTa" name="moTa"></textarea>
                            <!-- <input type="text" class="form-control" id="updateMoTa" name="moTa"> -->
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" id="updateUserBtn">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<button id="deleteGDV" class="btn btn-danger" data-id="<?php echo $pnk['id']?>"><i class="fa fa-trash">Xóa</i></button>
                                </td>
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
                document.getElementById('updateMoTa').value = button.getAttribute('data-moTa');
                document.getElementById('updateTenGoi').value = button.getAttribute('data-tenGoi');
                document.getElementById('updateGia').value = button.getAttribute('data-gia');
                
                modal.show();
            });
        });
        
        // Lắng nghe sự kiện click cho nút "Cập Nhật"
        document.getElementById('updateUserBtn').addEventListener('click', function() {
            // Lấy dữ liệu từ các input trong modal
            var updateID = document.getElementById('updateID').value;
            var updateMoTa = document.getElementById('updateMoTa').value;
            var updateTenGoi = document.getElementById('updateTenGoi').value;
            var updateGia = document.getElementById('updateGia').value;
            
            // Tạo formData để gửi dữ liệu và file hình ảnh lên server
            var formData = new FormData();
            formData.append('id', updateID);
            formData.append('moTa', updateMoTa);
            formData.append('tenGoi', updateTenGoi);
            formData.append('gia', updateGia);

            // Gửi request Ajax
            $.ajax({
                url: 'inc/update-goidichvu.php',
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
                    alert('Update thành công !.');
                    location.reload();
                }
            });
        });


        //lắng nghe sự kiện cho nút XÓA gói dịch vụ
        $(document).on('click', '#deleteGDV', function(e) {
                e.preventDefault();
                // Lấy mã kho từ thuộc tính data
                var id = $(this).data('id');
                // console.log(maKho)
                // Kiểm tra nếu người dùng chắc chắn muốn xóa
                var isConfirmed = confirm('Bạn có chắc chắn muốn xóa?');

                if (isConfirmed && id) {
                    // Thực hiện Ajax request khi người dùng nhấp vào nút xóa
                    $.ajax({
                        url: 'inc/delete-goidichvu.php', // Đường dẫn tới file PHP xử lý xóa trên server
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
