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
}
