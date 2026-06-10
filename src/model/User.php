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
}
