<?php

include_once __DIR__ . "/Database.php";

class Cart
{
    // hàm tạo mới giỏ hàng
    public function createNewCart($userid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }
        $sql = "insert into cart (UserID) values($userid)";

        return $conn->query($sql);
    }

    // hàm thêm sản phẩm vào giỏ hàng
    public function addItemToCart($data)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        if (!$conn) {
            die("Lỗi kết nối database!");
        }

        $sql = "INSERT INTO cart_detail (CartID, ProductID, Quantity, Price) 
            VALUES (
                {$data['CartID']}, 
                {$data['ProductID']}, 
                {$data['Quantity']}, 
                {$data['Price']}
            )";
        return $conn->query($sql);
    }

    // hàm kiếm giỏ hàng từ userID
    public function getCartByUserID($userid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        $sql = "SELECT * FROM cart WHERE UserID = $userid LIMIT 1";
        $result = $conn->query($sql);

        return $result ? $result->fetch_assoc() : null;
    }

    // hàm cập nhật giỏ hàng
    public function updateCartItem($cartID, $productID, $quantity)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        $sql = "UPDATE cart_detail 
            SET Quantity = $quantity + Quantity
            WHERE CartID = $cartID 
            AND ProductID = $productID";

        return $conn->query($sql);
    }

    // hàm lấy sản phẩm từ giỏ hàng
    public function getCartItem($cartID, $productID)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        $sql = "SELECT cd.*, p.ProductName 
            FROM cart_detail cd join product p on p.ProductID = cd.ProductID 
            WHERE cd.CartID = $cartID 
            AND cd.ProductID = $productID 
            LIMIT 1";

        $result = $conn->query($sql);

        return $result ? $result->fetch_assoc() : null;
    }

    // hàm lấy tất cả sản phẩm từ giỏ hàng
    public function getAllCartItem($cartID)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        $sql = "SELECT cd.*, p.ProductName, p.Image  , p.ShopID
            FROM cart_detail cd join product p on p.ProductID = cd.ProductID 
            WHERE cd.CartID = $cartID";

        $result = $conn->query($sql);

        return $result ? $result : null;
    }

    // hàm xóa sản phẩm trong giỏ hàng
    public function deleteItemInCart($cartid, $productid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        $sql = "DELETE 
                FROM cart_detail
                WHERE CartID = $cartid 
                AND ProductID = $productid";

        return $conn->query($sql);
    }

    // hàm xóa giỏ hàng
    public function deleteCart($cartid)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        $sql = "DELETE 
                FROM cart
                WHERE CartID = $cartid";

        return $conn->query($sql);
    }

    // hàm đếm sản phẩm từ giỏ hàng
    public function countItem($cartID)
    {
        $db = new Database();
        $conn = $db->moKetNoi();

        $sql = "SELECT count(*) as count 
            FROM cart_detail  
            WHERE CartID = $cartID";

        return  $conn->query($sql)->fetch_assoc();
    }
}
