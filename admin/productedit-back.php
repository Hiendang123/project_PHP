<meta charset="utf-8">
<?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    require_once '../model/connect.php';
    error_reporting(2);

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["FileImage"]["name"]);
    $uploadOk = 1;

    if (isset($_GET['idProduct'])) {
        $idProduct = $_GET['idProduct'];
    }


    // lấy name của button edit
    if (isset($_POST['editProduct']))
    {
        $keywordPr = '';
        $descriptPr = '';
        $status = 0;

        // Ảnh sản phẩm
        $image = basename($_FILES["FileImage"]["name"]);
        if ($image == null || $image = '')
        {
            $image = $_POST['image'];
            $uploadOk = 0;
        }
        else
        {
            $check = getimagesize($_FILES["FileImage"]["tmp_name"]);
            if ($check !== false)
            {
                $image = basename($_FILES["FileImage"]["name"]);
                $uploadOk = 1;
            }
            else {
                $image = $_POST['image'];
                header("location:product-edit.php?notimage=notimage");
                exit();
                $uploadOk = 0;
            }
        }

        // Upload image
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        if ($uploadOk == 0)
        {
            echo "Image chưa có!";
        }
        else {
            if (move_uploaded_file($_FILES["FileImage"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["FileImage"]["name"]) . " has been uploaded.";
            } else {
               // echo "Sorry, there was an error uploading your file.";
            }
        }

        if (isset($_POST['txtName'])) {
            $namePr = $_POST['txtName'];
        }

        if (isset($_POST['category'])) {
            $categoryPr = $_POST['category'];
        }

        if (isset($_POST['txtPrice'])) {
            $pricePr = $_POST['txtPrice'];
        }

        if (isset($_POST['txtSalePrice'])) {
            $salePricePr = $_POST['txtSalePrice'];
        } else {
            $salePricePr = 0;
        }

        if (isset($_POST['txtNumber'])) {
            $quantityPr = $_POST['txtNumber'];
        }

        if (isset($_POST['txtKeyword'])) {
            $keywordPr = $_POST['txtKeyword'];
        }

        if (isset($_POST['txtDescript'])) {
            $descriptPr = $_POST['txtDescript'];
        }

        if (isset($_POST['status'])) {
            $status = $_POST['status'];
        }

        // Truy vấn update
        $sql = "UPDATE products SET name = '$namePr', category_id = $categoryPr, image ='$image', description = '$descriptPr', price = '$pricePr', saleprice = '$salePricePr', quantity = '$quantityPr', keyword = '$keywordPr', status = '$status' WHERE id = $idProduct";
        $result = mysqli_query($conn,$sql);
        if ($result)
        {
?>
            <script type="text/javascript">
                window.location = 'product-edit.php?idProduct= <?php echo $idProduct; ?>&es=editsuccess';
            </script>
<?php
        } else {
?>
            <script type="text/javascript">
                window.location = 'product-edit.php?idProduct= <?php echo $idProduct; ?>&ef=editfail';
            </script>
<?php
        }

    } else {
        echo 'error';
    }
?>