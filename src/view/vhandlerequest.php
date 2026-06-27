<?php
if (!isset($_POST["orderid"]) && !isset($_POST["productid"])) {
    echo '<script>
            window.location.href="?page=order-manager";
        </script>';
    return;
}
$orderid = $_POST["orderid"];
$productid = $_POST["productid"];



?>

<table class="product-manager">
    <tr>
        <td>Mã yêu cầu</td>
        <td>Tên khách hàng</td>
        <td>Số điện thoại</td>
        <td>Loại yêu cầu</td>
        <td>Nội dung phản hồi</td>
        <td>Ảnh đính kèm</td>
        <td>Hành động</td>
    </tr>
    <?php
    renderCustomerRequestByOrderID($orderid, $productid);
    ?>
</table>