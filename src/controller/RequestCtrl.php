<?php

include_once __DIR__ . "/../model/Request.php";

class RequestCtrl
{
    // hàm tạo yêu cầu khách hàng
    public function createNewRequest($data)
    {
        $requestModel = new Request();
        return $requestModel->createNewRequest($data);
    }

    // hàm lấy thông tin yêu cầu khách hàng theo OrderID và ProductID
    public function getCustomerRequestByOrderID($orderid, $productid)
    {
        $customerRequestModel = new Request();

        $result = $customerRequestModel->getCustomerRequestByOrderID($orderid, $productid);

        if (count($result) == 0) {
            return [
                "success" => false,
                "message" => "Không tìm thấy yêu cầu!"
            ];
        }

        return [
            "success" => true,
            "customerrequestlist" => $result
        ];
    }
}
