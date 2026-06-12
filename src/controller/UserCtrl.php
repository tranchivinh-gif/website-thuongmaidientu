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
}
