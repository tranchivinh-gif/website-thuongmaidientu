<?php

include_once __DIR__ . "/Database.php";

class Product
{
    // hàm lấy sản phẩm để quản lý theo chủ shop userid
    public function getAllProductByShopId($shopid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }
        $sql = "select pd.*, s.ShopID, s.OwnerID from product pd join shop s on pd.ShopID = s.ShopID where pd.ShopID = $shopid";
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

    // hàm thêm sản phẩm vào database
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

    // hàm lấy tất cả danh mục sản phẩm
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

    public function getAllProduct()
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }
        $sql = "select * from product";
        $result = $conn->query($sql);

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
