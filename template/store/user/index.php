<?php
if (!defined('IN_CRONLITE')) die();
@header('Content-Type: text/html; charset=UTF-8');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no"/>
    <title>会员中心-<?php echo $conf['sitename']; ?></title>
    <meta name="keywords" content="<?php echo $conf['keywords'] ?>">
    <meta name="description" content="<?php echo $conf['description'] ?>">
    <link rel="shortcut icon" href="<?php echo $conf['default_ico_url'] ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>/assets/store/css/foxui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>/assets/store/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>/assets/store/css/iconfont.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>/assets/css/hiddenTollCenter.css">
    <link href="<?php echo $cdnserver; ?>assets/css/font-awesome-4.7.0.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo $cdnserver; ?>assets/css/toastr.min.css">
    <link rel="stylesheet" href="<?php echo $cdnserver; ?>assets/css/notificationStyle_2.css" type="text/css" />

    <script src="<?php echo $cdnserver; ?>assets/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo $cdnserver; ?>assets/js/layer-2.3.js"></script>
</head>
<style>
body {
    width: 100%;
    max-width: 650px;
    margin: auto;
    background: #f3f3f3;
    line-height: 24px;
    font: 14px Helvetica Neue,Helvetica,PingFang SC,Tahoma,Arial,sans-serif;
}
/* 主题变量与暗色模式（尽可能少地覆盖） */
:root{--bg:#f3f3f3;--card:#fff;--text:#333;--muted:#666}
body{background:var(--bg)}
.fui-cell-group,.more-services,.notice-section{background:var(--card)}
.theme-dark{--bg:#0f172a;--card:#121a2b;--text:#e5e7eb;--muted:#a1a1aa}
.theme-dark body{background:var(--bg)}
.theme-dark .fui-page,.theme-dark .fui-content{background:var(--bg)!important}
.theme-dark .fui-cell-group,.theme-dark .more-services,.theme-dark .notice-section{background:var(--card);box-shadow:0 0 0 1px rgba(148,163,184,.15) inset}
.theme-dark .fui-cell-text,.theme-dark .title,.theme-dark .more-services-title,.theme-dark .notice-text{color:var(--text)}
.theme-dark .fui-cell-remark,.theme-dark .notice-date{color:var(--muted)}

.label{
    color: unset;
    line-height: 1.8;
}
.account-main{
    height: 100% !important;
}
a {
    text-decoration:none;
}
a:hover{
    text-decoration:none;
}

/*按钮1*/
.button-simple {
    background-color: #4CAF50; /* 绿色背景 */
    border: none; /* 无边框 */
    color: white; /* 白色文字 */
    padding: 6px 14px; /* 内边距 */
    text-align: center; /* 文字居中 */
    text-decoration: none; /* 无下划线 */
    display: inline-block; /* 行内块元素 */
    font-size: 12px; /* 字体大小 */
    margin: 4px 2px; /* 外边距 */
    cursor: pointer; /* 鼠标指针样式 */
    border-radius: 8px; /* 圆角 */
    transition: background-color 0.3s ease; /* 背景色过渡效果 */
}

.button-simple:hover {
    background-color: #45a049; /* 鼠标悬停时的背景色 */
}

/*按钮2*/
.button-gradient {
    background: linear-gradient(45deg, #FF7E5F, #FEB47B); /* 渐变背景 */
    border: none; /* 无边框 */
    color: white; /* 白色文字 */
    padding: 6px 14px; /* 内边距 */
    text-align: center; /* 文字居中 */
    text-decoration: none; /* 无下划线 */
    display: inline-block; /* 行内块元素 */
    font-size: 20px; /* 字体大小 */
    margin: 4px 2px; /* 外边距 */
    cursor: pointer; /* 鼠标指针样式 */
    border-radius: 8px; /* 圆角 */
    transition: background 0.3s ease; /* 背景过渡效果 */
}

.button-gradient:hover {
    background: linear-gradient(45deg, #FEB47B, #FF7E5F); /* 鼠标悬停时的渐变背景 */
}


/*按钮3*/
.button-3d {
    background-color: #008CBA; /* 蓝色背景 */
    border: none; /* 无边框 */
    color: white; /* 白色文字 */
    padding: 6px 14px; /* 内边距 */
    text-align: center; /* 文字居中 */
    text-decoration: none; /* 无下划线 */
    display: inline-block; /* 行内块元素 */
    font-size: 12px; /* 字体大小 */
    margin: 4px 2px; /* 外边距 */
    cursor: pointer; /* 鼠标指针样式 */
    border-radius: 8px; /* 圆角 */
    box-shadow: 0 5px #007B9E; /* 阴影效果 */
    transition: all 0.3s ease; /* 所有属性过渡效果 */
}

.button-3d:hover {
    background-color: #007B9E; /* 鼠标悬停时的背景色 */
    box-shadow: 0 3px #005F6B; /* 鼠标悬停时的阴影效果 */
    transform: translateY(2px); /* 按钮下移 */
}


/*按钮3*/
.button-stars {
    background: radial-gradient(circle, #1a1a1a, #000); /* 星空背景 */
    border: 2px solid #00ffcc; /* 边框 */
    color: #00ffcc; /* 文字颜色 */
    padding: 20px 40px; /* 内边距 */
    font-size: 18px; /* 字体大小 */
    cursor: pointer; /* 鼠标指针样式 */
    border-radius: 10px; /* 圆角 */
    position: relative; /* 相对定位 */
    overflow: hidden; /* 溢出隐藏 */
    transition: all 0.5s ease; /* 所有属性过渡效果 */
}

.button-stars::before {
    content: '★'; /* 星星 */
    position: absolute; /* 绝对定位 */
    top: -20px;
    left: 10%;
    font-size: 24px;
    color: rgba(255, 255, 255, 0.5);
    animation: star 3s infinite linear; /* 星星动画 */
}

.button-stars::after {
    content: '★'; /* 星星 */
    position: absolute; /* 绝对定位 */
    top: -20px;
    left: 80%;
    font-size: 24px;
    color: rgba(255, 255, 255, 0.5);
    animation: star 4s infinite linear; /* 星星动画 */
}

@keyframes star {
    0% {
        transform: translateY(0) rotate(0); /* 初始位置 */
    }
    100% {
        transform: translateY(200px) rotate(360deg); /* 星星下落 */
    }
}

.button-stars:hover {
    transform: scale(1.1); /* 鼠标悬停时的缩放效果 */
    box-shadow: 0 0 20px rgba(0, 255, 204, 0.8); /* 光晕效果 */
}
/*标签*/
.tag {
  display: inline-block;
  padding: 8px 16px;
  background: linear-gradient(45deg, #ff416c, #ff4b2b);
  color: #fff;
  font-size: 16px;
  font-weight: bold;
  border-radius: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  position: relative;
  overflow: hidden;
  /* 标签自身的脉动动画 */
  animation: pulse 3s ease-in-out infinite;
}
/* 闪光效果的伪元素 */
.tag::before {
  content: "";
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.2);
  transform: skewX(-20deg);
  /* 闪光动画 */
  animation: shine 3s linear infinite;
}
/* 定义闪光动画：从左侧划过标签 */
@keyframes shine {
  0% {
	left: -100%;
  }
  50% {
	left: 100%;
  }
  100% {
	left: -100%;
  }
}
/* 定义脉动动画：轻微放大再恢复 */
@keyframes pulse {
  0%, 100% {
	transform: scale(1);
  }
  50% {
	transform: scale(1.05);
  }
}

/* 订单分类滚动容器 */
.order-categories {
    position: relative;
    margin: 10px 0;
    padding: 10px 0;
}

.scroll-tip {
    position: absolute;
    right: 10px;
    top: -20px;
    font-size: 12px;
    color: #999;
    background: rgba(0, 0, 0, 0.05);
    padding: 2px 8px;
    border-radius: 10px;
    display: flex;
    align-items: center;
}

.scroll-tip i {
    margin-left: 3px;
    font-size: 14px;
}

.fui-icon-group.selecter {
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
    padding: 10px 0;
}

.fui-icon-group.selecter::-webkit-scrollbar {
    display: none;
}

.fui-icon-group.selecter .fui-icon-col {
    width: 20%;
    min-width: 80px;
    float: none;
    display: inline-block;
    vertical-align: top;
}

/* 横向滚动两侧渐隐提示 */
.order-categories .fade-edge{position:absolute;top:0;bottom:0;width:20px;pointer-events:none}
.order-categories .fade-left{left:0;background:linear-gradient(90deg,#fff,rgba(255,255,255,0))}
.order-categories .fade-right{right:0;background:linear-gradient(270deg,#fff,rgba(255,255,255,0))}

/* 新增状态图标样式 */
.icon-daikaoshi:before {
    content: "\e6c9"; /* 使用一个合适的图标编码 */
    color: #9333ea;
}

.icon-pingshifen:before {
    content: "\e6b5"; /* 使用一个合适的图标编码 */
    color: #8b4513;
}

.icon-purple {
    background: rgba(147, 51, 234, 0.1) !important;
}

.icon-brown {
    background: rgba(139, 69, 19, 0.1) !important;
}

/* 更多服务区域样式 */
.more-services {
    margin: 15px;
    padding: 15px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.more-services-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.more-services-title:before {
    content: "";
    width: 4px;
    height: 16px;
    background: linear-gradient(45deg, #FF7E5F, #FEB47B);
    margin-right: 8px;
    border-radius: 2px;
}

.service-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.service-button {
    flex: 1;
    min-width: 120px;
    padding: 10px 15px;
    text-align: center;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.service-button.app-download {
    background: linear-gradient(45deg, #FF7E5F, #FEB47B);
    color: white;
}

.service-button.forum {
    background: linear-gradient(45deg, #36D1DC, #5B86E5);
    color: white;
}

.service-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* 骨架屏（今日收益、徽章等加载前） */
.skeleton{position:relative;color:transparent !important;background:linear-gradient(90deg,#f1f5f9 25%,#e5e7eb 37%,#f1f5f9 63%);background-size:400% 100%;animation:shimmer 1.2s ease-in-out infinite;border-radius:6px}
@keyframes shimmer{0%{background-position:100% 0}100%{background-position:0 0}}

/* 顶部头图滚动联动（收缩效果） */
.member-page .cover-img{transition:transform .25s ease,opacity .25s ease}
.member-page.shrink .cover-img{transform:scale(1.05) translateY(-8px);opacity:.85}

/* 渐显动画（安全默认：可见） */
.reveal{opacity:1;transform:none;transition:opacity .35s ease,transform .35s ease}
.reveal.show{opacity:1;transform:none}

/* 悬浮快捷菜单（Speed Dial） */
.fab{position:fixed;right:18px;bottom:90px;z-index:9999}
.fab-main{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#667eea,#5b6ef7);color:#fff;border:none;box-shadow:0 10px 20px rgba(17,24,39,.2);display:flex;align-items:center;justify-content:center;font-size:22px}
.fab-menu{position:absolute;right:0;bottom:64px;display:flex;flex-direction:column;gap:10px;pointer-events:none}
.fab.open .fab-menu{pointer-events:auto}
.fab-item{display:flex;align-items:center;gap:8px;transform:translateY(10px);opacity:0;transition:transform .2s ease,opacity .2s ease}
.fab.open .fab-item{transform:none;opacity:1}
.fab-chip{padding:6px 10px;border-radius:999px;background:#fff;color:#374151;box-shadow:0 6px 14px rgba(17,24,39,.12);font-size:12px}
.fab-btn{width:44px;height:44px;border-radius:50%;border:none;background:#fff;box-shadow:0 6px 14px rgba(17,24,39,.12);display:flex;align-items:center;justify-content:center}

/* 回到顶部按钮 */
#scrollTop{position:fixed;right:20px;bottom:148px;width:40px;height:40px;border-radius:50%;border:none;background:#fff;box-shadow:0 6px 14px rgba(17,24,39,.12);display:none;align-items:center;justify-content:center;z-index:9998}

/* 代理数据统计区域样式 */
.data-center {
    margin: 15px;
    padding: 15px;
    background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
    border-radius: 12px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.data-center-title {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    font-size: 16px;
    font-weight: 600;
}

.data-center-title .new-tag {
    background: #FF4B2B;
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 12px;
    margin-right: 8px;
}

.data-center-content {
    padding: 10px;
    background: rgba(255,255,255,0.1);
    border-radius: 8px;
    backdrop-filter: blur(5px);
}

.data-center:before {
    content: "";
    position: absolute;
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    top: -75px;
    right: -75px;
    border-radius: 50%;
}

.data-center:after {
    content: "";
    position: absolute;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    bottom: -50px;
    left: -50px;
    border-radius: 50%;
}

@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
    100% { transform: translateY(0px); }
}

.floating {
    animation: float 3s ease-in-out infinite;
}

/* 代理数据中心的补充样式 */
.quick-stats {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px;
    background: rgba(255,255,255,0.1);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: rgba(255,255,255,0.2);
}

.stat-item i {
    font-size: 18px;
    width: 24px;
    text-align: center;
}

.stat-item span {
    flex: 1;
}

.stat-item .button-simple,
.stat-item .button-3d {
    padding: 4px 8px;
    font-size: 12px;
    margin: 0;
}

/* 公告区域样式 */
.notice-section {
    margin: 15px;
    padding: 15px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.notice-content {
    margin-top: 15px;
}

.notice-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 10px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.notice-date {
    color: #666;
    font-size: 0.9em;
    white-space: nowrap;
}

.notice-text {
    flex: 1;
    line-height: 1.5;
}

/* 添加按钮波纹效果 */
.service-button, .button-simple, .button-3d, .fui-cell, .fui-icon-group .fui-icon-col {
    position: relative;
    overflow: hidden;
}

.ripple {
    position: absolute;
    background: rgba(255,255,255,0.3);
    border-radius: 50%;
    transform: scale(0);
    animation: ripple 0.6s linear;
    pointer-events: none;
}

/* 列表项按压反馈 */
.fui-cell:active{background:rgba(0,0,0,.03)}
.theme-dark .fui-cell:active{background:rgba(255,255,255,.04)}

/* 图标卡片微交互 */
.fui-icon-group .fui-icon-col{transition:transform .15s ease}
.fui-icon-group .fui-icon-col:active{transform:scale(.98)}

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
</style>
<body>
<div id="body">


<div class="fui-page  fui-page-current" style="max-width: 650px;left: auto;">
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back" onclick="goback();"></a>
        </div>
        <div class="title">会员中心</div>
        <div class="fui-header-right">
          <a id="themeToggle" href="javascript:void(0)" class="external" style="padding:0 .6rem;opacity:.8">🌓</a>
        </div>
    </div>

    <div class="fui-content member-page navbar" style="">
    <?php 
if($islogin2==1){
    if($userrow['status']==0){
        sysmsg('你的账号已被封禁！',true);exit;
    }elseif($userrow['power']>0 && $conf['fenzhan_expiry']>0 && $userrow['endtime']<$date){
        //sysmsg('你的账号已到期，请联系管理员续费！',true);exit;
        echo '<script>layer.msg("您的账号已到期，请联系管理员续费！")</script>';
    }
}else{
    exit("<script language='javascript'>window.location.href='./login.php';</script>");
}
?>
        <div style="overflow: hidden;height: 9rem;position: relative;background: #fff">
            <div class="headinfo" style="z-index:100;border: none;">
                <a class="setbtn" href="uset.php?mod=user"><i class="icon icon-shezhi"></i></a>
                <div class="child">
                    <a href="javascript:;">
                        <div class="title">余额</div>
                        <div class="num"><?php echo $userrow['rmb']?></div>
                    </a>
                    <a href="recharge.php">
                        <div class="btn">充值</div>
                    </a>              
                </div>
                <div class="child userinfo">
                    <a href="javascript:;" style="color: white;">
                        <div class="face"><img src="<?php echo $faceimg ?>"></div>
                        <div class="name"><?php echo $nickname?></div>
                        <div class="uid">UID:<?php echo $userrow['zid']?></div>
                    </a>
                    <div class="level">
                        <?php if($userrow['power'] == 2){ ?>
                            <font color="orange">[高级代理]</font>
                        <?php }else if($userrow['power'] == 1){ ?>
                            <font color="orange">[普通代理]</font>
                        <?php }else{ ?>
                            [普通会员]
                        <?php } ?>
                        
                    </div>
                </div>
                <div class="child">
                    <a href="record.php">
                        <div class="title">今日收益</div>
                        <div class="num" id="income_today"></div>
                    </a>
                    <?php if($userrow['power'] > 0){ ?>
                    <a href="tixian.php" class="external">
                        <div class="btn">提现</div>
                    </a>
                    <?php }else{ ?>
                    <a href="javascript:layer.msg('暂无提现权限');" class="external">
                        <div class="btn">提现</div>
                    </a>
                    <?php } ?>
                </div>
            </div>

            <div class="member_header" style="background: #ff5555;">
                
            </div>
            <img class="cover-img" src="../assets/store/picture/cover.png">
        </div>

        <div class="fui-cell-group fui-cell-click" style="margin-top: 0">
            <a class="fui-cell external reveal" href="../?mod=query">
                <div class="fui-cell-icon"><i class="icon icon-dingdan1"></i></div>
                <div class="fui-cell-text">我的订单</div>
                <div class="fui-cell-remark" style="font-size: 0.65rem;">查看全部订单</div>
            </a>
            <div class="order-categories reveal">
                <div class="scroll-tip">
                    左右滑动查看更多 <i class="icon icon-right"></i>
                </div>
                <div class="fui-icon-group selecter">
                    <a class="fui-icon-col external" href="../?mod=query&status=1">
                        <div class="icon icon-green radius">
                            <i class="icon icon-daifukuan1"></i>
                        </div>
                        <div class="text">已完成</div>
                    </a>
                    <a class="fui-icon-col external" href="../?mod=query&status=0">
                        <div class="icon icon-orange radius">
                            <i class="icon icon-daifahuo1"></i>
                        </div>
                        <div class="text">已提取</div>
                    </a>
                    <a class="fui-icon-col external" href="../?mod=query&status=2">
                        <div class="icon icon-blue radius">
                            <i class="icon icon-daishouhuo1"></i>
                        </div>
                        <div class="text">处理中</div>
                    </a>
                    <a class="fui-icon-col external" href="../?mod=query&status=4">
                        <div class="icon icon-pink radius">
                            <i class="icon icon-daituikuan2"></i>
                        </div>
                        <div class="text">已退单</div>
                    </a>
                    <a class="fui-icon-col external before" href="../?mod=query&status=3">
                        <div class="icon icon-pink radius">
                            <i class="icon icon-xiangmuzhouqi"></i>
                        </div>
                        <div class="text">异常</div>
                    </a>
                    <a class="fui-icon-col external" href="../?mod=query&status=20">
                        <div class="icon icon-purple radius">
                            <i class="icon icon-daikaoshi"></i>
                        </div>
                        <div class="text">待考试</div>
                    </a>
                    <a class="fui-icon-col external" href="../?mod=query&status=21">
                        <div class="icon icon-brown radius">
                            <i class="icon icon-pingshifen"></i>
                        </div>
                        <div class="text">平时分</div>
                    </a>
                </div>
            </div>
        </div>
      
         
    <!--普通用户-->
    <!--<div class="modal-overlay" id="modalOverlay">-->
    <!--        <div class="modal">-->
    
    <!--            <div class="particles" id="particles">-->
    
    <!--            </div>-->
    <!--            <button class="close-modal-btn" id="closeModalBtn">&times;</button>-->
    <!--        </div>-->
    <!--    </div>-->
    <div id="isApp" class="more-services-card" style="display:none;">
        <div class="more-services">
            <div class="more-services-title">更多服务</div>
            <div class="service-buttons">
                <a href="javascript:;" onclick="openApp()" class="service-button app-download">
                    <i class="fa fa-download"></i>
                    APP下载
                </a>
                <a href="javascript:;" onclick="openForum()" class="service-button forum">
                    <i class="fa fa-comments"></i>
                    在线论坛交流
                </a>
                <a href="yiban.php" class="service-button" style="background: linear-gradient(45deg, #a8edea, #fed6e3); color: #333;">
                    <i class="fa fa-money"></i>
                    易班网薪下单
                </a>
            </div>
        </div>
    </div>


        
	<!--代理用户-->
    <div class="fui-cell-group fui-cell-click reveal">
    <?php if($userrow['power']>0){?>
           <div  style="margin-top:23px;margin-bottom:10px;text-align:center">
                <input type="checkbox" id="toggle" >
        	  <!-- 点击 label 切换复选框状态 -->
        	  <label for="toggle" class="button-stars"><font color="red">[NEW]</font>展开代理数据统计与工具中心</label>
        	  <!-- 需要显示或隐藏的内容 -->
        	  <div class="toggle-content">
        	   
        	   
        	    <div style="text-align:center;">
                 <!--快捷查单-->
                <a href="http://chake.qzcy2.top/" class="button-gradient">实时查单入口</a>
        
            
                <div style="text-align:left; padding-left : 5%">
                    <!--名称-->
                
            	 <div class="fui-according-group " style="display: block;margin-top:unset;"><font color="red">网站名称：<font color="blue"><?php echo $userrow['sitename']?></font></font></div>
            	 
            	 <!--代理升级？顶级管理下级-->
            	  <div class="fui-according-group " style="display: block;margin-top:unset;">
        			<font style="font-weight:bold" class="list-group-item">站点类型：<?php echo ($userrow['power']==2?'<font color=red>专业版</font>':'<font>普及版</font>')?>&nbsp;<?php if($conf['fenzhan_upgrade']>0 && $userrow['power']==1){echo '<a href="upsite.php" class="button-simple"> ->升级站点 <- </a>';}else{echo '<a href="./sitelist.php "> ->下级管理 <- </a>';}?></font></div>
            
            <!--//续费管理-->
                 <div class="fui-according-group " style="display: block;margin-top:unset;">
                	<div ><?php if($conf['fenzhan_expiry']>0){?>
                    <font color="red">到期时间：</font><font color="orange"><?php echo $userrow['endtime']?></font> <a href="renew.php" class="button-3d">立即续期</a>
                	<?php }?></div>
                </div>
            </div>
        	   
        	   
        	  </div>
        	    
        	    <!--公告-->
        	    <div>
        	        <div class="tag">最新公告</div>
        	        <div style="text-align:left; ">
        	           <p style="color:green; border-left : 3px solid blue;">2025/2/24 : &nbsp;</p>
        	           网站正常运行 所有项目正常运行 网站到期为自行续费的代理请联系 QQ 430742225 进行手动续费处理 <br />
        	           <p style="color:green; border-left : 3px solid blue;">2025/3/09 : &nbsp;</p>
        	           查课页面重置上线运行 采用海外远端服务器转发数据 更加安全 同时有效的防护了网站 避免渗透攻击！<br />
        	           <p style="color:green; border-left : 3px solid blue;">2025/4/06 : &nbsp;</p>
                        平台更新了消除智慧树异常弹窗的方法：主页->网课学习->智慧树异常解除 请阅读商品说明操作！
        	        </div>
        	    </div>
        	  
                	</div>
           </div>
        
        
        <!--隐藏节点结束-->
    
            <div class="fui-according-group " style="display: block;margin-top:unset;">
                <div class="fui-according expanded">
                    <div class="fui-according-header fui-cell">
                        <div class="fui-cell-icon"><i class="fa fa-codepen"></i></div>
                      
                        <span class="text">网站管理</span>
		                	
                        <span class="remark"></span>
                    </div>
                    <div class="fui-according-content" style="display: block;">
                        <div class="fui-icon-group selecter col-<?php if($userrow['power']==2){echo '5';}else{echo '3';} ?>">
                            <a class="fui-icon-col external" href="siteinfo.php">
                                <div class="icon icon-green radius">
                                    <i class="fa fa-globe" style="color: #ff6a54;"></i>
                                </div>
                                <div class="text">站点信息</div>
                            </a>
                            <a class="fui-icon-col external" href="classlist.php">
                                <div class="icon icon-orange radius">
                                    <i class="icon icon-list"></i>
                                </div>
                                <div class="text">分类管理</div>
                            </a>
                            <a class="fui-icon-col external" href="shoplist.php">
                                <div class="icon icon-blue radius">
                                    <i class="icon icon-goods"></i>
                                </div>
                                <div class="text">商品管理</div>
                            </a>
                            <?php if($userrow['power']==2){?>
                            <a class="fui-icon-col external" href="sitelist.php">
                                <div class="icon icon-pink radius"><i class="icon icon-fenxiao"></i></div>
                                <div class="text">分站列表</div>
                            </a>
                            <a class="fui-icon-col external" href="userlist.php">
                                <div class="icon icon-pink radius"><i class="fa fa-users"></i></div>
                                <div class="text">用户列表</div>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <a class="fui-cell external reveal" href="tuiguang.php">
                    <div class="fui-cell-icon"><i class="fa fa-share-alt"></i></div>
                    <div class="fui-cell-text"><p>推广文案</p></div>
                    <div class="fui-cell-remark"></div>
            </a>
			 <?php if($conf['appcreate_open']==1){?> 
			<a class="fui-cell external" href="appCreate.php">
                    <div class="fui-cell-icon"><i class="fa fa-android"></i></div>
                    <div class="fui-cell-text"><p>APP生成</p></div>
                    <div class="fui-cell-remark"></div>
            </a>
			<?php }?>
            <?php if( $conf['fenzhan_rank']==1){?>
                <a class="fui-cell external reveal" href="rank.php">
                    <div class="fui-cell-icon"><i class="fa fa-line-chart"></i></div>
                    <div class="fui-cell-text"><p>分站排行</p></div>
                    <div class="fui-cell-remark"></div>
                </a>
            <?php }?>
            <a class="fui-cell external reveal" href="list.php">
                    <div class="fui-cell-icon"><i class="fa fa-list"></i></div>
                    <div class="fui-cell-text"><p>订单管理</p></div>
                    <div class="fui-cell-remark"></div>
            </a>
    <?php }else{ ?>
        <a class="fui-cell" href="regsite.php">
            <div class="fui-cell-icon"><i class="fa fa-diamond"></i></div>
                <div class="fui-cell-text"><p>申请成为代理</p></div>
            <div class="fui-cell-remark"></div>
        </a>
    <?php } ?>
		<?php if($conf['qiandao_reward']){?>
		<a class="fui-cell external" href="qiandao.php">
				<div class="fui-cell-icon"><i class="fa fa-check-square"></i></div>
				<div class="fui-cell-text"><p>每日签到</p></div>
				<div class="fui-cell-remark"></div>
		</a>
		<?php }?>
        <a class="fui-cell external reveal" href="record.php">
                <div class="fui-cell-icon"><i class="fa fa-credit-card"></i></div>
                <div class="fui-cell-text"><p>收支明细</p></div>
                <div class="fui-cell-remark"></div>
        </a>
    </div>
<!--     <div class="fui-according-group" id="container" style="display: block;">
            <div class="fui-according expanded">
                <div class="fui-according-header">
                    <span class="text">关于</span>
                    <span class="remark"></span>
                </div>
                <div class="fui-according-content" style="display: block;">
                    <div class="content-block"><p><span style="font-size:16px;font-family:黑体">12</span></p></div>
                </div>
            </div>
            </div> -->
    

    <div class="fui-cell-group fui-cell-click">
        <a class="fui-cell reveal" href="message.php">
            <div class="fui-cell-icon"><i class="icon icon-notice"></i></div>
            <div class="fui-cell-text"><p>消息通知</p></div>
            <div class="fui-cell-remark" >
                <span class="badge tiaoshu_cont" style="display:none;"></span>
            </div>
        </a>
        <?php if($conf['workorder_open']==1){?>
        <a class="fui-cell reveal" href="workorder.php">
                <div class="fui-cell-icon"><i class="fa fa-check-square-o"></i></div>
                <div class="fui-cell-text"><p>我的工单</p></div>
                <div class="fui-cell-remark">
                    <span class="badge work_cont" style="display:none;"></span>    
                </div>
        </a>
        <?php } ?>
        <?php if($userrow['power']>0){?>
        <a class="fui-cell reveal" href="faq.php">
                <div class="fui-cell-icon"><i class="fa fa-exclamation-circle"></i></div>
                <div class="fui-cell-text"><p>常见问题</p></div>
                <div class="fui-cell-remark">           
                </div>
        </a>
        <?php } ?>
    </div>

    <div class="fui-cell-group fui-cell-click">
            <div class="fui-according-group " style="display: block;margin-top:unset;">
                <div class="fui-according">
                    <div class="fui-according-header fui-cell">
                        <div class="fui-cell-icon"><i class="fa fa-cogs"></i></div>
                        <span class="text">系统设置</span>
                        <span class="remark"></span>
                    </div>
                    <div class="fui-according-content" style="display: none;">
                        <div class="fui-icon-group selecter col-<?php if($userrow['power']>0){echo '3';}else{echo '1';}?>">
                            <a class="fui-icon-col external" href="uset.php?mod=user" >
                                <div class="icon icon-green radius">
                                    <i class="fa fa-cog"></i>
                                </div>
                                <div class="text">用户资料设置</div>
                            </a>
                            <?php if($userrow['power']>0){?>
                            <a class="fui-icon-col external" href="uset.php?mod=skimg">
                                <div class="icon icon-orange radius">
                                    <i class="icon icon-alipay"></i>
                                </div>
                                <div class="text">收款图设置</div>
                            </a>
                            <a class="fui-icon-col external" href="uset.php?mod=site">
                                <div class="icon icon-orange radius">
                                    <i class="fa fa-edit"></i>
                                </div>
                                <div class="text">网站信息设置</div>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
    </div>      
                
<!--         <div class="fui-cell-group fui-cell-click">
            <a class="fui-cell" href="">
                <div class="fui-cell-icon"><i class="icon icon-cart"></i></div>
                <div class="fui-cell-text"><p>我的购物车</p></div>
                <div class="fui-cell-remark"></div>
            </a>
            <a class="fui-cell external" href="">
                <div class="fui-cell-icon"><i class="icon icon-daituikuan2"></i></div>
                <div class="fui-cell-text"><p>收益明细</p></div>
                <div class="fui-cell-remark"></div>
            </a>
        </div> -->

        <div class="fui-cell-group fui-cell-click transparent reveal">
<!--             <a class="fui-cell external changepwd" href="">
                <div class="fui-cell-text style="text-align: center;"><p>修改密码</p></div>
            </a> -->
            <a class="fui-cell external btn-logout" href="login.php?logout">
                <div class="fui-cell-text" style="text-align: center;"><p>退出登录</p></div>
            </a>
        </div>
        <div class="footer" style="width: 100%;margin-top: 0.5rem;margin-bottom: 2.5rem;display: block;float: left;">
            <p style="text-align: center;"><span style="color: rgb(37, 36, 36); font-family: 微软雅黑, " microsoft="" font-size:="" text-align:="" background-color:="">© 版权所有 <?php echo $conf['sitename'];  ?></span></p>
        </div>
</div>

    <div class="fui-navbar reveal" style="z-index: 100000;max-width: 650px;">
        <a href="../" class="nav-item  "> <span class="icon icon-home"></span> <span class="label">首页</span> </a>
        <a href="../?mod=query" class="nav-item "> <span class="icon icon-dingdan1"></span> <span class="label">订单</span> </a>
		<a href="../?mod=cart" class="nav-item " <?php if($conf['shoppingcart']==0){?>style="display:none"<?php }?>> <span class="icon icon-cart2"></span> <span class="label">购物车</span> </a>
        <a href="../?mod=kf" class="nav-item "> <span class=" icon icon-service1"></span> <span class="label">客服</span> </a>
        <a href="./" class="nav-item active"> <span class="icon icon-person2"></span> <span class="label">会员中心</span> </a>
    </div>
</div>

<!--app下载跳转链接-->
<script src="<?php echo $cdnserver; ?>assets/js/notification_2.js" type="text/javascript"></script>
<script>
    function confirmDownload() {
        const version = 'v.2.1.0'; // 替换成你的实际版本号
        const userConfirmed = confirm(`是否下载APP？版本号：${version}`);
        if (userConfirmed) {
            // 用户点击"确定"后进行跳转下载
            window.location.href = 'http://www.qzcy3.top/appDownload/qzcyOnlineShop.apk';
        }
    }
</script>

<script>
  // 更稳健的 5+ 环境检测（HBuilderX/uni-app 等）
  function isPlusEnv(){
    var ua = (navigator.userAgent||'').toLowerCase();
    return !!(window.plus || ua.indexOf('html5plus')>-1 || ua.indexOf('uni-app')>-1 || ua.indexOf('streamapp')>-1 || ua.indexOf('hbuilder')>-1);
  }
  (function(){
    var isAppDiv = document.getElementById('isApp');
    // 先根据 UA 做一次判断，避免首屏闪烁
    if(!isPlusEnv()){
      isAppDiv.style.display = 'block';
    }
    // 监听 plusready，若为 App 则强制隐藏
    document.addEventListener('plusready', function(){
      if(window.plus){ isAppDiv.style.display = 'none'; }
    });
  })();
</script>

<script src="<?php echo $cdnserver; ?>assets/js/toastr.min.js"></script>
<script src="../assets/store/js/foxui.js"></script>
<?php  if(substr($userrow['user'],0,3)=='qq_'){ ?>
<script>
toastr.warning('<a href="uset.php?mod=user">系统检测到您为QQ快捷登陆<br/>为确保您的账号后续能够正常使用建议设置登录账号！</a>', '账号安全提醒');
</script>
<?php } ?>
<?php  if($userrow['rmb']>4){ ?>
<?php if(strlen($userrow['pwd'])<6 || is_numeric($userrow['pwd']) && strlen($userrow['pwd'])<=10 || $userrow['pwd']===$userrow['qq']){ ?>
<script>
toastr.error('<a href="uset.php?mod=user">你的密码过于简单，请不要使用较短的纯数字或自己的QQ号当做密码，以免造成资金损失！</a>', '账号安全提醒');
</script>
<?php }else if($userrow['user']===$userrow['pwd']){ ?>
<script>
toastr.error('<a href="uset.php?mod=user">你的用户名与密码相同，极易被黑客破解，请及时修改密码</a>', '账号安全提醒');
</script>
<?php } ?>
<?php } ?>
<script>

function goback()
{
        if(window.document.referrer==""||window.document.referrer==window.location.href){  
        window.location.href="/";  
    }else{  
        window.location.href=window.document.referrer;  
    } 
    // document.referrer === '' ?window.location.href = '/' :window.history.go(-1);
}
$(document).ready(function(){
	$.ajax({
		type : "GET",
		url : "ajax_user.php?act=msg",
		dataType : 'json',
		async: true,
		success : function(data) {
			if(data.code==0){
				if(data.count>0){
					$(".tiaoshu_cont").text(data.count);
					$(".tiaoshu_cont").show();

				}
				if(data.count2>0){
					$(".work_cont").text(data.count2);
					$(".work_cont").show();
				}
                var incomeEl = $("#income_today");
                if(!data.income_today){ incomeEl.addClass('skeleton').text(''); }
                else { incomeEl.removeClass('skeleton').html(data.income_today); }
			}
		}
	});

    // 主题切换（本地持久化）
    try{
      var key='store_theme_dark';
      var cls='theme-dark';
      var root=document.documentElement;
      if(localStorage.getItem(key)==='1'){ root.classList.add(cls); }
      $('#themeToggle').on('click',function(){
        root.classList.toggle(cls);
        localStorage.setItem(key, root.classList.contains(cls)?'1':'0');
      });
    }catch(e){}
});
</script>
<script>
// 渐显 reveal 触发
(function(){
  function inView(el){
    var r=el.getBoundingClientRect();
    return r.top < window.innerHeight - 40;
  }
  function scan(){
    document.querySelectorAll('.reveal').forEach(function(el){
      // 仅在进入视口时附加 show，不移除，避免闪烁/错位
      if(inView(el)) el.classList.add('show');
    });
  }
  document.addEventListener('scroll', scan, {passive:true});
  window.addEventListener('load', scan);
  setTimeout(scan, 200);
})();

// 悬浮快捷菜单 & 回到顶部
$(function(){
  var $fab=$('<div class="fab" aria-hidden="true"><button class="fab-main" aria-label="快捷操作"><i class="fa fa-plus"></i></button><div class="fab-menu"></div></div>');
  var menu=[
    {icon:'fa fa-qrcode',text:'扫码登录',href:'uset.php?mod=bind'},
    {icon:'fa fa-credit-card',text:'充值',href:'recharge.php'},
    {icon:'fa fa-comments',text:'客服',href:'../?mod=kf'}
  ];
  menu.forEach(function(m){
    var $item=$('<div class="fab-item"><span class="fab-chip">'+m.text+'</span><button class="fab-btn"><i class="'+m.icon+'"></i></button></div>');
    $item.find('.fab-btn').on('click',function(){ location.href=m.href; });
    $fab.find('.fab-menu').append($item);
  });
  $('body').append($fab);
  $fab.find('.fab-main').on('click',function(){ $fab.toggleClass('open'); });

  var $top=$('<button id="scrollTop" aria-label="回到顶部"><i class="fa fa-arrow-up"></i></button>');
  $('body').append($top);
  $(document).on('scroll',function(){
    var y=window.scrollY||document.documentElement.scrollTop; $top.toggle(y>280);
  });
  $top.on('click',function(){ window.scrollTo({top:0,behavior:'smooth'}); });
});
function openApp() {
    window.location.href = '../appDownload/';
}

function openForum() {
    window.location.href = 'https://m.qzcy2.top/';
}

// 代理数据中心点击效果
$(document).ready(function() {
    $('.data-center').click(function() {
        layer.open({
            type: 2,
            title: '代理数据统计与工具中心',
            shadeClose: true,
            shade: 0.8,
            area: ['90%', '90%'],
            content: 'agent_stats.php'
        });
    });
});

// 初始化动画效果
$(document).ready(function() {
    // 顶部头图滚动联动
    var $page=$('.member-page');
    $('.fui-content').on('scroll',function(){
        var y=this.scrollTop||0; if(y>30){$page.addClass('shrink');}else{$page.removeClass('shrink');}
    });

    // 横向滚动两侧渐隐
    var $scroller=$('.fui-icon-group.selecter');
    if($scroller.length){
        var left=$('<div class="fade-edge fade-left"></div>');
        var right=$('<div class="fade-edge fade-right"></div>');
        $scroller.parent().append(left,right);
        var update=function(){
            var el=$scroller.get(0); if(!el) return;
            left.toggle(el.scrollLeft>2);
            right.toggle(el.scrollLeft + el.clientWidth < el.scrollWidth-2);
        };
        $scroller.on('scroll',update); update();
    }

    // 添加图标闪烁效果
    $('.data-center i').each(function() {
        $(this).addClass('floating');
    });
    
    // 添加按钮点击波纹效果
    $('.service-button, .button-simple, .button-3d').click(function(e) {
        let ripple = $('<span class="ripple"></span>');
        let x = e.pageX - $(this).offset().left;
        let y = e.pageY - $(this).offset().top;
        
        ripple.css({
            top: y + 'px',
            left: x + 'px'
        });
        
        $(this).append(ripple);
        
        setTimeout(function() {
            ripple.remove();
        }, 600);
    });
});
</script>
</body>
</html>