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



