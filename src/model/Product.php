<?php

include_once __DIR__ . "/Database.php";

class Product
{
    // hàm lấy sản phẩm để quản lý theo chủ shop userid
    public function getAllProductByShopId($userid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }
        // select pd.*, s.ShopID, s.OwnerID, s.ShopName from product pd join shop s on pd.ShopID = s.ShopID where s.ShopID = 1 && s.OwnerID = 4
        $sql = "select pd.*, s.ShopID, s.OwnerID from product pd join shop s on pd.ShopID = s.ShopID where s.OwnerID = $userid";
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

    public function insertProduct($data)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "insert into product
            (
                CategoryID,
                ShopID,
                ProductName,
                Price,
                Discount,
                Description,
                Image,
                Stock,
                Status
            )
            values
            (
                '$data[categoryid]',
                '$data[shopid]',
                '$data[productname]',
                '$data[price]',
                '$data[discount]',
                '$data[description]',
                '$data[image]',
                '$data[stock]',
                '$data[status]'
            )";

        $result = $conn->query($sql);

        if ($result) {
            return true;
        }

        return false;
    }

    public function getAllCategoryProduct()
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }
        $sql = "select * from category_product";
        $result = $conn->query($sql);

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
