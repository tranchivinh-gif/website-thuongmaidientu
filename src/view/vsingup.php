<form action="?page=signup" method="POST">
    <table>
        <tr>
            <td>Họ và tên</td>
            <td><input type="text" name="txtfullname" required></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" name="txtemail" required></td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td><input type="password" name="txtpassword" required></td>
        </tr>
        <tr>
            <td>Nhập lại mật khẩu</td>
            <td><input type="password" name="txtrepassword" required></td>
        </tr>
        <tr>
            <td>Chủ cửa hàng?</td>
            <td>Có<input type="radio" name="slcrole" value="4"> Không<input type="radio" name="slcrole" value="3"
                    checked></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="btnsingup" onclick=" return validateSignupForm()">Đăng ký</button> <button
                    type="reset">Nhập
                    lại</button></td>
        </tr>
    </table>
</form>