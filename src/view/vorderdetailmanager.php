<form method="GET" action="">

    <table class="product-manager">
        <tr>
            <td>Sản phẩm</td>
            <td>Địa chỉ giao hàng</td>
            <td>Trạng thái</td>
        </tr>

        <?php
        renderOrderDetailList($_GET["orderid"], $_SESSION["shopid"]);
        ?>
    </table>
</form>