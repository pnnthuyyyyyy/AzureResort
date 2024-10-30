<?php
session_start();

try {
    // Lấy dữ liệu từ form
    $ngayNhanPhong = isset($_POST['ngayNhanPhong']) ? $_POST['ngayNhanPhong'] : '';
    $ngayTraPhong = isset($_POST['ngayTraPhong']) ? $_POST['ngayTraPhong'] : '';
    $soPhong = isset($_POST['soPhong']) ? $_POST['soPhong'] : '';
    $tenGoiDichVu = isset($_POST['tenGoiDichVu']) ? $_POST['tenGoiDichVu'] : '';
    $soNguoi = isset($_POST['soNguoi']) ? $_POST['soNguoi'] : '';
    $tenUuDai = isset($_POST['tenUuDai']) ? $_POST['tenUuDai'] : null; // uuDaiID có thể null
    $soDT = isset($_POST['soDT']) ? $_POST['soDT'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $trangThai = 0;

    // Kiểm tra dữ liệu cần thiết
    if (empty($ngayNhanPhong) || empty($ngayTraPhong) || empty($soPhong) || empty($tenGoiDichVu) || empty($soNguoi) || empty($soDT) || empty($email)) {
        throw new Exception("Vui lòng điền đầy đủ thông tin.");
    }

    // Include database connection
    include("database.php");
    $conn = connect();

    // Lấy ID khách hàng từ cơ sở dữ liệu
    $query = "SELECT id FROM khachhang WHERE sdt = ? AND email = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute(array($soDT, $email));
    $khachHang = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$khachHang) {
        throw new Exception("Khách hàng không tồn tại.");
    }
    $khachHangID = $khachHang['id'];

    // Bắt đầu một giao dịch PDO
    $conn->beginTransaction();
    $transactionActive = true; // Biến để theo dõi trạng thái giao dịch
    // Tính toán giá trị hóa đơn
    // Lấy giá của phòng
    $query = "SELECT gia FROM phong WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute(array($soPhong));
    $giaPhong = $stmt->fetchColumn();

    // Lấy giá của gói dịch vụ
    $query = "SELECT gia FROM goidichvu WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute(array($tenGoiDichVu));
    $giaGoiDichVu = $stmt->fetchColumn();

    // Lấy giảm giá từ ưu đãi (nếu có)
    $giamGia = 0;
    if (!empty($tenUuDai)) {
        $query = "SELECT giaGiam FROM uudai WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($tenUuDai));
        $giamGia = $stmt->fetchColumn();
    }

    // Tính tổng tiền
    $tongTien = ($giaPhong + $giaGoiDichVu) * (100 - $giamGia) / 100;

    // Thêm phiếu đặt phòng vào cơ sở dữ liệu
    $query = "INSERT INTO phieudatphong (phongID, uuDaiID, goiDichVuID, khachHangID, soNguoi, tongTien, ngayDatPhong, ngayNhanPhong, TrangThai, ngayTraPhong) 
              VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute(array($soPhong, $tenUuDai, $tenGoiDichVu, $khachHangID, $soNguoi, $tongTien , $ngayNhanPhong, $trangThai, $ngayTraPhong));
    $phieuDatPhongID = $conn->lastInsertId();

    // Commit giao dịch
    $conn->commit();
    $transactionActive = false; // Đặt lại biến theo dõi trạng thái giao dịch

    $response = array(
        'success' => true,
        'message' => "Dữ liệu đã được thêm thành công!"
    );

} catch (Exception $e) {
    // Rollback giao dịch nếu có lỗi và giao dịch đang hoạt động
    if ($transactionActive) {
        $conn->rollBack();
    }
    $response = array(
        'success' => false,
        'message' => $e->getMessage()
    );
}

// Save response to session and redirect
$_SESSION['response'] = $response;
header("Location: ../phieudatphong.php");
exit();
?>
