<form method="POST" action="?page=myorder">
    <table class="product-manager">
        <tr>
            <td>Mã đơn</td>
            <td>Ngày đặt</td>
            <td>Tổng tiền</td>
            <td>Trạng thái</td>
            <td>Hành động</td>
        </tr>
        <tr>
            <?php renderOrdersByUser($_SESSION["user"]["UserID"]); ?>
        </tr>
    </table>
</form>