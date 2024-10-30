<?php
session_start();

// Kiểm tra xem request có phải là POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận dữ liệu từ form
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $khachSanID = isset($_POST['khachSanID']) ? intval($_POST['khachSanID']) : null;
    $soPhong = isset($_POST['soPhong']) ? intval($_POST['soPhong']) : null;
    $tenPhong = isset($_POST['tenPhong']) ? $_POST['tenPhong'] : null;
    $gia = isset($_POST['gia']) ? doubleval($_POST['gia']) : null;
    $hangPhong = isset($_POST['hangPhong']) ? intval($_POST['hangPhong']) : null;
    $loaiPhong = isset($_POST['loaiPhong']) ? intval($_POST['loaiPhong']) : null;
    $dienTich = isset($_POST['dienTich']) ? doubleval($_POST['dienTich']) : null;
    $songuoi = isset($_POST['songuoi']) ? intval($_POST['songuoi']) : null;
    $trangThai = isset($_POST['trangThai']) ? intval($_POST['trangThai']) : null;

   
    // Kiểm tra xem người dùng đã chọn hình ảnh mới hay không
    if(isset($_FILES['hinhAnh']['name']) && !empty($_FILES['hinhAnh']['name'])) {
        // Nếu có hình ảnh mới được chọn, thực hiện cập nhật hình ảnh
        $hinhAnh = $_FILES['hinhAnh']['name'];

        // Thư mục lưu trữ hình ảnh
        $target_dir = "../uploads/";

        // Tạo thư mục nếu nó không tồn tại
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Đường dẫn đầy đủ của hình ảnh
        $target_file = $target_dir . basename($_FILES["hinhAnh"]["name"]);
        // Di chuyển file hình ảnh vào thư mục bạn muốn
        move_uploaded_file($_FILES["hinhAnh"]["tmp_name"], $target_file);
    } else {
        // Nếu không có hình ảnh mới được chọn, giữ nguyên hình ảnh cũ
        $hinhAnh = null;
    }

    try {
        include("database.php");
        $conn = connect();

        // Sử dụng prepare statement để tránh SQL injection
        $sql = "UPDATE phong SET soPhong = :soPhong, tenPhong =:tenPhong ,gia = :gia, 
                dienTich = :dienTich, songuoi = :songuoi, loaiPhong = :loaiPhong, hangPhong = :hangPhong,
               trangThai = :trangThai ";

        // Nếu có hình ảnh mới được chọn, cập nhật hình ảnh
        if($hinhAnh != null) {
            $sql .= ", hinhAnh = :hinhAnh ";
        }

        $sql .= "WHERE id= :id AND khachSanID = :khachSanID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':soPhong', $soPhong, PDO::PARAM_INT);
        $stmt->bindParam(':tenPhong', $tenPhong, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':khachSanID', $khachSanID, PDO::PARAM_INT);
        $stmt->bindParam(':gia', $gia, PDO::PARAM_STR);
        $stmt->bindParam(':dienTich', $dienTich, PDO::PARAM_STR);
        $stmt->bindParam(':songuoi', $songuoi, PDO::PARAM_INT);
        $stmt->bindParam(':loaiPhong', $loaiPhong, PDO::PARAM_INT);
        $stmt->bindParam(':hangPhong', $hangPhong, PDO::PARAM_INT);
        $stmt->bindParam(':trangThai', $trangThai, PDO::PARAM_INT);

        // Nếu có hình ảnh mới được chọn, gắn giá trị vào prepare statement
        if($hinhAnh != null) {
            $stmt->bindParam(':hinhAnh', $hinhAnh, PDO::PARAM_STR);
            if ($stmt->execute()) 
                $response = array(
                    'status' => 'success',
                    'message' => 'Cập nhật thành công'
                );
            
        }

        if ($stmt->execute()) {
            $response = array(
                'status' => 'success',
                'message' => 'Cập nhật thành công'
            );
        } 
        else {
            $errorInfo = $stmt->errorInfo();
            $response = array(
                'status' => 'error',
                'message' => 'Không thể cập nhật dữ liệu.',
                'errorInfo' => $errorInfo
            );
        }

        $stmt->closeCursor();
        $conn = null;
    } catch (PDOException $e) {
        $response = array(
            'status' => 'error',
            'message' => 'Lỗi xảy ra: ' . $e->getMessage()
        );
    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'message' => $e->getMessage()
        );
    }

    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Nếu không phải là request POST, trả về lỗi
    $response = array(
        'status' => 'error',
        'message' => 'Yêu cầu không hợp lệ'
    );

    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>

