$(function () {
    ycw_task._table_toggle();
    ycw_task._task_list();
});

var ycw_task = {
    /* table切换 */
    _table_toggle:function(){
        $(".task_tab .list").off("click").on("click",function(){
            $(this).addClass("current").siblings().removeClass("current");
        })
    },
    /** 任务列表 **/
    _task_list:function(){
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
                var _class = idata["orders"] ? "orange" : "link_btn radius-large";
                if(idata["orders"]){
                    $(".td_center .ico_msg").css("display","none");
                }
                idata["orders"] = idata["orders"] ? "任务已接手，正在进行中" : "接手任务";
                var _html  = "<tr class='task_list'>";
                _html += "<td>";
                _html += '<div class="main-list">';
                _html += '<div class="top">';
                _html += '<span class="top_title">';
                _html += '<span class="left">';
                _html += '任务编号:<span title="任务编号">'+idata["id"]+'</span>';
                _html += '</span>';
                _html += '<span class="addtime" title="发布时间">'+moment(idata["modifiTime"]-0).format("YYYY/MM/DD HH:mm:ss")+'</span>';
                _html += '</span>';
                _html += '</div>';
                _html += '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                _html += '<tbody>';
                _html += '<tr>';
                _html += '<td class="td_left">';
                _html += '<img src='+idata["fileUrl"]+'>';
                _html += '</td>';
                _html += '<td class="td_center">';
                _html += '<ul>';
                _html += '<li>';
                _html += '发布人:';
                _html += '<span class="red">'+idata["author"]+'</span>';
                _html += '<img src="" align="absmiddle" aria-describedby="tipsy" tabindex="0">';
                _html += '<img src="" align="absmiddle" aria-describedby="tipsy" tabindex="0">';
                _html += '<img src="" align="absmiddle" aria-describedby="tipsy" tabindex="0">';
                _html += '</li>';
                _html += '<li>';
                _html += '任务金额：<span class="gold red">'+idata["taskCommission"]+'</span> 元';
                _html += '</li>';
                _html += '<li>';
                _html += '发布点：<span class="red">'+idata["integral"]+'</span> 点';
                _html += '</li>';
                _html += '<li>';
                _html += '收货时限：<span class="orange"><span title="30分钟后确认收货带字好评和店评5分">'+idata["timeOfReceipt"]+'</span></span>';
                _html += '</li>';
                _html += '</ul>';
                _html += '<div class="ico_msg">';
                _html += '<img src="" height="18" align="absmiddle" aria-describedby="tipsy" tabindex="0">';
                _html += '<img src="" height="18" align="absmiddle" aria-describedby="tipsy" tabindex="0">';
                _html += '<img src="" height="18" align="absmiddle" aria-describedby="tipsy" tabindex="0">';
                _html += '<img src="" height="18" align="absmiddle" aria-describedby="tipsy" tabindex="0"><br>';
                _html += '<span class="blue" title="自由填写好评内容">'+idata["commentOfReceipt"]+'</span><br>';
                _html += '</div>';
                _html += '</td>';
                _html += '<td class="td_right">';
                _html += '<a class='+_class+' href="#">'+idata["orders"]+'</a>';
                _html += '</td>';
                _html += '</tr>';
                _html += '</tbody>';
                _html += '</table>';
                _html += '</div>';
                _html += '</td>';
                _html += '</tr>"';

                $("#main-list").append(_html);
            })
        });


    }
}