<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <?php include("inc/links.php"); ?>
    <link rel="stylesheet" href="css/cssforgot.css">
</head>

<body>
    <?php include("inc/header.php"); ?>
    <?php
    include("./config/connect.php");
    require("./inc/sendgrid/sendgrid-php.php");
    function send_email1($toemail1, $token1, $type)
    {
        if ($type == "email_confirmation") {
            $page = "email_confirm.php";
            $subject = "Account Verification Link";
            $content = "Confirm Your Email";
        } else {
            $page = "reset_password.php";
            $subject = "Account Reset Link";
            $content = "Reset Your Account";
        }
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("ducthinh140202@gmail.com", "Resort Azure");
        $email->setSubject($subject);
        $email->addTo($toemail1);
        $email->addContent(
            "text/html",
            "Click the link to $content: <br>
                 <a href='" . SITE_URL . "$page?$type&email=$toemail1&token=$token1" . "'>Click Me</a>"
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

    $message = "";
    $messageType = "";

    if (isset($_POST['btnForgot'])) {
        $email = $_POST['forgot_email'];

        $token1 = bin2hex(random_bytes(16));
        $email_sent1 = send_email1($email, $token1, 'account_recovery');

        $sql = "SELECT * FROM khachhang WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $fetch = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        $row_id = $row['id'];
        if ($row['is_veryfied'] == 0) {
            $message = "Email chưa được kích hoạt!";
            $messageType = "danger";
        } else if (!$email_sent1) {
            $message = "Email không thể gửi!";
            $messageType = "danger";
        } else {
            $date = date('Y-m-d');
            $sql_forgot = "UPDATE khachhang SET token = '$token1', token_created_at = '$date' WHERE id = '$row_id'";
            $query_forgot = mysqli_query($conn, $sql_forgot);
            if ($query_forgot) {
                $message = "Link thay đổi đã được gửi đến email của bạn!";
                $messageType = "success";
            } else {
                $message = "Email chưa được gửi!";
                $messageType = "danger";
            }
        }
    }

    ?>

    <?php if ($message) : ?>
        <div id="alert-message" class="alert alert-<?php echo $messageType; ?> text-center">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="container form-container">
        <div class="form-box">
            <h2 class="text-center">Forgot Password</h2>
            <p class="text-center">Vui lòng nhập email của bạn, chúng tôi sẽ gửi link reset password!</p>
            <form action="" method="post" onsubmit="return validateEmail()">
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="forgot_email" placeholder="example@gmail.com">
                    <div id="error-message" class="error-message"></div>
                </div>
                <br>
                <div class="form-group d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="btnForgot">Send Link</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?php include("inc/footer.php"); ?>

    <script>
        function validateEmail() {
            var email = document.getElementById("email").value;
            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var errorMessage = document.getElementById("error-message");

            if (!regex.test(email)) {
                errorMessage.textContent = "Vui lòng nhập email hợp lệ.";
                errorMessage.style.display = "block";
                return false;
            } else {
                errorMessage.textContent = "";
                errorMessage.style.display = "none";
                return true;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var alertMessage = document.getElementById('alert-message');
            if (alertMessage) {
                setTimeout(function() {
                    alertMessage.style.display = 'none';
                }, 5000);
            }
        });
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