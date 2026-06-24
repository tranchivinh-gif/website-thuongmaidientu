<?php

// hàm xử lý nút đặt hàng trong giỏ hàng
// function handleBtnOrderInCart()
// {
//     $cartCtrl = new CartCtrl();

//     // lấy mã giỏ hàng của người dùng bằng id
//     $cartID = $cartCtrl->getCartByUserID($_SESSION["user"]["UserID"]);

//     // kiểm tra chọn sản phẩm
//     if (!isset($_POST["selected"])) {
//         echo '<script>
//                     alert("Vui lòng chọn ít nhất 1 sản phẩm!");
//                     window.location.href="?page=cart";
//                 </script>';
//         exit();
//     }

//     // kiểm tra thông tin giao hàng
//     $infoUser = checkUser();

//     include_once __DIR__ . "/../controller/ProductCtrl.php";

//     $productCtrl = new ProductCtrl();

//     // kiểm tra số lượng tồn trong kho
//     checkStockValidation($_POST["selected"], $_POST["quantity"], $productCtrl);

//     $data = [
//         "userid" => $_SESSION["user"]["UserID"],
//         "orderdate" => date("Y-m-d H:i:s"),
//         "total" => (float) str_replace(['.', ',', ' VNĐ', 'VNĐ'], '', $_POST["totalPrice"]),
//         "status" => "pending",
//         "shippingaddress" => $infoUser["Address"]
//     ];

//     include_once __DIR__ . "/../controller/OrderCtrl.php";

//     $orderCtrl = new OrderCtrl();
//     $orderID = $orderCtrl->createNewOrder($data);

//     if (!$orderID) {
//         echo 'Lỗi tạo mới đơn đặt hàng!';
//     } else {
//         include_once __DIR__ . "/../controller/OrderDetailCtrl.php";

//         $orderdetailCtrl = new OrderDetailCtrl();

//         foreach ($_POST["selected"] as $productID => $value) {

//             $data = [
//                 "orderid"   => $orderID,
//                 "productid" => $productID,
//                 "quantity"  => $_POST["quantity"][$productID],
//                 "unitprice" => $_POST["price"][$productID],
//                 "discount"  => 0 // hoặc lấy từ form nếu có
//             ];

//             $productCtrl->updateStockProductByID($productID,  $_POST["quantity"][$productID]);

//             $orderdetailCtrl->createOrderDetail($data);

//             $cartCtrl->deleteItemInCart($cartID["CartID"], $productID);
//         }

//         // kiểm tra số sản phẩm trong giỏ hàng
//         $count = $cartCtrl->countItem($cartID["CartID"]);

//         if ($count["count"] > 0) {
//             echo '<script>
//                     alert("Đặt hàng thành công!");
//                     window.location.href="?page=cart";
//                 </script>';
//             exit();
//         } else {
//             $cartCtrl->deleteCart($cartID["CartID"]);
//             echo '<script>
//                     alert("Đặt hàng thành công!");
//                     window.location.href="?page=home";
//                 </script>';
//             exit();
//         }
//     }
// }