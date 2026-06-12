<form action="?page=login" method="POST" class="formlogin">
    <table>
        <tr>
            <td>Email</td>
            <td><input type="email" name="txtemail" required></td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td><input type="password" name="txtpassword" required></td>
        </tr>
        <tr>
            <td></td>
            <td><button name="btnlogin" onclick="return validateEmail()">Đăng nhập</button> <a href="?page=signup">Đăng
                    ký</a>
            </td>
        </tr>
    </table>
</form>