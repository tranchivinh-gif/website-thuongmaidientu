<?php
$productid = $_GET["id"];
$product = getProductForEdit($productid);
?>
<div style="display:flex; gap:30px">
    <form action="?page=edit-product&id=<?= $productid ?>" method="POST" enctype="multipart/form-data"
        onsubmit="return validatePrice()">
        <table>
            <tr>
                <td>Loại sản phẩm</td>
                <td>
                    <select name="txtcategoryid" required>
                        <?php rederCategoryProduct($product["CategoryID"]) ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Tên sản phẩm</td>
                <td>
                    <input type="text" name="txtproductname" value="<?= $product["ProductName"] ?? '' ?>" required>
                </td>
            </tr>
            <tr>
                <td>Giá</td>
                <td>
                    <input type="number" name="txtprice" value="<?= $product["Price"] ?? '' ?>" required>
                </td>
            </tr>
            <tr>
                <td>Giá bán</td>
                <td>
                    <input type="number" name="txtdiscount" value="<?= $product["Discount"] ?? '' ?>" required>
                </td>
            </tr>
            <tr>
                <td>Mô tả</td>
                <td>
                    <textarea name="txtdescription"><?= $product["Description"] ?? '' ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Hình ảnh</td>
                <td>
                    <input type="file" name="txtimage">
                </td>
            </tr>
            <tr>
                <td>Số lượng tồn</td>
                <td>
                    <input type="number" name="txtstock" value="<?= $product["Stock"] ?? '' ?>" required>
                </td>
            </tr>
            <tr>
                <td>Trạng thái</td>
                <td>
                    <input type="radio" name="txtstatus" value="1"
                        <?= (($product["Status"] ?? 1) == 1) ? 'checked' : '' ?>>Hoạt động
                    <input type="radio" name="txtstatus" value="0"
                        <?= (($product["Status"] ?? 1) == 0) ? 'checked' : '' ?>>Ngừng bán
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="btnupdate">
                        Sửa
                    </button>
                    <button type="reset">Nhập lại</button>
                </td>
            </tr>
        </table>
    </form>
    <img style="width:180px;height:180px;object-fit:cover" src="<?= getProductImage($product["Image"] ?? '') ?>" alt="">
</div>