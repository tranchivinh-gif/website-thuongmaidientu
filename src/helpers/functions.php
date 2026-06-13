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
        default:
            echo 'trang home';
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
            // die($_SESSION["shopid"]);
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
        echo '<td><a href="?page=edit-product=' . $p['ProductID'] . '">sửa</a> | <a href="?page=del-product=' . $p['ProductID'] . '">xóa</a></td>';
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
            echo "Ảnh không hợp lệ hoặc upload thất bại";
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
            echo "Thêm sản phẩm thành công";
        } else {
            echo "Thêm sản phẩm thất bại";
        }
    }
}

// hàm xử lý và upload ảnh
function uploadProductImage($shopid)
{
    if (
        !isset($_FILES["txtimage"]) ||
        $_FILES["txtimage"]["error"] != 0
    ) {
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

    $folder = "./img/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // đặt tên: idshop-time()
    $imageName = $shopid . "-" . time() . "." . $ext;

    $path = $folder . $imageName;

    if (move_uploaded_file($file["tmp_name"], $path)) {

        return [
            "filename" => $imageName,
            "path" => "/img/" . $imageName
        ];
    }

    return false;
}

// hàm render lựa chọn danh mục sản phẩm
function rederCategoryProduct()
{
    include_once __DIR__ . "/../controller/ProductCtrl.php";
    $productCtrl = new ProductCtrl();
    $result = $productCtrl->getAllCategoryProduct();

    if (!$result["success"]) {
        echo $result["message"];
    }

    foreach ($result["categorylist"] as $p) {
        echo '<option value="' . $p["CategoryID"] . '">' . $p["CategoryName"] . '</option>';
    }
}
