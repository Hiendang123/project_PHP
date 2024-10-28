<?php
session_start(); // Bắt đầu session để sử dụng biến $_SESSION

error_reporting(E_ALL ^ E_DEPRECATED); // Báo lỗi tất cả trừ lỗi đã lỗi thời
ini_set('display_errors', 1); // Hiển thị lỗi trên trình duyệt

require_once('model/connect.php'); // Kết nối với cơ sở dữ liệu

$prd = 0; // Khởi tạo biến đếm số lượng sản phẩm trong giỏ hàng

// Kiểm tra xem có giỏ hàng trong session không
if (isset($_SESSION['cart'])) {
    $prd = count($_SESSION['cart']); // Nếu có, đếm số lượng sản phẩm trong giỏ hàng
}

// Kiểm tra xem có tham số 'ls' trong URL không
if (isset($_GET['ls'])) {
    echo "<script type=\"text/javascript\">alert(\"Bạn đã đăng nhập thành công!\");</script>"; // Hiển thị thông báo đăng nhập thành công
}

// Kiểm tra nếu có giỏ hàng, nếu không thì khởi tạo giỏ hàng rỗng
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Khởi tạo giỏ hàng là mảng rỗng
}

// Khởi tạo biến tổng tiền và các biến liên quan đến giảm giá
$total = 0; // Khởi tạo tổng tiền
$totalSalePrice = 0; // Khởi tạo tổng tiền giảm giá
$totalDiscount = 0; // Khởi tạo giá trị giảm giá

// Lấy thông tin từ session
$customer_info = isset($_SESSION['customer_info']) ? $_SESSION['customer_info'] : []; // Kiểm tra và lấy thông tin khách hàng từ session
//Lấy thông tin khách hàng từ session nếu có, nếu không có thì khởi tạo như một mảng rỗng.


// Kiểm tra xem thông tin khách hàng có trong session hay không
if (empty($customer_info)) {
    echo "Không có thông tin đơn hàng!"; // Nếu không có thông tin, thông báo và dừng thực thi
    exit(); // Dừng thực thi mã
}


// Đoạn code thực thi chức năng đặt hàng
// Kiểm tra xem người dùng đã đặt hàng chưa
if ($_SERVER["REQUEST_METHOD"] === "POST") { // Kiểm tra xem yêu cầu có phải là phương thức POST hay không, tức là người dùng đã gửi biểu mẫu.
    // Lấy thông tin từ giỏ hàng và thông tin khách hàng
    if (isset($_SESSION['cart'])) { //Kiểm tra xem giỏ hàng có tồn tại hay không. Nếu có, lấy giỏ hàng từ session và tính toán tổng tiền.
        $cart = $_SESSION['cart']; // Lấy giỏ hàng từ session
        foreach ($cart as $value) { // Duyệt qua từng sản phẩm trong giỏ hàng để tính toán tổng tiền.
            $totalSalePrice = $value['price'] * $value['quantity']; // Tính thành tiền của từng sản phẩm
            $total += $totalSalePrice; // Cộng dồn vào tổng tiền
        }
    }

    // Lấy thông tin khách hàng từ session và làm sạch dữ liệu
    //Hàm htmlspecialchars() trong PHP được sử dụng để chuyển đổi các ký tự đặc biệt thành mã HTML
    $name = htmlspecialchars($customer_info['name']); // Lấy và làm sạch họ tên
    $email = htmlspecialchars($customer_info['email']); // Lấy và làm sạch email
    $phone = htmlspecialchars($customer_info['phone']); // Lấy và làm sạch số điện thoại
    $address = htmlspecialchars($customer_info['address']); // Lấy và làm sạch địa chỉ
    $order_date = date("Y-m-d H:i:s"); // Lấy ngày và giờ hiện tại để lưu vào trường date trong cơ sở dữ liệu.

    // Thực hiện truy vấn lưu thông tin vào bảng product_bill
    $stmt = $conn->prepare("INSERT INTO product_bill (name, email, phone, address, order_date, total) VALUES (?, ?, ?, ?, ?, ?)"); // Chuẩn bị câu lệnh SQL
    $stmt->bind_param("ssssss", $name, $email, $phone, $address, $order_date, $total); // Gán giá trị vào câu lệnh SQL ? ở trên

    if ($stmt->execute()) { // Thực hiện câu lệnh. Nếu thành công, hiển thị thông báo rằng đơn hàng đã được lưu thành công.
        echo "<script>alert('Đơn hàng đã được lưu thành công!');</script>"; // Thông báo nếu đơn hàng lưu thành công
    } else {
        echo "<script>alert('Lỗi: " . $stmt->error . "');</script>"; // Thông báo lỗi nếu có vấn đề
    }

    $stmt->close(); // Đóng statement
    $conn->close(); // Đóng kết nối cơ sở dữ liệu
}
?>



<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fashion MyLiShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logohong.png">
    <link rel="stylesheet" type="text/css" href="admin/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src='js/wow.js'></script>
    <script type="text/javascript" src="js/mylishop.js"></script>
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <header>
        <div class="container-fluid header_top wow bounceIn" data-wow-delay="0.1s">
            <div class="col-sm-10 col-md-10">
                <div class="header_top_left"> <span><i class="fa fa-phone"></i></span> <span>01697 450 200 | 0926 055 983</span>&nbsp;&nbsp;&nbsp; <span><i class="fa fa-envelope-o" aria-hidden="true"></i></span> <span>admin@mylishop.com.vn</span> </div>
            </div>
            <div class="col-sm-2 col-md-2">
                <div class="header_top_right">
                    <a href="https://www.facebook.com/" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a>
                    <a href="https://twitter.com/" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a>
                    <a href="https://www.rss.com/" target="_blank" title="rss"><i class="fa fa-rss"></i></a>
                    <a href="https://www.youtube.com/" target="_blank" title="youtube"><i class="fa fa-youtube"></i></a>
                    <a href="https://plus.google.com/" target="_blank" title="google"><i class="fa fa-google-plus"></i></a>
                    <a href="https://linkedin.com/" target="_blank" title="linkedin"><i class="fa fa-linkedin"></i></a>
                </div>
            </div>
            <div class="clear-fix"></div>
        </div>
        <!-- /header-top -->
        <!-- Menu ngang header -->
        <div class="container">
            <!-- Logo -->
            <div class="title">
                <a href="index.php" title="MyLiShop"> <img src="images/logohong.png" width="260px;" height="180px;"> </a>
            </div>
            <!-- /logo -->
            <div class="col-sm-12 col-md-12 account">
                <div class="row">
                    <?php
                    if (isset($_SESSION['username'])) {
                    ?>
                        <i class="fa fa-user fa-lg"></i>
                        <span><?php echo $_SESSION['username'] ?></span> &nbsp;
                        <span><i class="fa fa-sign-out"></i><a href="user/logout.php"> Đăng xuất </a></span>
                    <?php
                    } else {
                    ?>
                        <i class="fa fa-user fa-lg"></i>
                        <a href="user/login.php"> Đăng nhập </a> &nbsp;
                        <i class="fa fa-users fa-lg"></i>
                        <a href="user/register.php"> Đăng ký </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="clearfix"></div>

            <!-- Menu -->
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="index.php"> Trang Chủ </a></li>
                            <li><a href="introduceshop.php"> Dịch Vụ </a></li>
                            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sản Phẩm <b class="fa fa-caret-down"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="fashionboy.php"><i class="fa fa-caret-right"></i> Thời Trang Nam</a></li>
                                    <li class="divider"></li>
                                    <li><a href="fashiongirl.php"><i class="fa fa-caret-right"></i> Thời Trang Nữ</a></li>
                                    <li class="divider"></li>
                                    <li><a href="newproduct.php"><i class="fa fa-caret-right"></i> Hàng Mới Về</a></li>
                                </ul>
                            </li>
                            <li><a href="lienhe.php"> Liên Hệ </a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <form role="search" action="search.php" method="POST">
                                <div class="input-group header-search">
                                    <input type="text" maxlength="50" name="search" id="searchs" class="form-control" placeholder="Nhập từ khóa..." style="font-size: 14px;">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-search" type="submit"><span class="fa fa-search"></span></button>
                                    </span>
                                </div>
                                <div class="cart-total">
                                    <a class="bg_cart" href="view-cart.php" title="Giỏ hàng">
                                        <button type="button" class="btn header-cart">
                                            <span class="fa fa-shopping-cart"></span>&nbsp;
                                            <span id="cart-total">
                                                <?php
                                                if (isset($_SESSION['cart'])) {
                                                    $cart = $_SESSION['cart'];
                                                    $sl = count($_SESSION['cart']);
                                                    echo $sl;
                                                } else {
                                                    echo "0";
                                                }
                                                ?>
                                            </span> sản phẩm
                                        </button>
                                    </a>
                                    <div class="mini-cart-content shopping_cart"></div>
                                </div>
                            </form>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!-- /Menu ngang header -->
    </header>
    <!-- /header -->
    <div class="container"> <!-- Khởi tạo một thẻ div với class 'container' để chứa toàn bộ nội dung -->
        <div class="order-details"> <!-- Thẻ div để nhóm các thông tin chi tiết đơn hàng -->
            <h1 class="chitiet">Chi tiết đơn hàng</h1> <!-- Tiêu đề chính cho phần chi tiết đơn hàng -->
            <h3>Thông tin người nhận</h3> <!-- Tiêu đề phụ cho phần thông tin người nhận -->

            <div class="info-row"> <!-- Thẻ div để hiển thị hàng thông tin -->
                <div class="label-detail">Tên khách hàng:</div> <!-- Nhãn cho thông tin tên khách hàng -->
                <div class="value-details"><?php echo htmlspecialchars($customer_info['name']); ?></div> <!-- Hiển thị tên khách hàng, sử dụng htmlspecialchars để bảo mật chuyển đổi các ký tự đặc biệt trong chuỗi thành dạng an toàn cho HTML -->
            </div>

            <div class="info-row"> <!-- Tương tự như trên cho email -->
                <div class="label-detail">Email:</div>
                <div class="value-details"><?php echo htmlspecialchars($customer_info['email']); ?></div> <!-- Hiển thị email khách hàng -->
            </div>

            <div class="info-row"> <!-- Tương tự như trên cho số điện thoại -->
                <div class="label-detail">Số điện thoại:</div>
                <div class="value-details"><?php echo htmlspecialchars($customer_info['phone']); ?></div> <!-- Hiển thị số điện thoại khách hàng -->
            </div>

            <div class="info-row"> <!-- Tương tự như trên cho địa chỉ -->
                <div class="label-detail">Địa chỉ:</div>
                <div class="value-details"><?php echo htmlspecialchars($customer_info['address']); ?></div> <!-- Hiển thị địa chỉ khách hàng -->
            </div>

            <div class="info-row"> <!-- Tương tự như trên cho ngày đặt hàng -->
                <div class="label-detail">Ngày đặt hàng:</div>
                <div class="value-details"><?php echo htmlspecialchars($customer_info['order_date']); ?></div> <!-- Hiển thị ngày đặt hàng -->
            </div>
        </div>

        <h3 class="chitiet">Danh sách sản phẩm</h3> <!-- Tiêu đề cho phần danh sách sản phẩm -->

        <table class="table table-bordered table-hover"> <!-- Tạo bảng để hiển thị danh sách sản phẩm -->
            <thead> <!-- Phần đầu bảng -->
                <tr>
                    <th>STT</th> <!-- Cột số thứ tự -->
                    <th>Tên sản phẩm</th> <!-- Cột tên sản phẩm -->
                    <th>Giá sản phẩm</th> <!-- Cột giá sản phẩm -->
                    <th>Số lượng</th> <!-- Cột số lượng -->
                    <th>Thành tiền</th> <!-- Cột thành tiền -->
                </tr>
            </thead>
            <tbody> <!-- Phần thân bảng chứa dữ liệu sản phẩm -->
                <?php
                $total = 0; // Khởi tạo biến tổng tiền đơn hàng
                if (isset($_SESSION['cart'])) { // Kiểm tra nếu giỏ hàng tồn tại trong session
                    $cart = $_SESSION['cart']; // Lấy giỏ hàng từ session
                    foreach ($cart as $key => $value) { // Duyệt qua từng sản phẩm trong giỏ hàng
                        $totalSalePrice = $value['price'] * $value['quantity']; // Tính thành tiền của sản phẩm
                        $total += $totalSalePrice; // Cộng dồn tổng tiền đơn hàng
                ?>
                        <tr> <!-- Tạo một hàng mới cho bảng -->
                            <td><?php echo $key + 1; ?></td> <!-- Hiển thị số thứ tự sản phẩm -->
                            <td><?php echo htmlspecialchars($value['name']); ?></td> <!-- Hiển thị tên sản phẩm -->
                            <td><?php echo number_format($value['price'], 0, ',', '.'); ?> VND</td> <!-- Hiển thị giá sản phẩm định dạng số với dấu phẩy -->
                            <td><?php echo $value['quantity']; ?></td> <!-- Hiển thị số lượng sản phẩm -->
                            <td><?php echo number_format($totalSalePrice, 0, ',', '.'); ?> VND</td> <!-- Hiển thị thành tiền định dạng số với dấu phẩy -->
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
            <tfoot> <!-- Phần chân bảng để hiển thị tổng đơn hàng -->
                <tr>
                    <td colspan="4" style="text-align:right;">Tổng giá trị đơn hàng:</td> <!-- Nhãn cho tổng giá trị đơn hàng -->
                    <td><?php echo number_format($total, 0, ',', '.'); ?> VND</td> <!-- Hiển thị tổng giá trị đơn hàng định dạng số với dấu phẩy -->
                </tr>
            </tfoot>
        </table>

        <div class="text-center"> <!-- Trung tâm cho nút quay lại trang chủ -->
            <a href="index.php" class="btn btn-primary">Quay lại trang chủ</a> <!-- Nút để quay lại trang chủ -->
        </div>
    </div>
    <!-- partner -->


    <!-- footer -->
    <div class="container">
        <?php include("model/footer.php"); ?>
    </div>
    <!-- /footer -->
</body>

</html>