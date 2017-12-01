
var _init_login={
    _loginId:"#loginform",
    _login:function () {
        var username=$("#username",_init_login._loginId).val();
        var password=$("#password",_init_login._loginId).val();
        var verifyCode=$("#verifyCode",_init_login._loginId).val();
        var _html="<span style='color:#f00;'>请填写验证码</span>";

        if(username==""||password==""){
            _html="<span style='color:#f00;'>用户名或密码不能为空</span>";
            $("#rox-error-tips",_init_login._loginId).html(_html);
            return false;
        }

        if(verifyCode==""){
            $("#rox-error-tips",_init_login._loginId).html(_html);
            return false;
        }

        var _params={
            password:password
        };
        if(parseInt(username)){
            _params.telephone=username;
        }else{
            _params.username=username;
        }
        requestApi.login(_params).then(function (data) {
            console.log(data);
            if(data=="False"){
                _html="<span style='color:#f00;'>用户名或密码错误</span>";
                $("#rox-error-tips",_init_login._loginId).html(_html);
            }else if(data=="True"){
                location.href="../index.html";
            }

        });

    }
};


