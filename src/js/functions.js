// hàm kiểm tra tên 
function validateFullName() {
    var hoten = document.getElementsByName("txtfullname")[0].value;
    var bieuthuc = /^[A-Za-zÀ-ỹ]+(\s[A-Za-zÀ-ỹ]+)+$/;

    if (!bieuthuc.test(hoten)) {
        alert("Tên chỉ chứa kí tự chữ cái và ít nhất 2 từ!");
        return false;
    }
    return true;
}

// hàm kiểm tra email
function validateEmail() {
    var email = document.getElementsByName("txtemail")[0].value;
    var bieuthuc = /^[A-Za-z\d]{2,}\w*@gmail\.com$/;

    if (!bieuthuc.test(email)) {
        alert("Email phải dài hơn 3 kí tự!");
        return false;
    }
    return true;
}

 // hàm so sánh password và repassword
function comparePassword()
    {
        if (document.getElementsByName("txtpassword")[0].value != document.getElementsByName("txtrepassword")[0].value) {
            alert("Mật khẩu không khớp!");
            return false;
        } else {
             return true;
        }
    }

// hàm thực thi kiểm tra form đăng ký
function validateSignupForm(){
    if(  validateFullName() && validateEmail() && comparePassword()){
        return true;
    }
    else{
        return false;
    }
}

// hàm kiểm tra giữa giá gốc và giá giảm khi nhập
function validatePrice() {
    let price = Number(document.getElementsByName("txtprice")[0].value);
    let discount = Number(document.getElementsByName("txtdiscount")[0].value);

    if (discount > 0 && discount >= price) {
        alert("Giá bán phải nhỏ hơn giá");
        return false;
    }

    return true;
}

// hàm kiểm tra số điện thoại
function kiemtrasdt() {
    var sdt = document.getElementById("tel").value;
    var bieuthuc = /^(03|05|07|08|09)\d{8}$/;

    if (bieuthuc.test(sdt)) {
        document.getElementById("err2").innerHTML = "";
        return true;
    }

    document.getElementById("err2").innerHTML = "Số điện thoại không hợp lệ!";
    return false;
}

// hàm chọn tất cả sản phẩm trong giỏ hàng
function toggleCheckAll(checkAll) {
    const items = document.querySelectorAll(".item-check");

    items.forEach(cb => {
        cb.checked = checkAll.checked;
    });

    tinhTongTien();
}

// kiểm tra số lượng sản phẩm hợp lệ trong giỏ hàng 
function kiemTraSoLuong(input) {
    var value = input.value;
    var productId = input.id.replace("quantity_", "");
    var err = document.getElementById("err_" + productId);

    var bieuthuc = /^[1-9]\d*$/;

    if (bieuthuc.test(value)) {
        err.innerHTML = "";
        return true;
    }

    err.innerHTML = "Số lượng không hợp lệ!";
    return false;
}

// hàm tính tổng tiền khi checkbox trong giỏ hàng
function tinhTongTien() {
    let checkboxes = document.querySelectorAll(".item-check");
    let total = 0;

    checkboxes.forEach(cb => {
        if (cb.checked) {
            let id = cb.dataset.id;

            let qtyInput = document.getElementById("quantity_" + id);
            let priceInput = document.getElementById("price_" + id);

            if (!qtyInput || !priceInput) return;

            let qty = parseInt(qtyInput.value);
            let price = parseFloat(priceInput.dataset.price);

            if (!isNaN(qty) && qty > 0) {
                total += qty * price;
            }
        }
    });

    document.getElementById("total_price").value =
        total.toLocaleString("vi-VN") + " VNĐ";
}