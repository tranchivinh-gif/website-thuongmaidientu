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

    // cập nhật trạng thái chi tiết đơn hàng
    public function updateStatusOfOrderDetail($status, $orderid, $productid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "update order_detail
            set Status = '$status'
            where OrderID = $orderid and ProductID = $productid and Status not in ('completed', 'return')";

        return $conn->query($sql);
    }

    // hàm lấy trạng thái chi tiết 1 đơn hàng để kiểm tra
    public function getStatusOrderDetailByOrderID($orderid, $productid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }
        $sql = "select Status from `order_detail` where OrderID = $orderid and ProductID = $productid";
        $result = $conn->query($sql);

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
