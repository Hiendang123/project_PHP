<?php
include 'header.php'; // Bao gồm file header.php, thường chứa phần đầu trang như tiêu đề, liên kết CSS, v.v.

require_once("../model/connect.php"); // Kết nối đến cơ sở dữ liệu bằng file connect.php

error_reporting(E_ALL); // Bật báo cáo lỗi để hiển thị tất cả các lỗi, điều này giúp dễ dàng phát hiện và sửa lỗi trong mã

// Khởi tạo biến để lưu thông tin hàng được chọn
// Biến này sẽ lưu thông tin của hàng sản phẩm được chọn để sửa hoặc xem chi tiết,
// và sẽ được dùng để hiển thị chi tiết hàng hóa khi người dùng bấm nút "Xem chi tiết"
$selectedRow = null; // Biến này sẽ lưu thông tin của hàng sản phẩm được chọn để sửa hoặc xem chi tiết



// Kiểm tra nếu có ID được truyền vào URL
if (isset($_GET['id'])) { // Kiểm tra xem tham số 'id' có tồn tại trong URL không. Nếu có, nó cho biết rằng một hàng cụ thể cần được lấy dữ liệu.
    $id = intval($_GET['id']); // Lấy ID từ URL và chuyển đổi nó thành số nguyên để bảo mật và tránh lỗi
    $sql = "SELECT * FROM product_bill WHERE id = $id"; // Truy vấn SQL để lấy dữ liệu của hàng hóa với ID tương ứng từ bảng product_bill.
    $result = $conn->query($sql); // Thực hiện truy vấn trên cơ sở dữ liệu và lưu kết quả vào biến $result.
    if ($result->num_rows > 0) { // Kiểm tra xem có ít nhất một hàng dữ liệu được trả về từ truy vấn hay không.
        $selectedRow = $result->fetch_assoc(); // Nếu có, lưu thông tin hàng được chọn vào biến $selectedRow dưới dạng mảng kết hợp -> fetch_assoc();
    }
}

// Lấy thông tin khách hàng từ cơ sở dữ liệu
$sql = "SELECT * FROM product_bill"; // Truy vấn SQL để lấy tất cả dữ liệu trong bảng product_bill
$result = $conn->query($sql); // Thực hiện truy vấn trên cơ sở dữ liệu
?>


<style>
    .thongtin1 {
        width: 30%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        /* Căn giữa theo chiều dọc */
        align-items: center;
        /* Căn giữa theo chiều ngang */
        min-height: 50vh;
        /* Đảm bảo chiều cao của khối bằng chiều cao của màn hình */
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 0;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        z-index: 1000;
    }

    .form-tt {
        width: 100%;
        max-width: 500px;
        /* Đặt độ rộng tối đa cho form */
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        /* Hiệu ứng đổ bóng */
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<div id="page-wrapper"> <!-- Khởi đầu một khối chứa toàn bộ nội dung của trang -->
    <div class="container-fluid"> <!-- Khối chứa nội dung với khoảng cách bên trong -->
        <div class="row"> <!-- Khởi đầu một hàng -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <!-- Tạo một cột với kích thước đầy đủ -->
                <h1 class="page-header">Danh sách sản phẩm</h1> <!-- Tiêu đề trang -->
            </div><!-- /.col -->

            <!-- Bảng hiển thị danh sách sản phẩm -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example"> <!-- Khởi tạo bảng với các lớp CSS -->
                <thead> <!-- Phần tiêu đề của bảng -->
                    <tr align="center"> <!-- Dòng tiêu đề, căn giữa nội dung -->
                        <th>Mã hàng</th> <!-- Tiêu đề cột cho Mã hàng -->
                        <th>Tổng tiền</th> <!-- Tiêu đề cột cho Tổng tiền -->
                        <th>Thông tin khách hàng</th> <!-- Tiêu đề cột cho Thông tin khách hàng -->
                        <th>Chuyển hàng</th> <!-- Tiêu đề cột cho Chuyển hàng -->
                        <th>Chi tiết</th> <!-- Tiêu đề cột cho Chi tiết -->
                        <th>Xóa</th> <!-- Tiêu đề cột cho Xóa -->
                    </tr>
                </thead>
                <tbody> <!-- Phần thân của bảng -->
                    <?php
                    if ($result->num_rows > 0) { // Kiểm tra xem có dòng dữ liệu nào trong kết quả không
                        while ($row = $result->fetch_assoc()) { // Lặp qua từng dòng kết quả, sử dụng fetch_assoc() để lấy mỗi hàng dữ liệu dưới dạng mảng kết hợp.
                            echo "<tr align='center'>"; // Mở dòng mới và căn giữa
                            echo "<td>{$row['id']}</td>"; // Hiển thị giá trị ID của sản phẩm trong cột đầu tiên.
                            echo "<td>" . (isset($row['total']) && is_numeric($row['total']) ? number_format($row['total']) . "đ" : "0đ") . "</td>"; // Hiển thị tổng tiền, nếu có, và định dạng nó với dấu phẩy cho dễ đọc; nếu không có, hiển thị "0đ".
                            echo "<td>{$row['name']}<br>{$row['phone']}<br>{$row['address']}</td>"; // Hiển thị thông tin khách hàng
                            echo "<td><input type='checkbox'></td>"; // Cột cho phép chọn hàng để chuyển hàng
                            echo "<td><a href='javascript:void(0);' onclick='showDetails({$row['id']});'><i class='fa-solid fa-pencil'></i></a></td>"; // Liên kết để hiện chi tiết sản phẩm
                            echo "<td><a href='delete_table.php?id={$row['id']}'><i class='fa-solid fa-trash'></i></a></td>"; // Liên kết để xóa sản phẩm
                            echo "</tr>"; // Đóng dòng
                        }
                    } else {
                        echo "<tr><td colspan='6'>Không có sản phẩm nào</td></tr>"; // Hiển thị thông báo nếu không có sản phẩm nào
                    }
                    ?>
                </tbody>
            </table> <!-- Đóng bảng -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->



<!-- Hiện form nếu có dữ liệu -->
<div class="container"> <!-- Khối chứa nội dung form -->
    <div class="thongtin1" id="thongtin-form" style="display: <?= $selectedRow ? 'block' : 'none'; ?>;"> <!-- Khối chứa form, hiển thị nếu có dữ liệu ($selectedRow không phải là null), ngược lại sẽ ẩn. -->
        <form class="form-tt"> <!-- Bắt đầu form -->
            <h3 style="text-align: center;">Thông tin đặt hàng</h3> <!-- Tiêu đề form -->
            <!-- Nút đóng form -->
            <button type="button" id="close-form" style="float: right; background: none; border: none; font-size: 20px; cursor: pointer; margin-top: -70px; color: red;">&times;</button>

            <!-- Thông tin họ và tên -->
            <div class="mb-3"> <!-- Khoảng cách dưới mỗi phần -->
                <label>Họ và tên:</label> <!-- Nhãn cho trường họ và tên -->
                <input type="text" class="form-control" name="name" id="name" readonly> <!-- Trường nhập họ và tên, chỉ đọc -->
            </div>
            <!-- Thông tin email -->
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" class="form-control" name="email" id="email" readonly> <!-- Trường nhập email, chỉ đọc -->
            </div>
            <!-- Thông tin số điện thoại -->
            <div class="mb-3">
                <label>Số điện thoại:</label>
                <input type="text" class="form-control" name="phone" id="phone" readonly> <!-- Trường nhập số điện thoại, chỉ đọc -->
            </div>
            <!-- Thông tin địa chỉ -->
            <div class="mb-3">
                <label>Địa chỉ:</label>
                <input type="text" class="form-control" name="address" id="address" readonly> <!-- Trường nhập địa chỉ, chỉ đọc -->
            </div>
            <!-- Thông tin ngày đặt -->
            <div class="mb-3">
                <label>Ngày đặt:</label>
                <input type="date" class="form-control" name="order_date" id="order_date" readonly> <!-- Trường nhập ngày đặt, chỉ đọc -->
            </div>
        </form> <!-- Đóng form -->
    </div> <!-- Đóng khối form -->
</div> <!-- Đóng khối container -->

<script>
    // Khi tài liệu được tải xong
    $(document).ready(function() {
        $('#dataTables-example').DataTable({ // Khởi tạo DataTable cho bảng
            "order": [], // Không sắp xếp tự động
            "paging": true, // Bật phân trang
            "info": true, // Bật thông tin về số trang
            "searching": true // Bật chức năng tìm kiếm
        });
    });


    // Hàm hiện thông tin chi tiết sản phẩm
    function showDetails(id) { //Khai báo một hàm có tên showDetails với một tham số id, là ID của sản phẩm mà bạn muốn hiển thị thông tin chi tiết.
        $.ajax({ // Sử dụng jQuery để gửi yêu cầu AJAX. AJAX cho phép bạn gửi và nhận dữ liệu từ máy chủ mà không cần làm mới trang.
            url: 'get_product_details.php', // Đường dẫn đến file PHP (get_product_details.php) sẽ xử lý yêu cầu và trả về thông tin chi tiết sản phẩm dựa trên ID đã cung cấp.
            type: 'GET', // Chỉ định phương thức HTTP cho yêu cầu, ở đây là GET. Điều này có nghĩa là dữ liệu sẽ được gửi đến máy chủ qua URL.
            data: {
                id: id
            }, // Dữ liệu gửi đi (ID sản phẩm)
            success: function(data) { // Đây là một hàm callback sẽ được gọi nếu yêu cầu AJAX thành công. Dữ liệu trả về từ máy chủ sẽ được truyền vào hàm này thông qua tham số data.
                const product = JSON.parse(data); // Chuyển đổi dữ liệu JSON thành đối tượng JavaScript
                $('#name').val(product.name); // Cập nhật giá trị của trường nhập liệu có ID name với giá trị name từ đối tượng product
                $('#email').val(product.email); // Cập nhật giá trị của trường nhập liệu có ID email với giá trị email từ đối tượng product.
                $('#phone').val(product.phone); // Cập nhật giá trị của trường nhập liệu có ID phone với giá trị phone từ đối tượng product.
                $('#address').val(product.address); // Cập nhật giá trị của trường nhập liệu có ID address với giá trị address từ đối tượng product.
                $('#order_date').val(product.order_date); //Cập nhật giá trị của trường nhập liệu có ID order_date với giá trị date từ đối tượng product.
                $('#thongtin-form').show(); // Hiện form
            }
        });
    }

    // Đóng form khi bấm nút đóng
    $('#close-form').click(function() {
        $('#thongtin-form').hide(); // Ẩn form khi bấm nút đóng
    });
</script>

<!-- Kết nối với thư viện DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> <!-- CSS cho DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Thư viện jQuery -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> <!-- JavaScript cho DataTables -->

<?php
$conn->close(); // Đóng kết nối cơ sở dữ liệu
?>