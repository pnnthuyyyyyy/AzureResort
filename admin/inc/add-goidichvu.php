<?php
session_start();

try {
    // Assign values to variables
    $tenGoi = isset($_POST['tenGoi']) ? $_POST['tenGoi'] : '';
    $moTa = isset($_POST['moTa']) ? $_POST['moTa'] : '';
    $gia = isset($_POST['gia']) ? $_POST['gia'] : '';
    
    // Check if $soPhong is not null or empty
    if (empty($tenGoi) && empty($moTa) && empty($gia)) {
        throw new Exception(message: "Không được để trống bất kỳ trường gì .");
    }

    // Include database connection
    include("database.php");
    $conn = connect();

    
    // SQL statement for prepared statement
    $sql = "INSERT INTO goidichvu (tenGoi, gia, moTa) VALUES 
    (:tenGoi, :gia, :moTa)";

    // Prepare and execute statement
    $stmt = $conn->prepare(query: $sql);
    $stmt->bindParam(param: ':tenGoi', var: $tenGoi);
    $stmt->bindParam(param: ':gia', var: $gia);
    $stmt->bindParam(param: ':moTa', var: $moTa);
   

    $stmt->execute();

    $response = array(
        'success' => true,
        'message' => "Dữ liệu đã được thêm thành công!"
    );
} catch (Exception $e) {
    $response = array(
        'success' => false,
        'message' => $e->getMessage()
    );
}

// Save response to session and redirect
$_SESSION['response'] = $response;
header("refresh:0; url='../goidichvu.php'");
?>
