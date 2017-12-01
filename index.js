
$(function () {
    _init_task._init_newTasks();
});

var _init_task={
    _init_newTasks:function () {
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
            console.log(serverdata,serverdata.length);
            serverdata=JSON.parse(serverdata);
            $.each(serverdata,function (i, idata) {
                var _li="<li>用户："+idata.author+" 成功发布了一个<span>任务</span> 佣金<span>￥"+idata.taskCommission+"</span></li>";
                $("#ycw-newTasks").append(_li);
            })
        });
    }
};