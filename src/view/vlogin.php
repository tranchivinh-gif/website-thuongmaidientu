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

    $result = $userCtrl->clogin(
        $_POST["txtemail"],
        $_POST["txtpassword"]
    );

    if (!$result["success"]) {

        if ($result["message"] == "locked") {
            echo '<script>alert("Tài khoản đã bị khóa!");</script>';
        } else {
            echo '<script>alert("Email hoặc mật khẩu không chính xác!");</script>';
        }

        exit();
    }

    $_SESSION["user"] = $result["user"];

    echo '<script>
            alert("Đăng nhập thành công!");
            window.location.href="?home";
          </script>';
}
?>