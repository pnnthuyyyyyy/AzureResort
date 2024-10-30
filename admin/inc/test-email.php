<?php
// Đảm bảo đường dẫn đến các tệp PHPMailer đúng
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();
try {
    // Cấu hình máy chủ SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com'; // Thay 'smtp.example.com' bằng máy chủ SMTP thực tế
    $mail->SMTPAuth = true;
    $mail->Username = 'your@example.com'; // Thay 'your@example.com' bằng địa chỉ email của bạn
    $mail->Password = 'yourpassword'; // Thay 'yourpassword' bằng mật khẩu của email
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Thiết lập người gửi và người nhận
    $mail->setFrom('your@example.com', 'Your Name'); // Thay 'your@example.com' bằng địa chỉ email của bạn
    $mail->addAddress('recipient@example.com'); // Thay 'recipient@example.com' bằng địa chỉ email của người nhận

    // Thiết lập chủ đề và nội dung
    $mail->Subject = 'Test Email';
    $mail->Body = 'Hello! This is a test email.';

    // Gửi email
    if ($mail->send()) {
        echo 'Email đã được gửi thành công!';
    } else {
        echo 'Có lỗi khi gửi email: ' . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo 'Có lỗi khi gửi email: ' . $e->getMessage();
}
?>
