<?php

// hàm điều hướng
function router()
{
    $page = $_GET['page'] ?? '';

    switch ($page) {
        case 'login':
            handleLogin();
            include_once __DIR__ . "/../view/vlogin.php";
            break;

        case 'logout':
            handleLogout();
            break;

        case 'signup':
            handleSignup();
            include_once __DIR__ . "/../view/vsingup.php";
            break;

        case 'employee':
            verifyRole(2);
            include_once __DIR__ . "/../view/vemployee.php";
            break;

        case 'admin':
            verifyRole(1);
            include_once __DIR__ . "/../view/vadmin.php";
            break;

        case 'member':
            verifyRole(3);
            include_once __DIR__ . "/../view/vmember.php";
            break;

        case 'vchangepassword':
            if (isset($_POST["btnchange"])) {
                handleChangePassword(
                    $_SESSION["user"]["UserID"],
                    $_POST["txtpassword"],
                    $_POST["txtrepassword"]
                );
            }
            include_once __DIR__ . "/../view/vchangepassword.php";
            break;

        case 'ownershop':
            verifyRole(4);
            include_once __DIR__ . "/../view/vownershop.php";
            break;

        case 'product-manager':
            include_once __DIR__ . "/../view/vproductmanager.php";
            break;

        case 'add-product':
            handleAddProduct();
            include_once __DIR__ . "/../view/vaddproduct.php";
            break;

        case 'del-product':
            deleteProduct();
            break;

        case 'edit-product':
            include_once __DIR__ . "/../view/veditproduct.php";

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                handleUpdateProduct($productid, $product["Image"]);
                exit;
            }
            break;

        case 'product-detail':
            include_once __DIR__ . "/../view/vproductdetail.php";
            break;

        case 'cart':
            include_once __DIR__ . "/../view/vcart.php";
            handleEventInCartPage();
            break;

        case 'addcart':

            handleCart($_SESSION["user"]["UserID"], $_GET["id"]);
            break;

        default:
            renderProduct();
    }
}

// hàm xử lý xử kiện ở trang giỏ hàng
function handleEventInCartPage()
{
    // xử lý nút xóa sản phẩm trong giỏ hàng
    if (isset($_POST["btndelete"])) {

        include_once __DIR__ . "/../controller/CartCtrl.php";

        $cartCtrl = new CartCtrl();
        $cartID = $cartCtrl->getCartByUserID($_SESSION["user"]["UserID"]);

        if (isset($_POST["selected"])) {

            $selected = $_POST['selected'];

            foreach ($selected as $productId => $value) {
                $cartCtrl->deleteItemInCart($cartID["CartID"], $productId);
            }
            $count = $cartCtrl->countItem($cartID["CartID"]);
            if ($count["count"] > 0) {
                echo '<script>
                    alert("Xóa thành công!");
                    window.location.href="?page=cart";
                </script>';
                exit();
            } else {
                $cartCtrl->deleteCart($cartID["CartID"]);
                echo '<script>
                    alert("Giỏ hàng trống! Mua sắm ngay!!");
                    window.location.href="?page=home";
                </script>';
                exit();
            }
        } else {
            echo '<script>
                    alert("Vui lòng chọn ít nhất 1 sản phẩm!");
                    window.location.href="?page=cart";
                </script>';
            exit();
        }
    }
}

// hàm tính tổng
function totalPrice($price, $quanlity)
{
    return $price * $quanlity;
}

// hàm render sản phẩm trong giỏ hàng
function renderProductInCart()
{
    $products = getCartDetail($_SESSION["user"]["UserID"]);
    $totalPrice = 0;

    while ($product = $products->fetch_assoc()) {
        echo "<tr>";

        // checkbox chọn sản phẩm
        echo '<td>
            <input type="checkbox"
                   class="item-check"
                   name="selected[' . $product["ProductID"] . ']"
                   value="1">
        </td>';

        echo "<td>
            <a href='?page=product-detail&id=" . $product["ProductID"] . "'>
                " . $product["ProductName"] . "
            </a>
        </td>";

        echo '<td>
            <a href="?page=product-detail&id=' . $product["ProductID"] . '">
                <img src="/img/' . $product["Image"] . '" width="60">
            </a>
        </td>';

        echo '<td>
            <input type="number"
                   name="quantity[' . $product["ProductID"] . ']"
                   value="' . $product["Quantity"] . '"
                   min="1">
        </td>';

        echo "<td>" . number_format($product["Price"]) . " VNĐ</td>";

        echo "</tr>";

        $totalPrice += totalPrice($product["Price"], $product["Quantity"]);
    }

    // dòng tổng
    echo '<tr style="color:red; font-weight:bold;">';

    echo '<td>
        <input type="checkbox" id="checkAll" onclick="initCheckAllCart();">
    </td>';

    echo '<td colspan = "2">Tổng Cộng:</td>';

    echo '<td colspan = "2">' . number_format($totalPrice) . ' VNĐ</td>';

    echo '</tr>';
    echo '<tr><td colspan = "5">
        <button type="submit" name="btnorder" class="btn btn-primary">
            Đặt hàng
        </button>
        <button type="submit" name="btndelete" class="btn btn-danger">
            Xóa
        </button>
    </td></tr>';
}

// hàm lấy thông tin chi tiết giỏ hàng đổ ra view giỏ hàng
function getCartDetail($userid)
{
    include_once __DIR__ . "/../controller/CartCtrl.php";
    $cartCtrl = new CartCtrl();

    $resultOfGetCartIDByUserID = $cartCtrl->getCartByUserID($userid);

    if ($resultOfGetCartIDByUserID == null) {
        echo '<script>
                    alert("chưa có sản phẩm trong giỏ!");
                    window.location.href="?page=home";
                </script>';
        exit();
    } else {
        $resultOfGetAllProductInCart = $cartCtrl->getAllCartItem($resultOfGetCartIDByUserID["CartID"]);
        return $resultOfGetAllProductInCart;
    }
}

// hàm xử lý giỏ hàng
function handleCart($userid, $productid)
{
    if (!isset($_SESSION["user"])) {
        echo '<script>
                        alert("Bạn phải đăng nhập trước khi mua hàng!");
                        window.location.href="?page=login";
                    </script>';
        exit();
    }

    if (isset($_GET["id"])) {
        include_once __DIR__ . "/../controller/CartCtrl.php";
        $cartCtrl = new CartCtrl();

        $resultofGetOrCreate = $cartCtrl->getOrCreateCart($userid);

        $resultofgetCartItem = $cartCtrl->getCartItem($resultofGetOrCreate["CartID"], $productid);

        if ($resultofgetCartItem == null) {

            $product = getProductDetail($_GET["id"]);
            $product = $product["product"];

            $data = [
                "CartID"    => $resultofGetOrCreate["CartID"],
                "ProductID" => $product["ProductID"],
                "Quantity"  => $_POST["quantity"],
                "Price"     => $product["Discount"]
            ];

            $resultofAddtoCart = $cartCtrl->addItemToCart($data);

            if ($resultofAddtoCart) {
                echo '<script>
                        alert("Thêm vào giỏ hàng thành công!");
                        window.location.href="?page=cart";
                    </script>';
                exit();
            }
        } else {
            $resultOfupdateCartItem = $cartCtrl->updateCartItem(
                $resultofgetCartItem["CartID"],
                $resultofgetCartItem["ProductID"],
                $_POST["quantity"]
            );

            if ($resultOfupdateCartItem) {
                echo '<script>
                        alert("Thêm vào giỏ hàng thành công!");
                        window.location.href="?page=cart";
                    </script>';
                exit();
            }
        }
    }
}

// hàm xử lý đăng ký
function handleSignup()
{
    if (isset($_POST["btnsingup"])) {
        include_once __DIR__ . "/../controller/UserCtrl.php";
        $userCtrl = new UserCtrl();

        if (!$userCtrl->checkExistEmail($_POST["txtemail"])) {
            echo '<script>alert("Email này đã được đăng ký!");</script>';
            return;
        }

        $result = $userCtrl->createNewUser(intval($_POST["slcrole"]), $_POST["txtfullname"], $_POST["txtemail"], $_POST["txtpassword"]);
        echo '<script>
                alert("' . $result . '");
                window.location.href="?page=login";
              </script>';
    }
}

// hàm kiểm tra quyền
function verifyRole($rolecompare)
{
    if (!isset($_SESSION["user"]) || $_SESSION["user"]["RoleID"] != $rolecompare) {
        echo '<script>
                window.location.href="index.php";
              </script>';
        exit();
    }
}

// hàm xử lý đổi mật khẩu khi nhân viên đăng nhập lần đầu 
function handleChangePassword($userID, $password, $repassword)
{
    include_once __DIR__ . "/../controller/UserCtrl.php";
    $userCtrl = new UserCtrl();
    if (!$userCtrl->confirmPassword($password, $repassword)) {
        echo '<script>alert("Mật khẩu không khớp!");</script>';
        exit();
    }

    if (!$userCtrl->changePassword($userID, $password)) {
        echo '<script>alert("Đổi mật khẩu thất bại!");</script>';
        exit();
    }

    echo '<script>
            alert("Đổi mật khẩu thành công!");
            window.location.href="?page=employee";
          </script>';
    exit();
}

// hàm xử lý login
function handleLogin()
{
    if (!isset($_POST["btnlogin"])) {
        return;
    }

    include_once __DIR__ . "/../controller/UserCtrl.php";

    $userCtrl = new UserCtrl();

    $resultlogin = $userCtrl->clogin(
        $_POST["txtemail"],
        $_POST["txtpassword"]
    );

    if (!$resultlogin["success"]) {

        if ($resultlogin["message"] == "locked") {
            echo '<script>alert("Tài khoản đã bị khóa!");</script>';
            return;
        } else {
            echo '<script>alert("Email hoặc mật khẩu không chính xác!");</script>';
            return;
        }
    }

    $resultupdatecountlogin = $userCtrl->cupdateCountLogin(
        $resultlogin["user"]["UserID"]
    );

    if (!$resultupdatecountlogin) {
        echo '<script>
                alert("Lỗi đăng nhập (do không cập nhật được LoginCount)!");
              </script>';
        exit();
    }

    $_SESSION["user"] = $resultlogin["user"];

    if ($_SESSION["user"]["RoleID"] == 1) {
        echo '<script>
                alert("Chào mừng admin!");
                window.location.href="?page=admin";
              </script>';
    } elseif ($_SESSION["user"]["RoleID"] == 2) {

        if ($_SESSION["user"]["LoginCount"] == 0) {
            echo '<script>
                    alert("Lần đầu đăng nhập, vui lòng đổi mật khẩu!");
                    window.location.href="?page=vchangepassword";
                  </script>';
        } else {
            $_SESSION["shopid"]  = $userCtrl->getShopIDToSession($_SESSION["user"]["UserID"]);
            echo '<script>
                    alert("Chào mừng nhân viên!");
                    window.location.href="?page=employee";
                  </script>';
        }
    } elseif ($_SESSION["user"]["RoleID"] == 4) {
        $_SESSION["shopid"]  = $userCtrl->getShopIDToSession($_SESSION["user"]["UserID"]);
        echo '<script>
                alert("Chào mừng chủ cửa hàng!");
                window.location.href="?page=ownershop";
              </script>';
    } else {
        echo '<script>
                alert("Chào mừng khách!");
                window.location.href="?page=member";
              </script>';
    }

    exit();
}

// xử lý đăng xuất
function handleLogout()
{
    session_unset();
    session_destroy();

    echo '<script>
            alert("Đăng xuất thành công!");
            window.location.href="index.php";
          </script>';
    exit();
}

//hàm hiển thị menu
function displayMenu()
{
    echo '<li><a href="?page=home">Trang chủ</a></li>';

    if (!isset($_SESSION["user"])) {
        echo '<li><a href="?page=login">Đăng nhập</a></li>';
        return;
    }

    $roleID = $_SESSION["user"]["RoleID"];

    switch ($roleID) {
        case 1:
            echo '<li><a href="?page=user-manager">Quản lý người dùng</a></li>';
            break;

        case 2:
            echo '<li><a href="?page=product-manager">Quản lý sản phẩm</a></li>';
            break;

        case 3:
            echo '<li><a href="?page=cart">Giỏ hàng</a></li>';
            break;

        case 4:
            echo '<li><a href="?page=employee-manager">Quản lý nhân viên</a></li>';
            echo '<li><a href="?page=product-manager">Quản lý sản phẩm</a></li>';
            break;
    }

    echo '<li><a href="?page=logout">Đăng xuất</a></li>';
}

// hàm render sản phẩm trang quản lý 
function renderProductMager()
{

    include_once __DIR__ . "/../controller/ProductCtrl.php";
    $productCtrl = new ProductCtrl();
    $result = $productCtrl->getProductToManage($_SESSION["shopid"]);

    if (!$result["success"]) {
        echo $result["message"];
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

// hàm xử lý quá trình thêm sản phẩm
function handleAddProduct()
{
    if (isset($_POST["btnadd"])) {

        include_once __DIR__ . "/../controller/ProductCtrl.php";

        $productCtrl = new ProductCtrl();

        // xử lý ảnh
        $handledImage = uploadProductImage($_SESSION["shopid"]);

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

// hàm xử lý upload / xóa ảnh
function uploadProductImage($shopid = '', $fileimage = '', $action = 'upload')
{
    $folder = "./img/";

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

    $hasUpload =
        isset($_FILES["txtimage"]) &&
        $_FILES["txtimage"]["error"] === 0;

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

    if (!in_array($ext, $allow)) {
        return false;
    }

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $imageName = $shopid . "-" . time() . "." . $ext;

    $path = $folder . $imageName;

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

// hàm render danh sách danh mục sản phẩm
function rederCategoryProduct($selectedCategoryID = null)
{
    include_once __DIR__ . "/../controller/ProductCtrl.php";

    $productCtrl = new ProductCtrl();

    $result = $productCtrl->getAllCategoryProduct();

    if (!$result["success"]) {
        echo $result["message"];
        return;
    }

    foreach ($result["categorylist"] as $p) {

        $selected =
            ($selectedCategoryID == $p["CategoryID"])
            ? 'selected'
            : '';

        echo '
        <option
            value="' . $p["CategoryID"] . '"
            ' . $selected . '>' . $p["CategoryName"] . '

        </option>';
    }
}

// hàm render sản phẩm ra màn hình
function renderProduct()
{
    include_once __DIR__ . "/../controller/ProductCtrl.php";

    $productCtrl = new ProductCtrl();
    $response = $productCtrl->getAllProduct();

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

        if ($p["Stock"] == 0) {
            continue;
        }

        echo '<div class="product-card"><a href="?page=product-detail&id=' . $p['ProductID'] . '">';
        echo '<img src="/img/' . $p['Image'] . '" alt="">';
        echo '<h3>' . $p['ProductName'] . '</h3>';
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

// hàm lấy thông tin 1 sản phẩm để chỉnh sửa
function getProductForEdit($productid)
{
    if (!isset($productid)) {
        return null;
    }

    include_once __DIR__ . "/../controller/ProductCtrl.php";

    $productCtrl = new ProductCtrl();

    $response = $productCtrl->getProductByID($_GET["id"]);

    if (!$response["success"]) {
        return null;
    }

    return $response["product"];
}

// hàm xử lý cập nhật sản phẩm
function handleUpdateProduct($productid, $fileimage)
{
    if (isset($_POST["btnupdate"])) {
        include_once __DIR__ . "/../controller/ProductCtrl.php";

        $productCtrl = new ProductCtrl();

        // xử lý ảnh
        $handledImage = uploadProductImage($_SESSION["shopid"], $fileimage);

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

        $result = $productCtrl->updateProduct($data);

        if ($result) {
            echo '<script>alert("Cập nhật sản phẩm thành công");window.location.href="?page=product-manager";</script>';
        } else {
            echo '<script>alert("Cập nhật sản phẩm thất bại");</script>';
        }
    }
}

// hàm kiểm tra ảnh sản phẩm có trong thư mục và database chưa
function getProductImage($filename)
{
    $default = "/img/default.jpg";

    if (!empty($filename)) {
        $path = __DIR__ . "/../img/" . $filename;

        if (file_exists($path)) {
            return "/img/" . $filename;
        }
    }

    return $default;
}

// hàm xử lý xóa sản phẩm
function deleteProduct()
{
    if (!isset($_GET["id"])) {
        return;
    }

    include_once __DIR__ . "/../controller/ProductCtrl.php";

    $productid = (int)$_GET["id"];

    $productCtrl = new ProductCtrl();

    // lấy thông tin sản phẩm
    $product = getProductForEdit($productid);

    if (!$product) {
        return;
    }

    $result = $productCtrl->deleteProduct($productid);

    if ($result) {

        // gọi hàm ảnh để xóa
        uploadProductImage('', $product["Image"], "delete");

        echo "
        <script>
            alert('Xóa thành công');
            window.location='?page=product-manager';
        </script>";
    }
}

// hàm lấy sản phẩm chi tiết đổ ra view
function getProductDetail($productid)
{
    include_once __DIR__ . "/../controller/ProductCtrl.php";
    $productModel = new ProductCtrl();
    return $productModel->getProductDetail($productid);
}
