<?php
session_start(); // Bắt đầu session để sử dụng biến $_SESSION

// Kiểm tra xem giỏ hàng có tồn tại hay không
if (!isset($_SESSION['cart'])) { 
    $_SESSION['cart'] = []; // Nếu giỏ hàng chưa tồn tại, khởi tạo giỏ hàng rỗng
}


// Xóa sản phẩm
// Kiểm tra xem có ID trong URL không. 
if (isset($_GET['id'])) {  //Nếu có, nó sẽ tiếp tục xử lý để xóa sản phẩm có ID tương ứng trong giỏ hàng.
    $id = intval($_GET['id']); // Chuyển đổi ID thành số nguyên để bảo vệ chống tấn công

    // Lặp qua giỏ hàng để tìm sản phẩm có ID tương ứng
    foreach ($_SESSION['cart'] as $key => $item) {  // Duyệt qua từng sản phẩm trong giỏ hàng. $key là chỉ số của sản phẩm trong mảng, và $item là thông tin của sản phẩm đó.
        // Kiểm tra xem sản phẩm có ID không và so sánh với ID từ URL
        if (isset($item['id']) && $item['id'] == $id) { // kiểm trả xem sản phẩm có ID ko và so sánh với ID đã lấy từ URL
            //Nếu tìm thấy sản phẩm có ID trùng khớp, nó sẽ thực hiện các hành động bên trong khối điều kiện.
            unset($_SESSION['cart'][$key]); // Xóa sản phẩm khỏi giỏ hàng với chỉ số là $key
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Đặt lại chỉ số mảng để loại bỏ các chỉ số không liên tục sau khi xóa sản phẩm
            break; // Thoát vòng lặp khi đã xóa sản phẩm
        }
    }
}


// Chuyển hướng về trang giỏ hàng
header("Location: view-cart.php"); // Chuyển hướng người dùng về trang xem giỏ hàng
exit; // Dừng thực thi mã sau khi chuyển hướng
?>
