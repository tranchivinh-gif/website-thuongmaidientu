<form method="POST" action="?page=order-detail">
    <table class="product-manager">
        <tr>
            <td>sản phẩm</td>
            <td>số lượng</td>
        </tr>
        <tr>
            <?php renderOrderDetail($_GET["orderid"]); ?>
        </tr>
    </table>
</form>