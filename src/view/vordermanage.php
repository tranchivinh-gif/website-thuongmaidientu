<form method="GET" action="">

    <table class="product-manager">
        <tr>
            <td>Mã đơn</td>
            <td>Ngày đặt</td>
            <td>Khách hàng</td>
            <td>Tổng tiền</td>
            <td>Thao tác</td>
        </tr>

        <?php
        renderOrderList($_SESSION["shopid"]);
        ?>
    </table>
</form>