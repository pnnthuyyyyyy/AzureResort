<?php
session_start();
if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
    echo "<script>window.location.href='index.php';</script>";
}
include_once("inc/upload.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Upload Ảnh</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./css/common.css">
     <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <?php require('inc/links.php')?>
</head>
<body>
    <div class="container">
        <h1>Ảnh chi tiết của phòng</h1>
        <form action="inc/upload.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_phong" value="<?php echo isset($_GET['id_phong']) ? intval($_GET['id_phong']) : 0; ?>">
            <div class="form-group">
                <label for="anh_phong">Chọn ảnh:</label>
                <input type="file" name="anh_phong[]" multiple class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3" >Upload Ảnh</button>
        </form>
        <button type="button" class="btn btn-primary mt-3 mb-4">
            <a href="./phong.php" class="text-decoration-none text-white">Quay lại quản lý phòng</a>
        </button>

        <h1>Danh sách ảnh chi tiết</h1>
        <div class="row mt-4">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID Ảnh</th>
                        <th>ID Phòng</th>
                        <th>Hiển thị hình ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $image): ?>
                        <tr>
                            <td><?php echo $image['id_image_phong']; ?></td>
                            <td><?php echo $image['id_phong']; ?></td>
                            <td><img src="uploads/<?php echo $image['anh_phong']; ?>" class="img-thumbnail" alt="Ảnh phòng" style="width: 150px; height: auto;"></td>
                            <td>
                                <!-- Nút sửa -->
                                <button class="btn btn-primary edit-image" data-id="<?php echo $image['id_image_phong']; ?>">Sửa</button>
                                <!-- Nút xóa -->
                                <button class="btn btn-danger delete-image" data-id="<?php echo $image['id_image_phong']; ?>">Xóa</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Không có ảnh nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include_once('inc/scripts.php')?>
<!-- <script src="./admin/js/add-room.php"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        // Xử lý sự kiện click cho nút Sửa
        $('.edit-image').on('click', function() {
            var idImage = $(this).data('id');
            // Điều hướng đến trang sửa ảnh với id ảnh
            window.location.href = 'edit_image.php?id_image_phong=' + idImage;
        });

        // Xử lý sự kiện click cho nút Xóa
        $('.delete-image').on('click', function() {
            if (confirm('Bạn có chắc chắn muốn xóa ảnh này không?')) {
                var idImage = $(this).data('id');
                // Gửi yêu cầu xóa ảnh đến server
                $.post('delete_image.php', { id_image_phong: idImage }, function(response) {
                    if (response.success) {
                        location.reload(); // Tải lại trang sau khi xóa thành công
                    } else {
                        alert('Có lỗi xảy ra khi xóa ảnh.');
                    }
                }, 'json');
            }
        });
    });
    </script>
</body>
</html>


