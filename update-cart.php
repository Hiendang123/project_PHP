<?php 
session_start(); // Bắt đầu session để sử dụng biến $_SESSION
error_reporting(E_ALL ^ E_DEPRECATED); // Tắt các cảnh báo liên quan đến mã lỗi 'deprecated' (lỗi đã lỗi thời)
require_once('model/connect.php'); // Kết nối cơ sở dữ liệu từ file connect.php

// Kiểm tra nếu có giỏ hàng
if (!isset($_SESSION['cart'])) { 
    $_SESSION['cart'] = []; // Nếu giỏ hàng chưa tồn tại, khởi tạo giỏ hàng rỗng
}

if (isset($_POST['id']) && isset($_POST['quantity'])) {  //Kiểm tra xem có dữ liệu id và quantity được gửi từ form hay không.
    $id = $_POST['id']; // Lấy ID sản phẩm từ form gửi lên
    $quantity = (int)$_POST['quantity']; // Lấy số lượng sản phẩm từ form và ép kiểu thành số nguyên

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    foreach ($_SESSION['cart'] as &$item) { // Duyệt qua từng sản phẩm trong giỏ hàng
        if ($item['id'] == $id) { // Kiểm tra xem sản phẩm có ID trùng với sản phẩm cần cập nhật không
            $item['quantity'] = $quantity; // Cập nhật số lượng sản phẩm
            break; // Kết thúc vòng lặp sau khi tìm thấy sản phẩm
        }
    } // chức năng là cập nhật số lượng sản phẩm

    

    // Chuyển hướng về trang giỏ hàng
    header("Location: view-cart.php"); // Chuyển hướng người dùng về trang xem giỏ hàng sau khi cập nhật
    exit(); // Dừng thực thi script sau khi chuyển hướng
}
?>