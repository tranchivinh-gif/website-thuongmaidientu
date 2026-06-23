<?php
session_start();
require_once __DIR__ . "/helpers/router.php";
require_once __DIR__ . "/helpers/order.php";
require_once __DIR__ . "/helpers/profile.php";
require_once __DIR__ . "/helpers/product.php";
require_once __DIR__ . "/helpers/cart.php";
require_once __DIR__ . "/helpers/auth.php";
require_once __DIR__ . "/helpers/functions.php";
include_once __DIR__ . "/view/vhome.php";
