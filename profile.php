<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azure Resort - Thông Tin Cá Nhân</title>
    <?php require('inc/links.php'); ?>
</head>

<body>
    <?php
    require('inc/header.php');
    ?>
    <?php
    if (isset($user['id'])) {
        $id_user = $user['id'];
        $sql_info = "SELECT * FROM khachhang WHERE id = '$id_user'";
        $result_info = mysqli_query($conn, $sql_info);
        $fetch_info = mysqli_fetch_assoc($result_info);
        if (isset($_POST['btnChange'])) {
            $hodemnew = $_POST['hodemnew'];
            $tennew = $_POST['tennew'];
            $emailnew = $_POST['emailnew'];
            $sdtnew = $_POST['sdtnew'];
            $diachinew = $_POST['diachinew'];
            $matkhaunew = $_POST['matkhaunew'];
            $rematkhaunew = $_POST['rematkhaunew'];

            $anhdaidien_name = '';
            if (isset($_FILES["anhnew"]) && $_FILES["anhnew"]["error"] === 0) {
                $anhdaidien_name = basename($_FILES["anhnew"]["name"]);
                $anhdaidien_tmp_name = $_FILES["anhnew"]["tmp_name"];
                $anhdaidien_destination = "./uploads/" . $anhdaidien_name;
                move_uploaded_file($anhdaidien_tmp_name, $anhdaidien_destination);
            }

            if (isset($matkhaunew) && isset($rematkhaunew) && $matkhaunew == $rematkhaunew) {
                $pass_hash_new = password_hash($matkhaunew, PASSWORD_DEFAULT);
                $sql_change = "UPDATE khachhang SET ho = '$hodemnew', ten = '$tennew', sdt = '$sdtnew', email = '$emailnew', diaChi = '$diachinew', hinhAnh = '$anhdaidien_name', password = '$pass_hash_new' WHERE id = '$id_user'";
                $result_change_info = mysqli_query($conn, $sql_change);
                if ($result_change_info) {
                    echo '<script>confirm("Thay đổi thông tin thành công!");</script>';
                    echo '<script>window.location.href = "profile.php";</script>';
                } else {
                    echo '<script>confirm("Thay đổi thông tin thất bại!");</script>';
                    echo '<script>window.location.href = "profile.php";</script>';
                }
            } else {
                $sql_change = "UPDATE khachhang SET ho = '$hodemnew', ten = '$tennew', sdt = '$sdtnew', email = '$emailnew', diaChi = '$diachinew', hinhAnh = '$anhdaidien_name' WHERE id = '$id_user'";
                $result_change_info = mysqli_query($conn, $sql_change);
                if ($result_change_info) {
                    echo '<script>confirm("Thay đổi thông tin thành công!");</script>';
                    echo '<script>window.location.href = "profile.php";</script>';
                } else {
                    echo '<script>confirm("Thay đổi thông tin thất bại!");</script>';
                    echo '<script>window.location.href = "profile.php";</script>';
                }
            }
        }
    ?>
        <div class="container">
            <div class="row">
                <div class="col-12 my-5 px-4">
                    <h2 class="fw-bold">Thông Tin Cá Nhân</h2>
                    <div style="font-size: 14px;">
                        <a href="index.php" class="text-secondary text-decoration-none;">HOME</a>
                        <span class="text-secondary"> > </span>
                        <a href="#" class="text-secondary text-decoration-none;">Thông Tin Cá Nhân</a>
                    </div>
                </div>
                <div class="col-12 my-5 px-4">
                    <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                        <div class="text-center">
                            <img src="uploads/<?php echo $fetch_info['hinhAnh']; ?>" class="rounded img-thumbnail" alt="avatar" height="200px" width="200px">
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <h5 class="mb-3 fw-bold">Thông Tin Cá Nhân</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="form-label">Họ Đệm</label>
                                    <input type="text" type="text" class="form-control shadow-none" name="hodemnew" value="<?php echo $fetch_info['ho']; ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="form-label">Tên</label>
                                    <input type="text" type="text" class="form-control shadow-none" name="tennew" value="<?php echo $fetch_info['ten']; ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="form-label">Email</label>
                                    <input type="email" type="email" class="form-control shadow-none" name="emailnew" value="<?php echo $fetch_info['email']; ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="form-label">Số điện thoại</label>
                                    <input type="phone" type="phone" class="form-control shadow-none" name="sdtnew" value="<?php echo $fetch_info['sdt']; ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="form-label">Địa Chỉ</label>
                                    <input type="text" type="text" class="form-control shadow-none" name="diachinew" value="<?php echo $fetch_info['diaChi']; ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="form-label">Ảnh đại diện</label>
                                    <input type="file" type="file" class="form-control shadow-none" name="anhnew" value="<?php echo $fetch_info['hinhAnh']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="form-label">Mật khẩu</label>
                                    <input type="password" type="password" class="form-control shadow-none" name="matkhaunew">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="form-label">Nhập lại mật khẩu</label>
                                    <input type="password" type="password" class="form-control shadow-none" name="rematkhaunew">
                                </div>
                            </div>
                            <center><button type="submit" class="btn text-white custom-bg shadow-none" name="btnChange">Save Change</button></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {

        echo "<script>window.location.href='index.php';</script>";
    }
    ?>
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