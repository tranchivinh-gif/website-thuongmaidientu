<?php

include_once __DIR__ . "/Database.php";

class User
{
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


    public function getShopID($userid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "select ShopID from shop where OwnerID = $userid";
        return $conn->query($sql)->fetch_assoc();
    }
}
