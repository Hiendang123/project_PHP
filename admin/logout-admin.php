<?php
session_start();

// Xóa tất cả các biến phiên
$_SESSION = [];

// Xóa cookie phiên nếu có
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hủy phiên
session_destroy();

// Chuyển hướng đến trang đăng nhập
header("Location: ..//user/login.php");
exit(); // Dừng thực thi script
?>
