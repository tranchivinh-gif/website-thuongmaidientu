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
}
