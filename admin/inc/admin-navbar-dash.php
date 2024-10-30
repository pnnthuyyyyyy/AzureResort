<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SlQhp3HA0+rnjbsn6GO1S5KtZkNs4XfE8A24e5XvbtxDTxI2+o78pM1+U0Xss1oD" crossorigin="anonymous">
    <style>
        .sidebar {
            width: 200px;
        }
        .nav-link {
            padding: 15px 15px;
            border-radius: 5px;
            margin: 5px 0;
            transition: background-color 0.3s;
        }
        .nav-link:hover {
            background-color: #343a40;
        }
        .nav-link.active {
            background-color: #343a40;
            color: white;
        }
        .nav-link.active:hover {
            background-color: #343a40;
        }
    </style>
</head>
<body>
<div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between border border-info">
    <h3 class="mb-0">ADMIN PANEL</h3>
    <a href="../logout.php" class="btn btn-light btn-sm">LOG OUT</a>
</div>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky">
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link text-white" aria-current="page" href="../dashboard">
                    <strong>Dashboard</strong>
                </a>
                
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../phong.php">
                    <strong>Phòng</strong>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../goidichvu.php">
                    <strong>Dịch vụ</strong>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../uudai.php">
                    <strong>Ưu đãi</strong>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../phieudatphong.php">
                    <strong>Đặt phòng</strong>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <strong>Người dùng</strong>
                </a>
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../user-admin.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../user-khachhang.php">Khách hàng</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <strong>Bài viết</strong>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <strong>Hệ thống chatbot</strong>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../thongke.php">
                    <strong>Thống kê</strong>
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-rrZoj3mzHpPTSSL2bDvxFtK2Tw0M4b3IYI+0vXkZ1OBQqKy/1MJRr/W5AqIst0M0" crossorigin="anonymous"></script>

</body>
</html>
