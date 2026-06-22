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
}
