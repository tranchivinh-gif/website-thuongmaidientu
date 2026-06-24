<?php

include_once __DIR__ . "/../model/OrderDetail.php";

class OrderDetailCtrl
{
    // hàm tạo hóa đơn chi tiết
    public function createOrderDetail($data)
    {
        $orderdetailModel = new OrderDetail();
        return $orderdetailModel->createOrderDetail($data);
    }

    // hàm lấy tất cả chi tiết đơn hàng của người dùng
    public function getAllOrderDetailByOrderID($orderid)
    {
        $orderdetailModel = new OrderDetail();
        $result = $orderdetailModel->getAllOrderDetailByOrderID($orderid);
        if (count($result) == 0) {
            return [
                "success" => false,
                "message" => "lỗi!"
            ];
        }

        return [
            "success" => true,
            "orderdetaillist" => $result
        ];
    }
}
