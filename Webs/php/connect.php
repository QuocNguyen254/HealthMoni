<?php
$servername = "localhost";
$username = "root"; // Sửa lại thành tài khoản mặc định
$password = ""; // Mật khẩu trống nếu bạn chưa đặt
$dbname = "healthmoni"; // Tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}
// echo "Kết nối thành công";

?>
