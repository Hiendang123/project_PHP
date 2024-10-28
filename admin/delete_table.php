<?php
require_once("../model/connect.php"); // Kết nối đến cơ sở dữ liệu

// Kiểm tra nếu có id được truyền đến
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Lấy ID từ query string (URL)

    // Câu lệnh SQL để xóa dữ liệu
    $sql = "DELETE FROM product_bill WHERE id = $id";

    if ($conn->query($sql) === TRUE) { // Thực thi câu lệnh xóa
        // Chuyển hướng trở lại với thông báo thành công
        header("Location: order-list.php?ps=1");
    } else {
        // Chuyển hướng trở lại với thông báo lỗi
        header("Location: order-list.php?pf=1");
    }
}

$conn->close(); // Đóng kết nối đến cơ sở dữ liệu
?>
