<?php

include_once __DIR__ . "/../controller/UserCtrl.php";

// hàm kiểm tra quyền có khớp đối với vai trò thật sự k
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
            alert("Đổi mật khẩu thành công, vui lòng đăng nhập lại!");
            window.location.href="?page=logout";
          </script>';
    exit();
}

// hàm xử lý đăng ký
function handleSignup()
{
    // bấm nút đăng kí
    if (isset($_POST["btnsingup"])) {

        $userCtrl = new UserCtrl();

        // kiểm tra email trùng k
        if (!$userCtrl->checkExistEmail($_POST["txtemail"])) {
            echo '<script>alert("Email này đã được đăng ký!");</script>';
            return;
        }

        // tạo mới tài khoản
        $result = $userCtrl->createNewUser(intval($_POST["slcrole"]), $_POST["txtfullname"], $_POST["txtemail"], $_POST["txtpassword"]);

        echo '<script>
                alert("' . $result . '");
                window.location.href="?page=login";
              </script>';
    }
}

// hàm xử lý login
function handleLogin()
{
    // kiểm tra đã bấm nút đăng nhập chưa
    if (!isset($_POST["btnlogin"])) {
        return;
    }

    $userCtrl = new UserCtrl();

    $resultlogin = $userCtrl->clogin(
        $_POST["txtemail"],
        $_POST["txtpassword"]
    );

    if (!$resultlogin["success"]) {

        // kiẻm tra trạng thái tài khoản
        if ($resultlogin["message"] == "locked") {
            echo '<script>alert("Tài khoản đã bị khóa!");</script>';
            return;
        } else {
            echo '<script>alert("Email hoặc mật khẩu không chính xác!");</script>';
            return;
        }
    }

    // update số lần đăng nhập
    $resultupdatecountlogin = $userCtrl->cupdateCountLogin(
        $resultlogin["user"]["UserID"]
    );

    if (!$resultupdatecountlogin) {
        echo '<script>
                alert("Lỗi đăng nhập (do không cập nhật được LoginCount)!");
              </script>';
        exit();
    }

    // gán vào SESSION khi thành công đăng nhập
    $_SESSION["user"] = $resultlogin["user"];

    // xác định vai trò
    switch ($_SESSION["user"]["RoleID"]) {

        case 1: // admin
            echo '<script>
                alert("Chào mừng admin!");
                window.location.href="?page=home";
              </script>';
            break;

        case 2: // nhân viên

            // kiểm tra đăng nhập lần đầu
            if ($_SESSION["user"]["LoginCount"] == 0) {
                echo '<script>
                    alert("Lần đầu đăng nhập, vui lòng đổi mật khẩu!");
                    window.location.href="?page=vchangepassword";
                  </script>';
            } else {
                // gán thêm session 
                $_SESSION["shopid"] = $userCtrl->getShopIDToSession($_SESSION["user"]["UserID"]);
                echo '<script>
                    alert("Chào mừng nhân viên!");
                    window.location.href="?page=home";
                  </script>';
            }
            break;

        case 4: // chủ shop

            $_SESSION["shopid"] = $userCtrl->getShopIDToSession($_SESSION["user"]["UserID"]);

            echo '<script>
                alert("Chào mừng chủ cửa hàng!");
                window.location.href="?page=home";
              </script>';
            break;

        default: // khách
            echo '<script>
                alert("Chào mừng khách!");
                window.location.href="?page=home";
              </script>';
            break;
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
