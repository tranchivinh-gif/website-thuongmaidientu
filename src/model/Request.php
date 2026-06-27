<?php

include_once __DIR__ . "/Database.php";

class Request
{
    // hàm tạo yêu cầu khách hàng
    public function createNewRequest($data)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "insert into customer_request
    (
        UserID,
        OrderID,
        ProductID,
        Title,
        Content,
        Image
    )
    values
    (
        '$data[userid]',
        '$data[orderid]',
        '$data[productid]',
        '$data[title]',
        '$data[content]',
        '$data[image]'
    )";

        $result = $conn->query($sql);

        if ($result) {
            return $conn->insert_id; // trả về RequestID vừa tạo
        }

        return false;
    }

    // hàm lấy thông tin yêu cầu khách hàng theo OrderID và ProductID
    public function getCustomerRequestByOrderID($orderid, $productid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "select 
                cr.RequestID,
                u.UserName,
                u.Phone,
                p.ProductName,
                cr.Title,
                cr.Content,
                cr.Image
            from customer_request cr
            join product p on cr.ProductID = p.ProductID
            join user u on u.UserID = cr.UserID
            where cr.OrderID = $orderid 
            and cr.ProductID = $productid";

        $result = $conn->query($sql);

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
