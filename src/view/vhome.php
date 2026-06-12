<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="nav">
                <ul>
                    <?php
                    displayMenu();
                    ?>
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
                router();
                ?>
            </div>
        </div>
        <div class="footer">TRẦN CHÍ VĨNH</div>
    </div>
    <script src="/../js/functions.js"></script>
</body>

</html>