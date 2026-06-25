<?php

include_once __DIR__ . "/../controller/CartCtrl.php";
include_once __DIR__ . "/../controller/ProductCtrl.php";
include_once __DIR__ . "/../controller/OrderCtrl.php";
include_once __DIR__ . "/../controller/OrderDetailCtrl.php";
include_once __DIR__ . "/../controller/PaymentCtrl.php";

// hàm tạo hóa đơn và chi tiết hóa đơn
function handleOrder()
{
    $cartCtrl = new CartCtrl();
    $productCtrl = new ProductCtrl();
    $orderCtrl = new OrderCtrl();
    $orderdetailCtrl = new OrderDetailCtrl();
    $paymentCtrl = new PaymentCtrl();

    // lấy mã giỏ hàng của người dùng bằng id
    $cartID = $cartCtrl->getCartByUserID($_SESSION["user"]["UserID"]);

    // kiểm tra chọn sản phẩm chưa
    checkSelectedProduct();

    // kiểm tra thông tin giao hàng
    $infoUser = checkUser();

    // kiểm tra số lượng tồn trong kho
    checkStockValidation($_POST["selected"], $_POST["quantity"], $productCtrl);

    // tạo mới đơn hàng
    $orderID = createNewOrder($infoUser, $orderCtrl);

    // tạo thanh toán
    createNewPayment($orderID, $paymentCtrl);

    // tạo mới các chi tiết hóa đơn
    createNewOrderDetail($orderID, $cartCtrl, $cartID, $productCtrl, $orderdetailCtrl);

    // tính số sản phẩm còn trong giỏ hàng
    $count = $cartCtrl->countItem($cartID["CartID"]);

    // điều hướng sau khi hoàn tất
    ridect($count, $cartID, $cartCtrl);
}

// kiểm tra chọn sản phẩm
function checkSelectedProduct()
{
    if (!isset($_POST["selected"])) {
        echo '<script>
                    alert("Vui lòng chọn ít nhất 1 sản phẩm!");
                    window.location.href="?page=cart";
                </script>';
        exit();
    }
}

// hàm tạo mới đơn hàng
function createNewOrder($infoUser, $orderCtrl)
{
    $data = [
        "userid" => $_SESSION["user"]["UserID"],
        "orderdate" => date("Y-m-d H:i:s"),
        "total" => (float) str_replace(['.', ',', ' VNĐ', 'VNĐ'], '', $_POST["totalPrice"]),
        "status" => "pending",
        "shippingaddress" => $infoUser["Address"],
        "note" => $_POST["txtnote"]
    ];

    // tạo mới đơn hàng
    $orderID = $orderCtrl->createNewOrder($data);

    if (!$orderID) {
        echo 'Lỗi tạo mới đơn đặt hàng!';
        return false;
    }

    return $orderID;
}

// hàm tạo thanh toán
function createNewPayment($orderID, $paymentCtrl)
{
    $data = [
        "orderid" => $orderID,
        "paymentmethod" => $_POST["paymentMethod"],
        "amount" => (float) str_replace(
            ['.', ',', ' VNĐ', 'VNĐ', ' '],
            '',
            $_POST["totalPrice"]
        ),
        "paymentdate" => date("Y-m-d H:i:s"),
        "status" => "Processing"
    ];
    $result = $paymentCtrl->createNewPayment($data);

    if (!$result) {
        echo '<script>
                    alert("tạo thanh toán thất bại!");
                </script>';
        exit();
    }
}

// hàm tạo chi tiết đơn hàng
function createNewOrderDetail($orderID, $cartCtrl, $cartID, $productCtrl, $orderdetailCtrl)
{
    foreach ($_POST["selected"] as $productID => $value) {

        // đóng gói dữ liệu theo từng sản phẩm đc tick chọn
        $data = [
            "orderid"   => $orderID,
            "productid" => $productID,
            "quantity"  => $_POST["quantity"][$productID],
            "unitprice" => $_POST["price"][$productID],
            "discount"  => 0 // hoặc lấy từ form nếu có
        ];

        // xử lý theo từng sản phẩm
        processOrder($productCtrl, $orderdetailCtrl, $cartCtrl, $cartID, $data);
    }
}

// hàm xử lý đơn hàng
function processOrder($productCtrl, $orderdetailCtrl, $cartCtrl, $cartID, $data)
{
    $productID = $data["productid"];

    // tạo chi tiết đơn hàng
    $orderdetailCtrl->createOrderDetail($data);

    // cập nhật tồn kho
    $productCtrl->updateStockProductByID($productID,  $_POST["quantity"][$productID]);

    // xóa sản phẩm đó khỏi giỏ hàng
    $cartCtrl->deleteItemInCart($cartID["CartID"], $productID);
}

// hàm chuyển hướng sau khi hoàn tất đặt hàng
function ridect($count, $cartID, $cartCtrl)
{
    // nếu còn sản phẩm trong giỏ hàng
    if ($count["count"] > 0) {
        echo '<script>
                    alert("Đặt hàng thành công!");
                    window.location.href="?page=cart";
                </script>';
        exit();
    } else {
        // nếu hết sản phẩm -> xóa giỏ hàng
        $cartCtrl->deleteCart($cartID["CartID"]);
        echo '<script>
                    alert("Đặt hàng thành công!");
                    window.location.href="?page=home";
                </script>';
        exit();
    }
}

// hàm render các hóa đơn của khách hàng
function renderOrdersByUser($userid)
{

    $orderCtrl = new OrderCtrl();
    $response = $orderCtrl->getAllOrderByUserID($userid);

    // kiểm tra có dữ liệu không
    if (!$response["success"]) {
        echo "<tr><td colspan='5'>" . $response["message"] . "</td></tr>";
        return;
    }

    $orders = $response["orderlist"];

    foreach ($orders as $order) {
        echo "<tr>";
        echo "<td>" . $order["OrderID"] . "</td>";
        echo "<td>" . $order["OrderDate"] . "</td>";
        echo "<td>" . $order["ShippingAddress"] . "</td>";
        echo "<td>" . number_format($order["Total"]) . " VNĐ</td>";
        echo "<td>" . formatOrderStatus($order["Status"]) . "</td>";
        echo "<td>
                <a href='?page=order-detail&orderid=" . $order["OrderID"] . "'>Chi tiết</a>
              </td>";
        echo "</tr>";
    }
}

// hàm xử lý trạng thái đơn hàng
function formatOrderStatus($status)
{
    switch ($status) {
        case "pending":
            return "Đang xử lý";
        case "shipping":
            return "Đang giao hàng";
        case "completed":
            return "Hoàn thành";
        case "cancelled":
            return "Đã hủy";
        default:
            return $status;
    }
}

// hàm rendeer chi tiết đơn hàng của 1 đơn hàng
function renderOrderDetail($orderid)
{
    $orderDetailCtrl = new OrderDetailCtrl();

    $response = $orderDetailCtrl->getAllOrderDetailByOrderID($orderid);

    if (!$response["success"]) {
        echo "<tr><td colspan='2'>" . $response["message"] . "</td></tr>";
        return;
    }

    $details = $response["orderdetaillist"];

    foreach ($details as $item) {
        echo "<tr>";
        echo "<td>" . $item["ProductName"] . "</td>";
        echo "<td>" . $item["Quantity"] . "</td>";
        echo "<td>" . $item["Status"] . "</td>";
        echo "</tr>";
    }
}

// hàm render đơn hàng cho shop để quản lý
function renderOrderList($shopid)
{
    $orderCtrl = new OrderCtrl();
    $result = $orderCtrl->getAllOrderByShopID($shopid);

    if (!$result["success"]) {
        echo "
            <tr>
                <td colspan='6'>" . $result["message"] . "</td>
            </tr>
        ";
        return;
    }

    foreach ($result["orderlist"] as $order) {
        echo "
        <tr>
            <td>{$order["OrderID"]}</td>
            <td>{$order["OrderDate"]}</td>
            <td>{$order["UserID"]}</td>
            <td>" . number_format($order["Total"]) . " VNĐ</td>
            <td>{$order["Status"]}</td>
            <td>
                <a href='?page=orderdetail-manager&&orderid={$order["OrderID"]}'>
                    Xem chi tiết
                </a>
            </td>
        </tr>
        ";
    }
}

// render chi tiết đơn hàng của shop để quản lý
function renderOrderDetailList($orderid, $shopid)
{
    $orderCtrl = new OrderCtrl();
    $result = $orderCtrl->getOrderDetailByOrderID($orderid, $shopid);

    if (!$result["success"]) {
        echo "
            <tr>
                <td colspan='3'>" . $result["message"] . "</td>
            </tr>
        ";
        return;
    }

    foreach ($result["orderdetail"] as $item) {
        echo "
        <tr>
            <td>{$item["ProductName"]}</td>
            <td>{$item["ShippingAddress"]}</td>
            <td>{$item["Status"]}</td>
        </tr>
        ";
    }
}
