<?php

include_once __DIR__ . "/../model/Cart.php";

class CartCtrl
{
    // hàm lấy giỏ hàng từ userid
    public function getCartByUserID($userid)
    {
        $cartModel = new Cart();

        $cart = $cartModel->getCartByUserID($userid);
        return $cart;
    }

    // hàm lấy hoặc tạo mới giỏ hàng
    public function getOrCreateCart($userid)
    {
        $cartModel = new Cart();

        $cart = $this->getCartByUserID($userid);

        if (!$cart) {
            $cartModel->createNewCart($userid);
            $cart = $this->getCartByUserID($userid);
        }

        return $cart;
    }

    // hàm lấy sản phẩm trong giỏ hàng
    public function getCartItem($cartID, $productID)
    {
        $cartModel = new Cart();
        return $cartModel->getCartItem($cartID, $productID);
    }

    // hàm lấy tất cả sản phẩm trong giỏ hàng
    public function getAllCartItem($cartID)
    {
        $cartModel = new Cart();
        return $cartModel->getAllCartItem($cartID);
    }

    // hàm cập nhật sản phẩm trong giỏ hàng
    public function updateCartItem($cartID, $productID, $quantity)
    {
        $cartModel = new Cart();
        return $cartModel->updateCartItem($cartID, $productID, $quantity);
    }

    // hàm thêm sản phẩm vào giỏ hàng
    public function addItemToCart($data)
    {
        $cartModel = new Cart();
        return $cartModel->addItemToCart($data);
    }
}
