//var path=(typeof(serverPath)=="undefined"?"../server/":serverPath);
var path="http://www.yunchuangwang.cn/server/";
var get_token=function(){
    var path="ycw_dbserver/server/";
    var key="mysecretpersonaluniquekey";
    var date=new Date();
    var year=date.getFullYear();
    var month=date.getMonth()+1;
    var day=date.getDate();
    if(day<10)day="0"+day;
    var moment=year+"-"+month+"-"+day;
    return $.md5(path+moment+"/"+key);
};
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
            api_token:get_token(),
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
            api_token:get_token(),
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
            api_token:get_token(),
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
            api_token:get_token(),
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
            api_token:get_token(),
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
            api_token:get_token(),
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
            api_token:get_token(),
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
            api_token:get_token(),
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
            api_token:get_token(),
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
            api_token:get_token(),
            method:"importSqlFile",
            params:""
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 发布任务
     * @param params
     * @returns {*}
     */
    createTask:function (params) {
        var prm={
            api_token:get_token(),
            method:"createTask",
            params:params
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 获取所有任务信息
     * @param params
     * @returns {*}
     */
    getTaskInfo:function (params) {
        var prm={
            api_token:get_token(),
            method:"getTaskInfo",
            params:params?params:{}
        };
        //console.log(get_token());
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /***
     * 获取用户任务信息
     * @param params
     * @returns {*}
     */
    getUserTaskInfo:function (params) {
        var prm={
            api_token:get_token(),
            method:"getUserTaskInfo",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 通过任务id获取任务信息
     * @param params
     * @returns {*}
     */
    getTaskInfoById:function (params) {
        var prm={
            api_token:get_token(),
            method:"getTaskInfoById",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 通过关键词获取任务信息
     * @param params
     * @returns {*}
     */
    getTaskInfoByKeyword:function (params) {
        var prm={
            api_token:get_token(),
            method:"getTaskInfoByKeyword",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 删除任务
     * @param params
     * @returns {*}
     */
    deleteTask:function (params) {
        var prm={
            api_token:get_token(),
            method:"deleteTask",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 上传图片
     * @param params
     * @returns {*}
     */
    uploadImg:function (params) {
        var prm={
            api_token:get_token(),
            method:"uploadImg",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 读取服务器本地文件
     * @param params
     * @returns {*}
     */
    readFiles:function(params){
        var prm={
            api_token:get_token(),
            method:"readFiles",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 清理服务器本地文件
     * @param params
     * @returns {*}
     */
    clearFiles:function(params){
        var prm={
            api_token:get_token(),
            method:"clearFiles",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 修改任务信息
     * @param params
     * @returns {*}
     */
    updateTask:function(params) {
        var prm={
            api_token:get_token(),
            method:"updateTask",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 任务交易
     * transact:recharge(充值),consumer(消费)
     * @param params
     * @returns {*}
     */
    transact:function(params) {
        var prm={
            api_token:get_token(),
            method:"transact",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 获取账户余额
     * @param params
     * @returns {*}
     */
    getAsset:function(params) {
        var prm={
            api_token:get_token(),
            method:"getAsset",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 获取交易记录
     * @param params
     * @returns {*}
     */
    getDealRecord:function(params) {
        var prm={
            api_token:get_token(),
            method:"getDealRecord",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    /**
     * 删除交易记录
     * @param params
     * @returns {*}
     */
    deleteDealRecord:function(params) {
        var prm={
            api_token:get_token(),
            method:"deleteDealRecord",
            params:params?params:{}
        };
        return $.post(path+"server.php",prm,function (data) {},"html");
    },
    sendMessageVerification:function (params) {
        var prm={
            api_token:get_token(),
            method:"sendMessageVerification",
            params:params?params:{}
        }
        return $.post(path+"server.php",prm,function (data) {},"html");
    }
};

var requestSyncApi={
    uploadImg:function (params) {
        var rdata="";
        $.ajaxSetup({
            async: false
        });
        requestApi["uploadImg"](params).then(function(data){rdata=data;});
        $.ajaxSetup({
            async: true
        });
        return rdata;
    },
    registration:function (params) {
        var rdata="";
        $.ajaxSetup({
            async: false
        });
        requestApi["registration"](params).then(function(data){rdata=data;});
        $.ajaxSetup({
            async: true
        });
        return rdata;
    },
}