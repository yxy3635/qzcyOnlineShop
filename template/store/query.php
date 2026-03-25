<?php
if (!defined('IN_CRONLITE')) die();

function display_zt($zt){
	if($zt==1)
		return '<span class="status-badge status-completed"><i class="icon-check"></i> 已完成</span>';
	elseif($zt==2)
		return '<span class="status-badge status-processing"><i class="icon-clock"></i> 处理中</span>';
	elseif($zt==3)
		return '<span class="status-badge status-error"><i class="icon-warning"></i> 异常</span>';
	elseif($zt==4)
		return '<span class="status-badge status-refunded"><i class="icon-undo"></i> 已退单</span>';
	elseif($zt==20)
		return '<span class="status-badge status-exam"><i class="icon-book"></i> 待考试</span>';
	elseif($zt==21)
		return '<span class="status-badge status-score"><i class="icon-star"></i> 平时分</span>';
	else
		return '<span class="status-badge status-pending"><i class="icon-time"></i> 已提交</span>';
}

if($islogin2==1){
	$cookiesid = $userrow['zid'];
}

$data=trim(daddslashes($_GET['data']));
$page=isset($_GET['page'])?intval($_GET['page']):1;
if(!empty($data)){
	if(strlen($data)==17 && is_numeric($data))
	{
	   $sql=" A.tradeno='{$data}'"; 
	}else{
	   $sql=" A.input='{$data}'";
	}
	if($conf['queryorderlimit']==1)$sql.=" AND A.`userid`='$cookiesid'";
}
else $sql=" A.userid='{$cookiesid}'";

$q_status=isset($_GET['status'])?trim(daddslashes($_GET['status'])):"";
if(isset($q_status) && $q_status != ""){
	$qu_status = intval($q_status);
	$sql .= " AND A.status = '{$qu_status}'";
}
$limit = 10;
$start = $limit * ($page-1);

$total = $DB->getColumn("SELECT count(*) FROM `pre_orders` A WHERE{$sql} ");
$total_page = ceil($total/$limit);
$sql = "SELECT A.*,B.`name`,B.`shopimg` FROM `pre_orders` A LEFT JOIN `pre_tools` B ON A.`tid`=B.`tid` WHERE{$sql} ORDER BY A.`id` DESC LIMIT {$start},{$limit}";
$rs=$DB->query($sql);
$record=array();
while($res = $rs->fetch()){
	$record[]=array('id'=>$res['id'],'tid'=>$res['tid'],'input'=>$res['input'],'money'=>$res['money'],'name'=>$res['name'],'shopimg'=>$res['shopimg'],'value'=>$res['value'],'addtime'=>$res['addtime'],'endtime'=>$res['endtime'],'result'=>$res['result'],'status'=>$res['status'],'djzt'=>$res['djzt'],'skey'=>md5($res['id'].SYS_KEY.$res['id']));
}
?>
<!DOCTYPE html>
<html lang="zh" style="font-size: 20px;">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover,user-scalable=no">
    <script> document.documentElement.style.fontSize = document.documentElement.clientWidth / 750 * 40 + "px";</script>
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $conf['sitename'].($conf['title']==''?'':' - '.$conf['title'])  ?></title>
    <meta name="keywords" content="<?php echo $conf['keywords'] ?>">
    <meta name="description" content="<?php echo $conf['description'] ?>">
    <link rel="shortcut icon" href="<?php echo $conf['default_ico_url'] ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/css/layui-2.5.7.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/foxui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/foxui.diy.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/iconfont.css">
    <link href="<?php echo $cdnserver; ?>assets/css/bootstrap-3.3.7.min.css" rel="stylesheet"/>
    <link href="<?php echo $cdnserver; ?>assets/css/font-awesome-4.7.0.min.css" rel="stylesheet"/>
    <script src="<?php echo $cdnserver; ?>assets/js/modernizr-2.8.3.min.js"></script>
	<?php echo str_replace('body','html',$background_css)?>
</head>

<style>
/* 现代化查询页面设计 */
:root {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --success-color: #48bb78;
    --warning-color: #ed8936;
    --danger-color: #f56565;
    --info-color: #4299e1;
    --light-color: #f8f9fa;
    --dark-color: #2d3748;
    --border-radius: 12px;
    --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    width: 100%;
    margin: 0;
    padding: 0;
    background: #f5f7fa;
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
    overflow-y: auto;
}

.fui-page-group {
    width: 100%;
    max-width: 650px;
    margin: 0 auto;
    background: #fff;
    border-radius: var(--border-radius);
    overflow: visible;
    position: relative;
    z-index: 1;
    padding-bottom: calc(60px + env(safe-area-inset-bottom));
}

/* 动态背景系统 */
.modern-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    pointer-events: none;
}

.floating-shapes {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    pointer-events: none;
}

.shape {
    position: absolute;
    background: rgba(200, 210, 220, 0.1);
    border-radius: 50%;
    animation: float 15s infinite linear;
}

.shape:nth-child(1) {
    width: 60px;
    height: 60px;
    top: 10%;
    left: 10%;
    animation-delay: 0s;
    animation-duration: 20s;
    background: rgba(200, 210, 220, 0.05);
}

.shape:nth-child(2) {
    width: 80px;
    height: 80px;
    top: 60%;
    right: 10%;
    animation-delay: -5s;
    animation-duration: 25s;
    background: rgba(200, 210, 220, 0.08);
}

.shape:nth-child(3) {
    width: 40px;
    height: 40px;
    bottom: 20%;
    left: 20%;
    animation-delay: -10s;
    animation-duration: 18s;
    background: rgba(200, 210, 220, 0.06);
}

@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    25% { background-position: 100% 50%; }
    50% { background-position: 100% 100%; }
    75% { background-position: 0% 100%; }
}

@keyframes float {
    0%, 100% { 
        transform: translateY(0) rotate(0deg) scale(1);
        opacity: 0.3;
    }
    25% { 
        transform: translateY(-20px) rotate(90deg) scale(1.1);
        opacity: 0.6;
    }
    50% { 
        transform: translateY(10px) rotate(180deg) scale(0.9);
        opacity: 0.8;
    }
    75% { 
        transform: translateY(-15px) rotate(270deg) scale(1.05);
        opacity: 0.4;
    }
}

/* 主容器样式 */
#body {
    position: relative;
    z-index: 2;
    padding: 15px;
    width: 100%;
    box-sizing: border-box;
    min-height: auto;
}

.fui-page {
    position: relative;
    z-index: 1;
    min-height: auto;
    overflow: visible;
}

/* 现代化搜索栏 */
.modern-search-container {
    background: #ffffff;
    border-radius: var(--border-radius);
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.search-title {
    text-align: center;
    margin-bottom: 1rem;
    color: var(--dark-color);
    font-weight: 600;
    font-size: 1.2rem;
    position: relative;
}

.search-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    border-radius: 2px;
}

.modern-search-input {
    position: relative;
    margin-bottom: 1rem;
}

.modern-search-input input {
    width: 100%;
    padding: 12px 20px 12px 45px;
    border: 2px solid #e2e8f0;
    border-radius: 25px;
    font-size: 0.9rem;
    transition: var(--transition);
    background: white;
    color: var(--dark-color);
}

.modern-search-input input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
}

.modern-search-input .search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    font-size: 1.1rem;
    transition: var(--transition);
}

.modern-search-input input:focus + .search-icon {
    color: var(--primary-color);
}

.modern-search-btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.modern-search-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.modern-search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.modern-search-btn:hover::before {
    left: 100%;
}

/* 现代化标签页 */
.modern-tabs {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: var(--border-radius);
    padding: 0.5rem;
    margin: 1rem;
    box-shadow: var(--box-shadow);
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: flex;
    flex-wrap: wrap;
    gap: 0.3rem;
}

.modern-tab {
    flex: 1;
    min-width: calc(50% - 0.15rem);
    padding: 8px 12px;
    text-align: center;
    border-radius: 8px;
    text-decoration: none;
    color: #64748b;
    font-size: 0.8rem;
    font-weight: 500;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.modern-tab.active {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.modern-tab:hover:not(.active) {
    background: rgba(102, 126, 234, 0.1);
    color: var(--primary-color);
    transform: translateY(-1px);
}

/* 状态徽章设计 */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
    letter-spacing: 0.2px;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.status-completed {
    background: linear-gradient(135deg, #48bb78, #38a169);
    box-shadow: 0 2px 8px rgba(72, 187, 120, 0.3);
}

.status-processing {
    background: linear-gradient(135deg, #ed8936, #dd6b20);
    box-shadow: 0 2px 8px rgba(237, 137, 54, 0.3);
}

.status-pending {
    background: linear-gradient(135deg, #4299e1, #3182ce);
    box-shadow: 0 2px 8px rgba(66, 153, 225, 0.3);
}

.status-error {
    background: linear-gradient(135deg, #f56565, #e53e3e);
    box-shadow: 0 2px 8px rgba(245, 101, 101, 0.3);
}

.status-refunded {
    background: linear-gradient(135deg, #a0aec0, #718096);
    box-shadow: 0 2px 8px rgba(160, 174, 192, 0.3);
}

.status-exam {
    background: linear-gradient(135deg, #9f7aea, #805ad5);
    box-shadow: 0 2px 8px rgba(159, 122, 234, 0.3);
}

.status-score {
    background: linear-gradient(135deg, #8B4513, #654321);
    box-shadow: 0 2px 8px rgba(139, 69, 19, 0.3);
}

/* 现代化订单卡片 */
.modern-order-card {
    background: #ffffff;
    border-radius: var(--border-radius);
    margin: 1rem 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: var(--transition);
    position: relative;
    width: 100%;
}

.modern-order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.order-container {
    padding: 0 15px;
    margin-bottom: 20px;
    width: 100%;
    box-sizing: border-box;
}

.order-header {
    padding: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.order-title {
    font-weight: 600;
    color: var(--dark-color);
    margin: 0;
    font-size: 0.9rem;
    max-width: 65%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.order-body {
    padding: 1rem;
}

.order-info-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.order-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: var(--transition);
}

.order-image:hover {
    transform: scale(1.05);
}

.order-details {
    flex: 1;
    font-size: 0.8rem;
    color: #64748b;
    line-height: 1.5;
}

.order-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
    margin-top: 0.5rem;
}

.modern-btn {
    padding: 6px 12px;
    border-radius: 15px;
    border: none;
    font-size: 0.7rem;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, var(--success-color), #38a169);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, var(--danger-color), #e53e3e);
    color: white;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    color: white;
    text-decoration: none;
}

/* 空状态设计 */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: var(--border-radius);
    margin: 1rem;
    box-shadow: var(--box-shadow);
}

.empty-state img {
    width: 120px;
    opacity: 0.6;
    margin-bottom: 1rem;
}

.empty-state p {
    color: #94a3b8;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}

.empty-state .btn {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 10px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.empty-state .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

/* 分页按钮 */
.pagination-container {
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: var(--border-radius);
    margin: 1rem;
    box-shadow: var(--box-shadow);
}

.pagination-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
}

.pagination-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* 订单说明悬浮球样式 */
.float-btn {
    position: fixed;
    right: 15px;
    bottom: calc(70px + env(safe-area-inset-bottom));
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #6366f1 0%, #7c3aed 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    z-index: 99;
    transition: all 0.3s ease;
    border: none;
}

.float-btn i {
    font-size: 22px;
    color: #fff;
}

/* 添加简单的动画效果 */
@keyframes gentle-float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-3px);
    }
}

.float-btn {
    animation: gentle-float 2s ease-in-out infinite;
}

.float-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
}

.float-btn:active {
    transform: scale(0.95);
}

/* 适配iPhone底部 */
@supports (padding-bottom: env(safe-area-inset-bottom)) {
    .float-btn {
        bottom: calc(70px + env(safe-area-inset-bottom));
    }
}

/* 状态说明弹窗 */
.status-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(5px);
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
}

.status-modal-content {
    background: white;
    border-radius: var(--border-radius);
    padding: 2rem;
    max-width: 90%;
    max-height: 70%;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.status-modal-title {
    text-align: center;
    margin-bottom: 1.5rem;
    color: var(--dark-color);
    font-weight: 600;
    font-size: 1.1rem;
}

.status-modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #94a3b8;
    cursor: pointer;
    transition: var(--transition);
}

.status-modal-close:hover {
    color: var(--danger-color);
    transform: scale(1.1);
}

/* 底部导航栏样式 */
.fui-navbar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 50px;
    background: #fff;
    display: flex;
    justify-content: space-around;
    align-items: center;
    box-shadow: 0 -1px 2px rgba(0,0,0,0.02);
    z-index: 100;
    padding-bottom: env(safe-area-inset-bottom);
}

.fui-navbar .nav-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #999;
    font-size: 12px;
    text-decoration: none;
    padding: 5px 0;
}

.fui-navbar .nav-item.active {
    color: #00a0e9;
}

.fui-navbar .nav-item i {
    font-size: 20px;
    height: 20px;
    line-height: 20px;
    margin-bottom: 4px;
}

.fui-navbar .nav-item .nav-text {
    font-size: 12px;
    line-height: 1.2;
    transform: scale(0.9);
}

/* 适配iPhone底部 */
@supports (padding-bottom: env(safe-area-inset-bottom)) {
    .fui-navbar {
        height: calc(50px + env(safe-area-inset-bottom));
        padding-bottom: env(safe-area-inset-bottom);
    }
}

/* 内容区域底部留白 */
.fui-page-group {
    padding-bottom: calc(50px + env(safe-area-inset-bottom));
}

/* 导航图标样式 */
.nav-icon {
    width: 24px;
    height: 24px;
    margin-bottom: 2px;
}

.nav-text {
    color: #666;
    font-size: 12px;
    line-height: 1;
    margin-top: 2px;
}

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 4px 0;
    text-decoration: none;
}

.nav-item.active .nav-text {
    color: var(--primary-color);
}

/* 响应式设计 */
@media (max-width: 480px) {
    .modern-tabs {
        gap: 0.2rem;
    }
    
    .modern-tab {
        min-width: calc(33.333% - 0.133rem);
        padding: 6px 8px;
        font-size: 0.7rem;
    }
    
    .order-info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .order-image {
        width: 50px;
        height: 50px;
    }
    
    .modern-btn {
        padding: 5px 10px;
        font-size: 0.65rem;
    }
}

/* 加载动画 */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
}
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modern-order-card {
    animation: fadeInUp 0.5s ease forwards;
}

.modern-order-card:nth-child(1) { animation-delay: 0.1s; }
.modern-order-card:nth-child(2) { animation-delay: 0.2s; }
.modern-order-card:nth-child(3) { animation-delay: 0.3s; }
.modern-order-card:nth-child(4) { animation-delay: 0.4s; }
.modern-order-card:nth-child(5) { animation-delay: 0.5s; }

/* 兼容性样式 */
.fix-iphonex-bottom {
    padding-bottom: 34px;
}

/* 隐藏原有样式冲突元素 */
.qt-header, .qt-card, .qt-btn, .layui-card {
    display: none !important;
}

@media screen and (max-width: 480px) {
    body {
        font-size: 14px;
    }
    
    .modern-order-card {
        margin: 0.75rem 0;
    }
    
    .order-header {
        padding: 0.75rem;
    }
    
    .order-body {
        padding: 0.75rem;
    }
}

/* 状态说明弹窗样式 */
.status-info-container {
    max-height: 400px;
    overflow-y: auto;
}

.status-info-container .status-item {
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.status-info-container .status-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.status-info-container .status-badge {
    margin-bottom: 8px;
    display: inline-flex;
}

.status-info-container p {
    margin: 0;
    color: #666;
    font-size: 14px;
    line-height: 1.5;
    padding-left: 10px;
}

.status-info-layer {
    border-radius: 8px;
    overflow: hidden;
}

.status-info-layer .layui-layer-title {
    background: #f8f9fa;
    color: #333;
    font-size: 16px;
    height: 45px;
    line-height: 45px;
    border-bottom: 1px solid #eee;
}

.status-info-layer .layui-layer-content {
    overflow: hidden;
}

/* 添加提示文字动画 */
.float-btn .tooltip {
    position: absolute;
    right: 120%;
    background: rgba(0, 0, 0, 0.75);
    color: #fff;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    transform: translateX(10px);
    transition: all 0.3s ease;
    pointer-events: none;
}

.float-btn:hover .tooltip {
    opacity: 1;
    transform: translateX(0);
}

/* 修改订单状态说明文字 */
.status-info-container .status-item p {
    margin: 5px 0 0 0;
    color: #666;
    font-size: 14px;
    line-height: 1.6;
    padding-left: 28px;
}

.status-info-container .status-item {
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 8px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.status-info-container .status-item:hover {
    background: #f0f2f5;
    transform: translateX(5px);
}
</style>

<body>
<!-- 动态背景 -->
<div class="modern-background"></div>
<div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<div id="body">
    <div class="fui-page-group statusbar">
        <!-- 现代化搜索区域 -->
        <div class="modern-search-container">
            <div class="search-title">🔍 订单查询</div>
            <div class="modern-search-input">
                <input type="search" id="query" value="<?php echo $data; ?>" placeholder="输入下单账号或订单号..." onkeydown="if(event.keyCode==13){OrderQuery()}">
                <i class="icon icon-search search-icon"></i>
                        	<input type="hidden" id="page" value="<?php echo $page?>">
                        	<input type="hidden" id="q_status" value="<?php echo $q_status?>">
                            </div>
            <button class="modern-search-btn" onclick="OrderQuery()">
                <i class="icon icon-search"></i> 立即查询
            </button>
                    </div>

        <!-- 现代化状态标签 -->
        <div class="modern-tabs">
            <a href="?mod=query&data=<?php echo $data; ?>" class="modern-tab <?php if(isset($q_status) && $q_status === ""){echo "active";} ?>">
                📋 全部
            </a>
            <a href="?mod=query&status=0&data=<?php echo $data; ?>" class="modern-tab <?php if($q_status === '0'){echo "active";} ?>">
                📤 已提交
            </a>
            <a href="?mod=query&status=2&data=<?php echo $data; ?>" class="modern-tab <?php if($q_status === '2'){echo "active";} ?>">
                ⏳ 处理中
            </a>
            <a href="?mod=query&status=1&data=<?php echo $data; ?>" class="modern-tab <?php if($q_status === '1'){echo "active";} ?>">
                ✅ 已完成
            </a>
            <a href="?mod=query&status=4&data=<?php echo $data; ?>" class="modern-tab <?php if($q_status === '4'){echo "active";} ?>">
                🔄 已退单
            </a>
            <a href="?mod=query&status=20&data=<?php echo $data; ?>" class="modern-tab <?php if($q_status === '20'){echo "active";} ?>">
                📚 待考试
            </a>
            <a href="?mod=query&status=21&data=<?php echo $data; ?>" class="modern-tab <?php if($q_status === '21'){echo "active";} ?>">
                ⭐ 平时分
            </a>
        </div>

        <!-- 订单列表 -->
        <?php if($record){ ?>
            <!-- 浮动帮助按钮 -->
            <a href="javascript:;" class="float-btn" onclick="showOrderStatusInfo()">
                <i class="icon icon-help"></i>
                <span class="tooltip">订单说明</span>
            </a>

            <?php foreach($record as $row){ ?>
            <div class="modern-order-card">
                <div class="order-header">
                    <h4 class="order-title"><?php echo $row['name']?></h4>
                    <?php echo display_zt($row['status'])?>
                </div>
                <div class="order-body">
                    <div class="order-info-row">
                        <img src="<?php echo $row['shopimg']?>" onerror="this.src='assets/store/picture/error_img.png'" class="order-image" alt="商品图片">
                        <div class="order-details">
                            <div>⏰ 下单时间：<?php echo $row['addtime']?></div>
                            <div>💰 商品总价：<?php echo $row['money']?>元</div>
                            <div>📦 购买数量：<?php echo $row['value']?>份</div>
            </div>
        </div>
                    <div class="order-actions">
                        <button class="modern-btn btn-primary" onclick="showOrder(<?php echo $row['id']?>,'<?php echo $row['skey']?>')">
                            <i class="icon icon-eye"></i> 查看详情
                      </button>
                        <a href="../order/list.php?tid=<?php echo $row['tid']?>&user=<?php echo $row['input']?>&ptname=<?php echo $row['name']?>" class="modern-btn btn-success">
                            <i class="icon icon-refresh"></i> 进度补刷
                      </a>
                      <?php if($row['djzt'] == 3){ ?>
                        <a href="?mod=faka&id=<?php echo $row['id']?>&skey=<?php echo $row['skey']?>" class="modern-btn btn-danger">
                            <i class="icon icon-download"></i> 提取卡密
                        </a>
                      <?php } ?>
               </div>
         </div>
    </div>
            <?php } ?>

            <!-- 分页 -->
            <?php if($page > 1 || $total_page != $page){ ?>
            <div class="pagination-container">
                <?php if($page > 1){ ?>
                <button class="pagination-btn" onclick="LastPage()">
                    ◀ 上一页
	</button>
                <?php } else { ?>
                <div></div>
                <?php } ?>
                
                <?php if($total_page != $page){ ?>
                <button class="pagination-btn" onclick="NextPage()">
                    下一页 ▶
	</button>
                <?php } else { ?>
                <div></div>
                <?php } ?>
</div>
            <?php } ?>

        <?php } else { ?>
            <!-- 空状态 -->
            <div class="empty-state">
                <img src="./assets/store/picture/nolist.png" alt="暂无订单">
                <?php if($_GET['data']){ ?>
                    <p>🔍 没有查询到相关订单</p>
                    <p>请检查输入的账号或订单号是否正确</p>
                <?php } else { ?>
                    <p>📋 您暂时没有任何订单</p>
                    <p>去首页看看有什么好东西吧！</p>
                    <a href="./" class="btn">🏠 去首页逛逛</a>
                <?php } ?>
</div>	
<?php } ?>

        <!-- 状态说明弹窗 -->
        <div class="status-modal" id="statusModal">
            <div class="status-modal-content">
                <button class="status-modal-close" onclick="hideStatusModal()">×</button>
                <div class="status-modal-title">📋 订单状态说明</div>
                <div>
                                    <?php echo $conf['gg_search'] ?>
                    <p style="margin-top: 1rem;">
                        <span class="status-badge status-exam"><i class="icon-book"></i> 待考试</span> 
                        等待考试开始
                    </p>
                    <p>
                        <span class="status-badge status-score"><i class="icon-star"></i> 平时分</span> 
                        正常进行平时分，每天45min左右
                    </p>
                        </div>
            </div>
        </div>

        <!-- 底部导航 -->
        <div class="fui-navbar">
            <a href="./" class="nav-item">
                <i class="icon icon-home"></i>
                <span class="nav-text">首页</span>
            </a>
            <a href="./?mod=query" class="nav-item active">
                <i class="icon icon-dingdan1"></i>
                <span class="nav-text">订单</span>
            </a>
            <a href="./?mod=cart" class="nav-item" <?php if($conf['shoppingcart']==0){?>style="display:none"<?php }?>>
                <i class="icon icon-cart2"></i>
                <span class="nav-text">购物车</span>
            </a>
            <a href="./?mod=kf" class="nav-item">
                <i class="icon icon-service1"></i>
                <span class="nav-text">客服</span>
            </a>
            <a href="./user/" class="nav-item">
                <i class="icon icon-person2"></i>
                <span class="nav-text">我的</span>
            </a>
        </div>
    </div>
</div>

<script src="<?php echo $cdnserver; ?>assets/js/jquery-3.4.1.min.js"></script>
<script src="<?php echo $cdnserver; ?>assets/js/jquery.lazyload-1.9.1.min.js"></script>
<script src="<?php echo $cdnserver; ?>assets/js/bootstrap-3.3.7.min.js"></script>
<script src="<?php echo $cdnserver; ?>assets/js/jquery.cookie-1.4.1.min.js"></script>
<script src="<?php echo $cdnserver; ?>assets/js/layui.all.js"></script>
<script src="<?php echo $cdnserver ?>assets/store/js/query.js"></script>

<script>
// 现代化交互功能
function showStatusModal() {
    document.getElementById('statusModal').style.display = 'flex';
    document.getElementById('statusModal').style.animation = 'fadeIn 0.3s ease';
}

function hideStatusModal() {
    const modal = document.getElementById('statusModal');
    modal.style.animation = 'fadeOut 0.3s ease';
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

// 点击弹窗外部关闭
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideStatusModal();
    }
});

// 搜索框焦点效果
document.getElementById('query').addEventListener('focus', function() {
    this.parentElement.style.transform = 'translateY(-2px)';
    this.parentElement.style.boxShadow = '0 8px 25px rgba(102, 126, 234, 0.2)';
});

document.getElementById('query').addEventListener('blur', function() {
    this.parentElement.style.transform = 'translateY(0)';
    this.parentElement.style.boxShadow = 'none';
});

// 页面加载动画
document.addEventListener('DOMContentLoaded', function() {
    // 为订单卡片添加延迟动画
    const cards = document.querySelectorAll('.modern-order-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100 + 200);
    });
});

// 添加CSS动画样式
const style = document.createElement('style');
style.textContent = `
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes fadeOut {
    from { opacity: 1; transform: scale(1); }
    to { opacity: 0; transform: scale(0.9); }
}
`;
document.head.appendChild(style);

function showOrderStatusInfo() {
    layer.open({
        type: 1,
        title: '订单状态说明',
        content: `<div class="status-info-container" style="padding: 15px;">
            <div class="status-item">
                <span class="status-badge status-pending"><i class="icon icon-time"></i> 已提交</span>
                <p>订单已提交到系统，等待处理</p>
            </div>
            <div class="status-item">
                <span class="status-badge status-processing"><i class="icon icon-clock"></i> 处理中</span>
                <p>订单正在处理中，请耐心等待</p>
            </div>
            <div class="status-item">
                <span class="status-badge status-completed"><i class="icon icon-check"></i> 已完成</span>
                <p>订单已完成，请查看订单结果</p>
            </div>
            <div class="status-item">
                <span class="status-badge status-error"><i class="icon icon-warning"></i> 异常</span>
                <p>订单处理出现异常，请联系客服</p>
            </div>
            <div class="status-item">
                <span class="status-badge status-refunded"><i class="icon icon-undo"></i> 已退单</span>
                <p>订单已退回，资金将原路返回</p>
            </div>
            <div class="status-item">
                <span class="status-badge status-exam"><i class="icon icon-book"></i> 待考试</span>
                <p>等待考试，到达考试时间，系统会自动上号。</p>
            </div>
            <div class="status-item">
                <span class="status-badge status-score"><i class="icon icon-star"></i> 平时分</span>
                <p>正在进行平时分，每天45min左右</p>
            </div>
        </div>`,
        area: ['300px', 'auto'],
        shadeClose: true,
        skin: 'status-info-layer'
    });
}
</script>

</body>
</html>