<?php
include("./config/connect.php");
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
if (!isset($user)) {
    header("location: index.php");
    exit;
}
if (isset($_POST['btnResetPass']) && isset($_REQUEST['email']) && isset($_REQUEST['token'])) {

    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $email_recovery = $_REQUEST['email'];
    $token_recovery = $_REQUEST['token'];

    $t_date = date('Y-m-d');

    $sql_recovery = "SELECT * FROM khachhang WHERE email = '$email_recovery' AND token = '$token_recovery' AND token_created_at = '$t_date' LIMIT 1";

    $result_recovery = mysqli_query($conn, $sql_recovery);
    $row_recovery = mysqli_num_rows($result_recovery);
    $data = mysqli_fetch_assoc($result_recovery);

    if ($row_recovery == 1) {
        if ($new_password == $confirm_password) {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update_pass = "UPDATE khachhang SET password = '$new_password_hash', token_created_at = '$t_date' WHERE email = '$email_recovery' AND token = '$token_recovery'";
            $query_updatepass = mysqli_query($conn, $update_pass);
            if ($query_updatepass) {
                echo '<script>alert("Đặt mật khẩu thành công");</script>';
                echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 5000);</script>';
                echo '<style>.container { animation: fadeOut 5s ease; }</style>';
            } else {
                echo '<script>alert("Sai truy vấn");</script>';
            }
        }
    } else {
        echo '<script>alert("Email hoặc token không hợp lệ");</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set up New Password</title>
    <?php require('inc/links.php'); ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/cssreset.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold fs-3" href="index.php">AZURE RESORT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active me-2" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="rooms.php">Phòng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="services.php">Dịch vụ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="contact.php">Liên hệ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="about.php">Về Azure</a>
                    </li>
                </ul>
                <?php if (!$user) : ?>
                    <div class="d-flex">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-dark me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Đăng nhập
                        </button>
                        <!-- Dang ky -->
                        <button type="button" class="btn btn-outline-dark me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#registerModal">
                            Đăng ký
                        </button>
                    </div>
                <?php else : ?>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <span><?php echo $user['ho'] . ' ' . $user['ten']; ?></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="profile.php">Thông tin cá nhân</a></li>
                            <li><a class="dropdown-item" href="mybookings.php">Booking</a></li>
                            <li><a class="dropdown-item" href="./inc/logout.php">Đăng Xuất</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <?php
    include("./config/connect.php");
    $err = [];
    if (isset($_POST['signup'])) {

        $email_login = $_POST['email_login'];
        $password_login = $_POST['password_login'];

        $sql = "SELECT * FROM khachhang WHERE email = '$email_login' AND is_veryfied = 1";
        $query = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($query);
        $check_sdt = mysqli_num_rows($query);

        if ($check_sdt == 1) {
            $checkpass = password_verify($password_login, $data['password']);
            if ($checkpass) {
                session_start();
                $_SESSION['user'] = $data;
                header('location: ./index.php');
            } else {
                $err['password_login'] = 'Mật khẩu không chính xác!';
            }
        } else {
            $err['email_login'] = 'Email chưa được xác nhận';
        }
    }
    ?>

    <!-- Modal đăng  nhập -->
    <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="loginModalLabel">
                            <i class="bi bi-person-circle fs-3 me-2"></i> User Login
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control shadow-none" name="email_login">
                            <p class="text-danger text-center">
                                <?php echo (isset($err['email_login'])) ? $err['email_login'] : '' ?></p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control shadow-none" name="password_login">
                            <p class="text-danger text-center">
                                <?php echo (isset($err['password_login'])) ? $err['password_login'] : '' ?></p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <button type="reset" class="btn btn-dark">Reset</button>
                                <button type="submit" class="btn btn-dark" name="signup">Đăng nhập</button>
                            </div>
                            <a href="forgot_password.php" class="text-secondary text-decoration-none">Quên mật khẩu</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- Modal đăng ký -->
    <?php
    include("./config/connect.php");

    // Include the necessary SendGrid files
    require("./inc/sendgrid/sendgrid-php.php");

    // Define constants for site URL and SendGrid API key
    define('SITE_URL', 'http://localhost/Resort_Azure/');
    define('SENDGRID_API_KEY', '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');  // Replace with your actual SendGrid API key

    function send_email($toemail, $toten, $token)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("ducthinh140202@gmail.com", "Resort Azure");
        $email->setSubject("Account Verification Link");
        $email->addTo($toemail, $toten);
        $email->addContent(
            "text/html",
            "Click the link to confirm your email: <br>
         <a href='" . SITE_URL . "email_confirm.php?email_confirmation&email=$toemail&token=$token" . "'>Click Me</a>"
        );

        $sendgrid = new \SendGrid(SENDGRID_API_KEY);
        try {
            $response = $sendgrid->send($email);
            return $response->statusCode() == 202;
        } catch (Exception $e) {
            error_log('Caught exception: ' . $e->getMessage());
            return false;
        }
    }

    $err = [];
    if (isset($_POST["signin"])) {
        $hodem = $_POST["hodem"];
        $ten = $_POST["ten"];
        $email = $_POST["email"];
        $sdt = $_POST["sdt"];
        $diachi = $_POST["diachi"];
        $password = $_POST["password"];
        $repassword = $_POST["repassword"];

        $sql2 = "SELECT * FROM khachhang WHERE email = '$email'";
        $query2 = mysqli_query($conn, $sql2);
        $check_email = mysqli_num_rows($query2);
        if ($check_email > 0) {
            $err['email'] = 'Email đã tồn tại!';
        }

        $anhdaidien_name = '';
        if (isset($_FILES["anhdaidien"]) && $_FILES["anhdaidien"]["error"] === 0) {
            $anhdaidien_name = basename($_FILES["anhdaidien"]["name"]);
            $anhdaidien_tmp_name = $_FILES["anhdaidien"]["tmp_name"];
            $anhdaidien_destination = "./uploads/" . $anhdaidien_name;
            move_uploaded_file($anhdaidien_tmp_name, $anhdaidien_destination);
        }

        $token = bin2hex(random_bytes(16));
        $email_sent = send_email($email, $ten, $token);

        if ($email_sent && empty($err)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO khachhang (ho, ten, sdt, email, diaChi, hinhAnh, password, token) VALUES ('$hodem', '$ten', '$sdt', '$email', '$diachi', '$anhdaidien_name', '$hashed_password', '$token')";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo '
            <div id="signup-success" class="alert alert-success animate__animated animate__bounceIn text-center" role="alert">
                Đăng ký thành công! Vui lòng kiểm tra email để xác nhận.
            </div>
            ';
            } else {
                echo "<script>alert('Đăng ký thất bại!');</script>";
            }
        } else {
            echo "<script>alert('Không thể gửi email xác nhận. Vui lòng thử lại sau.');</script>";
        }
    }
    ?>
    <div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="loginModalLabel">
                            <i class="bi bi-person-lines-fill fs-3 me-2"></i> User Registration
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="badge rounded-pill bg-info text-dark mb-3 text-wrap lh-base">
                            Chú ý: Thông tin chi tiết khi đăng ký phải khớp với giấy tờ tùy thân (CCCD, Hộ chiếu, bằng
                            lái xe,...)
                            vì những thông tin này phục vụ cho việc check-in tại khu nghỉ dưỡng.
                        </span>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Họ đệm</label>
                                    <input type="text" class="form-control shadow-none" name="hodem" value="<?php if (isset($_POST['hodem'])) echo $_POST['hodem'];
                                                                                                            else echo ''; ?>">
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-md-6 p-0">
                                    <label class="form-label">Tên</label>
                                    <input type="text" class="form-control shadow-none" name="ten" value="<?php if (isset($_POST['ten'])) echo $_POST['ten'];
                                                                                                            else echo ''; ?>">
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control shadow-none" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'];
                                                                                                                else echo ''; ?>">
                                    <p class="text-danger"><?php echo (isset($err['email'])) ? $err['email'] : '' ?></p>
                                </div>
                                <div class="col-md-6 p-0">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="phone" class="form-control shadow-none" name="sdt" value="<?php if (isset($_POST['sdt'])) echo $_POST['sdt'];
                                                                                                            else echo ''; ?>">
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control shadow-none" name="diachi" value="<?php if (isset($_POST['diachi'])) echo $_POST['diachi'];
                                                                                                                else echo ''; ?>">
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-md-6 p-0">
                                    <label class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="form-control shadow-none" name="anhdaidien">
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Mật khẩu</label>
                                    <input type="password" class="form-control shadow-none" name="password">
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-md-6 p-0">
                                    <label class="form-label">Xác nhận mật khẩu</label>
                                    <input type="password" class="form-control shadow-none" name="repassword">
                                    <p class="text-danger"></p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center my-1">
                            <button type="reset" class="btn btn-dark">Reset</button>
                            <button type="submit" class="btn btn-dark" name="signin">Đăng ký</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var isFormServerValidated = false;
            var form = document.querySelector('#registerModal form');
            var isFormValid = false;

            var inputFields = document.querySelectorAll('#registerModal input');
            inputFields.forEach(function(inputField) {
                inputField.addEventListener('blur', function() {
                    validateInput(this);
                });
            });

            form.addEventListener('submit', function(event) {
                var hasError = false;

                inputFields.forEach(function(inputField) {
                    if (!validateInput(inputField)) {
                        hasError = true;
                    }
                });

                if (hasError || !isFormValid) {
                    event.preventDefault();
                }
            });

            function validateInput(input) {
                var errorElement = input.nextElementSibling;
                var errorMessage = '';
                switch (input.name) {
                    case 'hodem':
                        errorMessage = input.value.trim() === '' ? 'Vui lòng nhập trường này!' : '';
                        break;
                    case 'ten':
                        errorMessage = input.value.trim() === '' ? 'Vui lòng nhập đầy đủ họ tên!' : '';
                        break;
                    case 'email':
                        errorMessage = input.value.trim() === '' ? 'Vui lòng nhập đầy đủ email!' : '';
                        break;
                    case 'sdt':
                        errorMessage = input.value.trim() === '' ? 'Vui lòng nhập đầy đủ số điện thoại!' : '';
                        break;
                    case 'diachi':
                        errorMessage = input.value.trim() === '' ? 'Vui lòng nhập đầy đủ địa chỉ!' : '';
                        break;
                    case 'password':
                        errorMessage = input.value.trim() === '' ? 'Vui lòng nhập đầy đủ mật khẩu!' : '';
                        break;
                    case 'repassword':
                        var passwordInput = document.querySelector('input[name="password"]');
                        errorMessage = input.value.trim() === '' ? 'Vui lòng nhập lại mật khẩu!' : (input.value
                            .trim() !== passwordInput.value.trim() ? 'Mật khẩu nhập lại không đúng!' : '');
                        break;
                    default:
                        errorMessage = '';
                        break;
                }
                errorElement.textContent = errorMessage;
                isFormValid = errorMessage === '';
                return isFormValid;
            }
        });
        var signupSuccess = document.getElementById('signup-success');
        signupSuccess.style.display = 'block';
        setTimeout(function() {
            signupSuccess.style.display = 'none';
        }, 10000);
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', function(event) {
                var sdt_login = document.getElementById('sdt_login').value.trim();
                var password_login = document.getElementById('password_login').value.trim();
                var hasError = false;

                document.getElementById('sdt_login_error').textContent = '';
                document.getElementById('password_login_error').textContent = '';

                if (sdt_login === '') {
                    document.getElementById('sdt_login_error').textContent = 'Vui lòng nhập số điện thoại!';
                    hasError = true;
                }

                if (password_login === '') {
                    document.getElementById('password_login_error').textContent = 'Vui lòng nhập mật khẩu!';
                    hasError = true;
                }

                if (hasError) {
                    event.preventDefault();
                }
            });
        });
    </script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Đặt lại mật khẩu</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="new_password">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                <div id="new_password_error" class="error-message"></div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Nhập lại mật khẩu mới</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <div id="confirm_password_error" class="error-message"></div>
                            </div>
                            <button type="submit" class="btn btn-custom btn-block" name="btnResetPass">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function validateForm() {
            var newPassword = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var newPasswordError = document.getElementById("new_password_error");
            var confirmPasswordError = document.getElementById("confirm_password_error");
            var isValid = true;

            newPasswordError.innerHTML = "";
            confirmPasswordError.innerHTML = "";

            if (newPassword.length < 8) {
                newPasswordError.innerHTML = "Mật khẩu ít nhất 8 kí tự.";
                isValid = false;
            }
            if (newPassword !== confirmPassword) {
                confirmPasswordError.innerHTML = "Mật khẩu nhập vào phải giống nhau!";
                isValid = false;
            }

            return isValid;
        }
    </script>
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