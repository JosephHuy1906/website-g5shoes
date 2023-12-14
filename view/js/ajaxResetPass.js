
// Ajax kiểm tra 
$("#resetpass").validate({
    rules: {

        code: {
            required: true,
        },
        email: {
            required: true,
            email: true,
            remote: "../controller/UserController.php?act=check_mail_login"
        }
    },
    messages: {
        code: "Bạn chưa nhập mã code",
       
        email: {
            required: "Bạn chưa nhập email",
            email: "Email chưa đúng định dạng",
            remote: "Email của bạn chưa đăng ký"
        }
    },
    submitHandler: function(form) {
        $.ajax({
            type: "POST",
            url: '../controller/UserController.php?act=check_code_user',
            data: $(form).serializeArray(),
            success: function(response) {
                response = JSON.parse(response);
                if(response.status == 0){
                    alert(response.message);
                }else{
                    window.location="../view/UpdatePasswordNew.php";
                }
            }
        });
    event.preventDefault();
    }
});
// Ajax cập nhập password
$("#resetpassnew").validate({
    rules: {

        password: 'required',
        repassword: {
            required: true,
            equalTo: "#password"
        },
        
    },
    messages: {
        password: "Bạn chưa nhập password",
        repassword: {
            required: "Bạn chưa nhập lại password",
            equalTo: "Password nhập lại không đúng"
        },
    },
    submitHandler: function(form) {
        $.ajax({
            type: "POST",
            url: '../controller/UserController.php?act=update_password',
            data: $(form).serializeArray(),
            success: function(response) {
                response = JSON.parse(response);
                if(response.status == 0){
                    alert(response.message);
                }else{
                    window.location="../view/UpdatePasswordNew.php";
                }
            }
        });
    event.preventDefault();
    }
});
