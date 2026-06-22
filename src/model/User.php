<?php

include_once __DIR__ . "/Database.php";

class User
{
    // hàm lấy user bởi Email
    public function getUserByEmail($email)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "select * from user where Email = '$email'";
        $result = $conn->query($sql);

        if (!$result || $result->num_rows == 0) {
            return false;
        }

        return $result->fetch_assoc();
    }

    // hàm lấy mỗi email bằng email
    public function getEmailByEmail($email)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "select Email from user where Email = '$email'";
        return $conn->query($sql)->num_rows;
    }

    // hàm thêm User vào database
    public function insertNewUser($RoleID, $UserName, $Email, $Password)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "insert into user (RoleID,UserName,Email,Password) values($RoleID,'$UserName','$Email','$Password')";
        return $conn->query($sql);
    }

    // hàm đổi mật khẩu trong database
    public function updatePassword($userid, $newpassword)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "update user set Password = '$newpassword' where UserID = $userid";
        return $conn->query($sql);
    }

    // hàm cập nhật số lần đăng nhập của user
    public function mupdateCountLogin($userid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "update user set LoginCount = LoginCount + 1  where UserID = $userid";
        return $conn->query($sql);
    }

    // hàm lấy ShopID bằng userid
    public function getShopID($userid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "select s.ShopID from shop s join employee e on s.ShopID=e.ShopID where s.OwnerID = $userid or e.UserID = $userid";
        return $conn->query($sql)->fetch_assoc();
    }

    // hàm lấy thông tin cá nhân của khách hàng
    public function getInfoCustomer($userid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "select UserName, Email, Image, Phone, Address from user where UserID = $userid";

        return $conn->query($sql)->fetch_assoc();
    }

    // hàm lấy cập nhật thông tin
    public function updateProfile($data)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "update user set 
        Image='$data[img]',
        Phone='$data[phone]',
        Address='$data[address]'
        where UserID=$data[userid]";

        return $conn->query($sql);
    }
}
