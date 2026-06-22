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
}
