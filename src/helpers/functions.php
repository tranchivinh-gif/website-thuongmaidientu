<?php

//hàm hiển thị menu
function displayMenu()
{
    echo '<li><a href="?page=home">Trang chủ</a></li>';

    // kiểm tra tình trạng đăng nhập bằng session
    if (!isset($_SESSION["user"])) {
        echo '<li><a href="?page=login">Đăng nhập</a></li>';
        return;
    }

    switch ($_SESSION["user"]["RoleID"]) {
        case 1: // admin
            echo '<li><a href="?page=user-manager">Quản lý người dùng</a></li>';
            break;

        case 2: // nhân viên
            echo '<li><a href="?page=product-manager">Quản lý sản phẩm</a></li>';
            echo '<li><a href="?page=order-manager">Quản lý đơn hàng</a></li>';
            break;

        case 3: // khách hàng
            echo '<li><a href="?page=cart">Giỏ hàng</a></li>';
            echo '<li><a href="?page=myorder">Đơn hàng của tôi</a></li>';
            echo '<li><a href="?page=profile">Hồ sơ</a></li>';
            break;

        case 4: // chủ shop
            echo '<li><a href="?page=employee-manager">Quản lý nhân viên</a></li>';
            echo '<li><a href="?page=product-manager">Quản lý sản phẩm</a></li>';
            echo '<li><a href="?page=order-manager">Quản lý đơn hàng</a></li>';
            break;
    }

    echo '<li><a href="?page=logout">Đăng xuất</a></li>';
}
