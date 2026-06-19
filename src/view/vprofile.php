<?php
$userCtrl = new UserCtrl();
$user = $userCtrl->getInfoCustomer($_SESSION["user"]["UserID"]);
?>
<form action="" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td>User Name</td>
            <td>
                <input type="text" name="txtusername" value="<?php echo $user['UserName']; ?>" readonly>
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>
                <input type="email" name="txtemail" value="<?php echo $user['Email']; ?>" readonly>
            </td>
        </tr>

        <tr>
            <td>Phone</td>
            <td>
                <input type="tel" name="txtphone" value="<?php echo $user['Phone']; ?>">
            </td>
        </tr>
        <tr>
            <td>Address</td>
            <td>
                <input type="text" name="txtaddress" value="<?php echo $user['Address']; ?>">
            </td>
        </tr>

        <tr>
            <td>Image</td>
            <td>
                <input type="file" name="txtimage">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" name="btnupdate">
                    Cập nhật
                </button>

                <button type="reset">
                    Nhập lại
                </button>
            </td>
        </tr>
    </table>
</form>