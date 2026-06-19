<?php

include_once __DIR__ . "/../model/User.php";

class UserCtrl
{
    //hàm xử lý đăng nhập
    public function clogin($email, $password)
    {
        $userModel = new User();
        $user = $userModel->getUserByEmail($email);

        if (!$user) {
            return [
                "success" => false,
                "message" => "invalid"
            ];
        }

        if ($user["Password"] != md5($password)) {
            return [
                "success" => false,
                "message" => "invalid"
            ];
        }

        if ($user["Status"] == 0) {
            return [
                "success" => false,
                "message" => "locked"
            ];
        }

        return [
            "success" => true,
            "user" => $user
        ];
    }

    // hàm so sánh password và repassword
    public function confirmPassword($password, $repassword)
    {
        if ($password == $repassword) {
            return true;
        } else {
            return false;
        }
    }


    // hàm gọi model update mật khẩu
    public function changePassword($userid, $newpassword)
    {
        $userModel = new User();
        $result = $userModel->updatePassword($userid, md5($newpassword));

        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    // hàm gọi model xử lý số lần đăng nhập
    public function cupdateCountLogin($userid)
    {
        $userModel = new User();
        $result = $userModel->mupdateCountLogin($userid);

        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    // hàm kiểm tra email tồn tại chưa
    public function checkExistEmail($email)
    {
        $userModel = new User();
        $result = $userModel->getEmailByEmail($email);
        if ($result > 0) {
            return false;
        } else {
            return true;
        }
    }

    // hàm tạo người dùng mới
    public function createNewUser($RoleID, $UserName, $Email, $Password)
    {
        $userModel = new User();
        $result = $userModel->insertNewUser($RoleID, $UserName, $Email, md5($Password));
        if (!$result) {
            return "Đăng ký thất bại!";
        } else {
            return "Đăng ký thành công!";
        }
    }

    // hàm lấy ShopID để gắn vào session lúc đăng nhập
    public function getShopIDToSession($userid)
    {
        $userModel = new User();
        $result = $userModel->getShopID($userid);
        return $result["ShopID"];
    }

    // hàm lấy thông tin cá nhân của khách hàng
    public function getInfoCustomer($userid)
    {
        $userModel = new User();
        return $userModel->getInfoCustomer($userid);
    }
}
