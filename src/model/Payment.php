<?php

include_once __DIR__ . "/Database.php";

class Payment
{
    // hàm tạo payment
    public function createNewPayMent($data)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "insert into `payment`
        (
            OrderID,
            PaymentMethod,
            Amount,
            PaymentDate,
            Status
        )
        values
        (
            '$data[orderid]',
            '$data[paymentmethod]',
            '$data[amount]',
            '$data[paymentdate]',
            '$data[status]'
        )";

        $result = $conn->query($sql);

        if ($result) {
            return $conn->insert_id; // trả về PaymentID
        }

        return false;
    }
}
