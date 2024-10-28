<?php
session_start(); // Bắt đầu session để lưu trữ dữ liệu giỏ hàng
require_once("model/connect.php"); // Kết nối cơ sở dữ liệu từ file connect.php

// Kiểm tra id từ GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Lấy ID sản phẩm từ URL và chuyển nó thành số nguyên, mặc định là 0 nếu không có id

// Lấy sản phẩm từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?"); // Chuẩn bị câu lệnh SQL để lấy thông tin sản phẩm dựa trên ID

/*
Hàm prepare() được dùng để chuẩn bị câu truy vấn SQL có sử dụng placeholder (dấu ?).
Thay vì đưa biến trực tiếp vào câu lệnh SQL (dễ gây ra lỗ hổng bảo mật như SQL injection), 
bạn sẽ chuẩn bị trước câu lệnh với các vị trí chờ (?).
Sau đó, bạn có thể truyền dữ liệu vào an toàn qua các hàm khác.
Placeholder ?: Đây là vị trí mà giá trị của $id sẽ được đưa vào sau này, 
khi bạn sử dụng hàm bind_param()
*/


$stmt->bind_param("i", $id); // Gán giá trị ID vào câu truy vấn với kiểu số nguyên (i = integer)

/*
Hàm bind_param() được sử dụng để gắn giá trị thực tế (trong trường hợp này là $id) vào vị trí placeholder (?) trong câu lệnh SQL.
"i" đại diện cho integer (số nguyên)
Nghĩa là khi câu lệnh này thức hiện nó sẽ gán vào đoạn code trên.
*/


$stmt->execute(); // Thực thi câu lệnh SQL

/*
 Sau khi đã chuẩn bị và gắn giá trị cho các placeholder,
 bạn cần thực thi câu lệnh SQL với hàm execute(). 
 Đây là bước mà truy vấn thực sự được gửi tới máy chủ cơ sở dữ liệu để lấy dữ liệu.
*/

$result = $stmt->get_result(); // Lấy kết quả trả về từ câu truy vấn

/*
 Sau khi truy vấn SQL được thực hiện thành công, hàm get_result() sẽ lấy về kết quả từ câu lệnh SELECT trước đó.
 Kết quả này được trả về dưới dạng đối tượng mysqli_result, mà bạn có thể dùng để truy xuất dữ liệu.
 */


$product = $result->fetch_assoc(); // Lấy một dòng dữ liệu dưới dạng mảng liên kết (assoc) chứa thông tin sản phẩm

/*
Hàm fetch_assoc() được sử dụng để lấy một dòng kết quả từ tập dữ liệu trả về (nếu có) dưới dạng mảng liên kết.
Mỗi cột trong cơ sở dữ liệu sẽ tương ứng với một phần tử của mảng,
với khó_a là tên của cột và giá trị là dữ liệu trong cột đó.
Đây là cách lấy thông tin sản phẩm từ kết quả truy vấn. 
Dữ liệu sản phẩm sẽ được lưu dưới dạng mảng và có thể truy cập thông qua các khó_a như name, price, v.v.
*/

//Hàm $stmt được sử dụng trong đoạn mã này là để thực hiện một truy vấn có chuẩn bị (prepared statement) trong MySQL, thông qua API mysqli:
// Bảo mật chống SQL Injection
// Hiệu suất tốt hơn
//Dễ bảo trì và gọn gàng

// Kiểm tra nếu sản phẩm tồn tại
if (!$product) { 
    die("Sản phẩm không tồn tại."); // Nếu không tìm thấy sản phẩm, kết thúc và báo lỗi
}


// Tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Nếu giỏ hàng chưa tồn tại, khởi tạo giỏ hàng rỗng
}


// Kiểm tra nếu sản phẩm đã có trong giỏ hàng
$isFound = false; // Biến kiểm tra xem sản phẩm đã có trong giỏ hàng chưa (ban đầu chưa có sản phẩm trong giỏ hàng)
foreach ($_SESSION['cart'] as &$item) { // Duyệt qua từng sản phẩm trong giỏ hàng
    if ($item['id'] == $product['id']) { // Nếu tìm thấy sản phẩm có ID trùng với sản phẩm cần thêm
        $item['quantity']++; // Tăng số lượng của sản phẩm đó lên 1
        $isFound = true; // Đánh dấu đã tìm thấy sản phẩm
        break; // Thoát khỏi vòng lặp
    }
} // chức năng của nó là quản lý giỏ hàng

if (!$isFound) { // Nếu sản phẩm chưa có trong giỏ hàng
    $product['quantity'] = 1; // Đặt số lượng ban đầu là 1
    $_SESSION['cart'][] = $product; // Thêm sản phẩm mới vào giỏ hàng
} // chức năng là thêm sản phẩm mới vào giỏ hàng


// Chuyển hướng lại trang giỏ hàng
header("Location: view-cart.php"); // Sau khi thêm sản phẩm vào giỏ hàng, chuyển hướng người dùng về trang giỏ hàng
exit; // Kết thúc script sau khi chuyển hướng

?>