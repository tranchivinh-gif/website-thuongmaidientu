<form action="" method="POST">
    <table>
        <tr>
            <td>Nhập mật khẩu mới</td>
            <td><input type="password" name="txtpassword"></td>
        </tr>
        <tr>
            <td>Nhập lại mật khẩu</td>
            <td><input type="password" name="txtrepassword"></td>
        </tr>
        <tr>
            <td></td>
            <td><button name="btnchange">Đổi mật khẩu</button></td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST["btnchange"])) {
    include_once __DIR__ . "/../controller/UserCtrl.php";
    $userCtrl = new UserCtrl();

    $resultconfirm = $userCtrl->confirmPassword($_POST["txtpassword"], $_POST["txtrepassword"]);
    if (!$resultconfirm) {
        echo '<script>
            alert("Mật khẩu không khớp!");
          </script>';
        exit();
    }

    $resultchange = $userCtrl->changePassword($_SESSION["user"]["UserID"], $_POST["txtpassword"]);
    if (!$resultchange) {
        echo '<script>
            alert("Đổi mật khẩu thất bại!");
          </script>';
        exit();
    } else {
        echo '<script>
            alert("Đổi mật khẩu thành công!");
            window.location.href="?employee";
          </script>';
        exit();
    }
}
?>