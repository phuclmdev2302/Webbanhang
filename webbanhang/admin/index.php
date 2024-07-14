<!DOCTYPE html>
<html>
<head>
    <title>Trang Admin</title>
    <style>
        #sidebar {
            float: left;
            width: 200px;
            background-color: #f0f0f0;
            padding: 10px;
        }
        #content {
            margin-left: 220px; /* Khoảng cách để tránh sidebar */
            padding: 20px;
        }
        #sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        #sidebar ul li {
            margin-bottom: 10px;
        }
        #sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 5px;
            background-color: #e0e0e0;
            border-radius: 5px;
        }
        #sidebar ul li a:hover {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    // Kiểm tra xem người dùng đã đăng nhập chưa
    // $_SESSION['logged_in'] khi bắt đầu phiên làm việc, thì nó sẽ không tồn tại và sẽ trả về giá trị mặc định là null
    
    if (!isset($_SESSION['logged_in'])) {
        // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
        header('Location: ../admin/authen/login.php');
        exit;
    }
    ?>

    <div id="sidebar">
        <ul>
            <li><a href="../admin/category">Quản lý danh mục</a></li>
            <li><a href="../admin/product">Quản lý khóa học</a></li>
            <li><a href="../admin/user">Quản lý người dùng</a></li>
            <li><a href="../admin/feedback">Quản lý phản hồi</a></li>
            <li><a href="../admin/other">Các chức năng khác</a></li>
            <li><a href="../admin/authen/logout.php">Đăng xuất</a></li>
        </ul>
    </div>

    <div id="content">
        <!-- Nội dung của trang admin sẽ được tải vào đây -->
        <h1>Xin chào, đây là trang quản lý admin!</h1>
        
    </div>

</body>
</html>
