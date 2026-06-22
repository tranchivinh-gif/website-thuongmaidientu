<?php

include_once __DIR__ . "/Database.php";

class Order
{
    // hàm tạo hóa đơn
    public function createNewOrder($data)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "insert into `order`
    (
        UserID,
        OrderDate,
        Total,
        Status,
        ShippingAddress
    )
    values
    (
        '$data[userid]',
        '$data[orderdate]',
        '$data[total]',
        '$data[status]',
        '$data[shippingaddress]'
    )";

        $result = $conn->query($sql);

        if ($result) {
            return $conn->insert_id;
        }

        return false;
    }
}
