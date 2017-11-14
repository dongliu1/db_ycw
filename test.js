/**
 * Created by liudong on 2017/11/9.
 */

$(function () {
    init_testApi();
    //init_testData();
    //init_importSQL();
});

var init_testApi=function () {
    //console.log(requestApi.login({"username":"admin","password":"123456","telephone":"15527744217"}));
    /*requestApi.login({"telephone":"15527744217","password":"123456"}).then(function (data) {
        console.log(data);
        $("#result-info").html(data);
    })*/

    var userinfo={
        "telephone":"15527744229",
        "password":"123456",
        "username":"xujinkai1",
        "payPassword":"123456",
        "qq":"1137293945",
        "userType":"1",
        "email":"1013204440@qq.com",
        "leader":"liudong",
        "nickname":"徐进凯"
    };

    requestApi.getUserInfo({"telephone":"15527744229"}).then(function (data) {
        console.log(data);
        $("#result-info").html(data);
    })
};

var init_testData=function () {
    requestApi.connectDatabase().then(function (data) {
        console.log(data);
        $("#result-info").html(data);
    })
};

var init_importSQL=function () {
    requestApi.importSqlFile().then(function (data) {
        console.log("------------------------------------------",JSON.parse(data));
        $("#result-info").html(data);
    })
};
