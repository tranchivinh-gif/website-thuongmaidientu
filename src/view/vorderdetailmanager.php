<table class="product-manager">
    <tr>
        <td>Sản phẩm</td>
        <td>Địa chỉ giao hàng</td>
        <td>Trạng thái thanh toán</td>
        <td>Trạng thái</td>
    </tr>

    <?php
    renderOrderDetailList($_GET["orderid"], $_SESSION["shopid"]);
    ?>
</table>