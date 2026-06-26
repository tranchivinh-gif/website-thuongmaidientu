<?php

include_once __DIR__ . "/../model/Payment.php";

class PaymentCtrl
{
    // hàm tạo Payment
    public function createNewPayment($data)
    {
        $orderModel = new Payment();
        return $orderModel->createNewPayMent($data);
    }

    // hàm lấy thanh toán bằng orderid
    public function getPaymentByOrderID($orderid)
    {
        $orderModel = new Payment();
        return $orderModel->getPaymentByOrderID($orderid)->fetch_assoc();
    }
}
