<?php
require_once("../model/connect.php"); // Kết nối đến cơ sở dữ liệu

// Kiểm tra xem có ID được truyền qua URL hay không
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Chuyển đổi giá trị ID thành số nguyên để đảm bảo tính an toàn

    // Tạo câu truy vấn SQL để lấy thông tin sản phẩm dựa trên ID
    $sql = "SELECT * FROM product_bill WHERE id = $id";
    
    // Thực hiện truy vấn SQL
    $result = $conn->query($sql);
    
    // Kiểm tra xem có kết quả trả về hay không
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Lấy thông tin hàng sản phẩm dưới dạng mảng kết hợp
        echo json_encode($row); // Chuyển đổi mảng $row thành chuỗi JSON và in ra. Chuỗi JSON này sẽ được gửi về cho client (trình duyệt) để sử dụng.
    } else {
        echo json_encode([]); // Nếu không có sản phẩm nào được tìm thấy, sẽ trả về một mảng rỗng dưới dạng JSON.
    }
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

// Đóng kết nối đến cơ sở dữ liệu
$conn->close();
?>
