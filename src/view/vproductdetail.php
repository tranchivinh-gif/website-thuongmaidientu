<?php
$product = getProductDetail($_GET["id"]);
$product = $product["product"];

if (!$product) {
    die("Không tìm thấy sản phẩm");
}
?>
<div class="product-detail">
    <div class="product-image"><img src="<?php echo '/img/' . $product["Image"]; ?>"
            alt="<?php echo $product["ProductName"]; ?>"></div>
    <div class="product-info">
        <h2><?php echo $product["ProductName"]; ?></h2>
        <hr>
        <p class="price"><?php echo number_format($product["Discount"]); ?> VNĐ</p>
        <p>
            Giá gốc:<del><?php echo number_format($product["Price"]); ?> VNĐ</del></p>
        <p>Tồn kho: <?php echo $product["Stock"]; ?></p>
        <p>Danh mục: <?php echo $product["CategoryName"]; ?></p>
        <hr>

        <p>Cửa hàng: <?php echo $product["ShopName"]; ?></p>
        <p><img src="<?php echo '/img/' . $product["Logo"]; ?>" alt="<?php echo $product["ShopName"]; ?>"
                style="width:80px; height:auto;"></p>

        <hr>
        <div class="description">Mô tả sản phẩm<?php echo nl2br($product["ProductDescription"]); ?></div>
        <div class="actions">
            <a href="?page=home" class="btn">Quay lại</a>
            <form action="?page=addcart&id=<?php echo $product['ProductID']; ?>" method="POST">
                <button type="submit" class="btn btn-primary">
                    Thêm vào giỏ hàng
                </button>
            </form>
        </div>
    </div>
</div>