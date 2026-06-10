<form action="" method="POST">
    <table>
        <tr>
            <td>Email</td>
            <td><input type="email" name="txtemail"></td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td><input type="password" name="txtpassword"></td>
        </tr>
        <tr>
            <td></td>
            <td><button name="btnlogin">Đăng nhập</button></td>
        </tr>
    </table>
</form>

<?php

if (isset($_POST["btnlogin"])) {

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

    // tính số lần đăng nhập
    $resultupdatecountlogin = $userCtrl->cupdateCountLogin($resultlogin["user"]["UserID"]);
    if (!$resultupdatecountlogin) {
        echo '<script>
            alert("Lỗi đăng nhập (do không cập nhật được LoginCount)!");
          </script>';
        exit();
    }

    echo '<script>
            alert("Đăng nhập thành công!");
          </script>';

    $_SESSION["user"] = $resultlogin["user"];

    if ($_SESSION["user"]["RoleID"] == 1) {
        echo '<script>
            alert("Chào mừng admin!");
            window.location.href="?admin";
          </script>';
        exit();
    } elseif ($_SESSION["user"]["RoleID"] == 2) {
        if ($_SESSION["user"]["LoginCount"] == 0) {
            echo '<script>
            alert("Lần đầu đăng nhập, vui lòng đổi mật khẩu!");
            window.location.href="?vchangepassword";
          </script>';
            exit();
        }
        echo '<script>
            alert("Chào mừng nhân viên!");
            window.location.href="?employee";
          </script>';
        exit();
    } else {
        echo '<script>
            alert("Chào mừng khách!");
            window.location.href="?home";
          </script>';
    }
}
?>