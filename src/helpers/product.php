<?php

include_once __DIR__ . "/../controller/ProductCtrl.php";

// hàm render danh sách danh mục sản phẩm
function rederCategoryProduct($selectedCategoryID = null)
{
    $productCtrl = new ProductCtrl();

    // lấy danh mục sản phẩm
    $result = $productCtrl->getAllCategoryProduct();

    // kiểm tra kết quả lấy
    if (!$result["success"]) {
        echo $result["message"];
        return;
    }

    // lọc và hiện thị ra trong ô select trong form 
    foreach ($result["categorylist"] as $p) {
        $selected = ($selectedCategoryID == $p["CategoryID"]) ? 'selected' : '';
        echo '<option value="' . $p["CategoryID"] . '" ' . $selected . '>' . $p["CategoryName"] . '</option>';
    }
}

// hàm render sản phẩm ra màn hình home
function renderProduct()
{
    $productCtrl = new ProductCtrl();

    // lấy tất cả sản phẩm
    $response = $productCtrl->getAllProduct();

    // kiểm tra kết quả lấy
    if (!$response["success"]) {
        echo $response["message"];
        return;
    }

    $products = $response["productlist"];

    echo '<div class="product-grid">';

    foreach ($products as $p) {

        // Không hiển thị sản phẩm ngừng bán
        if ($p['Status'] == 0) {
            continue;
        }

        // không hiện thị sản phẩm hết hàng
        if ($p["Stock"] == 0) {
            continue;
        }

        echo '<div class="product-card"><a href="?page=product-detail&id=' . $p['ProductID'] . '">';
        echo '<img src="/img/product_img/' . $p['Image'] . '" alt="' . $p['ProductID'] . '">';
        echo '<h3>' . $p['ProductName'] . '</h3>';

        // nếu giá khuyến mãi = 0, hiện thị giá gốc
        if ($p['Discount'] == 0) {
            echo '<p>Giá: ' . number_format($p['Price'], 0, ',', '.') . ' vnđ</p>';
        } else {
            echo '<p>Giá: <s>' . number_format($p['Price'], 0, ',', '.') . '</s> vnđ</p>';
            echo '<p>Giảm còn: ' . number_format($p['Discount'], 0, ',', '.') . ' vnđ</p>';
        }
        echo '<p>' . $p['Description'] . '</p>';
        echo '</a></div>';
    }

    echo '</div>';
}

// hàm render sản phẩm trang quản lý 
function renderProductMager()
{
    $productCtrl = new ProductCtrl();

    // lấy sản phẩm để quản lý tương ứng với chủ và nhân viên shop đó
    $result = $productCtrl->getProductToManage($_SESSION["shopid"]);

    // kiểm tra kết quả lấy
    if (!$result["success"]) {
        echo '<tr>';
        echo '<td colspan = 7>' . $result["message"] . '</td>';
        echo '</tr>';
        exit();
    }

    foreach ($result["productpack"] as $p) {
        echo '<tr>';
        echo '<td>' . $p['ProductID'] . '</td>';
        echo '<td>' . $p['ProductName'] . '</td>';
        echo '<td>' . number_format($p['Price'], 0, ',', '.') . '</td>';
        echo '<td>' . number_format($p['Discount'], 0, ',', '.') . '</td>';
        echo '<td>' . $p['Stock'] . '</td>';
        echo '<td>' . ($p['Status'] == 1 ? 'Đang bán' : 'Ngừng bán') . '</td>';
        echo '<td><a href="?page=edit-product&id=' . $p['ProductID'] . '">sửa</a> | <a href="?page=del-product&id=' . $p['ProductID'] . '" onclick="return confirm(\'Bạn muốn xóa sản phẩm này?\')">xóa</a></td>';
        echo '</tr>';
    }
}

// hàm lấy sản phẩm chi tiết đổ ra view chi tiết sản phẩm
function getProductDetail($productid)
{
    $productModel = new ProductCtrl();

    return $productModel->getProductDetail($productid);
}

// hàm xử lý upload / xóa ảnh
function uploadProductImage($shopid = '', $fileimage = '', $action = 'upload')
{
    $folder = "./img/product_img/";

    // chế độ xóa ảnh
    if ($action === "delete") {

        if ($fileimage !== '') {

            $old = $folder . $fileimage;

            if (file_exists($old)) {
                unlink($old);
            }
        }

        return true;
    }

    // chế độ cập nhật ảnh
    $hasUpload = isset($_FILES["txtimage"]) && $_FILES["txtimage"]["error"] === 0;

    // không upload ảnh
    if (!$hasUpload) {

        // update → giữ ảnh cũ
        if ($fileimage !== '') {
            return [
                "filename" => $fileimage
            ];
        }
        return false;
    }

    $file = $_FILES["txtimage"];
    $allow = ["jpg", "jpeg", "png", "webp"];
    $ext = strtolower(
        pathinfo($file["name"], PATHINFO_EXTENSION)
    );

    // kiểm tra định dạng ảnh phù hợp
    if (!in_array($ext, $allow)) {
        return false;
    }

    $imageName = $shopid . "-" . time() . "." . $ext;

    $path = $folder . $imageName;

    // kiểm tra upload ảnh chưa
    if (!move_uploaded_file($file["tmp_name"], $path)) {
        return false;
    }

    // update → xóa ảnh cũ
    if ($fileimage !== '') {

        $old = $folder . $fileimage;

        if (file_exists($old)) {
            unlink($old);
        }
    }

    return [
        "filename" => $imageName
    ];
}

// hàm xử lý quá trình thêm sản phẩm
function handleAddProduct()
{
    if (isset($_POST["btnadd"])) {

        $productCtrl = new ProductCtrl();

        // xử lý thêm ảnh
        $handledImage = uploadProductImage($_SESSION["shopid"]);

        // kiểm tra ảnh
        if ($handledImage === false) {
            echo '<script>alert("Ảnh không hợp lệ hoặc upload thất bại");</script>';
            return;
        }

        $data = [
            "categoryid" => $_POST["txtcategoryid"],
            "shopid" => $_SESSION["shopid"],
            "productname" => $_POST["txtproductname"],
            "price" => $_POST["txtprice"],
            "discount" => $_POST["txtdiscount"],
            "description" => $_POST["txtdescription"],

            // lưu tên ảnh vào DB
            "image" => $handledImage["filename"],

            "stock" => $_POST["txtstock"],
            "status" => $_POST["txtstatus"]
        ];

        $result = $productCtrl->addNewProduct($data);

        if ($result) {
            echo '<script>alert("Thêm sản phẩm thành công");window.location.href="?page=product-manager";</script>';
        } else {
            echo '<script>alert("Thêm sản phẩm thất bại");</script>';
        }
    }
}

// hàm lấy thông tin 1 sản phẩm để chỉnh sửa
function getProductForEdit($productid)
{
    // nếu không tồn tại
    if (!isset($productid)) {
        return null;
    }

    $productCtrl = new ProductCtrl();

    $response = $productCtrl->getProductByID($_GET["id"]);

    // nếu không có sản phẩm đó trong db
    if (!$response["success"]) {
        return null;
    }

    return $response["product"];
}

// hàm kiểm tra ảnh sản phẩm có trong thư mục product_img chưa
function getProductImage($filename)
{
    $default = "/img/product_img/default.jpg";

    if (!empty($filename)) {
        $path = __DIR__ . "/../img/product_img/" . $filename;

        if (file_exists($path)) {
            return "/img/product_img/" . $filename;
        }
    }

    return $default;
}

// hàm xử lý cập nhật sản phẩm
function handleUpdateProduct($productid, $fileimage)
{
    if (isset($_POST["btnupdate"])) {

        $productCtrl = new ProductCtrl();

        // xử lý ảnh
        $handledImage = uploadProductImage($_SESSION["shopid"], $fileimage);

        // kết quả xử lý thất bại
        if ($handledImage === false) {
            echo '<script>alert("Ảnh không hợp lệ hoặc upload thất bại");</script>';
            return;
        }

        $data = [
            "productid" => $productid,
            "categoryid" => $_POST["txtcategoryid"],
            "shopid" => $_SESSION["shopid"],
            "productname" => $_POST["txtproductname"],
            "price" => $_POST["txtprice"],
            "discount" => $_POST["txtdiscount"],
            "description" => $_POST["txtdescription"],

            // lưu tên ảnh vào DB
            "image" => $handledImage["filename"],

            "stock" => $_POST["txtstock"],
            "status" => $_POST["txtstatus"]
        ];

        // gọi hàm update trong db
        $result = $productCtrl->updateProduct($data);

        if ($result) {
            echo '<script>alert("Cập nhật sản phẩm thành công");window.location.href="?page=product-manager";</script>';
        } else {
            echo '<script>alert("Cập nhật sản phẩm thất bại");</script>';
        }
    }
}

// hàm xử lý xóa sản phẩm
function deleteProduct()
{
    // kiểm tra url có id sản phẩm k
    if (!isset($_GET["id"])) {
        return;
    }

    $productid = (int)$_GET["id"];

    $productCtrl = new ProductCtrl();

    // lấy thông tin sản phẩm trong db
    $product = getProductForEdit($productid);

    // nếu không có trong db
    if (!$product) {
        return;
    }

    // gọi hàm xóa sản phẩm
    $result = $productCtrl->deleteProduct($productid);

    if ($result) {

        // gọi hàm xử lý ảnh với chức năng xóa
        uploadProductImage('', $product["Image"], "delete");

        echo "
        <script>
            alert('Xóa thành công');
            window.location='?page=product-manager';
        </script>";
    }
}
