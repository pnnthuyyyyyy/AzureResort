<?php
session_start();

try {
    // Assign values to variables
    $ho = isset($_POST['ho']) ? $_POST['ho'] : '';
    $ten = isset($_POST['ten']) ? $_POST['ten'] : '';
    $sdt = isset($_POST['soDT']) ? $_POST['soDT'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $diaChi = isset($_POST['diaChi']) ? $_POST['diaChi'] : '';
    $token = bin2hex(random_bytes(16));
    $status = 1;
    $password = "1111";
    $hashed_password = md5($password);
    $is_veryfied = 1;
    

// Tiếp theo, bạn có thể sử dụng $hashed_password để lưu vào cơ sở dữ liệu

    
    // Check if $soPhong is not null or empty
    if (empty($ho) && empty($ten) && empty($sdt) && empty($email) && empty($diaChi)) {
        throw new Exception("Không được để trống bất kỳ trường nào.");
    }
    else{
        // Include database connection
        include("database.php");
        $conn = connect();

        // SQL statement for prepared statement
        $sql = "INSERT INTO khachhang (ho, ten, sdt, email, diaChi, password, token, date, status, is_veryfied, token_created_at ) 
        VALUES 
        (:ho, :ten, :sdt, :email, :diaChi, :password, :token, NOW(), :status, :is_veryfied, NOW() )";

        // Prepare and execute statement
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ho', $ho);
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':sdt', $sdt);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':diaChi', $diaChi);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':is_veryfied', $is_veryfied);
        $stmt->execute();

        $response = array(
            'success' => true,
            'message' => "Dữ liệu đã được thêm thành công!"
        );
    }

} catch (Exception $e) {
    $response = array(
        'success' => false,
        'message' => $e->getMessage()
    );
}

// Save response to session and redirect
$_SESSION['response'] = $response;
header("refresh:0; url='../user-khachhang.php'");
?>
