<?php
// Kết nối đến cơ sở dữ liệu
include("essentials.php");
function connect() {
    $host = 'localhost:3307';
    $db_name = 'khunghiduong';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("set names utf8");
        return $conn;
    } catch(PDOException $e) {
        echo 'Lỗi kết nối: ' . $e->getMessage();
        return null;
    }
}

// Đăng nhập
function login($admin_name, $admin_pass) {
    $conn = connect();

    if ($conn) {
        $query = 'SELECT * FROM admin WHERE admin_name = :admin_name AND admin_pass = :admin_pass AND trangThai = 1';
        $stmt = $conn->prepare($query);
        
        // $admin_pass = md5($admin_pass);
        
        $stmt->bindParam(':admin_name', $admin_name);
        $stmt->bindParam(':admin_pass', $admin_pass);
        
        $stmt->execute();
        
        $count = $stmt->rowCount();
        
        if($count > 0) {
            $_SESSION['adminLogin'] = $admin_name;
            alert('success', 'Login successful - Đăng nhập thành công !');
            direct('./dashboard/index.php');
        } else {
            alert('error', 'Login fail - Sai tên đăng nhập/ mật khẩu hoặc tài khoản đã dừng hoạt động !');
            
        }
    }
}
function show($query)
    {
        $conn = connect();   
        // Câu truy vấn

        // Thực hiện truy vấn
        $stmt = $conn->prepare($query);
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return  $result;
    }
    function showTK($query, $params = array()) {
        try {
            $conn = connect();
    
            $stmt = $conn->prepare($query);
            $stmt->execute($params);
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    
function option_khachsan()
{
    
    $conn = connect();
    // Truy vấn để lấy danh sách khách sạn
    $sql = "SELECT id, tenKhachSan FROM khachsan";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Hiển thị danh sách khách sạn trong dropdown menu
    while ($row = $stmt->fetch()) {
        echo "<option value='" . $row['id'] . "'>" . $row['tenKhachSan'] . "</option>";
    }
       
}
function option_goidichvu()
{
    
    $conn = connect();
    // Truy vấn để lấy danh sách khách sạn
    $sql = "SELECT id, tenGoi FROM goidichvu";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Hiển thị danh sách khách sạn trong dropdown menu
    while ($row = $stmt->fetch()) {
        echo "<option value='" . $row['id'] . "'>" . $row['tenGoi'] . "</option>";
    }
       
}
function option_uudai()
{
    
    $conn = connect();
    // Truy vấn để lấy danh sách khách sạn
    $sql = "SELECT id, tenUuDai FROM uudai";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Hiển thị danh sách khách sạn trong dropdown menu
    while ($row = $stmt->fetch()) {
        echo "<option value='" . $row['id'] . "'>" . $row['tenUuDai'] . "</option>";
    }
       
}
function ten_khachsan($khachSanID)
{
    $conn = connect();
    // Truy vấn để lấy tên khách sạn
    $sql = "SELECT tenKhachSan FROM khachsan WHERE id = :khachSanID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':khachSanID', $khachSanID, PDO::PARAM_INT);
    $stmt->execute();

    // Lấy tên khách sạn
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        return $row['tenKhachSan'];
    } else {
        return 'Không tìm thấy khách sạn';
    }
}


?>
