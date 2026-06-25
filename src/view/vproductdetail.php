<?php
$product = getProductDetail($_GET["id"]);
$product = $product["product"];

if (!$product) {
    die("Không tìm thấy sản phẩm");
}
?>

<div class="product-detail">
    <div class="product-image">
        <img src="<?php echo '/img/product_img/' . $product["Image"]; ?>" alt="<?php echo $product["ProductName"]; ?>">
    </div>

    <div class="product-info">
        <h2><?php echo $product["ProductName"]; ?></h2>

        <hr>

        <p class="price">
            <?php echo number_format($product["Discount"]); ?> VNĐ
        </p>

        <p>
            Giá gốc:
            <del><?php echo number_format($product["Price"]); ?> VNĐ</del>
        </p>

        <p>Danh mục: <?php echo $product["CategoryName"]; ?></p>

        <hr>

        <p>Cửa hàng: <?php echo $product["ShopName"]; ?></p>

        <p>
            <img src="<?php echo '/img/logo_img/' . (!empty($product["Logo"]) ? $product["Logo"] : 'default.jpg'); ?>"
                alt="<?php echo $product["ShopName"]; ?>" style="width:80px;height:auto;">
        </p>

        <hr>

        <div class="description">
            Mô tả sản phẩm:
            <?php echo nl2br($product["ProductDescription"]); ?>
        </div>

        <hr>

        <form action="?page=addcart&id=<?php echo $product['ProductID']; ?>" method="POST">

            <div class="quantity">
                <label for="quantity">Số lượng:</label>

                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['Stock']; ?>">
            </div>

            <div class="actions">
                <a href="?page=home" class="btn">
                    Quay lại
                </a>

                <button type="submit" class="btn btn-primary">
                    Thêm vào giỏ hàng
                </button>
            </div>

        </form>

    </div>
</div>