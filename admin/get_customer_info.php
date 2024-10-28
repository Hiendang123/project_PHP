<?php
require_once("../model/connect.php"); // Kết nối đến cơ sở dữ liệu

$id = $_GET['id']; // Lấy giá trị ID từ query string (URL)

$sql = "SELECT * FROM product_bill WHERE id = ?"; // Chuẩn bị câu truy vấn SQL với tham số

$stmt = $conn->prepare($sql); // Tạo một câu lệnh chuẩn bị để chuẩn bị câu lệnh SQL cho việc thực thi an toàn, giúp bảo vệ chống lại các tấn công SQL Injection.
$stmt->bind_param("i", $id); // Sử dụng bind_param() để gán giá trị của $id vào câu lệnh SQL. Tham số "i" cho biết rằng $id là một số nguyên.

$stmt->execute(); // Thực thi câu lệnh đã chuẩn bị
$result = $stmt->get_result(); // Lấy kết quả trả về từ câu lệnh với giá trị đã gán.

if ($result->num_rows > 0) { // Kiểm tra nếu có bản ghi nào được trả về
    $customer = $result->fetch_assoc(); // Lấy dữ liệu của bản ghi đầu tiên dưới dạng mảng kết hợp
    echo json_encode($customer); // Chuyển đổi mảng dữ liệu thành chuỗi JSON và trả về
} else {
    echo json_encode([]); // Nếu không có bản ghi nào, trả về mảng rỗng dưới dạng JSON
}

// JSON là một định dạng dữ liệu nhẹ, dễ đọc và dễ ghi, thường được sử dụng để truyền tải dữ liệu giữa client và server trong ứng dụng web.
// JSON có cấu trúc tương tự như đối tượng trong JavaScript, nhưng nó có thể được sử dụng bởi nhiều ngôn ngữ lập trình khác nhau.
// Trong PHP, bạn có thể sử dụng hàm json_encode() để chuyển đổi mảng hoặc đối tượng thành chuỗi JSON và hàm json_decode() để chuyển đổi chuỗi JSON thành mảng hoặc đối tượng trong PHP.
// ví dụ
/*
$data = array("name" => "Nguyen Van A", "age" => 30);
$jsonData = json_encode($data); // Chuyển đổi mảng thành JSON
// Kết quả: {"name":"Nguyen Van A","age":30}

$decodedData = json_decode($jsonData, true); // Chuyển đổi JSON thành mảng
// Kết quả: Array ( [name] => Nguyen Van A [age] => 30 )
 */

$stmt->close(); // Đóng câu lệnh đã chuẩn bị
$conn->close(); // Đóng kết nối đến cơ sở dữ liệu
?>
