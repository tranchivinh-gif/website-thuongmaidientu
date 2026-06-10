<?php

include_once __DIR__ . "/../model/User.php";

class UserCtrl
{
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

    public function confirmPassword($password, $repassword)
    {
        if ($password == $repassword) {
            return true;
        } else {
            return false;
        }
    }

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
