<?php
if(!defined('IN_CRONLITE'))exit();
@header('Content-Type: text/html; charset=UTF-8');
@header('Cache-Control: no-cache, no-store, must-revalidate');
@header('Pragma: no-cache');
@header('Expires: 0');

$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$scriptpath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$scriptpath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = (is_https() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$scriptpath.'/';

$admin_cdnpublic = 0;
if($admin_cdnpublic==1){
	$cdnpublic = '//lib.baomitu.com/';
}elseif($admin_cdnpublic==2){
	$cdnpublic = 'https://cdn.bootcdn.net/ajax/libs/';
}elseif($admin_cdnpublic==4){
	$cdnpublic = '//s1.pstatp.com/cdn/expire-1-M/';
}else{
	$cdnpublic = '//cdn.staticfile.org/';
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="renderer" content="webkit"/>
  <meta name="force-rendering" content="webkit"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title><?php echo $title ?></title>
  <link href="../assets/css/bootstrap-3.4.1.min.css" rel="stylesheet"/>
  <link href="../assets/css/font-awesome-4.7.0.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../assets/appui/css/main.css">
  <link rel="stylesheet" href="../assets/appui/css/themes.css">
  <link id="theme-link" rel="stylesheet" href="<?php echo $_COOKIE['optionThemeColor']?$_COOKIE['optionThemeColor']:'../assets/appui/css/themes/amethyst-2.4.css';?>">
  <script src="../assets/js/jquery-2.1.4.min.js"></script>
  <script src="../assets/js/bootstrap-3.4.1.min.js"></script>
  <script src="../assets/appui/js/plugins.js"></script>
  <script src="../assets/appui/js/app2.js"></script>
  <!-- 交互增强需要的 flot 插件（已移除，因为文件不存在） -->
  <!-- 如需使用flot图表功能，请下载以下文件到 ../assets/js/ 目录：
       - jquery.flot.min.js
       - jquery.flot.time.min.js  
       - jquery.flot.resize.min.js
       - jquery.flot.selection.min.js
       - jquery.flot.categories.min.js
       下载地址：https://github.com/flot/flot/releases -->
  <style>
    /* Admin 现代化升级：卡片阴影、圆角与留白 */
    body{background:linear-gradient(180deg,#f6f8ff 0,#ffffff 60%,#ffffff 100%)}
    .content-header{margin:10px 0 8px}
    .header-section h1{font-weight:700;letter-spacing:.3px}
    .panel{border:1px solid rgba(17,24,39,.06);border-radius:12px;box-shadow:0 10px 30px rgba(17,24,39,.06);transition:box-shadow .18s ease,transform .18s ease}
    .panel:hover{box-shadow:0 14px 36px rgba(17,24,39,.09);transform:translateY(-2px)}
    .panel-heading{border-top-left-radius:12px;border-top-right-radius:12px}
    .block{border-radius:12px;box-shadow:0 6px 18px rgba(17,24,39,.04)}
    .navbar.navbar-inverse{background:linear-gradient(90deg,#667eea,#764ba2);border:none;box-shadow:0 6px 18px rgba(102,126,234,.25)}
    .sidebar-nav>li>a{border-radius:10px;margin:3px 10px}
    .sidebar-nav>li.active>a,.sidebar-nav>li>a:hover{background:rgba(255,255,255,.12)}
    /* 小徽章与图表容器 */
    .badge,.label{border-radius:999px;padding:.35em .6em}
    /* 仪表盘数字卡片 */
    .stat-card{display:flex;align-items:center;gap:12px;padding:14px 16px;border-radius:12px;background:rgba(255,255,255,.9);border:1px solid rgba(17,24,39,.06);box-shadow:0 6px 16px rgba(17,24,39,.05)}
    .stat-card .icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;background:linear-gradient(135deg,#667eea,#5a67d8)}
    .stat-card .num{font-size:20px;font-weight:700;color:#1f2937}
    .stat-card .desc{font-size:12px;color:#6b7280}
    /* 响应式优化 */
    @media(max-width:768px){
      #sidebar{transform:translateZ(0)}
      .navbar .nav>li>a{padding:10px 12px}
    }

    /* 表格升级：圆角+悬停高亮+粘性表头 */
    .table { border-collapse: separate; border-spacing: 0; border-radius: 10px; overflow: hidden; }
    .table > thead > tr > th { background: rgba(102,126,234,.08); color:#374151; border-bottom: 1px solid rgba(17,24,39,.06); position: sticky; top: 0; z-index: 1; }
    .table > tbody > tr:hover { background: rgba(102,126,234,.06); transition: background .15s ease; }
    .table > tbody > tr + tr td { border-top: 1px solid rgba(17,24,39,.04); }

    /* 表单控件圆角与聚焦态 */
    .form-control { border-radius: 10px; border-color: rgba(17,24,39,.12); box-shadow: none; }
    .form-control:focus { border-color: #7c8cf2; box-shadow: 0 0 0 3px rgba(124,140,242,.15); }

    /* 渐变按钮统一 */
    .btn-primary { background: linear-gradient(135deg,#667eea,#5a67d8); border: none; }
    .btn-success { background: linear-gradient(135deg,#34d399,#10b981); border: none; }
    .btn-warning { background: linear-gradient(135deg,#f59e0b,#f97316); border: none; }
    .btn-danger  { background: linear-gradient(135deg,#ef4444,#dc2626); border: none; }
    .btn:hover { filter: brightness(1.05); }
    .btn:active { transform: translateY(1px); }

    /* 弹窗优化（Bootstrap 模态窗） */
    .modal-header { background: linear-gradient(90deg,#667eea,#764ba2); color:#fff; border-top-left-radius:10px; border-top-right-radius:10px; }
    .modal-content { border-radius:12px; border: 1px solid rgba(17,24,39,.06); box-shadow: 0 20px 60px rgba(17,24,39,.15); }
    /* 确保 Bootstrap 模态框层级高于任何自定义遮罩 */
    .modal-backdrop { z-index: 1040 !important; }
    .modal { z-index: 1050 !important; }
    
    /* 特别针对余额充值弹窗的样式修复 */
    #modal-rmb.modal { z-index: 1060 !important; }
    #modal-rmb .modal-dialog { z-index: 1061 !important; }
    #modal-rmb .modal-content { z-index: 1062 !important; }
    
    /* 强制所有modal相关元素显示在最前 */
    .modal, .modal-dialog, .modal-content {
      z-index: 1050 !important;
    }
    
    /* 确保modal内容可见且可点击 */
    .modal.in, .modal.show {
      display: block !important;
      visibility: visible !important;
    }
    
    /* 修复modal backdrop可能被个性化背景遮罩干扰的问题 */
    .modal-backdrop.in {
      opacity: 0.5 !important;
      z-index: 1040 !important;
    }
    
    /* 确保点击事件正常工作 */
    .modal-backdrop {
      pointer-events: auto !important;
    }
    
    /* 防止背景遮罩影响modal显示 */
    #background-overlay {
      z-index: 1 !important;
      pointer-events: none !important;
    }
    
    /* 修复modal定位和显示问题 */
    .modal {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      width: 100% !important;
      height: 100% !important;
      overflow: auto !important;
    }
    
    .modal-dialog {
      position: relative !important;
      margin: 50px auto !important;
      max-width: 600px !important;
      width: auto !important;
    }
    
    .modal-content {
      position: relative !important;
      background: #fff !important;
      border-radius: 12px !important;
      box-shadow: 0 20px 60px rgba(17,24,39,.15) !important;
      max-height: calc(100vh - 100px) !important;
      overflow-y: auto !important;
    }
    
    /* 确保modal在我们的背景系统之上正确显示 */
    .modal.fade.in, .modal.show {
      display: block !important;
      opacity: 1 !important;
      visibility: visible !important;
      transform: none !important;
    }

    /* Layer 关闭按钮可见化 */
    .layui-layer .layui-layer-setwin .layui-layer-close1,
    .layui-layer .layui-layer-setwin .layui-layer-close { width:20px;height:20px;background:none;position:relative }
    .layui-layer .layui-layer-setwin .layui-layer-close1:after,
    .layui-layer .layui-layer-setwin .layui-layer-close:after { content:"×";position:absolute;left:0;right:0;top:50%;transform:translateY(-50%);text-align:center;font-size:16px;font-weight:700;color:#666 }
    .layui-layer .layui-layer-setwin .layui-layer-close1:hover:after,
    .layui-layer .layui-layer-setwin .layui-layer-close:hover:after { color:#333 }

    /* 快捷命令面板 Ctrl+K */
    #cmdk-mask{position:fixed;inset:0;background:rgba(15,23,42,.35);backdrop-filter:blur(3px);display:none;z-index:9998}
    #cmdk{position:fixed;left:50%;top:15vh;transform:translateX(-50%);width:min(720px,92vw);border-radius:12px;background:#fff;border:1px solid rgba(17,24,39,.06);box-shadow:0 25px 80px rgba(17,24,39,.25);display:none;z-index:9999}

    /* 个性化设置模态框样式优化 */
    #personalizationModal .modal-backdrop {
      background-color: rgba(0,0,0,0.5) !important;
      backdrop-filter: none !important;
    }
    #personalizationModal .modal-body {
      padding: 25px;
      background: #fff;
    }
    #personalizationModal .form-control {
      border-radius: 8px;
      border-color: rgba(17,24,39,.12);
      box-shadow: none;
    }
    #personalizationModal .form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102,126,234,.15);
    }
    #personalizationModal .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(17,24,39,.15);
    }
    #personalizationModal .btn:active {
      transform: translateY(0);
    }
    #cmdk .hdr{padding:10px 12px;border-bottom:1px solid rgba(17,24,39,.06);font-weight:600;color:#374151}
    #cmdk input{width:100%;border:none;outline:none;padding:12px 14px;font-size:14px}
    #cmdk .list{max-height:50vh;overflow:auto;border-top:1px solid rgba(17,24,39,.06)}
    #cmdk .item{padding:10px 14px;display:flex;justify-content:space-between;align-items:center;cursor:pointer}
    #cmdk .item:hover{background:#f3f4f6}
    #cmdk .item .hint{color:#6b7280;font-size:12px}

    /* 分页微调 */
    .pagination>li>a,.pagination>li>span{border-radius:8px;margin:0 2px;border-color:rgba(17,24,39,.12)}

    /* 主页等分排版：让同一行的两列等高，避免凹凸不平 */
    .row-eq { display: flex; flex-wrap: wrap; }
    .row-eq > [class^="col-"] { display: flex; flex-direction: column; }
    .row-eq .widget, .row-eq .card { height: 100%; display: flex; flex-direction: column; }
    .row-eq .widget > .widget-content:last-child, .row-eq .card .card-bd { flex: 1 1 auto; }
    /* 统一区块间距 */
    .widget { margin-bottom: 14px; }

    /* 微交互与动效 */
    .stat-card, .widget { transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
    .stat-card:hover, .widget:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(17,24,39,.08); }
    .fade-in { opacity: 0; transform: translateY(6px); animation: fadeInUp .28s ease forwards; }
    @keyframes fadeInUp { to { opacity: 1; transform: none; } }

    /* Skeleton 载入动画（AJAX 加载数据前） */
    @keyframes shimmer { 0% { background-position: -468px 0 } 100% { background-position: 468px 0 } }
    .loading .stat-card .num, .loading #chart-classic-dash { color: transparent !important; }
    .loading .stat-card .num { min-height: 20px; border-radius: 6px; background: #f1f5f9; background-image: linear-gradient(90deg, #f1f5f9 0, #e5e7eb 40%, #f1f5f9 80%); background-size: 800px 104px; animation: shimmer 1.2s infinite linear; }
    .loading #chart-classic-dash { border-radius: 10px; background: #f1f5f9; background-image: linear-gradient(90deg, #f1f5f9 0, #e5e7eb 40%, #f1f5f9 80%); background-size: 800px 104px; animation: shimmer 1.2s infinite linear; }

    /* 更柔和的滚动条（WebKit） */
    ::-webkit-scrollbar { width: 10px; height: 10px; }
    ::-webkit-scrollbar-thumb { background: rgba(17,24,39,.18); border-radius: 10px; }
    ::-webkit-scrollbar-track { background: transparent; }

    /* 背景图片样式优化 - 只应用到主内容区域 */
    .main-content-background {
      position: relative;
      min-height: 100vh;
    }
    
    .main-content-background::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: -1;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      pointer-events: none;
    }

    /* 磨砂玻璃效果 */
    .widget, .block, .panel {
      background: rgba(255, 255, 255, 0.25) !important;
      backdrop-filter: blur(25px) !important;
      -webkit-backdrop-filter: blur(25px) !important;
      border: 1px solid rgba(255, 255, 255, 0.3) !important;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
      border-radius: 20px !important;
      transition: all 0.3s ease !important;
    }
    
    .widget:hover, .block:hover, .panel:hover {
      background: rgba(255, 255, 255, 0.3) !important;
      backdrop-filter: blur(30px) !important;
      -webkit-backdrop-filter: blur(30px) !important;
      transform: translateY(-2px) !important;
      box-shadow: 0 16px 50px rgba(0, 0, 0, 0.2) !important;
    }
    
    .widget-content, .block-content, .panel-body {
      background: transparent !important;
    }
    
    /* 统计卡片磨砂效果 */
    .stat-card {
      background: rgba(255, 255, 255, 0.25) !important;
      backdrop-filter: blur(25px) !important;
      -webkit-backdrop-filter: blur(25px) !important;
      border: 1px solid rgba(255, 255, 255, 0.3) !important;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
      border-radius: 20px !important;
      transition: all 0.3s ease !important;
    }
    
    .stat-card:hover {
      background: rgba(255, 255, 255, 0.3) !important;
      backdrop-filter: blur(30px) !important;
      -webkit-backdrop-filter: blur(30px) !important;
      transform: translateY(-3px) !important;
      box-shadow: 0 16px 50px rgba(0, 0, 0, 0.2) !important;
    }
    
    /* 顶部导航栏磨砂效果 - 只在有背景图片时应用 */
    .main-content-background .navbar-inverse {
      background: rgba(102, 126, 234, 0.85) !important;
      backdrop-filter: blur(25px) !important;
      -webkit-backdrop-filter: blur(25px) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* 侧边栏磨砂效果 - 只在有背景图片时应用 */
    .main-content-background #sidebar {
      background: rgba(102, 126, 234, 0.85) !important;
      backdrop-filter: blur(25px) !important;
      -webkit-backdrop-filter: blur(25px) !important;
      border-right: 1px solid rgba(255, 255, 255, 0.2) !important;
      box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* 模态框磨砂效果 - 修复显示问题 */
    .modal-content {
      background: rgba(255, 255, 255, 0.95) !important;
      backdrop-filter: blur(10px) !important;
      -webkit-backdrop-filter: blur(10px) !important;
      border: 1px solid rgba(255, 255, 255, 0.8) !important;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2) !important;
      border-radius: 12px !important;
      color: #333 !important;
    }
    
    .modal-header {
      background: rgba(102, 126, 234, 0.95) !important;
      backdrop-filter: blur(10px) !important;
      -webkit-backdrop-filter: blur(10px) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.3) !important;
      border-top-left-radius: 12px !important;
      border-top-right-radius: 12px !important;
      color: #fff !important;
    }
    
    .modal-body {
      background: transparent !important;
      color: #333 !important;
    }
    
    /* 表格磨砂效果 */
    .table {
      background: rgba(255, 255, 255, 0.1) !important;
      backdrop-filter: blur(10px) !important;
      -webkit-backdrop-filter: blur(10px) !important;
    }
    
    .table > thead > tr > th {
      background: rgba(255, 255, 255, 0.15) !important;
      backdrop-filter: blur(10px) !important;
      -webkit-backdrop-filter: blur(10px) !important;
    }
    
    /* 表单控件磨砂效果 */
    .form-control {
      background: rgba(255, 255, 255, 0.15) !important;
      backdrop-filter: blur(10px) !important;
      -webkit-backdrop-filter: blur(10px) !important;
      border: 1px solid rgba(255, 255, 255, 0.2) !important;
      color: #333 !important;
    }
    
    .form-control:focus {
      background: rgba(255, 255, 255, 0.2) !important;
      border-color: rgba(102, 126, 234, 0.5) !important;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
    }
    
    /* 按钮磨砂效果 */
    .btn {
      backdrop-filter: blur(10px) !important;
      -webkit-backdrop-filter: blur(10px) !important;
      border: 1px solid rgba(255, 255, 255, 0.2) !important;
    }
    
    /* 列表项磨砂效果 */
    .list-group-item {
      background: rgba(255, 255, 255, 0.1) !important;
      backdrop-filter: blur(10px) !important;
      -webkit-backdrop-filter: blur(10px) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    
    /* 导航项磨砂效果 */
    .sidebar-nav > li > a {
      background: rgba(255, 255, 255, 0.1) !important;
      backdrop-filter: blur(10px) !important;
      -webkit-backdrop-filter: blur(10px) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    
    .sidebar-nav > li.active > a,
    .sidebar-nav > li > a:hover {
      background: rgba(255, 255, 255, 0.2) !important;
      backdrop-filter: blur(15px) !important;
      -webkit-backdrop-filter: blur(15px) !important;
    }
  </style>
  <!--[if lt IE 9]>
    <script src="../assets/js/html5shiv-3.7.3.min.js"></script>
    <script src="../assets/js/respond-1.4.2.min.js"></script>
  <![endif]-->
</head>
<body>
<?php if($islogin==1){?>
<!-- Start: Header -->
    <div id="page-wrapper">
        <div id="page-container" class="header-fixed-top sidebar-visible-lg-full enable-cookies">
<div id="cmdk-mask"></div>
<div id="cmdk">
  <div class="hdr">快速跳转</div>
  <input id="cmdk-input" placeholder="输入关键词 如: 订单/用户/分站/提现... (↑↓选择 回车确认)"/>
  <div class="list" id="cmdk-list"></div>
</div>
<script>
// 命令面板 Ctrl+K（全局可用）
(function(){
  var mask=document.getElementById('cmdk-mask');
  var panel=document.getElementById('cmdk');
  var input=document.getElementById('cmdk-input');
  var list=document.getElementById('cmdk-list');
  if(!mask||!panel||!input||!list) return;
  var items=[
    {text:'后台首页',hint:'home',url:'./'},
    {text:'订单管理',hint:'list',url:'./list.php'},
    {text:'导出订单',hint:'export',url:'./export.php'},
    {text:'商品列表',hint:'shop',url:'./shoplist.php'},
    {text:'分类列表',hint:'class',url:'./classlist.php'},
    {text:'用户列表',hint:'user',url:'./userlist.php'},
    {text:'分站列表',hint:'site',url:'./sitelist.php'},
    {text:'收支明细',hint:'record',url:'./record.php'},
    {text:'提现管理',hint:'tixian',url:'./tixian.php'},
    {text:'站内通知',hint:'message',url:'./message.php'},
    {text:'工单列表',hint:'workorder',url:'./workorder.php'},
    {text:'价格监控',hint:'price',url:'./pricejk.php'},
    {text:'计划任务',hint:'cron',url:'./set.php?mod=cron'}
  ];
  var sel=0;
  function open(){ mask.style.display='block'; panel.style.display='block'; input.value=''; render(''); input.focus(); sel=0; highlight(); }
  function close(){ mask.style.display='none'; panel.style.display='none'; }
  function render(q){
    var ql=(q||'').trim().toLowerCase();
    var html=items.filter(it=>it.text.toLowerCase().includes(ql)||it.hint.includes(ql)).map((it,i)=>'<div class="item" data-idx="'+i+'"><span>'+it.text+'</span><span class="hint">'+it.hint+'</span></div>').join('');
    list.innerHTML=html||'<div class="item"><span>无匹配结果</span></div>';
    sel=0; highlight();
  }
  function highlight(){
    var cs=list.querySelectorAll('.item'); cs.forEach(el=>el.style.background=''); if(cs[sel]) cs[sel].style.background='#eef2ff';
  }
  document.addEventListener('keydown',function(e){
    var k=e.key.toLowerCase();
    // 快捷键改为 Alt+K，避免与浏览器命令冲突
    if(e.altKey && !e.ctrlKey && !e.metaKey && k==='k'){ e.preventDefault(); open(); return; }
    if(panel.style.display==='block'){
      if(k==='escape'){ close(); }
      if(k==='arrowdown'){ e.preventDefault(); sel=Math.min(sel+1, list.children.length-1); highlight(); }
      if(k==='arrowup'){ e.preventDefault(); sel=Math.max(sel-1, 0); highlight(); }
      if(k==='enter'){ var el=list.children[sel]; if(el&&el.dataset.idx){ var idx=el.dataset.idx; close(); location.href=items[idx].url; }
      }
    }
  });
  mask.addEventListener('click', close);
  input.addEventListener('input',e=>render(e.target.value));
  list.addEventListener('click',function(e){ var el=e.target.closest('.item'); if(!el) return; var idx=el.getAttribute('data-idx'); close(); if(items[idx]) location.href=items[idx].url; });
})();
</script>
<div id="sidebar-alt" tabindex="-1" aria-hidden="true">
<a href="javascript:void(0)" id="sidebar-alt-close" onclick="App.sidebar('toggle-sidebar-alt');"><i class="fa fa-times"></i></a>
<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 888px;"><div id="sidebar-scroll-alt" style="overflow: hidden; width: auto; height: 888px;">
<div class="sidebar-content">
<div class="sidebar-section">
<style>
h4{font-family:"微软雅黑",Georgia,Serif;}
</style>
<h4 class="text-light">框架变色(New)</h4>
<br>
<ul class="sidebar-themes clearfix">
<li class="">
<a href="javascript:void(0)" class="themed-background-default" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/themes-2.2.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-default"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-classy" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/classy-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-classy"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-social" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/social-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-social"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-flat" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/flat-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-flat"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-amethyst" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/amethyst-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-amethyst"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-creme" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/creme-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-creme"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-passion" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/passion-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-passion"></span>
<span class="section-content"></span>
</a>
<br>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-classy" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/classy-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-social" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/social-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-flat" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/flat-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-amethyst" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/amethyst-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-creme" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/creme-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-passion" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/passion-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>

<li class="">
<a href="javascript:void(0)" class="themed-background-classy" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/classy-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-classy"></span>
<span class="section-content"></span>
</a>
<br>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-social" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/social-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-social"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-flat" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/flat-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-flat"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-amethyst" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/amethyst-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-amethyst"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-creme" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/creme-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-creme"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-passion" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/passion-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-passion"></span>
<span class="section-content"></span>
</a>
</li>
</ul>
</div>
</div>
</div><div class="slimScrollBar" style="background: rgb(187, 187, 187); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 888px;"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 1; z-index: 90; right: 1px;"></div></div>
</div>
            <div id="sidebar">
                <div id="sidebar-brand" class="themed-background">
				<a href="./" class="sidebar-title">
                    <i class="fa fa-cube"></i> <span class="sidebar-nav-mini-hide">管理后台</span>
                </a>
				</div>
                <div id="sidebar-scroll">
                    <div class="sidebar-content">
                        <ul class="sidebar-nav">

<li>
	<a class="<?php echo checkIfActive('index,')?>" href="./">
		<i class="fa fa-home sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">后台首页</span>
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive('list,export')?>" href="./list.php">
		<i class="fa fa-list sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">订单管理</span>
	</a>
</li>

<li class="<?php echo checkIfActive('classlist,shoplist,shopedit,price,shoprank,cardlist')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-shopping-cart sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">商品管理</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("classlist") ?>" href="./classlist.php">
		分类列表
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("shoplist,shopedit,shoprank") ?>" href="./shoplist.php">
		商品列表
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("price") ?>" href="./price.php">
		加价模板
	</a>
</li>
<?php if($conf['iskami']==1){?><li>
	<a class="<?php echo checkIfActive("cardlist") ?>" href="./cardlist.php">
		兑换卡密
	</a>
</li><?php }?>
	</ul>
</li>

<li class="<?php echo checkIfActive('fakalist,fakakms,mailcon')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-th sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">发卡管理</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("fakalist") ?>" href="./fakalist.php">
		库存管理
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("fakakms") ?>" href="./fakakms.php?my=add">
		添加卡密
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("mailcon") ?>" href="./set.php?mod=mailcon">
		发信模板
	</a>
</li>
	</ul>
</li>

<li class="<?php echo checkIfActive('sitelist,tixian,record,rank,userlist,message,workorder,siteprice,kmlist')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-sitemap sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">分站管理</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("sitelist,siteprice") ?>" href="./sitelist.php">
		分站列表
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("userlist") ?>" href="./userlist.php">
		用户列表
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("record") ?>" href="./record.php">
		收支明细
	</a>
</li>
<?php if($conf['fenzhan_tixian']==1){?>
<li>
	<a class="<?php echo checkIfActive("tixian") ?>" href="./tixian.php">
		余额提现
	</a>
</li>
<?php }?>
<li>
	<a class="<?php echo checkIfActive("rank") ?>" href="./rank.php">
		分站排行
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("workorder") ?>" href="./workorder.php">
		工单列表
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("message") ?>" href="./message.php">
		站内通知
	</a>
</li>
	</ul>
</li>

<li>
	<a class="<?php echo checkIfActive('article,rewrite')?>" href="./article.php">
		<i class="fa fa-book sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">文章管理</span>
	</a>
</li>

<li class="<?php echo checkIfActive('shequlist,pricejk,log,clone,cloneset,shequ,orderjk,batchgoods')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cubes sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">对接设置</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("shequlist") ?>" href="./shequlist.php">
		对接站点管理
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("pricejk") ?>" href="./pricejk.php">
		价格监控
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("orderjk") ?>" href="./orderjk.php">
		订单状态监控
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("log") ?>" href="./log.php">
		对接日志
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("clone,cloneset") ?>" href="./clone.php">
		克隆站点
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("batchgoods") ?>" href="./batchgoods.php">
		批量对接商品
	</a>
</li>
	</ul>
</li>

<li class="<?php echo checkIfActive('site,gonggao,mail,pay,template,template2,upimg,upbgimg,clean,cleanbom,defend,proxy,copygg,mailtest,epay,captcha,fenzhan,cron,oauth')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cog sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">系统设置</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("site") ?>" href="./set.php?mod=site">
		网站信息配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("fenzhan") ?>" href="./set.php?mod=fenzhan">
		分站相关配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("gonggao,copygg") ?>" href="./set.php?mod=gonggao">
		网站公告配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("mail") ?>" href="./set.php?mod=mail">
		邮箱与提醒配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("pay,epay") ?>" href="./set.php?mod=pay">
		支付接口配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("template,template2") ?>" href="./set.php?mod=template">
		首页模板设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("oauth") ?>" href="./set.php?mod=oauth">
		快捷登录配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("captcha") ?>" href="./set.php?mod=captcha">
		验证与IP配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("upimg,upbgimg") ?>" href="./set.php?mod=upimg">
		Logo与背景设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("cron") ?>" href="./set.php?mod=cron">
		计划任务设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("clean") ?>" href="./clean.php">
		系统数据清理
	</a>
</li>
<!--<li>-->
<!--	<a class="<?php echo checkIfActive("update") ?>" href="./update.php">-->
<!--		检查版本更新-->
<!--	</a>-->
<!--</li>-->
	</ul>
</li>

<li class="<?php echo checkIfActive('qiandao,invite,choujiang,invitelog,appCreate')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cogs sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">其它组件</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("qiandao") ?>" href="./set.php?mod=qiandao">
		每日签到设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("invite,invitelog") ?>" href="./set.php?mod=invite">
		推广链接设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("choujiang") ?>" href="./choujiang.php">
		抽奖商品设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("yiban_set") ?>" href="./yiban_set.php">
		易班业务设置
	</a>
</li>


	</ul>
</li>

<li>
	<a class="<?php echo checkIfActive('account')?>" href="./account.php">
		<i class="fa fa-user-circle-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">员工管理</span>
	</a>
</li>

<li>
	<a class="<?php echo checkIfActive('changelog')?>" href="./changelog.php">
		<i class="fa fa-file-text-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">更新日志 <font color="red">NEW</font></span>
	</a>
</li>


                        </ul>
                    </div>
                </div>
                <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">
<div class="progress progress-mini push-bit">
<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
</div>
<div class="text-center">
<small><span id="year-copy">2018</span> © <a href="#"><?php echo $conf['sitename']?></a></small>
</div>
</div>
            </div>
            <div id="main-container">
                <header class="navbar navbar-inverse navbar-fixed-top">
 
<ul class="nav navbar-nav-custom">
 
<li>
<a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
<i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
<i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>菜单
</a>
</li>
<li>
<a href="javascript:void(0)" onclick="javascript:history.go(-1);">
<i class="fa fa-reply fa-fw animation-fadeInRight"></i> 返回
</a>
</li>
 
</ul>
 
 
<ul class="nav navbar-nav-custom pull-right">
<li>
<a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt');this.blur();">
<i class="fa fa-wrench sidebar-nav-icon"></i>
</a>
</li>
<li>
<a href="javascript:void(0)" onclick="openPersonalizationModal();this.blur();" title="个性化设置">
<i class="fa fa-paint-brush sidebar-nav-icon"></i>
<font color="red"> NEW</font>
</a>
</li>
<li class="dropdown">
<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
<img src="<?php echo ($conf['kfqq'])?'//q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$conf['kfqq'].'&src_uin='.$conf['kfqq'].'&fid='.$conf['kfqq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'../assets/img/user.png'?>" alt="avatar">
</a>
<ul class="dropdown-menu dropdown-menu-right">
<li class="dropdown-header text-center">
<strong>管理员用户</strong>
</li>
<li>
<a href="set.php?mod=bind">
<i class="fa fa-qrcode fa-fw pull-right"></i>
扫码登录
</a>
</li>
</li>
<li>
<a href="set.php?mod=account">
<i class="fa fa-pencil-square fa-fw pull-right"></i>
密码修改
</a>
</li>
<li>
<a href="../">
<i class="fa fa-home fa-fw pull-right"></i>
网站首页
</a>
</li>
<li class="divider">
</li>
<li>
<li>
<a href="login.php?logout">
<i class="fa fa-power-off fa-fw pull-right"></i>
退出登录
</a>
</li>
</ul>
</li>
</ul>
</header>

<!-- 个性化设置模态对话框 -->
<div class="modal fade" id="personalizationModal" tabindex="-1" role="dialog" aria-labelledby="personalizationModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 20px 60px rgba(17,24,39,.25);">
      <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom: none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="personalizationModalLabel" style="font-weight: 600;">
          <i class="fa fa-paint-brush"></i> 个性化设置
        </h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="backgroundType">背景类型：</label>
          <select class="form-control" id="backgroundType" onchange="changeBackgroundType()">
            <option value="image">自定义图片</option>
            <option value="default">默认背景</option>
          </select>
        </div>
        
        <div id="imageOptions" class="form-group" style="display:none;">
          <div class="row">
            <div class="col-md-8">
              <label for="backgroundImageSelect">选择背景图片：</label>
              <select class="form-control" id="backgroundImageSelect" onchange="previewSelectedImage()">
                <option value="">请选择图片</option>
                <?php
                $backgroundDir = '../assets/img/background/';
                if (is_dir($backgroundDir)) {
                  $files = scandir($backgroundDir);
                  foreach ($files as $file) {
                    if ($file != '.' && $file != '..' && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
                      echo '<option value="' . $backgroundDir . $file . '">' . $file . '</option>';
                    }
                  }
                }
                ?>
              </select>
            </div>
            <div class="col-md-4">
              <label>&nbsp;</label>
              <div>
                <button type="button" class="btn btn-primary btn-sm btn-block" onclick="openUploadDialog()" style="margin-bottom: 5px;">
                  <i class="fa fa-upload"></i> 上传新图片
                </button>
                <button type="button" class="btn btn-danger btn-sm btn-block" onclick="deleteSelectedImage()">
                  <i class="fa fa-trash"></i> 删除选中
                </button>
              </div>
            </div>
          </div>
          
          <!-- 隐藏的文件上传框 -->
          <input type="file" id="backgroundUpload" accept="image/*" style="display:none;" onchange="uploadBackgroundImage()">
          
          <div id="imagePreview" style="margin-top:15px; display:none;">
            <label>预览：</label>
            <div style="border: 1px solid #ddd; border-radius: 8px; padding: 10px; background: #f9f9f9;">
              <img id="previewImg" style="max-width:100%; max-height:200px; border-radius:6px; display:block; margin:0 auto;">
            </div>
          </div>
          
          <div class="form-group" style="margin-top:15px;">
            <label for="backgroundOpacity">背景淡化程度：</label>
            <input type="range" class="form-control" id="backgroundOpacity" min="0" max="1" step="0.01" value="0.3" onchange="changeBackgroundOpacity(this.value)">
            <small class="text-muted">当前淡化程度: <span id="opacityValue">30%</span></small>
          </div>
        </div>
        
        <div class="form-group">
          <label>
            <input type="checkbox" id="saveSettings" checked> 保存设置到本地
          </label>
        </div>
      </div>
      <div class="modal-footer" style="border-top: 1px solid #e9ecef; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; background: #f8f9fa;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px;">取消</button>
        <button type="button" class="btn btn-primary" onclick="applyPersonalization()" style="border-radius: 8px; background: linear-gradient(135deg, #667eea, #5a67d8); border: none;">应用设置</button>
        <button type="button" class="btn btn-warning" onclick="resetPersonalization()" style="border-radius: 8px; background: linear-gradient(135deg, #f59e0b, #f97316); border: none;">重置默认</button>
      </div>
    </div>
  </div>
</div>

<div id="page-content">
		<div id="myDiv"></div>
			<div class="main pjaxmain">
				<div class="content-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="header-section">
                                    <h1><?php echo $title ?></h1>
                                </div>
                            </div>
                        </div>
				</div>
<div class="row">

<script>
// 个性化设置功能
let currentBackgroundSettings = {
  type: 'image',
  image: '../assets/img/background/background_1.jpg',
  opacity: 0.3
};

// 打开个性化设置模态框
function openPersonalizationModal() {
  // 加载保存的设置
  loadPersonalizationSettings();
  $('#personalizationModal').modal('show');
}

// 改变背景类型
function changeBackgroundType() {
  const type = document.getElementById('backgroundType').value;
  
  // 隐藏图片选项
  document.getElementById('imageOptions').style.display = 'none';
  
  // 显示对应选项
  if (type === 'image') {
    document.getElementById('imageOptions').style.display = 'block';
  }
  
  currentBackgroundSettings.type = type;
}

// 预览选中的图片
function previewSelectedImage() {
  const select = document.getElementById('backgroundImageSelect');
  const selectedImage = select.value;
  
  if (selectedImage) {
    document.getElementById('previewImg').src = selectedImage;
    document.getElementById('imagePreview').style.display = 'block';
    currentBackgroundSettings.image = selectedImage;
    
    // 更新预览图片的淡化效果
    updatePreviewFadeEffect();
  } else {
    document.getElementById('imagePreview').style.display = 'none';
    currentBackgroundSettings.image = '';
  }
}

// 更新预览图片的淡化效果
function updatePreviewFadeEffect() {
  const previewImg = document.getElementById('previewImg');
  const opacity = currentBackgroundSettings.opacity || 0.3;
  
  if (previewImg) {
    // 创建淡化遮罩
    let fadeOverlay = document.getElementById('preview-fade-overlay');
    if (!fadeOverlay) {
      fadeOverlay = document.createElement('div');
      fadeOverlay.id = 'preview-fade-overlay';
      fadeOverlay.style.cssText = `
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, ${1 - opacity});
        border-radius: 6px;
        pointer-events: none;
        z-index: 1;
      `;
      
      // 确保预览容器是相对定位
      const previewContainer = previewImg.parentElement;
      if (previewContainer) {
        previewContainer.style.position = 'relative';
        previewContainer.appendChild(fadeOverlay);
      }
    } else {
      fadeOverlay.style.background = `rgba(255, 255, 255, ${1 - opacity})`;
    }
  }
}

// 改变背景淡化程度
function changeBackgroundOpacity(value) {
  currentBackgroundSettings.opacity = parseFloat(value);
  document.getElementById('opacityValue').textContent = Math.round(value * 100) + '%';
  
  // 更新预览图片的淡化效果
  updatePreviewFadeEffect();
  
  // 实时更新页面背景的淡化效果
  updatePageBackgroundFade();
}

// 实时更新页面背景的淡化效果
function updatePageBackgroundFade() {
  const pageContent = document.getElementById('page-content');
  const overlay = document.getElementById('background-overlay');
  
  if (pageContent && overlay && currentBackgroundSettings.image) {
    const opacity = currentBackgroundSettings.opacity || 0.3;
    overlay.style.background = `rgba(255, 255, 255, ${0.7 - opacity})`;
  }
}

// 应用个性化设置
function applyPersonalization(showNotification = true) {
  const pageContent = document.getElementById('page-content');
  console.log('应用个性化设置:', currentBackgroundSettings);
  console.log('页面内容元素:', pageContent);
  
  // 移除之前的背景样式和遮罩
  if (pageContent) {
    pageContent.style.cssText = '';
    pageContent.classList.remove('main-content-background');
    
    // 移除旧的遮罩
    const oldOverlay = document.getElementById('background-overlay');
    if (oldOverlay) {
      oldOverlay.remove();
    }
    
    // 重置所有子元素的样式
    const children = pageContent.children;
    for (let i = 0; i < children.length; i++) {
      children[i].style.position = '';
      children[i].style.zIndex = '';
    }
  }
  
  // 应用新的背景样式
  if (currentBackgroundSettings.type === 'image' && currentBackgroundSettings.image) {
    console.log('应用背景图片:', currentBackgroundSettings.image);
    if (pageContent) {
      // 使用强制方法应用背景
      forceApplyBackground();
    }
  } else {
    console.log('移除背景图片');
  }
  
  // 保存设置
  if (document.getElementById('saveSettings').checked) {
    savePersonalizationSettings();
  }
  
  // 关闭模态框
  $('#personalizationModal').modal('hide');
  
  // 只在用户主动应用时显示提示
  if (showNotification) {
    showNotification('个性化设置已应用！', 'success');
  }
}

// 重置个性化设置
function resetPersonalization() {
  // 重置为默认背景图片
  currentBackgroundSettings = {
    type: 'image',
    image: '../assets/img/background/background_1.jpg',
    opacity: 0.3
  };
  
  // 应用默认背景，不显示通知
  applyPersonalization(false);
  
  // 重置表单
  document.getElementById('backgroundType').value = 'image';
  document.getElementById('backgroundImageSelect').value = '../assets/img/background/background_1.jpg';
  document.getElementById('backgroundOpacity').value = '0.3';
  document.getElementById('opacityValue').textContent = '30%';
  document.getElementById('imagePreview').style.display = 'block';
  document.getElementById('previewImg').src = '../assets/img/background/background_1.jpg';
  
  // 显示图片选项
  changeBackgroundType();
  
  // 清除保存的设置
  localStorage.removeItem('adminPersonalization');
  
  // 关闭模态框
  $('#personalizationModal').modal('hide');
  
  // 显示成功提示
  showNotification('已重置为默认背景！', 'success');
}

// 保存个性化设置到本地存储
function savePersonalizationSettings() {
  localStorage.setItem('adminPersonalization', JSON.stringify(currentBackgroundSettings));
}

// 打开上传对话框
function openUploadDialog() {
  document.getElementById('backgroundUpload').click();
}

// 上传背景图片
function uploadBackgroundImage() {
  const fileInput = document.getElementById('backgroundUpload');
  const file = fileInput.files[0];
  
  if (!file) return;
  
  // 检查文件类型
  const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
  if (!allowedTypes.includes(file.type)) {
    alert('不支持的文件格式，只支持 JPG、PNG、GIF、WEBP 格式');
    return;
  }
  
  // 检查文件大小（最大10MB）
  if (file.size > 10 * 1024 * 1024) {
    alert('文件大小不能超过10MB');
    return;
  }
  
  // 显示上传进度（兼容无 layui 场景）
  var loadingIndex = null;
  if (typeof layer !== 'undefined' && layer && typeof layer.load === 'function') {
    loadingIndex = layer.load(2, {shade: [0.3, '#000']});
  }
  
  // 创建FormData
  const formData = new FormData();
  formData.append('background', file);
  
  // 发送上传请求
  $.ajax({
    url: 'ajax_background.php?act=upload',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',
    success: function(response) {
      if (loadingIndex !== null && typeof layer !== 'undefined' && typeof layer.close === 'function') layer.close(loadingIndex);
      
      if (response.code === 0) {
        // 上传成功，动态拉取文件列表并更新下拉框
        refreshBackgroundSelect(function(){
          $('#backgroundImageSelect').val(response.path);
          previewSelectedImage();
        });
        showNotification('图片上传成功！', 'success');
      } else {
        alert(response.msg || '上传失败');
      }
    },
    error: function() {
      if (loadingIndex !== null && typeof layer !== 'undefined' && typeof layer.close === 'function') layer.close(loadingIndex);
      alert('上传失败，请重试');
    }
  });
  
  // 清空文件输入框
  fileInput.value = '';
}

// 删除选中的图片
function deleteSelectedImage() {
  const select = document.getElementById('backgroundImageSelect');
  const selectedValue = select.value;
  
  if (!selectedValue) {
    alert('请先选择要删除的图片');
    return;
  }
  
  // 获取文件名
  const filename = selectedValue.split('/').pop();
  
  // 确认删除
  if (!confirm(`确定要删除图片 "${filename}" 吗？`)) {
    return;
  }
  
  // 显示加载（兼容无 layui 场景）
  var loadingIndex = null;
  if (typeof layer !== 'undefined' && layer && typeof layer.load === 'function') {
    loadingIndex = layer.load(2, {shade: [0.3, '#000']});
  }
  
  // 发送删除请求
  $.ajax({
    url: 'ajax_background.php?act=delete',
    type: 'POST',
    data: { filename: filename },
    dataType: 'json',
    success: function(response) {
      if (loadingIndex !== null && typeof layer !== 'undefined' && typeof layer.close === 'function') layer.close(loadingIndex);
      
      if (response.code === 0) {
        // 删除成功，刷新选择框
        refreshBackgroundSelect();
        // 清除预览
        document.getElementById('imagePreview').style.display = 'none';
        
        showNotification('图片删除成功！', 'success');
      } else {
        alert(response.msg || '删除失败');
      }
    },
    error: function() {
      if (loadingIndex !== null && typeof layer !== 'undefined' && typeof layer.close === 'function') layer.close(loadingIndex);
      alert('删除失败，请重试');
    }
  });
}

// 刷新背景图片选择框
function refreshBackgroundSelect(done) {
  $.ajax({
    url: 'ajax_background.php?act=list',
    type: 'GET',
    dataType: 'json',
    success: function(res) {
      const select = document.getElementById('backgroundImageSelect');
      select.innerHTML = '<option value="">请选择图片</option>';
      if(res && res.code === 0 && Array.isArray(res.files)){
        res.files.forEach(function(file){
          const opt = document.createElement('option');
          opt.value = file.path;
          opt.textContent = file.filename;
          select.appendChild(opt);
        });
      }
      if(typeof done === 'function') done();
    },
    error: function(){
      // 出错时不影响主流程
    }
  });
}

// 加载个性化设置
function loadPersonalizationSettings() {
  const saved = localStorage.getItem('adminPersonalization');
  if (saved) {
    currentBackgroundSettings = JSON.parse(saved);
  }
  
  // 恢复表单状态
  document.getElementById('backgroundType').value = currentBackgroundSettings.type;
  
  // 恢复淡化程度设置
  const opacity = currentBackgroundSettings.opacity || 0.3;
  document.getElementById('backgroundOpacity').value = opacity;
  document.getElementById('opacityValue').textContent = Math.round(opacity * 100) + '%';
  
  // 恢复图片选择
  if (currentBackgroundSettings.image) {
    document.getElementById('backgroundImageSelect').value = currentBackgroundSettings.image;
    document.getElementById('previewImg').src = currentBackgroundSettings.image;
    document.getElementById('imagePreview').style.display = 'block';
    
    // 更新预览图片的淡化效果
    setTimeout(function() {
      updatePreviewFadeEffect();
    }, 100);
  }
  
  // 显示对应选项
  changeBackgroundType();
}

// 显示通知
function showNotification(message, type = 'info') {
  const alertClass = type === 'success' ? 'alert-success' : 'alert-info';
  const icon = type === 'success' ? 'fa-check-circle' : 'fa-info-circle';
  
  const notification = $(`
    <div class="alert ${alertClass} alert-dismissible" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <i class="fa ${icon}"></i> ${message}
    </div>
  `);
  
  $('body').append(notification);
  
  // 3秒后自动消失
  setTimeout(() => {
    notification.fadeOut(() => {
      notification.remove();
    });
  }, 1000);
}

// 强制应用背景的函数
function forceApplyBackground() {
  const pageContent = document.getElementById('page-content');
  console.log('强制应用背景 - 页面内容元素:', pageContent);
  console.log('强制应用背景 - 背景图片:', currentBackgroundSettings.image);
  
  if (pageContent && currentBackgroundSettings.image) {
    // 移除旧的背景容器类
    pageContent.classList.remove('main-content-background');
    
    // 直接设置背景到页面内容
    const opacity = currentBackgroundSettings.opacity || 0.3;
    const fadeOpacity = 0.7 - opacity;
    
    pageContent.style.cssText = `
      background-image: url(${currentBackgroundSettings.image}) !important;
      background-size: cover !important;
      background-position: center !important;
      background-repeat: no-repeat !important;
      background-attachment: fixed !important;
      position: relative !important;
    `;
    
    // 添加遮罩层
    const overlay = document.createElement('div');
    overlay.id = 'background-overlay';
    overlay.style.cssText = `
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, ${fadeOpacity});
      z-index: 1;
      pointer-events: none;
    `;
    
    // 移除旧的遮罩
    const oldOverlay = document.getElementById('background-overlay');
    if (oldOverlay) {
      oldOverlay.remove();
    }
    
    pageContent.appendChild(overlay);
    
    // 确保所有子元素都在遮罩之上，但不干扰modal
    const children = pageContent.children;
    for (let i = 0; i < children.length; i++) {
      if (children[i].id === 'background-overlay') continue;
      // 完全跳过 Bootstrap 模态框相关元素
      if (children[i].classList && (
        children[i].classList.contains('modal') || 
        children[i].classList.contains('modal-backdrop') ||
        children[i].classList.contains('modal-dialog') ||
        children[i].classList.contains('modal-content')
      )) continue;
      
      children[i].style.position = 'relative';
      // 只在元素本身没有较高 z-index 时设置一个较低的默认层级
      const computedZ = parseInt(window.getComputedStyle(children[i]).zIndex) || 0;
      if (computedZ === 0 || computedZ < 100) {
        children[i].style.zIndex = '2';
      }
    }
    
    console.log('强制应用背景成功，遮罩透明度:', fadeOpacity);
    console.log('背景图片URL:', currentBackgroundSettings.image);
  } else {
    console.log('强制应用背景失败 - 页面内容元素或背景图片不存在');
  }
}

// 页面加载时应用保存的设置
$(document).ready(function() {
  // 先加载设置
  loadPersonalizationSettings();
  
  // 延迟应用背景，确保DOM完全加载
  setTimeout(function() {
    console.log('开始应用背景设置:', currentBackgroundSettings);
    // 页面加载时不显示通知
    applyPersonalization(false);
    
    // 如果正常方法失败，使用强制方法
    setTimeout(function() {
      if (currentBackgroundSettings.type === 'image' && currentBackgroundSettings.image) {
        console.log('使用强制方法应用背景');
        forceApplyBackground();
      }
    }, 500);
  }, 100);
  
  // 强制重定义showRecharge函数，确保使用Layer弹窗
  window.showRecharge = function(zid) {
    console.log('Global showRecharge called with zid:', zid);
    if (typeof layer === 'undefined') {
      alert('Layer组件未加载，请刷新页面重试');
      return;
    }
    layer.open({
      type: 1,
      title: '余额充值',
      area: ['400px', '300px'],
      content: `
        <div style="padding: 20px;">
          <div class="form-group">
            <label>操作类型：</label>
            <select class="form-control" id="recharge_do">
              <option value="0">加款</option>
              <option value="1">减款</option>
            </select>
          </div>
          <div class="form-group">
            <label>金额：</label>
            <input type="number" class="form-control" id="recharge_rmb" placeholder="请输入金额" step="0.01">
          </div>
          <div class="form-group">
            <label>备注：</label>
            <input type="text" class="form-control" id="recharge_remark" placeholder="备注信息（可选）">
          </div>
          <div class="form-group" style="margin-top: 20px;">
            <button type="button" class="btn btn-primary btn-block" onclick="doRecharge(${zid})">确认操作</button>
          </div>
        </div>
      `
    });
  };
  
  // 强制重定义doRecharge函数
  window.doRecharge = function(zid) {
    var actdo = $("#recharge_do").val();
    var rmb = $("#recharge_rmb").val();
    var remark = $("#recharge_remark").val();
    
    if(rmb == '' || rmb <= 0){
      layer.alert('请输入有效金额');
      return false;
    }
    
    var ii = layer.load(2, {shade:[0.1,'#fff']});
    $.ajax({
      type : "POST",
      url : "ajax_site.php?act=siteRecharge",
      data : {zid:zid,actdo:actdo,rmb:rmb,remark:remark},
      dataType : 'json',
      success : function(data) {
        layer.close(ii);
        if(data.code == 0){
          layer.msg('修改余额成功');
          layer.closeAll();
          if (typeof listTable === 'function') {
            listTable();
          } else {
            location.reload();
          }
        }else{
          layer.alert(data.msg);
        }
      },
      error:function(data){
        layer.close(ii);
        layer.msg('服务器错误');
        return false;
      }
    });
  };
});
</script>

<?php }?>
