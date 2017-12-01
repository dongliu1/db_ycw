var _init_register={
    _registerId:"#register",
    _register:function(_this){

        var isChecked=$("#register-protocol").prop("checked");
        var _html="<span style='color:#f00;'>未选择接受注册许可</span>";
        if(!isChecked)return _init_register._init_promptMessage(_this,_html);

        if(_init_register._init_checkVerifyCode()){
            if(_init_register._check_password()){
                if(_init_register._check_payword()){
                    _init_register._start_register(_this);
                }else{
                    _html="<span style='color:#f00;'>支付密码不一致</span>";
                    return _init_register._init_promptMessage(_this,_html);
                }
            }else{
                _html="<span style='color:#f00;'>密码不一致</span>";
                return _init_register._init_promptMessage(_this,_html);
            }
        }else{
            _html="<span style='color:#f00;'>验证码错误</span>";
            return _init_register._init_promptMessage(_this,_html);
        }
    },
    _start_register:function (_this) {
        var _params={};
        var _html="<span style='color:#f00;'>必填项不能为空</span>";
        var isRegister=true;
        $("input[dbname]",_init_register._registerId).each(function () {
            var _prop=$(this).attr("dbname");
            var _type=$(this).attr("dbType")?$(this).attr("dbType"):"string";
            var _val=$(this).val();
            var _isNeeded=$(this).attr("isNeeded");
            _val=ycw_check._init_checkVal(_type,_val);
            if(_isNeeded && _val==""){
                isRegister=false;
                return _init_register._init_promptMessage(_this,_html);
            }
            _params[_prop]=_val;
        });
        var userType=$(_this).attr("userType");
        _params["userType"]=userType+"";
        console.log(_params,isRegister);
        if(isRegister){
            requestApi.registration(_params).then(function (data) {
                console.log(data);
                if(data=="False"){
                    _html="<span style='color:#f00;'>注册失败</span>";
                    return _init_register._init_promptMessage(_this,_html);
                }else{
                    location.href="../index.html";
                }
            });
        }
    },
    _init_promptMessage:function (_this,_html) {
        $(_this).next("span").remove();
        $(_html).insertAfter($(_this));
        return false;
    },
    _init_checkVerifyCode:function () {
        return true;
    },
    _check_password:function () {
        var password=$("[dbname='password']",_init_register._registerId).val();
        var rePassword=$(".confirm_password",_init_register._registerId).val();
        if(password!==rePassword){
            return false;
        }else{
            return true;
        }
    },
    _check_payword:function () {
        var password=$("[dbname='payPassword']",_init_register._registerId).val();
        var rePassword=$(".confirm_payPassword",_init_register._registerId).val();
        if(password!==rePassword){
            return false;
        }else{
            return true;
        }
    }
}