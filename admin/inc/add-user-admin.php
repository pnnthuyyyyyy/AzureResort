<?php
session_start();

try {
    // Assign values to variables
    $admin_name = isset($_POST['tenAdmin']) ? $_POST['tenAdmin'] : '';
    $admin_pass = isset($_POST['matKhau']) ? $_POST['matKhau'] : '';
    $trangThai = isset($_POST['trangThai']) ? $_POST['trangThai'] : '';
    
    // Check if $soPhong is not null or empty
    if (empty($admin_name) && empty($admin_pass) && empty($trangThai)) {
        throw new Exception("Không được để trống bất kỳ trường nào.");
    }
    else{
        // Include database connection
        include("database.php");
        $conn = connect();

        // SQL statement for prepared statement
        $sql = "INSERT INTO admin (admin_name, admin_pass, trangThai) VALUES 
        (:admin_name, :admin_pass, :trangThai)";

        // Prepare and execute statement
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':admin_name', $admin_name);
        $stmt->bindParam(':admin_pass', $admin_pass);
        $stmt->bindParam(':trangThai', $trangThai);

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
header("refresh:0; url='../user-admin.php'");
?>
