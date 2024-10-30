<?php
session_start();

try {
    // Assign values to variables
    $soPhong = isset($_POST['soPhong']) ? $_POST['soPhong'] : '';
    $tenPhong = isset($_POST['tenPhong']) ? $_POST['tenPhong'] : '';
    $khachSanID = isset($_POST['khachSan']) ? $_POST['khachSan'] : '';
    $gia = isset($_POST['gia']) ? $_POST['gia'] : '';
    $dienTich = isset($_POST['dienTich']) ? $_POST['dienTich'] : '';
    $soNguoi = isset($_POST['songuoi']) ? $_POST['songuoi'] : '';
    $loaiPhong = isset($_POST['loaiPhong']) ? $_POST['loaiPhong'] : '';
    $hangPhong = isset($_POST['hangPhong']) ? $_POST['hangPhong'] : '';
    $trangThai = isset($_POST['trangThai']) ? $_POST['trangThai'] : '';
    
    // Check if $soPhong is not null or empty
    if (empty($soPhong)) {
        throw new Exception("Không được để trống bất kỳ trường nào.");
    }
    else if($gia<0)
    {
        throw new Exception("Giá phòng không được âm.");
    }
    else if($dienTich <= 0)
    {
        throw new Exception("Diện tích phải >0.");
    }
    else if($soNguoi<=0)
    {
        throw new Exception("Số người phải > 0.");
    }
    // Include database connection
    include("database.php");
    $conn = connect();

    // Handle image upload
    if (isset($_FILES['hinhAnh']) && $_FILES['hinhAnh']['size'] > 0) {
        $file_name = $_FILES['hinhAnh']['name'];
        $file_tmp = $_FILES['hinhAnh']['tmp_name'];
        $file_size = $_FILES['hinhAnh']['size'];
        $file_type = $_FILES['hinhAnh']['type'];

        // Check file type
        if ($file_type != "image/jpeg" && $file_type != "image/png" && $file_type != "image/gif " && $file_type != "image/jpg") {
            throw new Exception("Chỉ chấp nhận các file JPG, JPEG, PNG và GIF.");
        }

        // Check file size (max 5MB)
        if ($file_size > 5 * 1024 * 1024) {
            throw new Exception("File hình ảnh quá lớn. Vui lòng chọn file dưới 5MB.");
        }

        // Đường dẫn thư mục lưu trữ hình ảnh trên máy chủ
        $upload_folder = "../uploads/";

        // Di chuyển file tải lên vào thư mục lưu trữ trên máy chủ
        if (move_uploaded_file($file_tmp, $upload_folder . $file_name)) {
            $hinhAnh = $file_name;
        } else {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
    }
    

    // SQL statement for prepared statement
    // Check if the room number already exists
    $check_sql = "SELECT COUNT(*) FROM phong WHERE soPhong = :soPhong";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bindParam(':soPhong', $soPhong);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();

    if ($count > 0) {
        throw new Exception("Số phòng đã tồn tại. Vui lòng chọn một số phòng khác.");
    }else{
        $sql = "INSERT INTO 
        phong (soPhong, tenPhong ,khachSanID, gia, dienTich, soNguoi ,loaiPhong, hangPhong, trangThai, hinhAnh) 
        VALUES 
        (:soPhong, :tenPhong ,:khachSanID, :gia, :dienTich, :soNguoi, :loaiPhong, :hangPhong, :trangThai, :hinhAnh)
        ";
    }
    // Prepare and execute statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':soPhong', $soPhong);
    $stmt->bindParam(':tenPhong', $tenPhong);
    $stmt->bindParam(':khachSanID', $khachSanID);
    $stmt->bindParam(':gia', $gia);
    $stmt->bindParam(':dienTich', $dienTich);
    $stmt->bindParam(':soNguoi', $soNguoi);
    $stmt->bindParam(':loaiPhong', $loaiPhong);
    $stmt->bindParam(':hangPhong', $hangPhong);
    $stmt->bindParam(':trangThai', $trangThai);
    $stmt->bindParam(':hinhAnh', $hinhAnh);

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
header("refresh:0; url='../phong.php'");
?>
