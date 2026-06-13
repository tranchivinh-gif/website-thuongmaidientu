<form action="?page=add-product" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Loại sản phẩm</td>
            <td><select name="txtcategoryid" required>
                    <?php
                    rederCategoryProduct();
                    ?>
                </select></td>
        </tr>
        <tr>
            <td>Tên sản phẩm</td>
            <td><input type="text" name="txtproductname" required></td>
        </tr>
        <tr>
            <td>Giá</td>
            <td><input type="number" name="txtprice" required></td>
        </tr>
        <tr>
            <td>Giá bán</td>
            <td><input type="number" name="txtdiscount"></td>
        </tr>
        <tr>
            <td>Mô tả</td>
            <td><textarea name="txtdescription"></textarea></td>
        </tr>
        <tr>
            <td>Hình ảnh</td>
            <td><input type="file" name="txtimage"></td>
        </tr>
        <tr>
            <td>Số lượng tồn</td>
            <td><input type="number" name="txtstock" required></td>
        </tr>
        <tr>
            <td>Trạng thái</td>
            <td>
                <input type="radio" name="txtstatus" value="1" checked> Hoạt động
                <input type="radio" name="txtstatus" value="0"> Ngừng bán
            </td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="btnadd">Thêm</button> <button type="reset">Nhập lại</button></td>
        </tr>
    </table>
</form>