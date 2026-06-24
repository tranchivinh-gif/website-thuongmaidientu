<?php

include_once __DIR__ . "/../model/Order.php";

class OrderCtrl
{
    // hàm tạo hóa đơn
    public function createNewOrder($data)
    {
        $orderModel = new Order();
        return $orderModel->createNewOrder($data);
    }

    // hàm lấy tất cả đơn hàng của người dùng
    public function getAllOrderByUserID($userid)
    {
        $orderModel = new Order();
        $result = $orderModel->getAllOrderByUserID($userid);
        if (count($result) == 0) {
            return [
                "success" => false,
                "message" => "Chưa có đơn hàng nào!"
            ];
        }

        return [
            "success" => true,
            "orderlist" => $result
        ];
    }
}
