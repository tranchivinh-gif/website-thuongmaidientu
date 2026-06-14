<?php

include_once __DIR__ . "/../model/Product.php";

class ProductCtrl
{
    // hàm lấy sản phẩm để quản lý
    public function getProductToManage($shopid)
    {
        $productModel = new Product();
        $result = $productModel->getAllProductByShopId($shopid);
        if (!$result) {
            return [
                "success" => false,
                "message" => "Lỗi hiển thị sản phẩm!"
            ];
        }

        if (count($result) == 0) {
            return [
                "success" => false,
                "message" => "Chưa có sản phẩm!"
            ];
        }

        return [
            "success" => true,
            "productpack" => $result
        ];
    }

    // hàm thêm sản phẩm
    public function addNewProduct($data)
    {
        if (empty($data)) {
            return false;
        }

        $productModel = new Product();

        return $productModel->insertProduct($data);
    }

    // hàm lấy tất cả loại sản phẩm
    public function getAllCategoryProduct()
    {
        $productModel = new Product();
        $result = $productModel->getAllCategoryProduct();
        if (count($result) == 0) {
            return [
                "success" => false,
                "message" => "Chưa có phân loại sản phẩm nào!"
            ];
        }

        return [
            "success" => true,
            "categorylist" => $result
        ];
    }

    // hàm lấy tất cả sản phẩm
    public function getAllProduct()
    {
        $productModel = new Product();
        $result = $productModel->getAllProduct();

        if (count($result) == 0) {
            return [
                "success" => false,
                "message" => "Chưa có sản phẩm nào!"
            ];
        }

        return [
            "success" => true,
            "productlist" => $result
        ];
    }

    // hàm lấy sản phẩm bằng productid
    public function getProductByID($productid)
    {
        $productModel = new Product();
        $result = $productModel->getProductByID($productid);

        if ($result === null) {
            return [
                "success" => false,
                "message" => "Sản phẩm không tồn tại!"
            ];
        }

        return [
            "success" => true,
            "product" => $result
        ];
    }

    // hàm cập nhật sản phẩm
    public function updateProduct($data)
    {
        if (empty($data)) {
            return false;
        }

        $productModel = new Product();

        return $productModel->updateProduct($data);
    }
}
