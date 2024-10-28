<?php
session_start(); // Bắt đầu session để lưu trữ các thông tin như giỏ hàng, tài khoản người dùng, v.v.
error_reporting(E_ALL ^ E_DEPRECATED); // Tắt các cảnh báo lỗi liên quan đến các hàm đã bị loại bỏ (deprecated).
require_once('model/connect.php'); // Kết nối đến cơ sở dữ liệu bằng file kết nối.

$prd = 0; // Khởi tạo biến đếm số lượng sản phẩm trong giỏ hàng bằng 0.

if (isset($_SESSION['cart'])) { // Kiểm tra nếu đã có session 'cart' (giỏ hàng) tồn tại.
    $prd = count($_SESSION['cart']); // Đếm số lượng sản phẩm trong giỏ hàng và gán vào biến $prd.
}

if (isset($_GET['ls'])) { // Kiểm tra nếu tham số 'ls' được truyền qua URL.
    echo "<script type=\"text/javascript\">alert(\"Bạn đã đăng nhập thành công!\");</script>"; // Thông báo đăng nhập thành công.
}

// Kiểm tra nếu giỏ hàng chưa tồn tại
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Tạo giỏ hàng trống nếu chưa có.
}

$total = 0; // Khởi tạo biến $total để tính tổng tiền giỏ hàng.
?>


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
                <?php   } else {
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
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <!-- <a class="navbar-brand" href="#">MyLiShop</a> -->
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php"> Trang Chủ </a>
                        </li>
                        <li><a href="introduceshop.php"> Dịch Vụ </a>
                        </li>
                        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sản Phẩm <b class="fa fa-caret-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="fashionboy.php"><i class="fa fa-caret-right"></i> Thời Trang Nam</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="fashiongirl.php"><i class="fa fa-caret-right"></i> Thời Trang Nữ</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="newproduct.php"><i class="fa fa-caret-right"></i> Hàng Mới Về</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="lienhe.php"> Liên Hệ </a>
                        </li>
                    </ul>
                    <!-- search area -->
                    <ul class="nav navbar-nav navbar-right">
                        <form role="search" action="search.php" method="POST">
                            <div class="input-group header-search">
                                <!-- form search -->
                                <input type="text" maxlength="50" name="search" id="searchs" class="form-control" placeholder="Nhập từ khóa..." style="font-size: 14px;">
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-search" type="submit"><span class="fa fa-search"></span></button>
                                </span>
                            </div>
                            <!-- /input-group -->
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
                                <div class="mini-cart-content shopping_cart">

                                </div>
                            </div>
                        </form>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </div>
    <!-- /Menu ngang header -->
</header>
<!-- /header -->


<h1 style="text-align: center;">Thông tin mua hàng</h1> <!-- Tiêu đề chính được căn giữa -->
<div class="container"> <!-- Bắt đầu container chứa bảng thông tin mua hàng -->
    <table> <!-- Bắt đầu bảng -->
        <tr> <!-- Dòng tiêu đề của bảng -->
            <th>Ảnh sản phẩm</th> <!-- Cột hiển thị ảnh sản phẩm -->
            <th>Tên sản phẩm</th> <!-- Cột hiển thị tên sản phẩm -->
            <th>Số lượng</th> <!-- Cột hiển thị số lượng sản phẩm đã mua -->
            <th>Đơn giá</th> <!-- Cột hiển thị đơn giá sản phẩm -->
            <th>Giảm giá</th> <!-- Cột hiển thị giá giảm (nếu có) -->
            <th>Thành tiền</th> <!-- Cột hiển thị tổng tiền cho mỗi sản phẩm -->
            <th>Xóa</th> <!-- Cột hiển thị nút xóa sản phẩm khỏi giỏ hàng -->
        </tr>
        <?php   
        if (!empty($_SESSION['cart'])) { // Nếu giỏ hàng không trống
            foreach ($_SESSION['cart'] as $item) { // Lặp qua từng sản phẩm trong giỏ
                if (is_array($item)) { // Kiểm tra xem $item có phải là mảng (chứa thông tin sản phẩm)
                    $image = $item['image']; // Lấy đường dẫn ảnh sản phẩm
                    $name = $item['name']; // Lấy tên sản phẩm
                    $quantity = $item['quantity']; // Lấy số lượng sản phẩm đã đặt
                    $price = $item['price']; // Lấy giá sản phẩm
                    $saleprice = $item['saleprice']; // Lấy giá giảm (nếu có)
                    $subtotal = $price * $quantity; // Tính thành tiền cho sản phẩm (giá * số lượng)
                    $total += $subtotal; // Cộng tổng giá trị của sản phẩm vào tổng tiền giỏ hàng
                    echo "<tr>
                        <td><img src='$image' width='50' height='50'></td> <!-- Hiển thị ảnh sản phẩm với kích thước 50x50 -->
                        <td>$name</td> <!-- Hiển thị tên sản phẩm -->
                        <td>
                            <form action='update-cart.php' method='POST'> <!-- Form để cập nhật số lượng sản phẩm -->
                                <input type='hidden' name='id' value='{$item['id']}'> <!-- Input ẩn để lưu ID sản phẩm -->
                                <input type='number' name='quantity' value='$quantity' min='1' style='width: 30px;'> <!-- Ô input để thay đổi số lượng sản phẩm, giá trị tối thiểu là 1 -->
                                <input type='submit' value='Cập nhật'> <!-- Nút cập nhật số lượng -->
                            </form>
                        </td>
                        <td>" . number_format($price) . "<sup>đ</sup></td> <!-- Hiển thị đơn giá sản phẩm -->
                        <td>" . number_format($saleprice) . "<sup>đ</sup></td> <!-- Hiển thị giá giảm (nếu có) -->
                        <td>" . number_format($subtotal) . "<sup>đ</sup></td> <!-- Hiển thị thành tiền của từng sản phẩm -->
                        <td><a href='remove-item.php?id={$item['id']}' title='Xóa'><i class='fa fa-trash'></i></a></td> <!-- Nút xóa sản phẩm khỏi giỏ hàng -->
                    </tr>";
                }
            }
        } else {
            echo "<tr><td colspan='7'>Giỏ hàng trống!</td></tr>"; // Hiển thị thông báo giỏ hàng trống nếu không có sản phẩm nào
        }
        ?>
        <!-- Hàm number_format() trong PHP được sử dụng để định dạng các số theo cách dễ đọc hơn bằng cách thêm dấu phân cách phần ngàn và phần thập phân (nếu có) -->
        <!--  Ví dụ, 1000000 sẽ được định dạng thành "1,000,000" -->
    </table> <!-- Kết thúc bảng -->
</div> <!-- Kết thúc container đầu tiên -->

<div class="container"> <!-- Container chứa phần tổng tiền và các nút hành động -->
    <div class="bill-cart" style="align-items: center;">
        <div class="cart-capnhat">
            <p style="font-size: 14px; margin-top: 15px;"><b>Tổng cộng: <?php echo number_format($total); ?><sup>đ</sup></b></p> <!-- Hiển thị tổng cộng số tiền của giỏ hàng -->
        </div>
        <div class="buton"> <!-- Div chứa các nút hành động -->
            <button class="btn-index" onclick="window.location.href='index.php'">Tiếp tục mua hàng</button> <!-- Nút tiếp tục mua hàng -->
            <button class="btn-bill">Tiến hành mua hàng</button> <!-- Nút tiến hành mua hàng -->
        </div>
    </div>
</div>

<div class="container"> <!-- Container chứa form thông tin mua hàng -->
    <div class="thongtin" id="thongtin-form" style="display: none;"> <!-- Form thông tin đặt hàng ban đầu bị ẩn -->
        <form action="bill.php" method="POST" class="form-tt"> <!-- Form gửi thông tin đơn hàng -->
            <h3 style="text-align: center;">Thông tin đặt hàng</h3>
            <!-- Nút đóng form -->
            <button type="button" id="close-form" style="float: right; background: none; border: none; font-size: 20px; cursor: pointer; margin-top: -70px; color: red;">&times;</button> <!-- Nút đóng form (hiển thị dấu "x") -->

            <div class="mb-3">
                <label>Họ và tên:</label>
                <input type="text" class="form-control" name="name"> <!-- Ô input nhập họ và tên -->
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" class="form-control" name="email"> <!-- Ô input nhập email -->
            </div>
            <div class="mb-3">
                <label>Số điện thoại:</label>
                <input type="text" class="form-control" name="phone"> <!-- Ô input nhập số điện thoại -->
            </div>
            <div class="mb-3">
                <label>Địa chỉ:</label>
                <input type="text" class="form-control" name="address"> <!-- Ô input nhập địa chỉ -->
            </div>
            <div class="mb-3">
                <label>Ngày đặt:</label>
                <input type="date" class="form-control" name="order_date"> <!-- Ô input nhập ngày đặt hàng -->
            </div>
            <div class="mb-3" style="margin-top: 20px;">
                <p>Lưu ý: Khách hàng xin vui lòng nhập đúng thông tin và địa chỉ nhận hàng, Mọi sự cố ngoài ý muốn shop không chịu trách nhiệm. Nếu có thắc mắc xin vui lòng liên hệ với chúng tôi.</p>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 30px; text-align: center; border-radius: 20px; border: none; margin-left: 40%;">Xác nhận</button> <!-- Nút xác nhận đặt hàng -->
        </form>
    </div>
</div>


<!-- footer -->
<div class="container">
    <?php include("model/footer.php"); ?>
</div>
<!-- /footer -->

<script>
    // Mở form khi bấm "Tiến hành mua hàng"
    document.querySelector('.btn-bill').addEventListener('click', function() {
        document.getElementById('thongtin-form').style.display = 'block'; // Hiển thị form khi bấm nút tiến hành mua hàng
    });

    // Đóng form khi bấm nút tắt
    document.getElementById('close-form').addEventListener('click', function() {
        document.getElementById('thongtin-form').style.display = 'none'; // Ẩn form khi bấm nút đóng (dấu "x")
    });
</script>