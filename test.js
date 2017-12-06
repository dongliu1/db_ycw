/**
 * Created by liudong on 2017/12/6.
 */
$(function () {
    _init_apiTest._init();
});

var _init_apiTest={
  _init:function () {
      /*
       * platformType	  ：任务类别(1京东任务，2淘宝入围，3天猫任务。。。)
       * taaskId		  : 订单编号
       * modifiTime	  ：发布时间
       * fileUrl		  ：任务图片路径
       * author		  ：发布人
       * taskCommission  ：任务金额
       * integral		  ：任务点数
       * timeOfReceipt	  ：好评时间要求
       * commentOfReceipt：好评内容要求
       * orders	   	  ：任务状态类型(0未接单1已接单2已完成)
       * */

      requestApi.getTaskInfo({pageNum:1,pageRows:10}).then(function (serverdata) {
          console.log(serverdata);
          //$("#testMd5").html($.md5("ycw_dbserver/server/2017-12-06/mysecretpersonaluniquekey"));
          $("#jsonResult").html(serverdata);
      });
  }
};

