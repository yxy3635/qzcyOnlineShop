<?php
/**
 * 更新日志
**/
include("../includes/common.php");
$title='更新日志-千纸雏鸢';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="col-xs-12">
<div class="block">
<div class="block-title"><h3 class="panel-title">系统更新日志</h3></div>
<div class="block-content">
<div class="timeline">
<div class="timeline-item">
<div class="timeline-marker bg-primary"></div>
<div class="timeline-content">
<h4 class="timeline-title">v3.1.0 - 2025年9月</h4>
<div class="timeline-body">
<ul>
<li>取消内师入学考试入口</li>
<li>修复user用户自助下单偶现无法获取商品的问题</li>
<li>新增:个性背景的自定义上传功能</li>
</ul>
</div>
</div>
</div>

<div class="timeline-item">
<div class="timeline-marker bg-success"></div>
<div class="timeline-content">
<h4 class="timeline-title">v3.0.1 - 2025年7月</h4>
<div class="timeline-body">
<ul>
<li>新增更新日志功能，方便查看系统版本更新记录</li>
<li>优化后台管理界面，提升用户体验</li>
<li>修复已知问题，提升系统稳定性</li>
<li>改进数据库查询性能</li>
<li>重构前端user用户页面，提升页面访问稳定性</li>
<li><s>新增内师入学考试</s>（已取消）</li>
<li>实现资源本地化访问，大幅度提升页面访问的速度</li>
<li>新增个性化背景设置，提高观赏性</li>
<li>新增热键"ait + k" 常用窗口快捷跳转</li>
</ul>
</div>
</div>
</div>

<div class="timeline-item">
<div class="timeline-marker bg-info"></div>
<div class="timeline-content">
<h4 class="timeline-title">v1.1.3 - 历史版本</h4>
<div class="timeline-body">
<ul>
<li>修复已知问题</li>
<li>移除废弃api</li>
<li>优化动画流畅性</li>
</ul>
</div>
</div>
</div>
</div>

<div class="alert alert-info">
<i class="fa fa-info-circle"></i> 
<strong>提示：</strong> 系统会持续更新优化，请关注最新版本信息。如有问题请及时反馈。
</div>

<div class="alert alert-info" style="color: red;">
<i class="fa fa-info-circle"></i> 
<strong>联系作者：</strong> 电邮：yxy3635@gmail.com
</div>

<div class="alert alert-success">
<i class="fa fa-check-circle"></i> 
<strong>当前版本：</strong> 千纸雏鸢-qzcyOnlineSales-v3.0.1
</div>
</div>
</div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 40px;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #ddd;
}

.timeline-content {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-title {
    margin: 0 0 15px 0;
    color: #333;
    font-size: 18px;
    font-weight: 600;
}

.timeline-body ul {
    margin: 0;
    padding-left: 20px;
}

.timeline-body li {
    margin-bottom: 8px;
    color: #666;
    line-height: 1.6;
}

.bg-primary { background-color: #667eea !important; }
.bg-success { background-color: #34d399 !important; }
.bg-info { background-color: #17a2b8 !important; }

.alert {
    margin-top: 20px;
    border-radius: 8px;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.alert-info {
    background-color: #e3f2fd;
    color: #1976d2;
}

.alert-success {
    background-color: #e8f5e8;
    color: #2e7d32;
}
</style>
