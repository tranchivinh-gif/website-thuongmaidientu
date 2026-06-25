<form method="POST" action="?page=order-detail">
    <table class="product-manager">
        <tr>
            <td>Sản phẩm</td>
            <td>Số lượng</td>
            <td>Trạng thái</td>
        </tr>
        <tr>
            <?php renderOrderDetail($_GET["orderid"]); ?>
        </tr>
    </table>
</form>