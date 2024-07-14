<?php
// auth_model.php

// Import các tệp cấu hình và hàm trợ giúp từ thư mục database
require_once(__DIR__ . '/../../database/config.php');
require_once(__DIR__ . '/../../database/helper.php');

// Định nghĩa class AuthModel
class AuthModel {
    private $db; // Biến để lưu trữ kết nối tới cơ sở dữ liệu

    // Phương thức khởi tạo, được gọi khi tạo một đối tượng AuthModel
    public function __construct() {
        // Khởi tạo kết nối tới cơ sở dữ liệu MySQL bằng MySQLi
        $this->db = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);

        // Kiểm tra kết nối, nếu có lỗi thì hiển thị thông báo và dừng chương trình
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    // Phương thức validateUser để xác thực người dùng
    public function validateUser($username, $password) {
        // Chuẩn bị truy vấn SQL để lấy mật khẩu đã được băm từ cơ sở dữ liệu
        $stmt = $this->db->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username); // Gán giá trị vào tham số của truy vấn
        $stmt->execute(); // Thực thi truy vấn
        $stmt->bind_result($hashed_password); // Gán kết quả trả về vào biến $hashed_password
        $stmt->fetch(); // Lấy kết quả
        $stmt->close(); // Đóng câu lệnh truy vấn

        // So sánh mật khẩu đã nhập với mật khẩu đã băm lấy từ cơ sở dữ liệu
        if (password_verify($password, $hashed_password)) {
            return true; // Trả về true nếu mật khẩu khớp
        }
        return false; // Trả về false nếu mật khẩu không khớp
    }

    // Phương thức createUser để tạo người dùng mới
    public function createUser($username, $password) {
        // Băm mật khẩu trước khi lưu vào cơ sở dữ liệu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Chuẩn bị truy vấn SQL để chèn người dùng mới vào cơ sở dữ liệu
        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password); // Gán giá trị vào tham số của truy vấn
        $result = $stmt->execute(); // Thực thi truy vấn
        $stmt->close(); // Đóng câu lệnh truy vấn
        return $result; // Trả về kết quả của câu lệnh INSERT (true nếu thành công, false nếu thất bại)
    }

    // Phương thức để lấy vai trò của người dùng từ cơ sở dữ liệu
    public function getUserRole($username)
    {
        $stmt = $this->db->prepare("SELECT roles FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        $stmt->close();
        return $role; // Trả về vai trò của người dùng (user hoặc admin)
    }
}
?>
