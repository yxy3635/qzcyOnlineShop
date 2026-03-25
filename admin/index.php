<?php
/**
 * 自助下单系统
**/
include("../includes/common.php");
$title='系统管理中心';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<?php
$mysqlversion=$DB->getColumn("select VERSION()");
$sec_msg = sec_check();
$checkupdate = getCheckString();
?>
<style>
/* 首页卡片升级：替换旧 widget 为 stat-card */
.stat-grid{display:grid;grid-template-columns:repeat(12,1fr);grid-gap:12px;margin-bottom:12px}
.col-4{grid-column:span 4}
@media(max-width:991px){.col-4{grid-column:span 6}}
@media(max-width:767px){.col-4{grid-column:span 12}}
.stat-card{display:flex;align-items:center;gap:12px;padding:16px;border-radius:12px;background:#fff;border:1px solid rgba(17,24,39,.06);box-shadow:0 8px 20px rgba(17,24,39,.05)}
.stat-card .icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff}
.stat-card .meta{display:flex;flex-direction:column}
.stat-card .meta .num{font-size:20px;font-weight:700;color:#1f2937}
.stat-card .meta .desc{font-size:12px;color:#6b7280}
.icon-purple{background:linear-gradient(135deg,#667eea,#5a67d8)}
.icon-green{background:linear-gradient(135deg,#34d399,#10b981)}
.icon-orange{background:linear-gradient(135deg,#f59e0b,#f97316)}
.icon-pink{background:linear-gradient(135deg,#ec4899,#f43f5e)}
.icon-gold{background:linear-gradient(135deg,#eab308,#f59e0b)}
.icon-rose{background:linear-gradient(135deg,#fb7185,#ef4444)}
/* 顶部迷你线条动画（位于图表上方的独立内边距区，不与图表内容重叠） */
.mini-line-anim{height:48px;display:block;width:100%;pointer-events:none}
@media(max-width:991px){.mini-line-anim{height:42px}}
@media(prefers-reduced-motion:reduce){.mini-line-anim{background:rgba(102,126,234,.06)}}
/* 统计图渐显与辅助线 */
.chart-fade{opacity:0;transition:opacity .26s ease}
.chart-fade.show{opacity:1}
#chart-classic-dash{position:relative}
#chart-classic-dash .vline{position:absolute;top:0;bottom:0;width:1px;background:rgba(17,24,39,.22);display:none}
/* 图例切换（交互） */
.chart-legend{display:flex;gap:10px;align-items:center;padding:0 12px 6px 12px}
.chart-legend .legend-pill{cursor:pointer;border:1px solid rgba(17,24,39,.12);padding:6px 10px;border-radius:20px;user-select:none;transition:background .15s ease, border-color .15s ease, opacity .15s ease}
.chart-legend .legend-pill:hover{background:#f3f4f6}
.chart-legend .legend-pill.off{opacity:.55}
/* 图表工具提示框样式 */
.chart-tooltip{position:absolute!important;z-index:10000!important;pointer-events:none;box-shadow:0 4px 12px rgba(17,24,39,.15)!important}
</style>
<div class="stat-grid">
  <div class="col-4">
    <div class="stat-card">
      <div class="icon icon-purple"><i class="fa fa-list-ol"></i></div>
      <div class="meta"><div class="num" id="count1">0</div><div class="desc">订单总数</div></div>
    </div>
  </div>
  <div class="col-4">
    <div class="stat-card">
      <div class="icon icon-green"><i class="fa fa-first-order"></i></div>
      <div class="meta"><div class="num" id="count3">0</div><div class="desc">待处理订单</div></div>
    </div>
  </div>
  <div class="col-4">
    <div class="stat-card">
      <div class="icon icon-orange"><i class="fa fa-briefcase"></i></div>
      <div class="meta"><div class="num">+ <span id="count4">0</span></div><div class="desc">今日订单数</div></div>
    </div>
  </div>
  <div class="col-4">
    <div class="stat-card" title="只统计通过支付接口产生的支付订单总额，不包括余额下单的">
      <div class="icon icon-pink"><i class="fa fa-rmb"></i></div>
      <div class="meta"><div class="num">$ <span id="count5">0</span></div><div class="desc">今日交易额</div></div>
    </div>
  </div>
  <div class="col-4">
    <div class="stat-card" title="只统计已完成和正在处理的订单">
      <div class="icon icon-gold"><i class="fa fa-briefcase"></i></div>
      <div class="meta"><div class="num">$ <span id="count15">0</span></div><div class="desc">今日收益</div></div>
    </div>
  </div>
  <div class="col-4">
    <div class="stat-card" title="只统计已完成和正在处理的订单">
      <div class="icon icon-rose"><i class="fa fa-rmb"></i></div>
      <div class="meta"><div class="num">$ <span id="count16">0</span></div><div class="desc">昨日收益</div></div>
    </div>
  </div>
</div>
<div class="row">
<div class="col-sm-6 col-lg-8">
	<div class="widget">
		<div class="widget-content border-bottom">
一周交易与订单统计
		</div>
        <div class="widget-content" style="padding:6px 12px 0 12px;">
            <canvas id="lineAnimTop" class="mini-line-anim"></canvas>
        </div>
        <div class="widget-content" style="padding:0 12px 0 12px;">
            <div class="chart-legend">
              <span class="legend-pill" data-series="0" style="border-color:#667eea;color:#4f46e5">订单量</span>
              <span class="legend-pill" data-series="1" style="border-color:#34d399;color:#059669">交易量</span>
              <span style="margin-left:auto;color:#6b7280;font-size:12px">tips：再次点击可取消选中</span>
            </div>
        </div>
        <div class="widget-content" style="padding:6px 12px 0 12px;">
            <div id="chart-classic-dash" class="chart-fade" style="height: 360px;"></div>
        </div>
		<div class="widget-content widget-content-full">
			<div class="row text-center">
				<div class="col-xs-4 push-inner-top-bottom border-right">
					<h4 class="widget-heading"><i class="fa fa-qq text-dark push-bit"></i>&nbsp;QQ钱包交易额<br>
					<center><span id="count12"></span>元</center></h4>
				</div>
				<div class="col-xs-4 push-inner-top-bottom">
					<h4 class="widget-heading"><i class="fa fa-wechat text-dark push-bit"></i>&nbsp;微信交易额<br>
					<center><span id="count13"></span>元</center></h4>
				</div>
				<div class="col-xs-4 push-inner-top-bottom border-left">
					<h4 class="widget-heading"><i class="fa fa-credit-card text-dark push-bit"></i>&nbsp;支付宝交易额<br>
					<center><span id="count14"></span>元</center></h4>
				</div>
			</div>
		</div>
	</div>
<div class="widget">
<div class="widget-content border-bottom">
<span class="pull-right text-muted"><i class="fa fa-shield"></i></span>
安全中心
</div>
	<ul class="list-group">
<?php
foreach($sec_msg as $row){
	echo $row;
}
if(count($sec_msg)==0)echo '<li class="list-group-item"><span class="btn-sm btn-success">正常</span>&nbsp;暂未发现网站安全问题</li>';
?>
	</ul>
</div>
</div>
<div class="col-sm-4">
	<div class="widget">
		<div class="widget-content border-bottom">
			<span class="pull-right text-muted"><i class="fa fa-circle"></i></span>
分站统计
		</div>
		<div class="widget-content widget-content-full-top-bottom border-bottom">
			<div class="row text-center">
				<div class="col-xs-6 push-inner-top-bottom border-right">
					<h4 class="widget-heading"><i class="fa fa-sitemap text-dark push"></i>&nbsp;分站/用户总数<br>
					<center><span id="count6"></span>个</font></center></h4>
				</div>
				<div class="col-xs-6 push-inner-top-bottom">
					<h4 class="widget-heading"><i class="fa fa-cloud text-dark push"></i>&nbsp;今日新开分站<br>
					<center><span id="count7"></span>个</center></h4>
				</div>
			</div>
		</div>
		<div class="widget-content widget-content-full border-bottom">
			<div class="row text-center">
				<div class="col-xs-6 push-inner-top-bottom border-right">
					<h4 class="widget-heading"><i class="fa fa-rmb text-dark push"></i>&nbsp;今日分站提成<br>
					<center><span id="count8"></span>元</center></h4>
				</div>
				<div class="col-xs-6 push-inner-top-bottom">
					<h4 class="widget-heading"><i class="fa fa-money text-dark push"></i>&nbsp;待处理提现<br>
					<center><a id="count11" href="tixian.php"></a>元</center></h4>
				</div>
			</div>
		</div>
		<div class="widget-content widget-content-full">
			<div class="row text-center">
				<div class="col-xs-12 push-inner-top-bottom border-right">
					<i class="fa fa-comment text-dark"></i>&nbsp;待处理工单数量：<a id="count17" href="workorder.php">0</a> 个
				</div>
			</div>
		</div>
	</div>

<div class="widget" style=" border-left: 5px solid blue;">
<div class="widget-content border-bottom">
<span class="pull-right text-muted"><i class="fa fa-info-circle"></i></span>环境信息
</div>
<ul class="nav nav-pills nav-stacked">
	<li>
		<a><b>PHP 版本：</b><?php echo phpversion() ?>&nbsp;&nbsp;&nbsp;<b>MySQL 版本：</b><?php echo $mysqlversion ?></a>
	</li>
	<li>
		<a><b>服务器软件：</b><?php echo $_SERVER['SERVER_SOFTWARE'] ?></a>
	</li>
	<li>
		<a><b>服务器时间：</b><?php echo $date ?></a>
	</li>
	<li>
		<a><b>技术支持：</b>yxy3635@gmail.com</a>
	</li>
	<li>
		<a href="http://www.qzcy2.top/"><b>平台链接：</b>千纸雏鸢</a>
	</li>
</ul>
</div>

<div class="widget" style=" border-left: 5px solid green;">
<div class="widget-content border-bottom text-dark">
<span class="pull-right text-muted"><i class="fa fa-check-square"></i></span>
检测更新
</div>
	<!--<ul class="list-group text-dark" id="checkupdate">-->
	<!--</ul>-->
	<ul>
	    	<li>
		<a><b>当前版本为最新：</b>千纸雏鸢-qzcyOnlineSales-v3.0.1</a>
	</li>
	</ul>
</div>

    </div>
  </div> 
<script>
$(document).ready(function(){
	$('#title').html('正在加载数据中...');
	$.ajax({
		type : "GET",
		url : "ajax.php?act=getcount",
		dataType : 'json',
		async: true,
		success : function(data) {
			$('#title').html('后台管理首页');
			$('#yxts').html(data.yxts);
			$('#count1').html(data.count1);
			$('#count2').html(data.count2);
			$('#count3').html(data.count3);
			$('#count4').html(data.count4);
			$('#count5').html(data.count5);
			$('#count6').html(data.count6);
			$('#count7').html(data.count7);
			$('#count8').html(data.count8);
			$('#count9').html(data.count9);
			$('#count10').html(data.count10);
			$('#count11').html(data.count11);
			$('#count12').html(data.count12);
			$('#count13').html(data.count13);
			$('#count14').html(data.count14);
			$('#count15').html(data.count15);
			$('#count16').html(data.count16);
			$('#count17').html(data.count17);

            var t=$("#chart-classic-dash");
            // 升级：圆角面积、渐变、平滑曲线与自定义提示
            var chartOptions={
              colors:["#667eea","#34d399"],
              legend:{show:!0,position:"nw",backgroundOpacity:0},
              grid:{borderWidth:0,hoverable:!0,clickable:!0,margin:{top:10,bottom:10,left:10,right:10}},
              yaxis:{show:!1,tickColor:"#f3f4f6",ticks:3},
              xaxis:{ticks:data.chart.date,tickColor:"#f3f4f6"},
              series:{
                lines:{show:!0,fill:!0,lineWidth:2,fillColor:{colors:[{opacity:.25},{opacity:.12}]}},
                splines:{show:!0,tension:0.4,lineWidth:2,fill:.25},
                shadowSize:0,
                points:{show:!0,radius:3,fillColor:"#fff"}
              }
            };
            // 使用 lines + splines 的组合（若不支持 splines 插件则回退为 lines）
            try{
              $.plot(t,[
                {label:"订单量",data:data.chart.orders},
                {label:"交易量",data:data.chart.money}
              ],chartOptions);
            }catch(e){
              // 回退：不使用 splines
              delete chartOptions.series.splines;
              $.plot(t,[
                {label:"订单量",data:data.chart.orders},
                {label:"交易量",data:data.chart.money}
              ],chartOptions);
            }
            $("#chart-classic-dash").addClass('show');

            // 交互增强：
            // 1) 图例点击开关某条曲线
            var plot=$("#chart-classic-dash").data('plot') || null;
            plot = $.plot.plugins ? $(t).plot : null; // 兼容旧版写法
            $(document).off('click','.legend-pill').on('click','.legend-pill',function(){
              var idx=parseInt(this.getAttribute('data-series'),10);
              var series=$(t).data('plot')?$(t).data('plot').getData():null;
              if(!series){ series = [ {label:"订单量",data:data.chart.orders,hidden:false}, {label:"交易量",data:data.chart.money,hidden:false} ]; }
              var current=$(this).toggleClass('off').hasClass('off');
              // 通过重新绘制实现显隐
              var newData=[
                {label:"订单量",data: current && idx===0 ? [] : data.chart.orders},
                {label:"交易量",data: current && idx===1 ? [] : data.chart.money}
              ];
              $.plot(t,newData,chartOptions);
            });

            // 2) 框选缩放（selection 插件）
            $(t).bind("plotselected", function (event, ranges) {
              // 仅横向缩放
              var opts=$.extend(true,{},chartOptions);
              opts.xaxis.min = ranges.xaxis.from;
              opts.xaxis.max = ranges.xaxis.to;
              $.plot(t,[{label:"订单量",data:data.chart.orders},{label:"交易量",data:data.chart.money}],opts);
            });
            // 双击还原
            $(t).on('dblclick',function(){ $.plot(t,[{label:"订单量",data:data.chart.orders},{label:"交易量",data:data.chart.money}],chartOptions); });
            var s=null,r=null;
            t.bind("plothover",function(o,t,i){
              if(i){ if(s!==i.dataIndex){ s=i.dataIndex; $("#chart-tooltip").remove();
                var val=i.datapoint[1];
                var label=i.series.label;
                var tip='<div style="font-weight:600;margin-bottom:2px">'+label+'</div>'+
                         '<div style="opacity:.85">'+i.datapoint[0]+' 日</div>'+
                         '<div style="font-size:16px;font-weight:700;margin-top:2px">'+(i.seriesIndex===1?"￥":"")+val+'</div>';
                $('<div id="chart-tooltip" class="chart-tooltip">'+tip+'</div>')
                  .css({top:i.pageY-35,left:i.pageX+8,background:'rgba(17,24,39,.85)',color:'#fff',padding:'6px 10px',borderRadius:'8px',fontSize:'12px',position:'absolute',zIndex:10000})
                  .appendTo("body").show();
              }} else { $("#chart-tooltip").remove(); s=null; }
            });

            // 顶部迷你装饰线条动画（不改变版式，仅填充统计图上方空白）
            try{
              var cTop=document.getElementById('lineAnimTop');
              if(cTop){
                var ctx=cTop.getContext('2d');
                function resize(){
                  var w=cTop.offsetWidth, h=cTop.offsetHeight;
                  var dpi=window.devicePixelRatio||1; cTop.width=w*dpi; cTop.height=h*dpi; ctx.setTransform(dpi,0,0,dpi,0,0);
                }
                resize();
                var t0=0, raf=null;
                function draw(){
                  var w=cTop.width/(window.devicePixelRatio||1), h=cTop.height/(window.devicePixelRatio||1); ctx.clearRect(0,0,w,h);
                  ctx.lineWidth=1.2; ctx.globalAlpha=.8; var colors=['#7c8cf2','#34d399'];
                  for(var k=0;k<2;k++){
                    ctx.beginPath(); ctx.strokeStyle=colors[k];
                    for(var x=0;x<=w;x+=5){
                      var y= h*0.6 + Math.sin((x*0.015)+(t0*0.03+k))*10 + Math.cos((x*0.028)-(t0*0.02))*4;
                      if(x===0) ctx.moveTo(x,y); else ctx.lineTo(x,y);
                    }
                    ctx.stroke();
                  }
                  t0++; raf=requestAnimationFrame(draw);
                }
                document.addEventListener('visibilitychange',function(){ if(document.hidden) cancelAnimationFrame(raf); else raf=requestAnimationFrame(draw); });
                window.addEventListener('resize', resize);
                raf=requestAnimationFrame(draw);
              }
            }catch(e){}
			$.ajax({
				url: '<?php echo $checkupdate?>',
				type: 'get',
				dataType: 'jsonp',
				async: true,
				jsonpCallback: 'callback'
			}).done(function(data){
				$("#checkupdate").html(data.msg);
			})
		}
	});
})
</script>