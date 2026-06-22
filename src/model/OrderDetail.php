<?php

include_once __DIR__ . "/Database.php";

class OrderDetail
{
    // hàm thêm chi tiết hóa đơn
    public function createOrderDetail($data)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "insert into `order_detail`
    (
        OrderID,
        ProductID,
        Quantity,
        UnitPrice,
        Discount
    )
    values
    (
        '$data[orderid]',
        '$data[productid]',
        '$data[quantity]',
        '$data[unitprice]',
        '$data[discount]'
    )";

        return $conn->query($sql);
    }
}
