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

    // hàm lấy tất cả chi tiết đơn hàng của người dùng
    public function getAllOrderDetailByOrderID($orderid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }
        $sql = "select od.*, p.ProductName from `order_detail` od join product p on p.ProductID = od.ProductID where OrderID = $orderid";
        $result = $conn->query($sql);

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
