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

    // hàm lấy tất cả đơn hàng theo shop
    public function getAllOrderByShopID($shopid)
    {
        $orderModel = new Order();
        $result = $orderModel->getAllOrderByShopID($shopid);

        if (!$result || count($result) == 0) {
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

    // hàm lấy chi tiết đơn hàng theo orderID (controller)
    public function getOrderDetailByOrderID($orderid, $shopid)
    {
        $orderModel = new Order();
        $result = $orderModel->getOrderDetailByOrderID($orderid, $shopid);

        if (count($result) == 0) {
            return [
                "success" => false,
                "message" => "Không tìm thấy chi tiết đơn hàng!"
            ];
        }

        return [
            "success" => true,
            "orderdetail" => $result
        ];
    }
}
