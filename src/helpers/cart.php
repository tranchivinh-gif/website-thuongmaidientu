<?php

include_once __DIR__ . "/../controller/CartCtrl.php";

// hàm render sản phẩm trong giỏ hàng
function renderProductInCart()
{
    // lấy chi tiết giỏ hàng
    $products = getCartDetail($_SESSION["user"]["UserID"]);

    while ($product = $products->fetch_assoc()) {

        echo "<tr>";

        // checkbox chọn sản phẩm
        echo '<td>
                <input type="checkbox"
                    class="item-check"
                    data-id="' . $product["ProductID"] . '"
                    name="selected[' . $product["ProductID"] . ']"
                    value="1"
                    onchange="tinhTongTien()">
            </td>';

        // tên sp
        echo '<td>
                <a href="?page=product-detail&id=' . $product["ProductID"] . '">
                    ' . $product["ProductName"] . '
                </a>
              </td>';

        // ảnh sp
        echo '<td>
                <a href="?page=product-detail&id=' . $product["ProductID"] . '">
                    <img src="/img/product_img/' . $product["Image"] . '" width="60">
                </a>
            </td>';

        // ảnh shop
        echo '<td>
                <a href="?page=product-detail&shopid=' . $product["ShopID"] . '">
                    <img src="/img/product_img/' . $product["Image"] . '" width="60">
                </a>
            </td>';

        // số lượng sản phẩm 
        echo '<td>
                <input type="number"
                id="quantity_' . $product["ProductID"] . '"
                name="quantity[' . $product["ProductID"] . ']"
                value="' . $product["Quantity"] . '"
                min="1"
                onchange="kiemTraSoLuong(this); tinhTongTien();">
                <div id="err_' . $product["ProductID"] . '" style="color:red;"></div>
            </td>';

        // giá sản phẩm 
        echo '<td>
                <input type="text"
                    value="' . number_format($product["Price"]) . ' VNĐ"
                    readonly
                    id="price_' . $product["ProductID"] . '"
                    data-price="' . $product["Price"] . '"
                    name="price[' . $product["ProductID"] . ']">
            </td>';
        echo "</tr>";
    }

    // dòng tổng
    echo '<tr style="color:red; font-weight:bold;">';

    echo '<td>
            <input type="checkbox"
                    id="checkAll"
                    onchange="toggleCheckAll(this)">
          </td>';

    echo '<td colspan="3">Tổng Cộng:</td>';

    // tổng tiền (readonly)
    echo '<td colspan="2">  
            <input type="text"
                   value="' . number_format(0) . ' VNĐ"
                   readonly id="total_price"
                   name = "totalPrice">
          </td>';

    echo '</tr>';

    echo '<tr>
            <td colspan="4">
                <textarea name="txtnote" cols="30" rows="4" placeholder="Nhập ghi chú đơn hàng"></textarea>
            </td>

            <td colspan="2">
                
                <input type="radio" name="paymentMethod" id="cash" value="cash" checked>
                <label for="cash">Thanh toán khi nhận hàng</label>


                <input type="radio" name="paymentMethod" id="bank" value="bank">
                <label for="bank">Chuyển khoản</label>
                
            </td>
          </tr>';

    echo '<tr>
            <td colspan="5">
                <button type="submit" name="btnorder" class="btn btn-primary">
                    Đặt hàng
                </button>

                <button type="submit" name="btndelete" class="btn btn-danger">
                    Xóa
                </button>
            </td>
          </tr>';
}

// hàm so sánh số lượng tồn trong kho và số lượng mua hàng
function checkStockValidation($selected, $quantity, $productCtrl)
{
    $errors = [];

    foreach ($selected as $productID => $value) {

        // láy hàng tồn với id sản phẩm đó
        $stock = $productCtrl->getStockProductByID($productID);

        // lấy số lượng chọn, tên, tồn kho
        $qty =  (int)$quantity[$productID];
        $productName = $stock["ProductName"];
        $currentStock = $stock["Stock"];

        if ($qty > $currentStock) {
            $errors[] = "sản phẩm \"$productName\" chỉ còn $currentStock";
        }
    }

    // hiện thị các sản phẩm quá tồn kho
    if (!empty($errors)) {
        $msg = implode("\n", $errors);

        echo "<script>
                alert(" . json_encode($msg) . ");
                history.back();
              </script>";
        exit;
    }
    return true;
}

// hàm xử lý nút xóa sản phẩm trong giỏ hàng
function handleBtnDeleteInCart()
{
    $cartCtrl = new CartCtrl();

    // lấy mã giỏ hàng của người dùng bằng id
    $cartID = $cartCtrl->getCartByUserID($_SESSION["user"]["UserID"]);

    // kiểm tra chọn sản phẩm chưa
    if (isset($_POST["selected"])) {

        $selected = $_POST['selected'];

        // xóa từng cái đã chọn
        foreach ($selected as $productId => $value) {
            $cartCtrl->deleteItemInCart($cartID["CartID"], $productId);
        }

        // kiểm tra số sản phẩm trong giỏ hàng
        $count = $cartCtrl->countItem($cartID["CartID"]);

        if ($count["count"] > 0) {
            echo '<script>
                    alert("Xóa thành công!");
                    window.location.href="?page=cart";
                </script>';
            exit();
        } else {
            $cartCtrl->deleteCart($cartID["CartID"]);
            echo '<script>
                    alert("Giỏ hàng trống! Mua sắm ngay!!");
                    window.location.href="?page=home";
                </script>';
            exit();
        }
    } else {
        echo '<script>
                    alert("Vui lòng chọn ít nhất 1 sản phẩm!");
                    window.location.href="?page=cart";
                </script>';
        exit();
    }
}

// hàm xử lý xử kiện ở trang giỏ hàng
function handleEventInCartPage()
{
    // xử lý nút xóa sản phẩm trong giỏ hàng
    if (isset($_POST["btndelete"])) {
        handleBtnDeleteInCart();
    }

    // xử lý nút đặt hàng trong giỏ hàng
    if (isset($_POST["btnorder"])) {
        handleOrder();
    }
}

// hàm tính tổng tiền trong giỏ hàng
function totalPrice($price, $quanlity)
{
    return $price * $quanlity;
}

// hàm lấy thông tin chi tiết sản phẩm trong giỏ hàng của người dùng
function getCartDetail($userid)
{

    $cartCtrl = new CartCtrl();

    // lấy giỏ hàng của người dùng bằng id
    $resultOfGetCartIDByUserID = $cartCtrl->getCartByUserID($userid);

    // kiểm tra có giỏ hàng chưa
    if ($resultOfGetCartIDByUserID == null) {
        echo '<script>
                    alert("chưa có sản phẩm trong giỏ!");
                    window.location.href="?page=home";
                </script>';
        exit();
    } else {
        // lấy tất cả sản phẩm
        $resultOfGetAllProductInCart = $cartCtrl->getAllCartItem($resultOfGetCartIDByUserID["CartID"]);
        return $resultOfGetAllProductInCart;
    }
}

// hàm xử lý thao tác khi bấm nút thêm vào giỏ hàng
function handleCart($userid, $productid)
{
    // kiểm tra đăng nhập chưa
    if (!isset($_SESSION["user"])) {
        echo '<script>
                alert("Bạn phải đăng nhập trước khi mua hàng!");
                window.location.href="?page=login";
            </script>';
        exit();
    }

    // xử lý khi thêm 1 sản phẩm vào giỏ hàng
    if (isset($_GET["id"])) {

        $cartCtrl = new CartCtrl();

        // lấy giỏ hàng hoặc tạo giỏ hàng nếu chưa có
        $resultofGetOrCreate = $cartCtrl->getOrCreateCart($userid);

        // lấy sản phẩm đó trong giỏ hàng nếu có
        $resultofgetCartItem = $cartCtrl->getCartItem($resultofGetOrCreate["CartID"], $productid);

        // nếu không có sản phẩm trong giỏ hàng thì thêm mới 
        if ($resultofgetCartItem == null) {

            // lấy thông tin chi tiết sản phẩm đó
            $product = getProductDetail($_GET["id"]);
            $product = $product["product"];

            $data = [
                "CartID"    => $resultofGetOrCreate["CartID"],
                "ProductID" => $product["ProductID"],
                "Quantity"  => $_POST["quantity"],
                "Price"     => $product["Discount"]
            ];

            // thêm sản phẩm đó vào giỏ hàng
            $resultofAddtoCart = $cartCtrl->addItemToCart($data);

            // kiểm tra kết quả thêm
            if ($resultofAddtoCart) {
                echo '<script>
                        alert("Thêm vào giỏ hàng thành công!");
                        window.location.href="?page=cart";
                    </script>';
                exit();
            }
        } else {
            // ngược lại cập nhật số lượng của sản phẩm đó trong giỏ hàng
            $resultOfupdateCartItem = $cartCtrl->updateCartItem(
                $resultofgetCartItem["CartID"],
                $resultofgetCartItem["ProductID"],
                $_POST["quantity"]
            );

            // thành công thì thông báo
            if ($resultOfupdateCartItem) {
                echo '<script>
                        alert("Thêm vào giỏ hàng thành công!");
                        window.location.href="?page=cart";
                    </script>';
                exit();
            }
        }
    }
}
