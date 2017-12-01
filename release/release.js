var ycw_task={
    _init_createTask:function () {
        var opt={
            username :"liudong",               	//发布人
            taskName:"衣品天成",                	//任务名称
            payType:"1",                 		//付款方式
            platformType:"2",        			//发布平台类型
            shopName:"三只松鼠",                	//店铺名称
            equipment:"1",              		//设备
            keywords:["坚果","核桃"],          	//搜索关键词  例如:["鞋子","男士"]

            fileUrl:"http://localhost/ycw/serverFiles/img/mi.png",                  //任务图片地址

            linkAddress:"http://www.baidu.com", //商品链接地址
            credibilityLevel:"LV5", 			//买号信誉等级要求
            taskCommission:"50",     			//任务佣金
            taskCode:["201","302"],            	//地区行政编码  例如:["201","302"]
            integral:"8.1",                 	//任务点数
            timeOfReceipt:"10天内",       		//好评时间要求
            commentOfReceipt:"lv2以上", 			//好评内容要求
            orders:"1" 							//任务接受状态
        };
        console.log(JSON.stringify(opt));
        requestApi.createTask(opt).then(function (data) {
            console.log(data);
        })
    },
}