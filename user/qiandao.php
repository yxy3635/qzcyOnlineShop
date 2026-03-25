<?php
$is_defend=true;
require '../includes/common.php';
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

if(!$conf['qiandao_reward']){
	showmsg('当前站点未开启签到功能',3);
}
$_SESSION['isqiandao']=$userrow['zid'];

$day = date("Y-m-d");
$lastday = date("Y-m-d",strtotime("-1 day"));
if ($row = $DB->getRow("SELECT * FROM pre_qiandao WHERE zid='{$userrow['zid']}' AND date='$day' ORDER BY id DESC LIMIT 1")) {
	$isqiandao = true;
	$continue = $row['continue'];
}else{
	if ($row = $DB->getRow("SELECT * FROM pre_qiandao WHERE zid='{$userrow['zid']}' AND date='$lastday' ORDER BY id DESC LIMIT 1")) {
		$continue = $row['continue'];
	}else{
		$continue = 0;
	}
	$isqiandao = false;
}

$rs=$DB->query("SELECT * FROM pre_qiandao ORDER BY id DESC LIMIT 10");
$qqrow=array();
$qdrow=array();
while($res = $rs->fetch()){
	if(count($qqrow)<5){
		$qqrow[]=$res['qq'];
	}
	$qdrow[]=$res;
}

$title = '每日签到';
include 'head.php';

$url = 'http://'.$userrow['domain'].'/';
//if($conf['fanghong_api']>0){
//	$turl = fanghongdwz($url);
//	if(strpos($turl,'/')===false){
//		$turl = $url;
//	}
//}else{
	$turl = $url;
//}
?>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.compact-checkin {
    padding: 15px 0;
}

.checkin-container {
    max-width: 800px;
    margin: 0 auto;
}

.main-checkin-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 20px;
}

.checkin-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px 25px;
    text-align: center;
    position: relative;
}

.checkin-title {
    font-size: 24px;
    font-weight: 600;
    margin: 0 0 10px 0;
}

.checkin-date {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 20px;
}

.checkin-stats-compact {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin: 20px 0;
}

.stat-compact {
    text-align: center;
}

.stat-compact .value {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 5px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.stat-compact .label {
    font-size: 12px;
    opacity: 0.9;
}

.checkin-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 25px;
}

.btn-checkin {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    border: none;
    border-radius: 25px;
    padding: 12px 30px;
    color: white;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
}

.btn-checkin:hover {
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(79, 172, 254, 0.4);
}

.btn-checkin:disabled {
    background: #ccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.btn-share {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    box-shadow: 0 8px 20px rgba(240, 147, 251, 0.3);
}

.btn-share:hover {
    box-shadow: 0 12px 25px rgba(240, 147, 251, 0.4);
}

.ranking-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.ranking-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    overflow: hidden;
}

.ranking-header {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    padding: 15px 20px;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
}

.avatar-section {
    padding: 20px;
    text-align: center;
}

.avatar-group {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.avatar-item {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid #667eea;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.avatar-item:hover {
    transform: scale(1.1);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
    background: white;
}

.stats-cell {
    padding: 15px 10px;
    text-align: center;
    border-right: 1px solid #f0f0f0;
    position: relative;
}

.stats-cell:last-child {
    border-right: none;
}

.stats-cell::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
}

.stats-cell:nth-child(1)::before {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-cell:nth-child(2)::before {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stats-cell:nth-child(3)::before {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stats-icon {
    font-size: 18px;
    margin-bottom: 8px;
    color: #667eea;
}

.stats-number {
    font-size: 20px;
    font-weight: 700;
    color: #333;
    margin-bottom: 3px;
}

.stats-desc {
    font-size: 11px;
    color: #666;
}

.history-card {
    grid-column: 1 / -1;
    margin-top: 20px;
}

.history-header {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    color: #333;
    padding: 15px 20px;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
}

.history-content {
    padding: 15px 20px;
    max-height: 200px;
    overflow-y: auto;
}

.history-item {
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
}

.history-item:last-child {
    border-bottom: none;
}

.history-info {
    flex: 1;
    color: #666;
}

.history-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 500;
}

.notice-text {
    text-align: center;
    color: #999;
    font-size: 11px;
    margin-top: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
}

@media (max-width: 768px) {
    .ranking-section {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-cell {
        border-right: none;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .checkin-stats-compact {
        gap: 20px;
    }
    
    .checkin-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-checkin, .btn-share {
        width: 200px;
    }
}

.img-circle{width: 15%!important;}
</style>

<div class="compact-checkin">
    <div class="checkin-container">
        <!-- 主签到卡片 -->
        <div class="main-checkin-card">
            <div class="checkin-header">
                <h3 class="checkin-title">
                    <i class="fa fa-check-square-o"></i> 每日签到
                </h3>
                <div class="checkin-date">
                    <i class="fa fa-calendar"></i> <?php echo date('Y年m月d日 星期'.['日','一','二','三','四','五','六'][date('w')]); ?>
                    <span style="margin-left: 15px;"><i class="fa fa-sun-o"></i> 每日签到，积少成多</span>
                </div>
                
                <div class="checkin-stats-compact">
                    <div class="stat-compact">
                        <div class="value" id="rewardcount">0.00</div>
                        <div class="label">总奖励(元)</div>
                    </div>
                    <div class="stat-compact">
                        <div class="value"><?php echo $continue; ?></div>
                        <div class="label">连续签到(天)</div>
                    </div>
                </div>
                
                <div class="checkin-actions">
                    <button type="button" class="btn-checkin" id="qiandao" <?php echo $isqiandao ? 'disabled' : ''; ?>>
                        <i class="fa fa-check-square"></i> 
                        <?php echo $isqiandao ? '今天已签到' : '立即签到'; ?>
                    </button>
                    <a href="#fxhy" data-toggle="modal" class="btn-checkin btn-share">
                        <i class="fa fa-share-alt"></i> 分享获奖
                    </a>
                </div>
            </div>
        </div>
        
        <!-- 排行榜和统计区域 -->
        <div class="ranking-section">
            <!-- 签到头像 -->
            <div class="ranking-card">
                <div class="ranking-header">
                    <i class="fa fa-trophy"></i> 签到之星
                </div>
                <div class="avatar-section">
                    <div class="avatar-group">
                        <?php
                        foreach($qqrow as $row){
                            echo $row ? '<img src="http://q4.qlogo.cn/headimg_dl?dst_uin='.$row.'&spec=100" class="avatar-item">' : '<img src="../assets/img/user.png" class="avatar-item">';
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <!-- 统计数据 -->
            <div class="ranking-card">
                <div class="ranking-header">
                    <i class="fa fa-bar-chart"></i> 统计数据
                </div>
                <div class="stats-grid">
                    <div class="stats-cell">
                        <div class="stats-icon"><i class="fa fa-user-circle-o"></i></div>
                        <div class="stats-number" id="count1">-</div>
                        <div class="stats-desc">今日签到</div>
                    </div>
                    <div class="stats-cell">
                        <div class="stats-icon"><i class="fa fa-user-circle"></i></div>
                        <div class="stats-number" id="count2">-</div>
                        <div class="stats-desc">昨日签到</div>
                    </div>
                    <div class="stats-cell">
                        <div class="stats-icon"><i class="fa fa-pie-chart"></i></div>
                        <div class="stats-number" id="count3">-</div>
                        <div class="stats-desc">累计签到</div>
                    </div>
                </div>
            </div>
            
            <!-- 签到历史 -->
            <div class="ranking-card history-card">
                <div class="history-header">
                    <i class="fa fa-history"></i> 最近签到记录
                </div>
                <div class="history-content">
                    <?php
                    foreach($qdrow as $row){
                        echo '<div class="history-item">
                                <div class="history-info">
                                    <i class="fa fa-user"></i> ZID:'.$row['zid'].' 在'.date("H:i",strtotime($row['time'])).'签到获得'.$row['reward'].'元
                                </div>
                                <div class="history-badge">连续'.$row['continue'].'天</div>
                              </div>';
                    }
                    ?>
                    <div class="notice-text">
                        <i class="fa fa-info-circle"></i> 为防止多号签到，系统采用IP绑定策略，一个IP仅能签到一次/天
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--复制广告词分享开始-->
<div class="modal fade" id="fxhy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.8;">
                    <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                </button>
                <h4 class="modal-title" style="margin: 0; font-weight: 600;">
                    <i class="fa fa-share-alt"></i> 分享网站给好友
                </h4>
            </div>
            <div class="modal-body" style="padding: 25px;">
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 600; color: #333; margin-bottom: 10px;">
                        <i class="fa fa-bullhorn"></i> 推广文案
                    </label>
                    <textarea id="fxggc" class="form-control" rows="6" readonly style="border-radius: 10px; border: 2px solid #f0f0f0;">网站 <?php echo $conf['sitename'] ?>

网课全网最低价，最具性价比。
网址:<?php echo $turl?>

建议收藏网站可天天领取</textarea>
                </div>
                
                <button data-clipboard-target="#fxggc" class="btn btn-block fenx" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border: none; color: white; padding: 12px; border-radius: 10px; font-weight: 600;">
                    <i class="fa fa-copy"></i> 一键复制分享语
                </button>
                
                <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-top: 15px; text-align: center; color: #666;">
                    <i class="fa fa-gift"></i> 将网站分享给你的好友，有机会获取网课免单或余额奖励！
                </div>
            </div>
        </div>
    </div>
</div>      
<!--复制广告词分享结束-->

<?php include './foot.php';?>
<script src="<?php echo $cdnserver?>assets/js/clipboard-1.7.1.min.js"></script>
<script>
var clipboard = new Clipboard('.fenx');
clipboard.on('success', function(e) {
  	layer.msg("复制成功,快去分享给朋友吧！", {icon: 1});
});
clipboard.on('error', function(e) {
     layer.msg("复制失败，请长按链接后手动复制", {icon: 2});
});	

$(document).ready(function(){
    // 添加进入动画
    $('.main-checkin-card, .ranking-card').css('opacity', '0').animate({
        opacity: 1
    }, 600);
    
	$("#qiandao").click(function(){
        if($(this).prop('disabled')) return;
        
        $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> 签到中...');
        
		$.ajax({
		 type: "get",
		 url: "ajax_user.php?act=qiandao",
		 dataType: "json",
		 success: function(data){
			if(data.code == 0){
				layer.alert(data.msg,{icon:6},function(){
					window.location.reload();
				})
			}else{
				layer.alert(data.msg,{icon:5});
                $("#qiandao").prop('disabled', false).html('<i class="fa fa-check-square"></i> 立即签到');
			}
		 },
		 error: function(){
			layer.alert('签到失败，请稍后刷新重试！');
            $("#qiandao").prop('disabled', false).html('<i class="fa fa-check-square"></i> 立即签到');
		 }
	   });
	});
    
	$.ajax({
		type : "GET",
		url : "ajax_user.php?act=qdcount",
		dataType : 'json',
		async: true,
		success : function(data) {
			$('#count1').html(data.count1);
			$('#count2').html(data.count2);
			$('#count3').html(data.count3);
			$('#rewardcount').html(data.rewardcount);
		}
	});
})
</script>
</body>
</html>