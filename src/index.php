<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <style>
        .container {
            width: 1200px;
            margin: auto;
            border: 1px solid black;
        }

        .header {
            display: flex;
            border-bottom: 1px solid black;
        }

        .nav {
            width: 60%;
        }

        .nav ul {
            display: flex;
            gap: 20px;
            list-style: none;
        }

        .nav a {
            text-decoration: none;
        }

        .search {
            width: 40%;
            align-self: center;
            justify-items: end;
            margin-right: 20px;
        }

        .section {
            display: flex;
        }

        .left {
            width: 30%;
            border-right: 1px solid black;
        }

        .right {
            width: 70%;
        }

        .footer {
            text-align: center;
            border-top: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="nav">
                <ul>
                    <li><a href="?login">Đăng nhập</a></li>
                    <li><a href="?logout">Đăng xuất</a></li>
                </ul>
            </div>
            <div class="search">
                <form action="" method="GET">
                    <input type="search" name="txtsearch">
                    <button name="btnsearch">Tìm kiếm</button>
                </form>
            </div>
        </div>
        <div class="section">
            <div class="left"></div>
            <div class="right">
                <?php
                if (isset($_REQUEST["login"])) {
                    include_once __DIR__ . "/view/vlogin.php";
                }

                if (isset($_REQUEST["employee"])) {
                    include_once __DIR__ . "/view/vemployee.php";
                }

                if (isset($_REQUEST["admin"])) {
                    include_once __DIR__ . "/view/vadmin.php";
                }

                if (isset($_REQUEST["home"])) {
                    include_once __DIR__ . "/view/vmember.php";
                }

                if (isset($_REQUEST["vchangepassword"])) {
                    include_once __DIR__ . "/view/vchangepassword.php";
                }
                ?>
            </div>
        </div>
        <div class="footer">TRẦN CHÍ VĨNH</div>
    </div>
</body>

</html>