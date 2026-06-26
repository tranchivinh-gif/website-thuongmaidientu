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
        ShippingAddress,
        Note
    )
    values
    (
        '$data[userid]',
        '$data[orderdate]',
        '$data[total]',
        '$data[status]',
        '$data[shippingaddress]',
        '$data[note]'
    )";

        $result = $conn->query($sql);

        if ($result) {
            return $conn->insert_id;
        }

        return false;
    }

    // hàm lấy tất cả đơn hàng của người dùng
    public function getAllOrderByUserID($userid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }
        $sql = "select * from `order` where UserID = $userid";
        $result = $conn->query($sql);

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    // hàm lấy tất cả đơn hàng theo shop để quản lý
    public function getAllOrderByShopID($shopid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "SELECT 
                o.OrderID, 
                o.OrderDate, 
                o.UserID, 
                sum(od.UnitPrice * od.Quantity) as Total, 
                o.Status
            from `order` o
            join order_detail od on o.OrderID = od.OrderID
            join product p on p.ProductID = od.ProductID
            where p.ShopID = $shopid
            GROUP by o.OrderID";

        $result = $conn->query($sql);
        if (!$result) {
            return false;
        }

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    // hàm lấy chi tiết đơn hàng theo orderID để quản lý shop
    public function getOrderDetailByOrderID($orderid, $shopid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "SELECT 
                o.OrderID,
                p.ProductID,
                p.ProductName, 
                o.ShippingAddress, 
                od.Status
            from `order` o 
            join order_detail od on o.OrderID = od.OrderID 
            join product p on p.ProductID = od.ProductID 
            where o.OrderID = $orderid and p.ShopID = $shopid";

        $result = $conn->query($sql);

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
