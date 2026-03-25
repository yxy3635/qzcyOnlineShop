<?php
if (!defined('IN_CRONLITE')) die();

if($_GET['buyok']==1||$_GET['chadan']==1){include_once TEMPLATE_ROOT.'store/query.php';exit;}
if(isset($_GET['tid']) && !empty($_GET['tid']))
{
	$tid=intval($_GET['tid']);
    $tool=$DB->getRow("select tid from pre_tools where tid='$tid' limit 1");
    if($tool)
    {
		exit("<script language='javascript'>window.location.href='./?mod=buy&tid=".$tool['tid']."';</script>");
    }
}

$cid = intval($_GET['cid']);
if(!$cid && !empty($conf['defaultcid']) && $conf['defaultcid']!=='0'){
	$cid = intval($conf['defaultcid']);
}
$ar_data = [];
$classhide = explode(',',$siterow['class']);
$re = $DB->query("SELECT * FROM `pre_class` WHERE `active` = 1 ORDER BY `sort` ASC ");
$qcid = "";
$cat_name = "";
while ($res = $re->fetch()) {
    if($is_fenzhan && in_array($res['cid'], $classhide))continue;
    if($res['cid'] == $cid){
    	$cat_name=$res['name'];
    	$qcid = $cid;
    }
    $ar_data[] = $res;
}


$class_show_num = intval($conf['index_class_num_style'])?intval($conf['index_class_num_style']):2; //分类展示几组
?>
<!DOCTYPE html>
<html lang="zh" style="font-size: 102.4px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no"/>
    <script> document.documentElement.style.fontSize = document.documentElement.clientWidth / 750 * 40 + "px";</script>
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-param" content="_csrf">
    <title><?php echo $hometitle?></title>
    <meta name="keywords" content="<?php echo $conf['keywords'] ?>">
    <meta name="description" content="<?php echo $conf['description'] ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/foxui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/foxui.diy.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/iconfont.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/index.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/css/layui-2.5.7.css">
    <link href="<?php echo $cdnserver; ?>assets/css/swiper-6.4.5-bundle.min.css" rel="stylesheet">
    <style>
        /* ========== 简洁现代化设计 ========== */
        
        /* 整体页面简化 */
        body {
            background: #f5f7fa !important;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding: 0;
            margin: 0;
        }

        /* 主容器简化设计 */
        #body {
            background: #ffffff;
            border-radius: 12px 12px 0 0;
            margin: 0;
            padding: 0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
            min-height: 100vh;
        }

        /* 确保容器背景一致 */
        #container {
            background-color: #f5f7fa !important;
        }



        /* 轮播图区域 - 滑入动画 */
        .hero-section {
            padding: 16px;
            opacity: 0;
            transform: translateY(20px);
            animation: slideInUp 0.4s ease-out forwards;
            animation-delay: 0s;
        }

        @keyframes slideInUp {
            from { 
                opacity: 0; 
                transform: translateY(20px);
            }
            to { 
                opacity: 1; 
                transform: translateY(0);
            }
        }

        .fui-swipe {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        /* 公告栏 - 滑入动画 */
        .announcement-section {
            padding: 0 16px 12px;
            opacity: 0;
            transform: translateY(20px);
            animation: slideInUp 0.4s ease-out forwards;
            animation-delay: 0.1s;
        }

        .fui-notice {
            background: #ef4444;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2);
            border: none;
            margin: 0;
        }

        /* APP下载区域 - 震撼登场动画 */
        .app-download-section {
            padding: 16px;
            opacity: 0;
            transform: translateY(100px) scale(0.8);
            animation: spectacularEntrance 1.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            animation-delay: 0.5s;
        }

        @keyframes spectacularEntrance {
            0% {
                opacity: 0;
                transform: translateY(100px) scale(0.8) rotateX(90deg);
                filter: blur(10px);
            }
            40% {
                opacity: 0.6;
                transform: translateY(20px) scale(1.05) rotateX(20deg);
                filter: blur(2px);
            }
            70% {
                opacity: 0.9;
                transform: translateY(-10px) scale(1.02) rotateX(-5deg);
                filter: blur(0px);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1) rotateX(0deg);
                filter: blur(0px);
            }
        }

        .app-download-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            border-radius: 20px;
            padding: 24px 20px;
            box-shadow: 
                0 15px 35px rgba(102, 126, 234, 0.4),
                0 5px 15px rgba(118, 75, 162, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.15);
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: gradientFlow 8s ease-in-out infinite;
            border: 2px solid rgba(255, 255, 255, 0.1);
            opacity: 0;
            transform: scale(0.5) rotateY(180deg);
            animation-delay: 1s;
            animation-fill-mode: forwards;
        }

        .app-download-card.animate {
            animation: cardFlipIn 1.2s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards,
                       gradientFlow 8s ease-in-out infinite 1.2s;
        }

        @keyframes cardFlipIn {
            0% {
                opacity: 0;
                transform: scale(0.5) rotateY(180deg) rotateX(45deg);
                filter: brightness(0.3);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.1) rotateY(0deg) rotateX(10deg);
                filter: brightness(1.2);
            }
            80% {
                opacity: 1;
                transform: scale(0.95) rotateY(-10deg) rotateX(-5deg);
                filter: brightness(1.1);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotateY(0deg) rotateX(0deg);
                filter: brightness(1);
            }
        }

        @keyframes gradientFlow {
            0%, 100% {
                background-position: 0% 50%;
            }
            25% {
                background-position: 100% 50%;
            }
            50% {
                background-position: 50% 100%;
            }
            75% {
                background-position: 0% 0%;
            }
        }

        .app-download-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.3), 
                rgba(255, 255, 255, 0.1),
                transparent
            );
            animation: shineWave 4s infinite;
            z-index: 1;
        }

        @keyframes shineWave {
            0% {
                left: -100%;
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            50% {
                left: 100%;
                opacity: 1;
            }
            100% {
                left: 100%;
                opacity: 0;
            }
        }

        .app-download-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, 
                rgba(255, 255, 255, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 40%,
                transparent 70%
            );
            animation: breathe 6s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes breathe {
            0%, 100% {
                transform: scale(0.8) rotate(0deg);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.3) rotate(180deg);
                opacity: 0.7;
            }
        }

        .app-download-text {
            color: white;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 12px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            animation: textGlow 3s ease-in-out infinite alternate;
            opacity: 0;
            transform: translateY(30px) scale(0.8);
            animation-delay: 1.5s;
            animation-fill-mode: forwards;
        }

        .app-download-text.animate {
            animation: textReveal 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards,
                       textGlow 3s ease-in-out infinite alternate 0.8s;
        }

        @keyframes textReveal {
            0% {
                opacity: 0;
                transform: translateY(30px) scale(0.8);
                filter: blur(5px);
            }
            60% {
                opacity: 0.8;
                transform: translateY(-5px) scale(1.05);
                filter: blur(1px);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0px);
            }
        }

        @keyframes textGlow {
            from {
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }
            to {
                text-shadow: 
                    0 2px 4px rgba(0, 0, 0, 0.2),
                    0 0 8px rgba(255, 255, 255, 0.3);
            }
        }

        .appDown {
            display: inline-block;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.95);
            color: #667eea;
            font-size: 15px;
            font-weight: 700;
            border-radius: 25px;
            text-decoration: none;
            position: relative;
            z-index: 2;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(255, 255, 255, 0.8);
            box-shadow: 
                0 4px 15px rgba(255, 255, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            animation: buttonPulse 2s ease-in-out infinite;
            opacity: 0;
            transform: translateY(50px) rotateX(90deg) scale(0.5);
            animation-delay: 2s;
            animation-fill-mode: forwards;
        }

        .appDown.animate {
            animation: buttonDrop 1s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards,
                       buttonPulse 2s ease-in-out infinite 1s;
        }

        @keyframes buttonDrop {
            0% {
                opacity: 0;
                transform: translateY(50px) rotateX(90deg) scale(0.5);
                filter: drop-shadow(0 20px 20px rgba(0,0,0,0.3));
            }
            40% {
                opacity: 0.7;
                transform: translateY(-10px) rotateX(20deg) scale(1.1);
                filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));
            }
            70% {
                opacity: 0.9;
                transform: translateY(5px) rotateX(-10deg) scale(0.95);
                filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1));
            }
            100% {
                opacity: 1;
                transform: translateY(0) rotateX(0deg) scale(1);
                filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
            }
        }

        @keyframes buttonPulse {
            0%, 100% {
                box-shadow: 
                    0 4px 15px rgba(255, 255, 255, 0.2),
                    inset 0 1px 0 rgba(255, 255, 255, 0.8),
                    0 0 0 0 rgba(255, 255, 255, 0.4);
            }
            50% {
                box-shadow: 
                    0 6px 20px rgba(255, 255, 255, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9),
                    0 0 0 8px rgba(255, 255, 255, 0.1);
            }
        }

        .appDown::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(102, 126, 234, 0.2), 
                transparent
            );
            transition: left 0.6s ease;
        }

        .appDown:hover {
            background: white;
            color: #764ba2;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 
                0 8px 25px rgba(255, 255, 255, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 1),
                0 0 0 4px rgba(255, 255, 255, 0.2);
        }

        .appDown:hover::before {
            left: 100%;
        }

        .appDown:active {
            transform: translateY(0) scale(0.98);
            transition: transform 0.1s ease;
        }

        /* 涟漪效果 */
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            pointer-events: none;
            transform: scale(0);
            z-index: 1;
        }

        .ripple-animation {
            animation: ripple 0.6s linear;
        }

        @keyframes ripple {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }

        /* 完成时的震撼效果 */
        @keyframes completionShake {
            0%, 100% { transform: translateX(0); }
            10% { transform: translateX(-3px) scale(1.02); }
            20% { transform: translateX(3px) scale(1.02); }
            30% { transform: translateX(-2px) scale(1.01); }
            40% { transform: translateX(2px) scale(1.01); }
            50% { transform: translateX(-1px) scale(1.005); }
            60% { transform: translateX(1px) scale(1.005); }
            70% { transform: translateX(0) scale(1); }
        }

        /* 粒子效果增强 */
        .particle {
            box-shadow: 
                0 0 6px currentColor,
                0 0 12px currentColor,
                0 0 18px currentColor;
            animation: particleGlow 0.8s ease-out;
        }

        @keyframes particleGlow {
            0% {
                transform: scale(0) rotate(0deg);
                box-shadow: 
                    0 0 6px currentColor,
                    0 0 12px currentColor,
                    0 0 18px currentColor;
            }
            50% {
                transform: scale(1.5) rotate(180deg);
                box-shadow: 
                    0 0 12px currentColor,
                    0 0 24px currentColor,
                    0 0 36px currentColor;
            }
            100% {
                transform: scale(0.5) rotate(360deg);
                box-shadow: 
                    0 0 3px currentColor,
                    0 0 6px currentColor,
                    0 0 9px currentColor;
            }
        }

        /* 移动端优化 */
        @media (max-width: 768px) {
            .app-download-card {
                margin: 12px;
                padding: 20px 16px;
                border-radius: 16px;
            }
            
            .app-download-text {
                font-size: 14px;
            }
            
            .appDown {
                padding: 10px 20px;
                font-size: 14px;
            }
            
            .app-download-card::before,
            .app-download-card::after {
                animation-duration: 6s, 8s;
            }
        }



        /* 搜索区域 - 滑入动画 */
        .search-section {
            padding: 16px;
            opacity: 0;
            transform: translateY(20px);
            animation: slideInUp 0.4s ease-out forwards;
            animation-delay: 0.2s;
        }

        .searchbar {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .searchbar:focus-within {
            border-color: #4f46e5;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
        }

        .searchbtn {
            background: #e2e8f0;
            color: #64748b;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
            transition: all 0.3s ease;
            width: 36px !important;
            height: 36px !important;
            padding: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: auto;
        }

        .searchbtn:hover {
            background: #cbd5e1;
            color: #475569;
            border-color: #94a3b8;
            transform: scale(1.05);
        }

        .searchbtn:hover {
            background: #4338ca;
        }

        /* 分类区域 - 滑入动画 */
        .categories-section {
            padding: 8px 16px;
            opacity: 0;
            transform: translateY(20px);
            animation: slideInUp 0.4s ease-out forwards;
            animation-delay: 0.3s;
        }

        .content-slide {
            background: #f7f8fa;
            border-radius: 8px;
            box-shadow: none;
        }

        .categories-grid {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            gap: 12px;
            padding: 8px 4px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
        
        .categories-grid::-webkit-scrollbar {
            display: none;
        }
        
        .categories-grid {
            scrollbar-width: none;
        }
        
        /* 分类容器添加滑动提示 */
        .categories-section::after {
            content: "👈 左右滑动查看更多分类";
            position: absolute;
            bottom: 2px;
            right: 16px;
            font-size: 10px;
            color: #999;
            opacity: 0.7;
            animation: fadeInOut 3s ease-in-out infinite;
        }
        
        @keyframes fadeInOut {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.8; }
        }
        
        /* 分类项悬停效果增强 */
        .get_cat:active .mbg {
            transform: scale(0.95);
            background: #f0f0f0;
        }

        /* 分类标题样式 */
        .category-title-container {
            margin-bottom: 12px;
            padding: 0 8px;
        }

        .category-title {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 12px 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            opacity: 0;
            transform: translateY(-30px) scale(0.8);
            animation: titleEntrance 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards,
                       titlePulse 3s ease-in-out infinite 1s;
        }

        .title-icon {
            font-size: 18px;
            margin-right: 8px;
            opacity: 0;
            transform: translateX(-20px) rotate(-180deg);
            animation: iconEntrance 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.3s forwards,
                       iconBounce 2s ease-in-out infinite 1.3s;
        }

        .title-text {
            flex: 1;
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateX(20px);
            animation: textSlideIn 0.6s ease-out 0.6s forwards;
        }

        .title-decoration {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.3), 
                rgba(255, 255, 255, 0.1),
                transparent
            );
            animation: shimmerEffect 4s infinite;
            z-index: 1;
        }

        /* 标题入场动画 */
        @keyframes titleEntrance {
            0% {
                opacity: 0;
                transform: translateY(-30px) scale(0.8) rotateX(90deg);
                filter: blur(10px);
            }
            40% {
                opacity: 0.8;
                transform: translateY(5px) scale(1.05) rotateX(20deg);
                filter: blur(2px);
            }
            70% {
                opacity: 1;
                transform: translateY(-2px) scale(0.98) rotateX(-5deg);
                filter: blur(0px);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1) rotateX(0deg);
                filter: blur(0px);
            }
        }

        /* 标题脉动动画 */
        @keyframes titlePulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            }
            50% {
                transform: scale(1.02);
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            }
        }

        /* 图标入场动画 */
        @keyframes iconEntrance {
            0% {
                opacity: 0;
                transform: translateX(-20px) rotate(-180deg) scale(0.5);
            }
            60% {
                opacity: 1;
                transform: translateX(3px) rotate(10deg) scale(1.2);
            }
            80% {
                transform: translateX(-1px) rotate(-5deg) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translateX(0) rotate(0deg) scale(1);
            }
        }

        /* 文字滑入动画 */
        @keyframes textSlideIn {
            0% {
                opacity: 0;
                transform: translateX(20px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* 图标弹跳动画 */
        @keyframes iconBounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            10% {
                transform: translateY(-3px) rotate(-5deg);
            }
            30% {
                transform: translateY(-2px) rotate(5deg);
            }
            60% {
                transform: translateY(-1px) rotate(-2deg);
            }
        }

        /* 闪光效果动画 */
        @keyframes shimmerEffect {
            0% {
                left: -100%;
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            50% {
                left: 100%;
                opacity: 1;
            }
            100% {
                left: 100%;
                opacity: 0;
            }
        }

        /* 移动端标题适配 */
        @media (max-width: 768px) {
            .category-title {
                font-size: 15px;
                padding: 10px 14px;
            }
            
            .title-icon {
                font-size: 16px;
                margin-right: 6px;
            }
        }

        .get_cat {
            text-decoration: none;
            flex-shrink: 0;
            min-width: 80px;
            max-width: 80px;
        }

        .mbg {
            background: #fff;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-align: center;
            padding: 8px;
            height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .mbg:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .ico img {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            object-fit: cover;
            margin-bottom: 4px;
        }
        
        .icon-title {
            font-size: 12px !important;
            color: #333 !important;
            text-align: center !important;
            margin: 0 !important;
            line-height: 1.2 !important;
            word-break: break-all;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            height: 28px;
        }

        .get_cat:hover .ico img {
            border-color: #4f46e5;
            transform: scale(1.15);
            box-shadow: 0 4px 16px rgba(79, 70, 229, 0.2);
        }

        /* 排序区域 - 滑入动画 */
        .sorting-section {
            padding: 0 16px 8px;
            opacity: 0;
            transform: translateY(20px);
            animation: slideInUp 0.4s ease-out forwards;
            animation-delay: 0.4s;
        }

        .goods_sort {
            background: #f7f8fa;
            border-radius: 8px;
            padding: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .goods_sort .item {
            flex: 1;
            text-align: center;
            padding: 4px;
        }

        .goods_sort .item:hover {
            color: #1492fb;
        }

        .goods_sort .item.on {
            color: #1492fb;
        }

        .goods_sort .item .sorting {
            display: inline-block;
            margin-left: 2px;
        }

        .goods_sort .item .icon {
            font-size: 12px;
        }

        /* 商品列表区域 - 滑入动画 */
        .products-section {
            padding: 8px;
            background: #f5f7fa;
            min-height: 50vh;
            opacity: 0;
            transform: translateY(30px);
            animation: slideInUp 0.5s ease-out forwards;
            animation-delay: 0.5s;
        }

        #goods-list-container {
            background: transparent !important;
        }

        .fui-goods-item {
            background: #ffffff !important;
            border-radius: 12px !important;
            margin: 0 !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
            border: 1px solid #e5e7eb !important;
            transition: all 0.3s ease !important;
            overflow: hidden;
            opacity: 0;
            transform: translateY(25px) scale(0.95);
            animation: goodsSlideIn 0.4s ease-out forwards;
        }

        @keyframes goodsSlideIn {
            from { 
                opacity: 0; 
                transform: translateY(25px) scale(0.95);
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1);
            }
        }

        /* 商品项交错淡入 */
        .fui-goods-item:nth-child(1) { animation-delay: 0.6s; }
        .fui-goods-item:nth-child(2) { animation-delay: 0.65s; }
        .fui-goods-item:nth-child(3) { animation-delay: 0.7s; }
        .fui-goods-item:nth-child(4) { animation-delay: 0.75s; }
        .fui-goods-item:nth-child(5) { animation-delay: 0.8s; }
        .fui-goods-item:nth-child(6) { animation-delay: 0.85s; }

        .fui-goods-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12) !important;
        }

        .fui-goods-item .image {
            border-radius: 12px 12px 0 0 !important;
            overflow: hidden;
        }

        .fui-goods-item .image img {
            border-radius: 12px 12px 0 0 !important;
            transition: transform 0.3s ease !important;
        }

        .fui-goods-item:hover .image img {
            transform: scale(1.05);
        }

        .fui-goods-item .detail .name {
            font-weight: 600 !important;
            color: #1f2937 !important;
        }

        .fui-goods-item .detail .minprice {
            color: #ef4444 !important;
            font-weight: 700 !important;
        }

        .fui-goods-item .detail .price .buy {
            background: #4f46e5 !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            border: none !important;
        }

        .fui-goods-item .detail .price .buy:hover {
            background: #4338ca !important;
            transform: translateY(-1px);
        }

        /* 底部导航简化 */
        .fui-navbar {
            background: #ffffff !important;
            border-top: 1px solid #e5e7eb !important;
            box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.08);
        }

        /* 移动端优化 */
        @media (max-width: 768px) {
            .hero-section,
            .announcement-section,
            .app-download-section,
            .search-section,
            .categories-section,
            .sorting-section,
            .products-section {
                padding: 12px;
            }
            
            .categories-grid {
                gap: 8px;
                padding: 8px 2px;
            }
            
            .content-slide {
                padding: 12px;
            }
            
            .get_cat {
                min-width: 70px;
                max-width: 70px;
            }
            
            .mbg {
                height: 90px;
                padding: 6px;
            }
            
            .ico img {
                width: 45px;
                height: 45px;
            }
            
            .searchbtn {
                width: 32px !important;
                height: 32px !important;
            }
            
            /* 移动端商品间距优化 */
            .fui-goods-item {
                padding: 0.4rem !important;
            }
            
            .products-section {
                padding: 6px !important;
            }
        }

        .fui-goods-item {
            width: 33.33% !important;
            margin: 0 !important;
            padding: 0.5rem !important;
            box-sizing: border-box !important;
            flex: 0 0 33.33% !important;
            max-width: 33.33% !important;
        }
        
        .fui-goods-group.block .fui-goods-item {
            width: 33.33% !important;
            margin: 0 !important;
            padding: 0.5rem !important;
            box-sizing: border-box !important;
            flex: 0 0 33.33% !important;
            max-width: 33.33% !important;
        }
        
        .fui-goods-group.block.three .fui-goods-item {
            width: 33.33% !important;
            margin: 0 !important;
            padding: 0.5rem !important;
            box-sizing: border-box !important;
            flex: 0 0 33.33% !important;
            max-width: 33.33% !important;
        }

        .fui-goods-group.block.three {
            display: flex !important;
            flex-wrap: wrap !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .fui-goods-group.block.three .flow_load {
            width: 100% !important;
            display: flex !important;
            flex-wrap: wrap !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .fui-goods-group.block.three #goods_list {
            width: 100% !important;
            display: flex !important;
            flex-wrap: wrap !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .fui-goods-item .image {
            width: 100% !important;
        }

        .fui-goods-item a {
            display: block !important;
            width: 100% !important;
        }
    </style>


    <?php echo str_replace('body','html',$background_css)?>
</head>
<style type="text/css">
    body {
        position: absolute;;

        margin: auto;
    }
    .fui-page.fui-page-from-center-to-left,
    .fui-page-group.fui-page-from-center-to-left,
    .fui-page.fui-page-from-center-to-right,
    .fui-page-group.fui-page-from-center-to-right,
    .fui-page.fui-page-from-right-to-center,
    .fui-page-group.fui-page-from-right-to-center,
    .fui-page.fui-page-from-left-to-center,
    .fui-page-group.fui-page-from-left-to-center {
        -webkit-animation: pageFromCenterToRight 0ms forwards;
        animation: pageFromCenterToRight 0ms forwards;
    }
    .fix-iphonex-bottom {
        padding-bottom: 34px;
    }
    .fui-goods-item .detail .price .buy {
        color: #fff;
        background: #1492fb;
        border-radius: 3px;
        line-height: 1.1rem;
    }
    .fui-goods-item .detail .sale {
        height: 1.7rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        font-size: 0.65rem;
        line-height: 0.9rem;
    }
    .goods-category {
        display: flex;
        background: #fff;
        flex-wrap: wrap;
    }

    .goods-category li {
        width: 25%;
        list-style: none;
        margin: 0.4rem 0;
        color: #666;
        font-size: 0.65rem;

    }

    .goods-category li.active p {
        background: #1492fb;
        color: #fff;
    }

    body {
        padding-bottom: constant(safe-area-inset-bottom);
        padding-bottom: env(safe-area-inset-bottom);
    }

    .goods-category li p {
        width: 4rem;
        height: 2rem;
        text-align: center;
        line-height: 2rem;
        border: 1px solid #ededed;
        margin: 0 auto;
        -webkit-border-radius: 0.1rem;
        -moz-border-radius: 0.1rem;
        border-radius: 0.1rem;
    }
    .footer ul {
        display: flex;
        width: 100%;
        margin: 0 auto;
    }

    .footer ul li {
        list-style: none;
        flex: 1;
        text-align: center;
        position: relative;
        line-height: 2rem;
    }

    .footer ul li:after {
        content: '';
        position: absolute;
        right: 0;
        top: .8rem;
        height: 10px;
        border-right: 1px solid #999;


    }

    .footer ul li:nth-last-of-type(1):after {
        display: none;
    }

    .footer ul li a {
        color: #999;
        display: block;
        font-size: .6rem;
    }
.fui-goods-group.block .fui-goods-item .image {
     width: 100%; 
     margin: unset; 
     padding-bottom: unset; 
     <?php if(checkmobile()){ ?>
        height:5.5rem;
     <?php }else{ ?>
        height:8rem;
     <?php } ?>
     

}
.layui-flow-more{
        width: 100%;
    float: left;
}
.fui-goods-group .fui-goods-item .image img{
    border-radius:5px;    
}
.fui-goods-group .fui-goods-item .detail .minprice {
    font-size: .6rem;
}
.fui-goods-group .fui-goods-item .detail .name{
    height: 1.9rem;
}

.swiper-pagination-bullet {
  width: 20px;
  height: 20px;
  text-align: center;
  line-height: 20px;
  font-size: 12px;
  color: #000;
  opacity: 1;
  background: rgba(0, 0, 0, 0.2);
}

.swiper-pagination-bullet-active {
  color: #fff;
  background: #ed414a;
}
.swiper-pagination{
    position: unset;
}
.swiper-container{
    --swiper-theme-color: #ff6600;/* 设置Swiper风格 */
    --swiper-navigation-color: #007aff;/* 单独设置按钮颜色 */
    --swiper-navigation-size: 18px;/* 设置按钮大小 */
}
.goods_sort {
    position: relative;
    width: 100%;

    -webkit-box-align: center;
    padding: .4rem 0;
    background: #fff;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
}

.goods_sort:after {
    content: " ";
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    border-bottom: 1px solid #e7e7e7;
}

.goods_sort .item {
    position: relative;
    width: 1%;
    display: table-cell;
    text-align: center;
    font-size: 0.7rem;
    border-left: 1px solid #e7e7e7;
    color: #666;
}
.goods_sort .item .sorting {
    width: .2rem;
    height: .2rem;
    position: relative;
}
.goods_sort .item:first-child {
    border: 0;
}

.goods_sort .item.on .text {
    color: #fd5454;
}
.goods_sort .item .sorting .icon {
    /*font-size: 11px;*/
    position: absolute;
    -webkit-transform: scale(0.6);
    -ms-transform: scale(0.6);
    transform: scale(0.6);
}

.goods_sort .item-price .sorting .icon-sanjiao1 {
    top: .15rem;
    left: 0;
}

.goods_sort .item-price .sorting .icon-sanjiao2 {
    top: -.15rem;
    left: 0;
}

.goods_sort .item-price.DESC .sorting .icon-sanjiao1 {
    color: #ef4f4f
}

.goods_sort .item-price.ASC .sorting .icon-sanjiao2 {
    color: #ef4f4f
}
.content-slide .shop_active .icon-title {
    color: #ff5555;
}
.xz {
    background-color: #3399ff;
    color: white !important;
    border-radius: 5px;
}
.tab_con > ul > li.layui-this{
    background: linear-gradient(to right, #73b891, #53bec5);
    color: #fff;
    border-radius: 6px;
    text-align: center;
}
#audio-play #audio-btn{width: 44px;height: 44px; background-size: 100% 100%;position:fixed;bottom:5%;right:6px;z-index:111;}
#audio-play .on{background: url('assets/img/music_on.png') no-repeat 0 0;}
#audio-play .off{background:url('assets/img/music_off.png') no-repeat 0 0}

</style>
<body ontouchstart="" style="overflow: auto;height: auto !important;max-width: 650px;">
<div id="body">
    <div style="position: fixed;    z-index: 100;    top: 30px;    left: 20px;       color: white;    padding: 2px 8px;      background-color: rgba(0,0,0,0.4);    border-radius: 5px;display: none" id="xn_text">
    </div>
    <div class="fui-page-group " style="height: auto">
        <div class="fui-page  fui-page-current " style="height:auto; overflow: inherit">
            <div class="fui-content navbar" id="container" style="background-color: #fafafc;overflow: inherit">


                <!-- 轮播图区域 -->
                <div class="hero-section">
                    <div class="fui-swipe">
                        <style>
                            .fui-swipe-page .fui-swipe-bullet {
                                background: #ffffff;
                                opacity: 0.6;
                                width: 12px;
                                height: 12px;
                                border-radius: 50%;
                                margin: 0 4px;
                                transition: all 0.3s ease;
                            }

                            .fui-swipe-page .fui-swipe-bullet.active {
                                opacity: 1;
                                background: linear-gradient(135deg, #667eea, #764ba2);
                                transform: scale(1.2);
                            }
                        </style>
                        <div class="fui-swipe-wrapper" style="transition-duration: 500ms;">
                            <?php
                            $banner = explode('|', $conf['banner']);
                            foreach ($banner as $v) {
                                $image_url = explode('*', $v);
                                echo '<a class="fui-swipe-item" href="' . $image_url[1] . '">
                                <img src="' . $image_url[0] . '" style="display: block; width: 100%; height: auto;" />
                            </a>';
                            }
                            ?>
                        </div>
                        <div class="fui-swipe-page right round" style="padding: 0 8px; bottom: 8px; ">
                        </div>
                    </div>
                </div>

                <!-- 公告栏区域 -->
                <div class="announcement-section">
                    <div class="fui-notice">
                        <div class="image">
                            <a href="JavaScript:void(0)" onclick="$('.tzgg').show()"><img src="assets/store/picture/1571065042489353.jpg"></a>
                        </div>
                        <div class="text" style="height: 1.2rem;line-height: 1.2rem">
                            <ul>
                                <li><a href="JavaScript:void(0)" onclick="$('.tzgg').show()">
                                        <marquee behavior="alternate">
                                            <span style="color:white; font-weight: 600;">课程项目加载缓慢请多等待几秒钟~</span>
                                        </marquee>
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- APP下载区域 -->
                <div class="app-download-section">
                    <div class="app-download-card">
                        <div class="app-download-text">
                            网页使用卡顿？下载官方最新版app告别卡顿！
                        </div>
                        <a class="appDown" href="../appDownload/index.html">
                            立即下载APP
                        </a>
                    </div>
                </div>
                <!-- 搜索区域 -->
                <div class="search-section">
                    <form action="" method="get" id="goods_search"><input type="hidden" value="yes" name="search">
                        <div class="fui-searchbar bar">
                            <div class="searchbar center searchbar-active" style="padding-right:2.5rem">
                                <button type="submit" class="searchbar-cancel searchbtn">
                                    <i class="icon icon-search" style="font-size: 16px;"></i>
                                </button>
                                <div class="search-input" style="border: 0px;padding-left:0px;padding-right:0px;">
                                    <input type="text" class="search" value="<?php echo trim(daddslashes($_GET['kw']));?>" name="kw" placeholder="输入商品关键字..." id="kw">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- 分类区域 -->
                <div class="categories-section" style="padding: 8px 16px; position: relative;">
                    <!-- 分类标题 -->
                    <div class="category-title-container">
                        <h3 class="category-title">
                            <span class="title-icon">🏷️</span>
                            <span class="title-text">商品分类</span>
                            <span class="title-decoration"></span>
                        </h3>
                    </div>
                    <div class="device">
                        <div class="swiper-container">
                            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                <?php
                                $arry = 0;
                                $au = 1;
                                foreach ($ar_data as $v) {
                                    if (($arry / ($class_show_num*5)) == ($au - 1)) { //循环首
                                        echo '<div class="swiper-slide swiper-slide-visible swiper-slide-prev" data-swiper-slide-index="' . $au . '" style="margin: auto;margin-top: 0px;">
                                        <div class="content-slide" style="padding: 10px;margin-bottom:8px;">
                                            <div class="categories-grid">';
                                    }
                                    echo '<a data-cid="'.$v['cid'].'" data-name="'.$v['name'].'" class="get_cat">
                                               <div class="mbg">
                                                   <p class="ico" style="margin:0;"><img src="' . $v['shopimg'] . '" onerror="this.src=\'assets/store/picture/1562225141902335.jpg\'"></p>
                                                   <p class="icon-title">' . $v['name'] . '</p>
                                              </div>
                                          </a>';

                                    if ((($arry + 1) / ($class_show_num*5)) == ($au)) { //循环尾
                                        echo '</div>
                                        </div>
                                        </div>';
                                        $au++;
                                    }
                                    $arry++;
                                }
                                if (floor((($arry) / ($class_show_num*5))) != (($arry) / ($class_show_num*5))) {
                                    echo '</div></div></div>';
                                }
                                ?>
                            </div>
                                <!-- Add Pagination -->
                                <div class="swiper-pagination"></div>
                                <div class="swiper-button-next" style="display:none"></div>
                                <div class="swiper-button-prev" style="display:none"></div>

                        </div>
                    </div>
                </div>
                <!-- 排序区域 -->
                <div class="sorting-section" style="padding: 0 16px 8px;">
                    <div class="goods_sort" style="background: #f7f8fa; border-radius: 8px; padding: 8px; display: flex; justify-content: space-between; align-items: center;">
                        <div class="item item-price" data-order="sort" data-sort="ASC" style="flex: 1; text-align: center; padding: 4px;">
                            <span class="text">综合</span>
                            <span class="sorting">
                                <i class="icon icon-sanjiao2"></i>
                                <i class="icon icon-sanjiao1"></i>
                            </span>
                        </div>
                        <div class="item item-price" data-order="sales" data-sort="ASC" style="flex: 1; text-align: center; padding: 4px;">
                            <span class="text">销量</span>
                            <span class="sorting">
                                <i class="icon icon-sanjiao2"></i>
                                <i class="icon icon-sanjiao1"></i>
                            </span>
                        </div>
                        <div class="item item-price" data-order="price" data-sort="ASC" style="flex: 1; text-align: center; padding: 4px;">
                            <span class="text">价格</span>
                            <span class="sorting">
                                <i class="icon icon-sanjiao2"></i>
                                <i class="icon icon-sanjiao1"></i>
                            </span>
                        </div>
                        <!-- <div class="item" style="flex: 0.5; text-align: center; padding: 4px;">
                            <span class="text">
                                <a href="javascript:;">
                                    <i class="icon icon-sort" id="listblock" data-state="list" style="font-size:18px;"></i>
                                </a>
                            </span>
                        </div> -->
                    </div>
                </div>
                <section style="text-align: center;display:none;height: 1.5rem;line-height: 1.6rem;" class="show_class">
                    <section style="display: inline-block;" class="">
                        <section class="135brush" data-brushtype="text" style="clear:both;margin:-18px 0px;text-align: center;color:#333;border-radius: 6px;padding:0px 1.5em;letter-spacing: 1.5px;">
                            <span style="color: #f79646;"><strong><span style="font-size: 15px;"><span class="catname_show">正在获取数据...</span></span></strong></span>
                        </section>
                    </section>
                </section>
                
                <div class="layui-tab tag_name tab_con" style="margin:0;display:none;">
                    <ul class="layui-tab-title" style="margin: 0;background:#fff;overflow: hidden;">
                    </ul>
                </div>
                
                <!-- 商品列表区域 -->
                <div class="products-section">
                    <div class="fui-goods-group block three" id="goods-list-container" style="display: flex !important; flex-wrap: wrap !important; width: 100% !important; margin: 0 !important; padding: 0 !important;">
                        <div class="flow_load" style="width: 100% !important; display: flex !important; flex-wrap: wrap !important; margin: 0 !important; padding: 0 !important;">
                            <div id="goods_list" style="width: 100% !important; display: flex !important; flex-wrap: wrap !important; margin: 0 !important; padding: 0 !important;"></div>
                        </div>
                        <div class="footer" style="width:100%; margin-top:0.5rem;margin-bottom:2.5rem;display: block;">
                            <ul>
                                <li>© <?php echo $conf['sitename'] ?>. All rights reserved.</li>
                            </ul>
                            <p style="text-align: center"><?php echo $conf['footer']?></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        </div>
        <input type="hidden" name="_cid" value="<?php echo $cid; ?>">
        <input type="hidden" name="_cidname" value="<?php echo $cat_name; ?>">
        <input type="hidden" name="_curr_time" value="<?php echo time(); ?>">
        <input type="hidden" name="_template_virtualdata" value="<?php echo $conf['template_virtualdata']?>">
		<input type="hidden" name="_template_showsales" value="<?php echo $conf['template_showsales']?>">
        <input type="hidden" name="_sort_type" value="">
        <input type="hidden" name="_sort" value="">
        
        <div class="fui-navbar" style="bottom:-34px;background-color: white;max-width: 650px">
        </div>

        <div class="fui-navbar" style="max-width: 650px;z-index: 100;">
            <a href="./" class="nav-item active"> <span class="icon icon-home "></span> <span class="label">首页</span>
            </a>
            <a href="./?mod=query" class="nav-item "> <span class="icon icon-dingdan1"></span> <span class="label">订单</span> </a>
			<a href="./?mod=cart" class="nav-item " <?php if($conf['shoppingcart']==0){?>style="display:none"<?php }?>> <span class="icon icon-cart2"></span> <span class="label">购物车</span> </a>
            <a href="./?mod=kf" class="nav-item "> <span class=" icon icon-service1"></span> <span class="label">客服</span>
            </a>
            <a href="./user/" class="nav-item "> <span class="icon icon-person2"></span> <span class="label">会员中心</span> </a>
        </div>



        <div style="width: 100%;height: 100vh;position: fixed;top: 0px;left: 0px;opacity: 0.5;background-color: black;display: none;z-index: 10000"
             class="tzgg"></div>
        <div class="tzgg" type="text/html" style="display: none">
            <div class="account-layer" style="z-index: 100000000;">
                <div class="account-main" style="padding:0.8rem;height: auto">

                    <div class="account-title">系 统 公 告</div>

                    <div class="account-verify"
                         style="  display: block;    max-height: 15rem;    overflow: auto;margin-top: -10px">
                        <?php echo $conf['anounce'] ?>
                    </div>
                </div>
                <div class="account-btn" style="display: block" onclick="$('.tzgg').hide()">确认</div>
                
                <!--<div class="account-close">-->
                <!--<i class="icon icon-guanbi1"></i>-->
                <!--</div>-->
            </div>
        </div>

    </div>
</div>
<!--音乐代码-->
<div id="audio-play" <?php if(empty($conf['musicurl'])){?>style="display:none;"<?php }?>>
  <div id="audio-btn" class="on" onclick="audio_init.changeClass(this,'media')">
    <audio loop="loop" src="<?php echo $conf['musicurl']?>" id="media" preload="preload"></audio>
  </div>
</div>

<script>
  // 监听 plusready 事件，确保 plus 对象已初始化
  document.addEventListener("plusready", function() {
    const isAppDiv = document.getElementById("isApp");
    if (window.plus) {
      isAppDiv.style.display = "none"; // 在 App 中隐藏
    } else {
      isAppDiv.style.display = "block"; // 在浏览器中显示
    }
  });

  // 如果 plusready 未触发（非 App 环境），直接显示
  setTimeout(function() {
    if (!window.plus && document.getElementById("isApp")) {
      document.getElementById("isApp").style.display = "block";
    }
  }, 300); // 延迟 300ms 确保 plusready 未触发
</script>

<!--音乐代码-->
<script src="<?php echo $cdnserver; ?>assets/js/jquery-3.4.1.min.js"></script>

<!-- 高级交互脚本 -->
<script>
$(document).ready(function() {
    // APP下载卡片高级交互
    $('.app-download-card').on('mouseenter', function() {
        $(this).css({
            'animation-play-state': 'paused',
            'transform': 'scale(1.02) rotateY(5deg)',
            'transition': 'transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)'
        });
    }).on('mouseleave', function() {
        $(this).css({
            'animation-play-state': 'running',
            'transform': 'scale(1) rotateY(0deg)'
        });
    });
    
    // APP下载按钮增强交互
    $('.appDown').on('mouseenter', function() {
        $(this).addClass('app-btn-hover');
    }).on('mouseleave', function() {
        $(this).removeClass('app-btn-hover');
    });
    
    // 触摸反馈（移动端）
    $('.appDown').on('touchstart', function(e) {
        // e.preventDefault();
        $(this).css('transform', 'translateY(0) scale(0.95)');
        
        // 添加涟漪效果
        const ripple = $('<div class="ripple-effect"></div>');
        $(this).append(ripple);
        
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.originalEvent.touches[0].clientX - rect.left - size / 2;
        const y = e.originalEvent.touches[0].clientY - rect.top - size / 2;
        
        ripple.css({
            width: size + 'px',
            height: size + 'px',
            left: x + 'px',
            top: y + 'px'
        }).addClass('ripple-animation');
        
        setTimeout(() => ripple.remove(), 600);
    }).on('touchend', function() {
        $(this).css('transform', 'translateY(-2px) scale(1.05)');
    });
    
    // 分类项交互增强
    $('.get_cat').hover(
        function() { 
            $(this).css('transform', 'translateY(-4px) scale(1.05)');
            $(this).find('.ico img').css('transform', 'scale(1.1)');
        },
        function() { 
            $(this).css('transform', 'translateY(0) scale(1)');
            $(this).find('.ico img').css('transform', 'scale(1)');
        }
    );
    
    // 商品卡片悬停效果
    $('.fui-goods-item').hover(
        function() { $(this).css('transform', 'translateY(-4px)'); },
        function() { $(this).css('transform', 'translateY(0)'); }
    );
    
    // 搜索按钮交互
    $('.searchbtn').on('click', function() {
        $(this).css('transform', 'scale(0.9)');
        setTimeout(() => {
            $(this).css('transform', 'scale(1.05)');
        }, 100);
        setTimeout(() => {
            $(this).css('transform', 'scale(1)');
        }, 200);
    });
    
    // 震撼的分阶段动画序列
    function startSpectacularAnimations() {
        // 阶段1: 容器登场 (0.5s后开始)
        setTimeout(() => {
            $('.app-download-section').addClass('animate');
        }, 500);
        
        // 阶段2: 卡片翻转登场 (1s后开始)
        setTimeout(() => {
            $('.app-download-card').addClass('animate');
        }, 1000);
        
        // 阶段3: 文字揭示 (1.5s后开始)
        setTimeout(() => {
            $('.app-download-text').addClass('animate');
        }, 1500);
        
        // 阶段4: 按钮掉落 (2s后开始)
        setTimeout(() => {
            $('.appDown').addClass('animate');
        }, 2000);
        
        // // 阶段5: 震撼的完成效果 (3.2s后)
        // setTimeout(() => {
        //     // 添加完成时的震撼效果
        //     $('.app-download-card').css({
        //         'animation': 'cardFlipIn 1.2s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards, gradientFlow 8s ease-in-out infinite, completionShake 0.5s ease-out'
        //     });
            
        //     // 添加粒子爆炸效果
        //     createParticleExplosion();
        // }, 3200);
    }
    
    // 创建粒子爆炸效果
    function createParticleExplosion() {
        const container = $('.app-download-card');
        const rect = container[0].getBoundingClientRect();
        
        for (let i = 0; i < 12; i++) {
            const particle = $('<div class="particle"></div>');
            $('body').append(particle);
            
            const angle = (i / 12) * 360;
            const distance = 100 + Math.random() * 50;
            const x = Math.cos(angle * Math.PI / 180) * distance;
            const y = Math.sin(angle * Math.PI / 180) * distance;
            
            particle.css({
                position: 'fixed',
                left: rect.left + rect.width / 2 + 'px',
                top: rect.top + rect.height / 2 + 'px',
                width: '6px',
                height: '6px',
                background: `hsl(${Math.random() * 360}, 70%, 60%)`,
                borderRadius: '50%',
                pointerEvents: 'none',
                zIndex: 10000
            });
            
            particle.animate({
                left: '+=' + x + 'px',
                top: '+=' + y + 'px',
                opacity: 0
            }, 800, function() {
                particle.remove();
            });
        }
    }
    
         // 启动动画序列
     startSpectacularAnimations();
     
     // 为动态加载的商品添加淡入动画
     function animateNewGoodsItems() {
         $('.fui-goods-item').each(function(index) {
             const item = $(this);
             if (!item.hasClass('animated')) {
                 item.addClass('animated');
                                   // 如果商品是动态加载的，立即显示
                  if (index >= 6) {
                      item.css({
                          'opacity': '0',
                          'transform': 'translateY(25px) scale(0.95)',
                          'animation': 'goodsSlideIn 0.4s ease-out forwards',
                          'animation-delay': (index * 0.1) + 's'
                      });
                  }
             }
         });
     }
     
     // 监听商品列表变化
     const observer = new MutationObserver(function(mutations) {
         mutations.forEach(function(mutation) {
             if (mutation.type === 'childList') {
                 animateNewGoodsItems();
             }
         });
     });
     
     // 开始观察商品列表容器
     const goodsContainer = document.getElementById('goods_list');
     if (goodsContainer) {
         observer.observe(goodsContainer, {
             childList: true,
             subtree: true
         });
     }
     
     // 页面加载完成后初始化
     setTimeout(() => {
         animateNewGoodsItems();
     }, 1000);
});
</script>
<script src="<?php echo $cdnserver; ?>assets/js/layui.all.js"></script>
<script src="<?php echo $cdnserver; ?>assets/js/jquery.cookie-1.4.1.min.js"></script>
<script src="<?php echo $cdnserver; ?>assets/js/swiper-6.4.5-bundle.min.js"></script>
<script src="<?php echo $cdnserver?>assets/store/js/foxui.js"></script>
<script src="<?php echo $cdnserver?>assets/store/js/layui.flow.js"></script>
<script src="<?php echo $cdnserver?>assets/store/js/index.js?ver=<?php echo VERSION ?>"></script>
</body>
</html>