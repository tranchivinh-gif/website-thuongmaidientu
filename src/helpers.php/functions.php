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

        default:
            echo 'trang home';
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
        } else {
            echo '<script>alert("Email hoặc mật khẩu không chính xác!");</script>';
        }

        exit();
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
            echo '<script>
                    alert("Chào mừng nhân viên!");
                    window.location.href="?page=employee";
                  </script>';
        }
    } elseif ($_SESSION["user"]["RoleID"] == 4) {
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
            echo '<li><a href="?page=user">Quản lý người dùng</a></li>';
            break;

        case 2:
            echo '<li><a href="?page=product">Quản lý sản phẩm</a></li>';
            break;

        case 3:
            echo '<li><a href="?page=cart">Giỏ hàng</a></li>';
            break;

        case 4:
            echo '<li><a href="?page=employee">Quản lý nhân viên</a></li>';
            echo '<li><a href="?page=employee">Quản lý sản phẩm</a></li>';
            break;
    }

    echo '<li><a href="?page=logout">Đăng xuất</a></li>';
}
