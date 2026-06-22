<?php
$userCtrl = new UserCtrl();
$user = $userCtrl->getInfoCustomer($_SESSION["user"]["UserID"]);
?>
<div style="display: flex;">
    <form action="?page=profile" method="POST" enctype="multipart/form-data">
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
                    <input type="tel" name="txtphone" value="<?php echo $user['Phone']; ?>" required
                        onblur="kiemtrasdt();" id="tel"><span id="err2"></span>
                </td>
            </tr>
            <tr>
                <td>Address</td>
                <td>
                    <input type="text" name="txtaddress" value="<?php echo $user['Address']; ?>"
                        placeholder="ví dụ: số nhà/tên đường/huyện/tỉnh" required>
                </td>
            </tr>

            <tr>
                <td>Image</td>
                <td>
                    <input type="hidden" name="txtimageold" value="<?php echo $user['Image']; ?>">
                    <input type="file" name="txtimage">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="btnupdateprofile">
                        Cập nhật
                    </button>

                    <button type="reset">
                        Nhập lại
                    </button>
                </td>
            </tr>
        </table>
    </form>
    <img style="width: 160px; height: 160px ;border-radius: 100px;"
        src="/img/profile_img/<?php echo $user['Image'];  ?>" alt="">
</div>