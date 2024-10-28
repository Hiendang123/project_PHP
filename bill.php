<?php
session_start(); // Bắt đầu phiên làm việc để sử dụng biến $_SESSION
error_reporting(E_ALL ^ E_DEPRECATED); // Tắt các cảnh báo liên quan đến mã lỗi 'deprecated' (lỗi đã lỗi thời)
require_once('model/connect.php'); // Kết nối đến cơ sở dữ liệu bằng file connect.php

// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error()); // Dừng chương trình nếu không thể kết nối, và hiển thị lỗi
}

// Kiểm tra xem form đã được gửi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Kiểm tra nếu phương thức yêu cầu là POST
    // Lấy dữ liệu từ form và làm sạch
    $name = trim($_POST['name']); // Lấy họ tên và loại bỏ khoảng trắng ở đầu và cuối
    $email = trim($_POST['email']); // Lấy email và loại bỏ khoảng trắng
    $phone = trim($_POST['phone']); // Lấy số điện thoại và loại bỏ khoảng trắng
    $address = trim($_POST['address']); // Lấy địa chỉ và loại bỏ khoảng trắng
    $order_date = trim($_POST['order_date']); // Lấy ngày đặt hàng và loại bỏ khoảng trắng
    // trim chức năng là loại bỏ khoảng trắng trước và sau chuỗi
    // Chức năng là lấy dữ liệu từ form và làm sạch dữ liệu từ form
    // của người dùng trước khi xử lý. Nhằm đảm bảo chính xác.

    // Kiểm tra dữ liệu đầu vào
    $errors = []; // Khởi tạo mảng lưu trữ các lỗi

    if (empty($name)) { // Kiểm tra nếu họ và tên trống
        $errors[] = "Vui lòng nhập họ và tên!"; // Thêm thông báo lỗi vào mảng
    }
    if (empty($email)) { // Kiểm tra nếu email trống
        $errors[] = "Vui lòng nhập email!"; // Thêm thông báo lỗi vào mảng
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Kiểm tra nếu email không hợp lệ
        $errors[] = "Email không hợp lệ!"; // Thêm thông báo lỗi vào mảng
    }
    if (empty($phone)) { // Kiểm tra nếu số điện thoại trống
        $errors[] = "Vui lòng nhập số điện thoại!"; // Thêm thông báo lỗi vào mảng
    }
    if (empty($address)) { // Kiểm tra nếu địa chỉ trống
        $errors[] = "Vui lòng nhập địa chỉ!"; // Thêm thông báo lỗi vào mảng
    }
    if (empty($order_date)) { // Kiểm tra nếu ngày đặt hàng trống
        $errors[] = "Vui lòng chọn ngày đặt hàng!"; // Thêm thông báo lỗi vào mảng
    } // chức năng là kiểm tra xem người dùng đã nhập dữ liệu vào chưa nếu chưa sẽ báo lỗi


    // Nếu có lỗi, hiển thị các lỗi
    if (!empty($errors)) { // Kiểm tra nếu có lỗi trong mảng. kiểm tra xem mảng $errors có chứa bất kỳ lỗi nào hay không
        foreach ($errors as $error) { // Duyệt qua từng lỗi trong mảng, mỗi phần tử là một thông báo lỗi.
            echo "<p style='color: red;'>$error</p>"; // Hiển thị thông báo lỗi
        }
    } else {
        // Nếu chương trình không lỗi thực hiện tính tổng giá trị đơn hàng từ giỏ hàng
        $total = 0; // Khởi tạo biến tổng, để bắt đầu tính tổng.
        if (isset($_SESSION['cart'])) { // Kiểm tra xem giỏ hàng đã được khởi tạo trong phiên (session) chưa. Nếu giỏ hàng tồn tại, mã sẽ tiếp tục xử lý.
            $cart = $_SESSION['cart']; // Lấy giỏ hàng từ session
            foreach ($cart as $item) { // Duyệt qua từng sản phẩm trong giỏ hàng
                $total += $item['price'] * $item['quantity']; // Tính tổng tiền (giá sản phẩm nhân với số lượng)
            }
        } // chức năng là xử lý thông báo lỗi và tính toán tổng giá trị đơn hàng từ giỏ hàng.
        // nó kiểm tra xem có lỗi nào trong dữ liệu đầu vào không và hiển thị các lỗi đó cho người dùng.
        //Nếu không có lỗi, nó sẽ tính tổng giá trị đơn hàng bằng cách duyệt qua từng sản phẩm trong giỏ hàng và cộng tổng giá trị của các sản phẩm.

        // Chuẩn bị câu lệnh SQL để chèn dữ liệu
        $sql = "INSERT INTO product_bill (name, email, phone, address, order_date, total) VALUES (?, ?, ?, ?, ?, ?)"; // Câu lệnh SQL để chèn thông tin vào bảng product_bill
        // Dấu hỏi (?) ở trong value được sử dụng như một placeholder (vị trí giữ chỗ) cho các giá trị mà bạn sẽ gán sau đó.
        // Thay vì để dữ liệu mặc định thì chúng ta sẽ để dấu (?) để khi người dùng thêm vào thì nó sẽ gán vào Values.
        
        $stmt = mysqli_prepare($conn, $sql); // Chuẩn bị câu lệnh SQL mà không thực thi nó ngay lập tức.
        mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $phone, $address, $order_date, $total); // Gán giá trị vào câu lệnh SQL ở trong values
        //Trong trường hợp này, "ssssss" chỉ định rằng tất cả các giá trị sẽ là kiểu chuỗi (string).

        // Thực hiện câu lệnh
        if (mysqli_stmt_execute($stmt)) { // Kiểm tra xem câu lệnh có thực thi thành công không
            // Lưu thông tin vào session để truy cập sau
            $_SESSION['customer_info'] = [ // Lưu thông tin khách hàng vào session
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'order_date' => $order_date,
            ];
            // Chuyển hướng đến trang success
            header("Location: success.php"); // Chuyển hướng người dùng đến trang success
            exit(); // Dừng thực thi script sau khi chuyển hướng
        } else {
            echo "<p style='color: red;'>Lỗi khi thêm đơn hàng: " . mysqli_error($conn) . "</p>"; // Hiển thị thông báo lỗi nếu không thể thêm đơn hàng
        }

        // Đóng statement
        mysqli_stmt_close($stmt); // Đóng statement sau khi thực hiện
    }
}

// Đóng kết nối
mysqli_close($conn); // Đóng kết nối đến cơ sở dữ liệu
?>
