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

    // cập nhật trạng thái chi tiết đơn hàng
    public function updateStatusOfOrderDetail($status, $orderid, $productid)
    {
        $orderdetailModel = new OrderDetail();
        return $orderdetailModel->updateStatusOfOrderDetail($status, $orderid, $productid);
    }

    // hàm lấy trạng thái chi tiết 1 đơn hàng để kiểm tra
    public function getStatusOrderDetailByOrderID($orderid, $productid)
    {
        $orderdetailModel = new OrderDetail();
        $result = $orderdetailModel->getStatusOrderDetailByOrderID($orderid, $productid);
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

    // cập nhật trạng thái chi tiết đơn hàng đối với hành động trả hàng
    public function updateStatusOfOrderDetailForRequest($orderid, $productid)
    {
        $orderdetailModel = new OrderDetail();
        return $orderdetailModel->updateStatusOfOrderDetailForRequest($orderid, $productid);
    }
}
