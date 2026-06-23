<?php

include_once __DIR__ . "/../controller/UserCtrl.php";

// hàm kiểm tra thông tin cần thiết để giao hàng
function checkUser()
{
    $userCtrl = new UserCtrl();

    // lấy thông tin khách hàng
    $infoUser = $userCtrl->getInfoCustomer($_SESSION["user"]["UserID"]);

    // kiểm tra phone và address
    if (
        empty(trim((string)$infoUser["Phone"])) ||
        empty(trim((string)$infoUser["Address"]))
    ) {
        echo '<script>
                alert("Bạn cần cập nhật số điện thoại và địa chỉ giao hàng!");
                window.location.href="?page=profile";
            </script>';
        exit();
    }

    return $infoUser;
}

// hàm xử lý upload ảnh
function handleProfileImage($oldImg)
{
    $img = $oldImg;

    // nếu có chọn ảnh mới
    if ($_FILES["txtimage"]["error"] == 0) {

        // xóa ảnh cũ (nếu có)
        if (!empty($oldImg)) {
            $oldImagePath = "img/profile_img/" . $oldImg;

            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // tạo tên mới: User-id-time()-profile
        $newFileName = $_SESSION["user"]["UserID"] . "_" . time() . ".jpg";

        $newImagePath = "img/profile_img/" . $newFileName;

        if (move_uploaded_file($_FILES["txtimage"]["tmp_name"], $newImagePath)) {
            $img = $newFileName;
        } else {
            echo '<script>
                alert("Upload ảnh thất bại!");
            </script>';
            exit();
        }
    }

    return $img;
}


// hàm xử lý cập nhật profile
function updateProfileHandler()
{
    // kiểm tra bấm nút k
    if (!isset($_POST["btnupdateprofile"])) {
        return;
    }

    $data = [
        "phone" => $_POST["txtphone"],
        "address" => $_POST["txtaddress"],
        "img" => handleProfileImage($_POST["txtimageold"] ?? ""),
        "userid" => $_SESSION["user"]["UserID"]
    ];

    $userCtrl = new UserCtrl();

    $resultOfUpdate = $userCtrl->updateProfile($data);

    if (!$resultOfUpdate) {
        echo '<script>
                alert("Cập nhật thất bại!");
            </script>';
        exit();
    }

    echo '<script>
            alert("Cập nhật thành công!");
            window.location.href="?page=profile";
        </script>';
    exit();
}
