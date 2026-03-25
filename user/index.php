<?php

// 检查 Cookie 是否存在
if (!isset($_COOKIE['user_is_visit_page'])) {
    // 如果 Cookie 不存在，说明用户未访问 user_agree.php，跳转到 user_agree.php
    header("Location: user_agree.php");
    exit();
}

$is_defend=true;
require '../includes/common.php';
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

if($_GET['mod']=='faka'){
	exit("<script language='javascript'>window.location.href='../?mod=faka&&id={$_GET['id']}&skey={$_GET['skey']}';</script>");
}
$title = '平台首页';
include 'head.php';
include 'link.php';

$scriptpath = str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$scriptpath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$scriptpath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$fenzhan_url = 'http://'.$userrow['domain'].$scriptpath.'/';
?>
<link rel="stylesheet" href="<?php echo $cdnserver?>assets/css/toastr.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

.modern-dashboard { padding: 16px 0; }

.dashboard-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: none;
    margin-bottom: 24px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.user-profile-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.user-profile-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    transform: rotate(45deg);
}

.user-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid rgba(255,255,255,0.3);
    object-fit: cover;
    margin-bottom: 15px;
}

.balance-display {
    font-size: 32px;
    font-weight: 700;
    margin: 10px 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.quick-actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 20px; padding: 24px; }

.action-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 15px;
    padding: 22px 16px;
    text-decoration: none;
    color: white;
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 110px;
    position: relative;
    overflow: hidden;
}

.action-btn:hover {
    color: white;
    text-decoration: none;
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
}

.action-btn i {
    font-size: 24px;
    margin-bottom: 8px;
}

.action-btn.success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.action-btn.warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.action-btn.info {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    color: #333;
}

.action-btn.danger {
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
}

.stats-row {
    display: flex;
    justify-content: space-around;
    align-items: center;
    background: rgba(255,255,255,0.1);
    border-radius: 15px;
    padding: 20px;
    margin: 20px 0;
}

.stat-item {
    text-align: center;
    flex: 1;
}

.stat-value {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 12px;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-card {
    padding: 25px;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 500;
    color: #666;
}

.info-value {
    font-weight: 600;
    color: #333;
}

.btn-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 25px;
    padding: 8px 20px;
    color: white;
    font-size: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-modern:hover {
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.btn-modern.success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.btn-modern.warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.btn-modern.info {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    color: #333;
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
    display: flex;
    align-items: center;
}

.section-title i {
    margin-right: 10px;
    color: #667eea;
}

.alert-modern {
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    border: none;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    color: #721c24;
}

.notification-badge {
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    position: absolute;
    top: -5px;
    right: -5px;
}

.quick-action-wrapper {
    position: relative;
}

img.logo{width:14px;height:14px;margin:0 5px 0 3px;}
.span_position{display:inline;background:red;border-radius:50%;width:10px;height:10px;position:absolute}
.nickname{overflow: hidden;text-overflow: ellipsis;white-space: nowrap;max-width:100px;}

/* 动态装饰板：粒子网络动画 */
.animated-area{position: relative;height: 460px;overflow: hidden;background: radial-gradient(160% 120% at 20% 0%, #eef2ff 0%, #f5f7ff 40%, #ffffff 100%);}
.animated-area canvas{position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none}
@media (max-width: 768px) { .animated-area{height: 220px;} }

@media (max-width: 768px) {
    .quick-actions { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    
    .stats-row {
        flex-direction: column;
        gap: 15px;
    }
    
    .balance-display {
        font-size: 24px;
    }
}
</style>

<div class="modern-dashboard">
    <div class="container-fluid dashboard-container">
        <?php
        if($userrow['rmb']>4){
        if(strlen($userrow['pwd'])<6 || is_numeric($userrow['pwd']) && strlen($userrow['pwd'])<=10 || $userrow['pwd']===$userrow['qq']){
            echo '<div class="alert-modern"><i class="fa fa-exclamation-triangle"></i> <strong>安全提醒：</strong>您的密码过于简单，请不要使用较短的纯数字或自己的QQ号当做密码，以免造成资金损失！ <a href="uset.php?mod=user" class="btn-modern info" style="margin-left: 10px;">立即修改</a></div>';
        }elseif($userrow['user']===$userrow['pwd']){
            echo '<div class="alert-modern"><i class="fa fa-exclamation-triangle"></i> <strong>安全提醒：</strong>您的用户名与密码相同，极易被黑客破解，请及时修改密码 <a href="uset.php?mod=user" class="btn-modern info" style="margin-left: 10px;">立即修改</a></div>';
        }
        }
        ?>
        
        <div class="row">
            <!-- 左列：用户信息（固定宽卡片） -->
            <div class="col-xl-3 col-lg-4 col-md-12">
                <div class="dashboard-card user-profile-card">
                    <div style="padding: 30px; position: relative; z-index: 2;">
                        <div class="text-center">
                            <img src="<?php echo $faceimg ?>" alt="Avatar" class="user-avatar">
                            <h5 style="margin: 0; font-weight: 600;"><?php echo $nickname?></h5>
                            <p style="margin: 5px 0 0 0; opacity: 0.8; font-size: 14px;">UID: <?php echo $userrow['zid']?></p>
                        </div>
                        
                        <div class="balance-display text-center">
                            ¥<?php echo $userrow['rmb']?>
                        </div>
                        
                        <div class="stats-row">
                            <div class="stat-item">
                                <div class="stat-value" id="income_today">¥0</div>
                                <div class="stat-label">今日收益</div>
                            </div>
                        </div>
                        
                        <div class="text-center" style="margin-top: 20px;">
                            <a href="recharge.php" class="btn-modern success" style="margin-right: 10px;">
                                <i class="fa fa-plus"></i> 充值余额
                            </a>
                            <a href="tixian.php" class="btn-modern info">
                                <i class="fa fa-bank"></i> 申请提现
                            </a>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card" style="padding:0;">
                    <div class="animated-area">
                        <center><h1><?php echo $conf['sitename']?> <br />欢迎来到用户中心</h1></center>
                        <canvas id="userDecorCanvas"></canvas>
                    </div>
                </div>

            </div>

            <!-- 右列：主要内容（快捷操作 + 信息区） -->
            <div class="col-xl-9 col-lg-8 col-md-12">
                <!-- 快捷操作（整行） -->
                <div class="dashboard-card">
                    <div style="padding: 18px 20px 0 20px;">
                        <div class="section-title"><i class="fa fa-bolt"></i> 功能菜单</div>
                    </div>
                    <div class="quick-actions">
                        <div class="quick-action-wrapper">
                            <a href="<?php echo $userrow['power']>0?'./shop.php':'../';?>" class="action-btn">
                                <i class="fa fa-shopping-cart"></i>
                                <span><?php echo $userrow['power']>0?'低价下单':'自助下单';?></span>
                            </a>
                        </div>
                        
                        <?php if($conf['qiandao_reward']){?>
                        <div class="quick-action-wrapper">
                            <a href="./qiandao.php" class="action-btn success">
                                <i class="fa fa-check-square"></i>
                                <span>每日签到</span>
                            </a>
                        </div>
                        <?php }else{?>
                        <div class="quick-action-wrapper">
                            <a href="recharge.php" class="action-btn success">
                                <i class="fa fa-money"></i>
                                <span>充值余额</span>
                            </a>
                        </div>
                        <?php }?>
                        
                        <div class="quick-action-wrapper">
                            <a href="message.php" class="action-btn warning">
                                <i class="fa fa-bullhorn"></i>
                                <span>站内通知</span>
                                <span id="message_count" class="notification-badge" style="display: none;"></span>
                            </a>
                        </div>
                        
                        <div class="quick-action-wrapper">
                            <a href="<?php echo $userrow['power']>0?'./shop.php?chadan=1':'../?chadan=1';?>" class="action-btn info">
                                <i class="fa fa-search"></i>
                                <span>自助查单</span>
                            </a>
                        </div>
                        
                        <div class="quick-action-wrapper">
                            <a href="./workorder.php" class="action-btn warning">
                                <i class="fa fa-check-square-o"></i>
                                <span>我的工单</span>
                                <span id="work_count" class="notification-badge" style="display: none;"></span>
                            </a>
                        </div>
                        
                        <div class="quick-action-wrapper">
                            <a href="record.php" class="action-btn info">
                                <i class="fa fa-hashtag"></i>
                                <span>收支明细</span>
                            </a>
                        </div>
                        
                        <?php if($userrow['power']>0){?>
                        <div class="quick-action-wrapper">
                            <a href="shoplist.php" class="action-btn">
                                <i class="fa fa-list-alt"></i>
                                <span>商品管理</span>
                            </a>
                        </div>
                        
                        <div class="quick-action-wrapper">
                            <a href="list.php" class="action-btn info">
                                <i class="fa fa-list"></i>
                                <span>订单记录</span>
                            </a>
                        </div>
                        
                        <?php if($userrow['power']==2){?>
                        <div class="quick-action-wrapper">
                            <a href="sitelist.php" class="action-btn">
                                <i class="fa fa-sitemap"></i>
                                <span>分站管理</span>
                            </a>
                        </div>
                        <?php }else{?>
                        <div class="quick-action-wrapper">
                            <a href="login.php?logout" class="action-btn danger">
                                <i class="fa fa-sign-out"></i>
                                <span>安全退出</span>
                            </a>
                        </div>
                        <?php }?>
                        <div class="quick-action-wrapper">
                            <a href="yiban.php" class="action-btn info">
                                <i class="fa fa-money"></i>
                                <span>易班网薪下单</span>
                            </a>
                        </div>
                        <?php }?>
                    </div>
                </div>

                <!-- 信息区：两列布局（等高对齐） -->
                <div class="row row-eq">
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <div class="info-card">
                                <div class="section-title"><i class="fa fa-globe"></i> 我的站点信息</div>
                                <ul class="info-list">
                            <?php if($userrow['power']>0){?>
                            <li class="info-item">
                                <span class="info-label">通知提醒</span>
                                <div>
                                    <span class="info-value" id="tiaosu">0</span> 条未读
                                    <a href="./message.php" class="btn-modern" style="margin-left: 10px;">查看</a>
                                </div>
                            </li>
                            
                            <li class="info-item">
                                <span class="info-label">我的域名</span>
                                <div>
                                    <a href="<?php echo $fenzhan_url?>" target="_blank" rel="noreferrer" class="info-value" style="color: #667eea;"><?php echo $userrow['domain']?></a>
                                    <a href="uset.php?mod=site" class="btn-modern info" style="margin-left: 10px;">编辑</a>
                                </div>
                            </li>
                            
                            <li class="info-item">
                                <span class="info-label">网站名称</span>
                                <span class="info-value" style="color: #667eea;"><?php echo $userrow['sitename']?></span>
                            </li>
                            
                            <li class="info-item">
                                <span class="info-label">站点类型</span>
                                <div>
                                    <span class="info-value" style="color: #f5576c;"><?php echo ($userrow['power']==2?'专业版':'普及版')?></span>
                                    <?php if($conf['fenzhan_upgrade']>0 && $userrow['power']==1){?>
                                    <a href="upsite.php" class="btn-modern warning" style="margin-left: 10px;">升级站点</a>
                                    <?php }else{?>
                                    <a href="./sitelist.php" class="btn-modern warning" style="margin-left: 10px;">下级管理</a>
                                    <?php }?>
                                </div>
                            </li>
                            
                            <?php if($conf['fenzhan_expiry']>0){?>
                            <li class="info-item">
                                <span class="info-label">到期时间</span>
                                <div>
                                    <span class="info-value" style="color: #f093fb;"><?php echo $userrow['endtime']?></span>
                                    <a href="renew.php" class="btn-modern" style="margin-left: 10px;">续期</a>
                                </div>
                            </li>
                            <?php }?>
                            
                            <?php if($conf['appcreate_open']==1){?>
                            <li class="info-item">
                                <span class="info-label">客户端APP</span>
                                <div>
                                    <?php echo ($userrow['appurl']?'<a href="'.$userrow['appurl'].'" target="_blank" class="info-value" style="color: #667eea;">点击下载</a>':'<span class="info-value" style="color: #999;">未生成</span>');?>
                                    <a href="appCreate.php" class="btn-modern warning" style="margin-left: 10px;">生成</a>
                                </div>
                            </li>
                            <?php }?>
                            
                            <?php }else{?>
                            <li class="info-item" style="text-align: center; padding: 30px 0;">
                                <div>
                                    <p style="color: #666; margin-bottom: 20px;">您还未开通分站</p>
                                    <a href="regsite.php" class="btn-modern" style="padding: 12px 30px; font-size: 14px;">
                                        <i class="fa fa-plus"></i> 立即开通分站
                                    </a>
                                </div>
                            </li>
                            <?php }?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 站点公告 -->
                    <?php if($userrow['power']>0 || $conf['user_level']==1){?>
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <div style="padding: 25px;">
                                <div class="section-title"><i class="fa fa-volume-up"></i> 站点公告</div>
                                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea;">
                                    <?php echo $conf['gg_panel']?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './foot.php';?>
<script src="<?php echo $cdnserver?>assets/js/clipboard-1.7.1.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/toastr.min.js"></script>
<script>
$(document).ready(function(){
var clipboard = new Clipboard('#copy-btn');
clipboard.on('success', function (e) {
	layer.msg('复制成功！', {icon: 1});
});
clipboard.on('error', function (e) {
	layer.msg('复制失败，请长按链接后手动复制', {icon: 2});
});

$("#recreate_url").click(function(){
	var self = $(this);
	if (self.attr("data-lock") === "true") return;
	else self.attr("data-lock", "true");
	var ii = layer.load(1, {shade: [0.1, '#fff']});
	$.get("ajax_user.php?act=create_url&force=1", function(data) {
		layer.close(ii);
		if(data.code == 0){
			layer.msg('生成链接成功');
			$("#copy-btn").html(data.url);
			$("#copy-btn").attr('data-clipboard-text',data.url);
		}else{
			layer.alert(data.msg);
		}
		self.attr("data-lock", "false");
	}, 'json');
});

if(window.location.hash=='#chongzhi'){
	$("#userjs").modal('show');
}

// 添加动画效果
setTimeout(function() {
    $('.dashboard-card').each(function(index) {
        $(this).delay(100 * index).animate({
            opacity: 1
        }, 600);
    });
}, 100);

// 粒子网络动画：在左侧动态装饰卡片内绘制
(function(){
    var canvas = document.getElementById('userDecorCanvas');
    if(!canvas) return;
    var ctx = canvas.getContext('2d');
    var particles = [];
    var raf = null;
    var prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    function resize(){
        var dpi = window.devicePixelRatio || 1;
        var rect = canvas.getBoundingClientRect();
        canvas.width = rect.width * dpi;
        canvas.height = rect.height * dpi;
        ctx.setTransform(dpi,0,0,dpi,0,0);
        // 粒子数量与面积相关，限制上限，移动端减少
        var base = Math.max(24, Math.min(60, Math.floor(rect.width * rect.height / 16000)));
        if(window.innerWidth < 768) base = Math.max(18, Math.min(40, base - 10));
        particles.length = 0;
        for(var i=0;i<base;i++){
            particles.push({
                x: Math.random()*rect.width,
                y: Math.random()*rect.height,
                vx: (Math.random()*1.2-0.6),
                vy: (Math.random()*1.2-0.6),
                r: Math.random()*2+0.6
            });
        }
    }
    function step(){
        var w = canvas.width/(window.devicePixelRatio||1);
        var h = canvas.height/(window.devicePixelRatio||1);
        ctx.clearRect(0,0,w,h);
        // 背景轻微渐变光晕
        var grd = ctx.createLinearGradient(0,0,w,h);
        grd.addColorStop(0,'rgba(102,126,234,0.08)');
        grd.addColorStop(1,'rgba(118,75,162,0.06)');
        ctx.fillStyle = grd; ctx.fillRect(0,0,w,h);

        // 更新与绘制粒子
        for(var i=0;i<particles.length;i++){
            var p = particles[i];
            p.x += p.vx; p.y += p.vy;
            if(p.x<0||p.x>w) p.vx*=-1;
            if(p.y<0||p.y>h) p.vy*=-1;
            ctx.beginPath();
            ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
            ctx.fillStyle = 'rgba(102,126,234,0.85)';
            ctx.fill();
        }
        // 连接相近的点
        for(var a=0;a<particles.length;a++){
            for(var b=a+1;b<particles.length;b++){
                var pa=particles[a], pb=particles[b];
                var dx=pa.x-pb.x, dy=pa.y-pb.y; var d=dx*dx+dy*dy;
                if(d<120*120){
                    var alpha = 1 - (d/(120*120));
                    ctx.strokeStyle = 'rgba(102,126,234,'+(0.25*alpha)+')';
                    ctx.lineWidth = 1;
                    ctx.beginPath(); ctx.moveTo(pa.x,pa.y); ctx.lineTo(pb.x,pb.y); ctx.stroke();
                }
            }
        }
        raf = requestAnimationFrame(step);
    }
    function start(){ if(prefersReduced) return; cancelAnimationFrame(raf); step(); }
    function stop(){ cancelAnimationFrame(raf); }
    resize();
    start();
    window.addEventListener('resize', function(){ resize(); start(); });
    document.addEventListener('visibilitychange', function(){ if(document.hidden) stop(); else start(); });
})();

$.ajax({
	type : "GET",
	url : "ajax_user.php?act=msg",
	dataType : 'json',
	async: true,
	success : function(data) {
		if(data.code==0){
			if(data.count>0){
				$("#tiaosu").text(data.count);
				$("#message_count").text(data.count).show();
				toastr.info('<a href="message.php">您有<b>'+data.count+'</b>条新消息，请注意查收！</a>', '消息提醒');
			}
			if(data.count2>0){
				$("#work_count").text(data.count2).show();
				toastr.warning('<a href="workorder.php">您有<b>'+data.count2+'</b>个工单已被管理员回复！</a>', '工单提醒');
			}
			$("#income_today").html('¥'+data.income_today);
		}
	}
});

$.ajax({
	type : "GET",
	url : "ajax_user.php?act=create_url",
	dataType : 'json',
	async: true,
	success : function(data) {
		if(data.code == 0){
			$("#copy-btn").html(data.url);
			$("#copy-btn").attr('data-clipboard-text',data.url);
		}else{
			$("#copy-btn").html(data.msg);
		}
	}
});
});
</script>
</body>
</html>