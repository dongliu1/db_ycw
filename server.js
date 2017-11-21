var path=(typeof(serverPath)=="undefined"?"server/":serverPath);
var requestApi={
    /***
     * 登录
     * @username:账号
     * @password:密码
     * @telephone:手机号
     ********/
    login:function(params){
        var param={};
        if(params.hasOwnProperty("password")){
            param.password=params.password;
        }else{
            param={isError:"参数错误"}
        }
        if(params.hasOwnProperty("username")){
            param.username=params.username;
        }else if(params.hasOwnProperty("telephone")){
            param.telephone=params.telephone
        }else{
            param={isError:"参数错误"}
        }
        var prm={
            method:"login",
            params:param
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /***
     * 注册
     * @username:账号
     * @password:密码
     * @telephone:手机
     * @payPassword:支付密码
     * @qq:QQ号
     * @email:邮箱
     * @leader:推荐人
     * @userType:用户类型
     * @nickname:昵称
     ********/
    registration:function (params) {
        var prm={
            method:"registration",
            params:params
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     *查询用户是否存在
     * @username:账号
     * @telephone:手机号
     */
    getUser:function (params) {
        var prm={
            method:"getUser",
            params:params
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     *获取用户所有信息
     * @username:账号
     * @telephone:手机号
     */
    getUserInfo:function (params) {
        var prm={
            method:"getUserInfo",
            params:params
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /***
     *修改密码
     * @username:账号
     * @telephone:手机号
     * @password:密码
     * @rePassword:新密码
     ********/
    modifyPassword:function (params) {
        var prm={
            method:"modifyPassword",
            params:params
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 忘记密码
     * @telephone:手机号
     * @password:密码
     */
    modifyPasswordByTelephone:function (params) {
        var prm={
            method:"modifyPasswordByTelephone",
            params:params
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 重置密码（管理员使用）
     * @telephone:手机号
     */
    resetPassword:function (params) {
        var prm={
            method:"resetPassword",
            params:params
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /***
     * 绑定邮箱
     * @telephone:手机号
     * @email:邮箱
     */
    bindEmail:function (params) {
        var prm={
            method:"bindEmail",
            params:params
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /***
     * 连接数据库，检测所需数据库是否存在
     */
    connectDatabase:function () {
        var prm={
            method:"connectDatabase",
            params:""
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /***
     * 导入sql文件
     */
    importSqlFile:function () {
        var prm={
            method:"importSqlFile",
            params:""
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    createTask:function (params) {
        var prm={
            method:"createTask",
            params:params
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    getTaskInfo:function (params) {
        var prm={
            method:"getTaskInfo",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    getUserTaskInfo:function (params) {
        var prm={
            method:"getUserTaskInfo",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    getTaskInfoById:function (params) {
        var prm={
            method:"getTaskInfoById",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    getTaskInfoByKeyword:function (params) {
        var prm={
            method:"getTaskInfoByKeyword",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    deleteTask:function (params) {
        var prm={
            method:"deleteTask",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    uploadImg:function (params) {
        var prm={
            method:"uploadImg",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    readFiles:function(params){
        var prm={
            method:"readFiles",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    clearFiles:function(params){
        var prm={
            method:"clearFiles",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    updateTask:function(params) {
        var prm={
            method:"updateTask",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
};

var requestSyncApi={
    uploadImg:function (params) {
        var rdata="";
        $.ajaxSetup({
            async: false
        });
        requestApi["uploadImg"](params).then(function(data){rdata=data;console.log(data);});
        $.ajaxSetup({
            async: true
        });
        return rdata;
    }
}