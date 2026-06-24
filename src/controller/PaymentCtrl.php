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
}
