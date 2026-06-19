<form method="POST" action="?page=cart">
    <table class="product-manager">
        <tr>
            <td>Chọn</td>
            <td>Tên sản phẩm</td>
            <td>Ảnh</td>
            <td>Số lượng</td>
            <td>Đơn giá</td>
        </tr>
        <?php renderProductInCart(); ?>
    </table>
</form>