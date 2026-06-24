<?php

// hàm điều hướng
function router()
{
    $page = $_GET['page'] ?? '';

    switch ($page) {
        case 'login':
            handleLogin();
            include_once __DIR__ . "/../view/vlogin.php";
            break;

        case 'logout':
            handleLogout();
            break;

        case 'signup':
            handleSignup();
            include_once __DIR__ . "/../view/vsingup.php";
            break;

        case 'employee':
            verifyRole(2);
            include_once __DIR__ . "/../view/vemployee.php";
            break;

        case 'admin':
            verifyRole(1);
            include_once __DIR__ . "/../view/vadmin.php";
            break;

        case 'member':
            verifyRole(3);
            include_once __DIR__ . "/../view/vmember.php";
            break;

        case 'vchangepassword':
            if (isset($_POST["btnchange"])) {
                handleChangePassword(
                    $_SESSION["user"]["UserID"],
                    $_POST["txtpassword"],
                    $_POST["txtrepassword"]
                );
            }
            include_once __DIR__ . "/../view/vchangepassword.php";
            break;

        case 'ownershop':
            verifyRole(4);
            include_once __DIR__ . "/../view/vownershop.php";
            break;

        case 'product-manager':
            include_once __DIR__ . "/../view/vproductmanager.php";
            break;

        case 'add-product':
            handleAddProduct();
            include_once __DIR__ . "/../view/vaddproduct.php";
            break;

        case 'del-product':
            deleteProduct();
            break;

        case 'edit-product':
            include_once __DIR__ . "/../view/veditproduct.php";

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                handleUpdateProduct($productid, $product["Image"]);
                exit;
            }
            break;

        case 'product-detail':
            include_once __DIR__ . "/../view/vproductdetail.php";
            break;

        case 'cart':
            include_once __DIR__ . "/../view/vcart.php";
            handleEventInCartPage();
            break;

        case 'addcart':
            handleCart($_SESSION["user"]["UserID"], $_GET["id"]);
            break;

        case 'profile':
            updateProfileHandler();
            include_once __DIR__ . "/../controller/UserCtrl.php";
            include_once __DIR__ . "/../view/vprofile.php";
            break;

        case 'myorder':
            include_once __DIR__ . "/../view/vmyorder.php";
            break;

        case 'order-detail':
            include_once __DIR__ . "/../view/vorderdetail.php";
            break;

        default:
            renderProduct();
    }
}
