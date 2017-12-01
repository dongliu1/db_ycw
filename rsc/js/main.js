$(function(){
	$(document).ready(function(){
		nav.nav_hover();
		nav.rotation();
		nav.help();
		nav.hover();
		
		ycw_task._table_toggle();
		//ycw_task._task_list()
	})
	// 全局变量
	var global_yun = {
		
	}
});

var nav = {
	init:function(){
		
	},
	nav_hover:function() {							// 导航hover动画
		$('.nav-header-menu li').hover(function(){
			$(this).addClass('active').siblings().removeClass('active');
		})
	},
	rotation:function() {							// 轮播图
		$btn=$('.dots').find('span');                 //获取小圆点
		$Img=$('.banner').find('li').index();         //获取图片索引值
		var Img=0;
		var btn=1;
		$btn.click(function(){
			var index=$(this).index();
			Img=index;                                   //将点击小圆点的索引值给图片
			$(this).addClass('active').siblings().removeClass('active');
			$('.banner').find('li').eq($(this).index()).addClass('active').siblings().removeClass('active');
		})
		$('.prev').on("click",function(){
			var dex=$('.dots span').filter('.active').index();            //filter() 方法将匹配元素集合缩减为匹配指定选择器的元素
			if(dex=="0"){
				var dex=$btn.length-1;
				$btn.eq($btn.length-1).addClass('current').siblings().removeClass('current');
				$('.banner').find('li').eq($btn.length-1).addClass('active').siblings().removeClass('active');
			}else{
				var dex=dex-1;
				$btn.eq($btn.filter('.current').index()-1).addClass('current').siblings().removeClass('current');
				$('.banner').find('li').eq($btn.filter('.current').index()).addClass('active').siblings().removeClass('active');
			}
			if(Img==0){
				Img=$btn.length-2;
			}else{
				Img=Img-2;
			}
			myshow();
		})
		$('.next').on("click",function(){
			var dex=$('.dots span').filter('.active').index();
			Img=Img;
			if(dex=="4"){
				var dex=0;
				$btn.eq(0).addClass('current').siblings().removeClass('current');
				$('.banner').find('li').eq(0).addClass('active').siblings().removeClass('active');
			}else{
				var dex=dex+1;
				$btn.eq($btn.filter('.current').index()+1).addClass('current').siblings().removeClass('current');
				$('.banner').find('li').eq($btn.filter('.current').index()).addClass('active').siblings().removeClass('active');
			}
			myshow();
		})
		//定时器
		var timer=setInterval(myshow,5000);              
		function myshow(){
			Img++;
			if(Img>$btn.length-1){
				Img=0;
			};
			$btn.eq(Img).trigger("click");               //模拟给小圆点添加点击事件
		}
	},
	help:function() {									// 我们能为你做什么
		$('.main-container .list').hover(function() {
			$(this).toggleClass("animated pulse");
		})
	},
	hover: function() {
		$('.layout-main-prompt .btn').hover(function() {
			$(this).css("color","#FF0000");
		},function() {
			$(this).css("color","#000");
		})
		$('.layout-footer-fixed li').hover(function() {
			$(this).css({"background":"#fff","color":"#70d48c"});
		},function() {
			$(this).css({"background":"#70d48c","color":"#000"});
		})
		$('.nav-bar-r .menu').hover(function() {
			//$(this).find('ul.menu1').slideDown(240);
			$(this).find('a.list').addClass('active');
			$(this).find('ul.menu1').addClass('current');
		},function(){
			$(this).find('a.list').removeClass('active');
			$(this).find('ul.menu1').removeClass('current');
			//$(this).find('ul.menu1').slideUp(240);
		})
		$('.nav-bar-r .menu1 li').hover(function() {
			$(this).find('a').css({"color":"#0082f6"})
		},function() {
			$(this).find('a').css("color","#000")
		})
	}
};


var ycw_check={
	_init_checkVal:function (_type,_val) {
		switch (_type){
			case "int":
				return parseInt(_val);
			case "float":
				return parseFloat(_val);
			case "string":
				return _val+"";
			default:
				break;
		}
    }
}
