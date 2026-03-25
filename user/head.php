<?php
// 使用本地资源文件，不再依赖CDN
$cdnpublic = '../assets/';
if(!empty($conf['staticurl'])){
	$cdnserver = '//'.$conf['staticurl'].'/';
}else{
	$cdnserver = '../';
}
if($conf['ui_user']==1){
	$ui_user = array('bg-dark','bg-white-only','bg-dark');
}else{
	$ui_user = array('bg-primary','bg-primary','bg-light dker');
}

if(substr($userrow['user'],0,3)=='qq_' && !empty($userrow['nickname'])){
	$nickname = htmlspecialchars($userrow['nickname']);
}else{
	$nickname = $userrow['user'];
}
if(empty($userrow['qq']) && !empty($userrow['faceimg'])){
	$faceimg = htmlspecialchars($userrow['faceimg']);
}elseif(!empty($userrow['qq'])){
	$faceimg = '//q4.qlogo.cn/headimg_dl?dst_uin='.$userrow['qq'].'&spec=100';
}else{
	$faceimg = '../assets/img/user.png';
}

$newuserhead=null;
$newuserfoot=null;
$template_route = \lib\Template::loadRoute();
if($template_route){
	$newuserhead = $template_route['userhead'];
	$newuserfoot = $template_route['userfoot'];
	if($template_route['userindex'] && checkIfActive(',index')){
		include($template_route['userindex']);exit;
	}
}
if($newuserhead){
	include($newuserhead);
	return;
}

@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8" />
  <title><?php echo $title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link href="<?php echo $cdnserver?>assets/css/bootstrap-3.4.1.min.css" rel="stylesheet"/>
<link href="<?php echo $cdnserver?>assets/css/font-awesome-4.7.0.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="<?php echo $cdnserver?>assets/user/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $cdnserver?>assets/user/css/app.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $cdnserver?>assets/css/umodal.css" type="text/css" />
  <style>
/* 现代化侧边栏样式 */
.app-aside {
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%) !important;
    box-shadow: 2px 0 15px rgba(0,0,0,0.1);
    border-right: none;
    transition: all 0.3s ease;
}

.aside-wrap {
    position: relative;
    z-index: 2;
}

.aside-wrap::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    z-index: -1;
}

/* 导航菜单样式 */
.navi .nav > li {
    margin: 3px 15px;
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.navi .nav > li::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.6s ease;
    z-index: 1;
}

.navi .nav > li:hover::before {
    left: 100%;
}

.navi .nav > li > a {
    color: rgba(255,255,255,0.8) !important;
    padding: 12px 20px;
    border-radius: 12px;
    text-decoration: none;
    display: flex;
    align-items: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 2;
    font-weight: 500;
    backdrop-filter: blur(5px);
}

.navi .nav > li > a:hover {
    color: white !important;
    background: rgba(255,255,255,0.15) !important;
    transform: translateX(8px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.navi .nav > li.active > a,
.navi .nav > li > a:focus {
    background: rgba(255,255,255,0.2) !important;
    color: white !important;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    transform: translateX(5px);
}

/* 图标动画 */
.navi .nav > li > a > i {
    font-size: 16px;
    margin-right: 12px;
    width: 20px;
    text-align: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.navi .nav > li:hover > a > i {
    transform: scale(1.2) rotate(5deg);
    text-shadow: 0 0 10px rgba(255,255,255,0.5);
}

.navi .nav > li.active > a > i {
    transform: scale(1.1);
    color: #fff;
}

/* 文字动画 */
.navi .nav > li > a > span {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.navi .nav > li:hover > a > span {
    letter-spacing: 0.5px;
}

/* 分组标题样式 */
.navi .nav > li.padder {
    color: rgba(255,255,255,0.6) !important;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 20px 15px 10px 15px;
    padding: 0 20px;
    font-weight: 600;
    position: relative;
}

.navi .nav > li.padder::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 20px;
    right: 20px;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
}

/* 下拉菜单样式 */
.navi .nav-sub {
    background: rgba(0,0,0,0.1);
    border-radius: 8px;
    margin: 5px 0 10px 0;
    backdrop-filter: blur(5px);
    overflow: hidden;
    display: none; /* 默认隐藏 */
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 1;
}

.navi .nav > li.active .nav-sub {
    display: block; /* 活跃时显示 */
    opacity: 1;
}

.navi .nav-sub > li {
    margin: 0;
    transform: translateX(-20px);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.navi .nav > li.active .nav-sub > li {
    transform: translateX(0);
    opacity: 1;
}

.navi .nav > li.active .nav-sub > li:nth-child(1) { transition-delay: 0.1s; }
.navi .nav > li.active .nav-sub > li:nth-child(2) { transition-delay: 0.15s; }
.navi .nav > li.active .nav-sub > li:nth-child(3) { transition-delay: 0.2s; }
.navi .nav > li.active .nav-sub > li:nth-child(4) { transition-delay: 0.25s; }

.navi .nav-sub > li > a {
    color: rgba(255,255,255,0.7) !important;
    padding: 8px 20px 8px 45px;
    font-size: 13px;
    transition: all 0.3s ease;
    position: relative;
}

.navi .nav-sub > li > a::before {
    content: '';
    position: absolute;
    left: 30px;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 4px;
    background: rgba(255,255,255,0.5);
    border-radius: 50%;
    transition: all 0.3s ease;
}

.navi .nav-sub > li > a:hover {
    color: white !important;
    background: rgba(255,255,255,0.1) !important;
    padding-left: 50px;
}

.navi .nav-sub > li > a:hover::before {
    transform: translateY(-50%) scale(1.5);
    background: white;
    box-shadow: 0 0 8px rgba(255,255,255,0.5);
}

.navi .nav-sub > li.active > a {
    color: white !important;
    background: rgba(255,255,255,0.15) !important;
}

/* 展开箭头动画 */
.navi .nav > li > a .fa-angle-right {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 1;
    display: inline-block;
}

.navi .nav > li > a .fa-angle-down {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    position: absolute;
    right: 20px;
    display: none;
}

.navi .nav > li.active > a .fa-angle-right {
    opacity: 0;
    transform: rotate(90deg);
    display: none;
}

.navi .nav > li.active > a .fa-angle-down {
    opacity: 1;
    transform: rotate(0deg);
    display: inline-block;
}

/* 滚动条样式 */
.aside-wrap::-webkit-scrollbar {
    width: 4px;
}

.aside-wrap::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.1);
}

.aside-wrap::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 2px;
}

.aside-wrap::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.5);
}

/* 特殊菜单项样式 */
.navi .nav > li:last-child {
    margin-top: auto;
    margin-bottom: 20px;
}

.navi .nav > li:last-child > a {
    background: rgba(220, 53, 69, 0.2) !important;
    border: 1px solid rgba(220, 53, 69, 0.3);
}

.navi .nav > li:last-child:hover > a {
    background: rgba(220, 53, 69, 0.3) !important;
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
}

/* 入场动画 */
@keyframes slideInFromLeft {
    0% {
        opacity: 0;
        transform: translateX(-30px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

.navi .nav > li {
    animation: slideInFromLeft 0.6s ease forwards;
    opacity: 0;
}

.navi .nav > li:nth-child(1) { animation-delay: 0.02s; }
.navi .nav > li:nth-child(2) { animation-delay: 0.04s; }
.navi .nav > li:nth-child(3) { animation-delay: 0.06s; }
.navi .nav > li:nth-child(4) { animation-delay: 0.08s; }
.navi .nav > li:nth-child(5) { animation-delay: 0.1s; }
.navi .nav > li:nth-child(6) { animation-delay: 0.12s; }
.navi .nav > li:nth-child(7) { animation-delay: 0.14s; }
.navi .nav > li:nth-child(8) { animation-delay: 0.16s; }
.navi .nav > li:nth-child(9) { animation-delay: 0.18s; }
.navi .nav > li:nth-child(10) { animation-delay: 0.2s; }
.navi .nav > li:nth-child(11) { animation-delay: 0.22s; }
.navi .nav > li:nth-child(12) { animation-delay: 0.24s; }

/* 脉冲动画用于活跃状态 */
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
    }
}

.navi .nav > li.active > a {
    animation: pulse 2s infinite;
}

/* 响应式调整 */
@media (max-width: 767px) {
    .app-aside {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .app-aside.show {
        transform: translateX(0);
    }
}

/* ================= 新主题覆盖：提升观感与层次 ================= */
:root {
    --u-primary: #667eea;
    --u-secondary: #9f7aea;
    --u-accent: #4fd1c5;
    --u-danger: #f56565;
    --u-warning: #ed8936;
    --u-success: #48bb78;
    --u-bg: #f3f6fb;
    --u-card: rgba(255,255,255,0.86);
    --u-border: rgba(99, 110, 114, 0.12);
    --u-shadow: 0 10px 30px rgba(31, 38, 135, 0.12);
}

body {
    background: linear-gradient(180deg, #eef2ff 0%, #f7fafc 60%, #ffffff 100%);
}

.app-header.navbar {
    background: linear-gradient(90deg, var(--u-primary) 0%, var(--u-secondary) 60%, #b794f4 100%) !important;
    border: none;
    box-shadow: 0 6px 18px rgba(102, 126, 234, 0.25);
}

/* Layer 弹窗关闭按钮适配（确保 X 显示）*/
.layui-layer-title { padding-right: 42px; }
.layui-layer-setwin .layui-layer-close { display: inline-block !important; opacity: 1 !important; }
.layui-layer-setwin .layui-layer-max, .layui-layer-setwin .layui-layer-min { display: none !important; }

.app-content-body {
    background: transparent;
    padding: 16px 24px 32px;
}

/* 顶部面包屑包装成卡片 */
.wrapper-sm {
    background: var(--u-card);
    backdrop-filter: saturate(140%) blur(6px);
    border: 1px solid var(--u-border);
    border-radius: 14px;
    box-shadow: var(--u-shadow);
    margin: 8px 0 16px 0;
    padding: 8px 16px !important;
}
.breadcrumb > li + li:before { color: #a0aec0; }
.breadcrumb a { color: #4a5568; text-decoration: none; }
.breadcrumb a:hover { color: var(--u-primary); text-decoration: none; }

/* 卡片/面板/区块统一视觉 */
.panel, .block, .widget, .panel-default, .panel-body, .table-responsive {
    background: var(--u-card) !important;
    border: 1px solid var(--u-border) !important;
    border-radius: 14px !important;
    box-shadow: var(--u-shadow);
}
.panel-heading, .block-title, .widget-content.themmed-background-flat, .panel-default>.panel-heading {
    background: linear-gradient(90deg, rgba(102,126,234,.12), rgba(159,122,234,.12)) !important;
    border: none !important;
    color: #2d3748 !important;
    border-top-left-radius: 14px !important;
    border-top-right-radius: 14px !important;
}

/* 表单与输入控件 */
.form-control {
    border-radius: 12px;
    border: 1px solid var(--u-border);
    box-shadow: none;
    transition: all .2s ease;
}
.form-control:focus {
    border-color: rgba(102,126,234,.45);
    box-shadow: 0 0 0 3px rgba(102,126,234,.15);
}

/* 按钮渐变与悬浮态 */
.btn { border-radius: 12px; border: none; transition: transform .15s ease, box-shadow .15s ease; }
.btn:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(0,0,0,.08); }
.btn:active { transform: translateY(0); box-shadow: none; }
.btn-primary, .btn-info, .btn-success, .btn-warning, .btn-danger, .btn-default {
    color: #fff !important;
}
.btn-primary { background: linear-gradient(135deg, var(--u-primary), #5a67d8); }
.btn-info    { background: linear-gradient(135deg, #63b3ed, #4299e1); }
.btn-success { background: linear-gradient(135deg, var(--u-success), #38a169); }
.btn-warning { background: linear-gradient(135deg, var(--u-warning), #dd6b20); }
.btn-danger  { background: linear-gradient(135deg, var(--u-danger), #e53e3e); }
.btn-default { background: linear-gradient(135deg, #a0aec0, #718096); }

/* 表格圆角与悬浮 */
.table { border-collapse: separate; border-spacing: 0; overflow: hidden; border-radius: 12px; }
.table > thead > tr > th { background: rgba(102,126,234,.06); border-bottom: 1px solid var(--u-border); }
.table > tbody > tr:hover { background: rgba(159,122,234,.06); }

/* 小徽章/标签 */
.label, .badge { border-radius: 999px; padding: 6px 10px; }

/* 小组件区间距更柔和 */
.panel, .block { margin-bottom: 18px; }

/* 卡片内分隔线更轻 */
.panel-body hr, .block hr { border-top: 1px dashed var(--u-border); }

/* 快捷操作卡片（图标型按钮容器常见于首页）*/
.quick-actions .btn, .quick-actions .panel {
    backdrop-filter: saturate(140%) blur(6px);
}
/* 统一页面主容器最大宽度，避免左右留白不一致 */
.dashboard-container {
    max-width: 1280px;
    margin: 0 auto;
}

/* 卡片投影与圆角统一 */
.dashboard-card, .panel, .block { border-radius: 16px !important; box-shadow: var(--u-shadow); }

/* 左侧用户卡片与右侧内容卡片的间距协调 */
.dashboard-card + .dashboard-card { margin-top: 16px; }

/* 快捷操作卡片中每项高度、对齐一致 */
.quick-actions .action-btn { display:flex; align-items:center; justify-content:center; min-height: 120px; }

/* 调整公告与信息卡片的对齐 */
.info-card .info-list { margin-top: 8px; }

/* 等高行：让同一行的列等高，避免凹凸不齐 */
.row-eq { display: flex; flex-wrap: wrap; align-items: stretch; }
.row-eq > [class^="col-"] { display: flex; }
.row-eq .dashboard-card { width: 100%; display: flex; flex-direction: column; }
.row-eq .dashboard-card > * { flex: 0 0 auto; }
.row-eq .dashboard-card .info-card, .row-eq .dashboard-card > div[style*="padding"] { flex: 1 1 auto; }

  /* 修复 layer 关闭按钮图标缺失（采用纯 CSS 渲染 ×） */
  .layui-layer-title { padding-right: 42px; }
  .layui-layer .layui-layer-setwin .layui-layer-close1,
  .layui-layer .layui-layer-setwin .layui-layer-close {
      width: 20px !important;
      height: 20px !important;
      background: none !important;
      position: relative;
  }
  .layui-layer .layui-layer-setwin .layui-layer-close1::after,
  .layui-layer .layui-layer-setwin .layui-layer-close::after {
      content: "×";
      position: absolute; left: 0; right: 0; top: 50%;
      transform: translateY(-50%);
      text-align: center; font-size: 16px; font-weight: 700; color: #666;
  }
  .layui-layer .layui-layer-setwin .layui-layer-close1:hover::after,
  .layui-layer .layui-layer-setwin .layui-layer-close:hover::after { color: #333; }

  </style>
  <!--[if lt IE 9]>
    <script src="<?php echo $cdnserver?>assets/js/html5shiv.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<?php if($islogin2==1){
if($userrow['status']==0){
	sysmsg('你的账号已被封禁！',true);exit;
}elseif($userrow['power']>0 && $conf['fenzhan_expiry']>0 && $userrow['endtime']<$date){
	sysmsg('你的账号已到期，请联系管理员续费！',true);exit;
}
?>
<div class="app app-header-fixed  ">
  <header id="header" class="app-header navbar ng-scope" role="menu">
      <div class="navbar-header <?php echo $ui_user[0]?>">
        <button class="pull-right visible-xs" ui-toggle="off-screen" target=".app-aside" ui-scroll="app">
          <i class="glyphicon glyphicon-align-justify"></i>
        </button>
        <a href="./" class="navbar-brand text-lt">
          <i class="fa fa-desktop hidden-xs"></i>
          <span class="hidden-folded m-l-xs">系统管理中心</span>
        </a>
      </div>

      <div class="collapse pos-rlt navbar-collapse box-shadow <?php echo $ui_user[1]?>">
        <!-- buttons -->
        <div class="nav navbar-nav hidden-xs">
          <a href="#" class="btn no-shadow navbar-btn" ui-toggle="app-aside-folded" target=".app">
            <i class="fa fa-dedent fa-fw text"> 菜单</i>
            <i class="fa fa-indent fa-fw text-active">菜单</i>
          </a>
        </div>
        <!-- / buttons -->

        <!-- nabar right -->
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
              <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                <img src="<?php echo $faceimg ?>">
                <i class="on md b-white bottom"></i>
              </span>
              <span class="hidden-sm hidden-md"><?php echo $nickname ?></span> <b class="caret"></b>
            </a>
            <!-- dropdown -->
            <ul class="dropdown-menu animated fadeInRight w">
              <li>
                <a href="./">
                  <span>用户中心</span>
                </a>
              </li>
              <li>
                <a href="./uset.php?mod=user">
                  <span>修改资料</span>
                </a>
              </li>
			  <li>
                <a href="../">
                  <span>返回首页</span>
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a ui-sref="access.signin" href="login.php?logout">退出登录</a>
              </li>
            </ul>
            <!-- / dropdown -->
          </li>
        </ul>
        <!-- / navbar right -->
      </div>
      <!-- / navbar collapse -->
  </header>
  <!-- / header -->
  <!-- aside -->
  <aside id="aside" class="app-aside hidden-xs <?php echo $ui_user[2]?>">
      <div class="aside-wrap">
        <div class="navi-wrap">

          <!-- nav -->
          <nav ui-nav class="navi">
            <ul class="nav">
              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>导航</span>
              </li>
              <li class="<?php echo checkIfActive(',index')?>">
                <a href="./">
                  <i class="fa fa-user"></i>
                  <span>用户中心</span>
                </a>
              </li>
			  <li class="">
                <a href="../">
                  <i class="fa fa-home"></i>
                  <span>返回首页</span>
                </a>
              </li>
              <li class="<?php echo checkIfActive('shop')?>">
                <a href="<?php echo $userrow['power']>0?'./shop.php':'../'?>">                      
                  <i class="fa fa-cart-plus"></i>
                  <span>自助下单</span>
                </a>
              </li>
              <li class="<?php echo checkIfActive('yiban')?>">
                <a href="./yiban.php">                      
                  <i class="fa fa-money"></i>
                  <span>易班网薪下单</span>
                </a>
              </li>
			  <?php if($conf['openbatchorder']==1){?><li class="<?php echo checkIfActive('shops')?>">
                <a href="./shops.php">                      
                  <i class="fa fa-clone"></i>
                  <span>批量下单</span>
                </a>
              </li><?php }?>
			  <?php if($conf['workorder_open']==1){?>
			  <li class="<?php echo checkIfActive('workorder')?>">
                <a href="./workorder.php">
                  <i class="fa fa-check-square-o"></i>
                  <span>我的工单</span>
                </a>
              </li>
			  <?php }?>
			  <?php if($userrow['power']==0&&!empty($conf['appurl'])){?>
			  <li class="">
                <a href="<?php echo $conf['appurl']?>">
                  <i class="fa fa-cloud-download"></i>
                  <span>APP下载</span>
                </a>
              </li>
			  <?php }?>
			  <?php if($userrow['power']>0){?>
			  <li class="<?php echo checkIfActive('classlist,shoplist,sitelist,userlist')?>">
                <a href class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="fa fa-codepen"></i>
                  <span>网站管理</span>
                </a>
                <ul class="nav nav-sub dk">
				  <li class="<?php echo checkIfActive('classlist')?>">
                    <a href="./classlist.php">
                      <span>分类管理</span>
                    </a>
                  </li> 
                  <li class="<?php echo checkIfActive('shoplist')?>">
                    <a href="./shoplist.php">
                      <span>商品管理</span>
                    </a>
                  </li>
				  <?php if($userrow['power']==2){?>
                  <li class="<?php echo checkIfActive('sitelist')?>">
                    <a href="./sitelist.php">
                      <span>分站列表</span>
                    </a>
                  </li><?php }?>
                  <li class="<?php echo checkIfActive('userlist')?>">
                    <a href="./userlist.php">
                      <span>用户列表</span>
                    </a>
                  </li>
                </ul>
              </li>
			  <?php }?>
			  <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>查询</span>
              </li>              
              <li class="<?php echo checkIfActive('list')?>">
                <a href="<?php echo $userrow['power']>0?'./list.php':'../?chadan=1'?>">  
                  <i class="fa fa-list"></i>
                  <span>订单查询</span>
                </a>
              </li>
              <li class="<?php echo checkIfActive('record')?>">
                <a href="./record.php">                      
                  <i class="fa fa-hashtag"></i>
                  <span>收支明细</span>
                </a>
              </li>
			  <?php if($userrow['power']>0 && $conf['fenzhan_rank']==1){?>
              <li class="<?php echo checkIfActive('rank')?>">
                <a href="./rank.php">                      
                  <i class="fa fa-line-chart"></i>
                  <span>分站排行</span>
                </a>
              </li>
			  <?php }?>
              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">          
                <span>其他</span>
              </li>
              <li class="<?php echo checkIfActive('uset')?>">
                <a href class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="fa fa-resistance"></i>
                  <span>系统设置</span>
                </a>
                <ul class="nav nav-sub dk">
				  <li class="<?php echo checkIfActive('user')?>">
                    <a href="./uset.php?mod=user">
                      <span>用户资料设置</span>
                    </a>
                  </li> 
			  <?php if($userrow['power']>0){?>
                  <li class="<?php echo checkIfActive('site')?>">
                    <a href="./uset.php?mod=site">
                      <span>网站信息设置</span>
                    </a>
                  </li>
				  <?php if($conf['fenzhan_edithtml']==1){?>
                  <li class="<?php echo checkIfActive('logo')?>">
                    <a href="./uset.php?mod=logo">
                      <span>网站Logo设置</span>
                    </a>
                  </li>
				  <?php }?>
                  <li class="<?php echo checkIfActive('skimg')?>">
                    <a href="./uset.php?mod=skimg">
                      <span>收款图设置</span>
                    </a>
                  </li>
			  <?php }?>
                </ul>
              </li>
              <li class="<?php echo checkIfActive('message')?>">
                <a href="./message.php">
                  <i class="fa fa-bullhorn"></i>
                  <span>消息通知</span>
                </a>
              </li>
			  <?php if($userrow['power']>0){?>
              <li class="<?php echo checkIfActive('faq')?>">
                <a href="./faq.php">
                  <i class="fa fa-exclamation-circle"></i>
                  <span>常见问题</span>
                </a>
              </li>
			  <?php }?>
              <li>
                <a ui-sref="access.signin" href="login.php?logout">
                  <i class="fa fa-power-off"></i>
                  <span>退出登录</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
  </aside>
<div id="content" class="app-content" role="main">
    <div class="app-content-body ">
				<div class="bg-light lter b-b wrapper-sm ng-scope">
					<ul class="breadcrumb" style="padding: 0;margin: 0;">
						<li><i class="fa fa-home"></i><a href="./">管理中心</a></li>
						<li><?php echo $title ?></li>
					</ul>
				</div>
  <!-- / aside -->
<?php }?>
