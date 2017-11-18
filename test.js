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
        "username":"liudong",
        "taskName":"牛肉粒",
        "payType":"支付宝",
        "platformName":"京东任务",
        "shopName":"良品铺子",
        "equipment":"1",
        "keywords":["牛肉","鞋子","服装"],
        "credibilityLevel":"LV3",
        "taskCommission":"25",
        "taskCode":["110000","310000","330000"]
    };

    requestApi.deleteTask({"taskId":"liudong_1510998002068"}).then(function (data) {
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
