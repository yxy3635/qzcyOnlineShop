<?php
/**
 * 登录
**/
// 检查 Cookie 是否存在
if (!isset($_COOKIE['user_is_visit_page'])) {
    // 如果 Cookie 不存在，说明用户未访问 user_agree.php，跳转到 user_agree.php
    header("Location: user_agree.php");
    exit();
}

// 添加CSP头
header("Content-Security-Policy-Report-Only: default-src 'self' *.geetest.com *.geevisit.com; script-src 'self' 'unsafe-inline' 'unsafe-eval' *.geetest.com *.geevisit.com; connect-src 'self' *.geetest.com *.geevisit.com; style-src 'self' 'unsafe-inline' *.geetest.com *.geevisit.com; font-src 'self' data: *.geetest.com *.geevisit.com; img-src 'self' data: *.geetest.com *.geevisit.com; frame-src 'self' *.geetest.com *.geevisit.com;");

$is_defend=true;
include("../includes/common.php");

// 加载模板路由，优先使用当前模板的登录页面
$template_route = \lib\Template::loadRoute();
if($template_route){
	if($template_route['userlogin'] && checkIfActive('login')){
		include($template_route['userlogin']);exit;
	}
}

// 获取配置
$conf = $DB->getAll("SELECT * FROM shua_config WHERE 1");
$conf = array_column($conf, 'v', 'k');

include 'link.php';
if(isset($_GET['logout'])){
	if(!checkRefererHost())exit();
	setcookie("user_token", "", time() - 604800, '/');
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登录！');window.location.href='./login.php';</script>");
}elseif($islogin2==1){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已登录！');window.location.href='./';</script>");
}
$title='用户登录';

// 使用本地资源文件，不再依赖CDN
$cdnpublic = '../assets/';
if(!empty($conf['staticurl'])){
	$cdnserver = '//'.$conf['staticurl'].'/';
}else{
	$cdnserver = '../';
}

@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php echo $title ?> - <?php echo $conf['sitename'] ?></title>
    <link href="<?php echo $cdnserver?>assets/css/bootstrap-4.1.3.min.css" rel="stylesheet"/>
    <link href="<?php echo $cdnserver?>assets/css/font-awesome-4.7.0.min.css" rel="stylesheet"/>
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --success-color: #4facfe;
            --danger-color: #f56565;
            --warning-color: #ed8936;
            --info-color: #00f2fe;
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --text-light: #a0aec0;
            --card-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow-soft: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-strong: 0 25px 50px rgba(0, 0, 0, 0.15);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow: hidden;
            height: 100vh;
            position: relative;
        }

        /* 多层动态背景系统 */
        .modern-login-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -100;
            overflow: hidden;
        }

        /* 主背景渐变层 */
        .bg-gradient-main {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        /* 几何图形背景层 */
        .bg-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 70%;
            right: 10%;
            animation-delay: -5s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            top: 30%;
            right: 30%;
            animation-delay: -10s;
        }

        /* 粒子背景层 */
        .bg-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            pointer-events: none;
            animation: particleFloat 15s linear infinite;
        }

        /* 主容器 */
        .login-container {
            margin-top : -80px;
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* 登录卡片等比例缩放容器 */
        .login-card-scale {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80%;
            height: 80%;
            transform: scale(0.8);
            transform-origin: center center;
        }
        @media (max-width: 600px) {
            .login-card-scale {
                transform: scale(1);
            }
        }

        /* 登录卡片 */
        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-xl);
            padding: 2.2rem;
            width: 100%;
            max-width: 800px;
            box-shadow: var(--shadow-strong);
            position: relative;
            overflow: hidden;
            transition: transform 0.1s ease-out, box-shadow 0.3s ease;
            transform-style: preserve-3d;
            will-change: transform;
        }

        .login-card:hover {
            box-shadow: 0 35px 80px rgba(102, 126, 234, 0.3);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
        }

        /* 标题区域 */
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            font-weight: 400;
        }

        /* 表单样式 */
        .modern-form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .modern-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid transparent;
            border-radius: var(--radius-lg);
            font-size: 1rem;
            color: white;
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }

        .modern-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .modern-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            z-index: 2;
        }

        /* 验证码区域 */
        .captcha-container {
            margin: 1.5rem 0;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-lg);
            backdrop-filter: blur(10px);
        }

        #captcha {
            width: 100%;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* 让第三方验证码控件在容器内自适应铺满 */
        #captcha > div,
        #captcha iframe,
        #captcha .geetest_holder,
        #captcha .geetest_panel,
        #captcha .dx_captcha_wrapper,
        #captcha .dx_captcha_content {
            width: 100% !important;
            max-width: 100% !important;
        }

        .captcha-loading {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            text-align: center;
        }

        /* 登录按钮 */
        .login-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: var(--radius-lg);
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            margin: 1.5rem 0;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        /* 社交登录 */
        .social-login {
            margin: 2rem 0;
            text-align: center;
        }

        .social-divider {
            position: relative;
            margin: 1.5rem 0;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .social-divider::before,
        .social-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        .social-divider span {
            padding: 0 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            font-weight: 500;
            white-space: nowrap;
            background: none;
        }

        .social-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .social-btn {
            position: relative;
            width: 120px;
            height: 50px;
            border-radius: 25px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.08));
            backdrop-filter: blur(20px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.3);
            overflow: hidden;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }

        .social-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(255, 255, 255, 0.2), transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .social-btn:hover::before {
            opacity: 1;
        }

        .social-btn:hover {
            transform: translateY(-3px) scale(1.02);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.25), 
                        0 0 0 3px rgba(255, 255, 255, 0.15),
                        inset 0 1px 0 rgba(255, 255, 255, 0.4);
            color: white;
        }

        .social-btn:active {
            transform: translateY(-1px) scale(1.01);
        }

        .social-btn img {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            filter: brightness(1.1) saturate(1.2);
        }

        .social-btn:hover img {
            transform: scale(1.1);
            filter: brightness(1.3) saturate(1.4);
        }

        /* QQ登录按钮特效 */
        .social-btn[title*="QQ"] {
            background: linear-gradient(135deg, rgba(30, 144, 255, 0.15), rgba(0, 100, 200, 0.08));
        }
        .social-btn[title*="QQ"]:hover {
            background: linear-gradient(135deg, rgba(30, 144, 255, 0.35), rgba(0, 100, 200, 0.25));
            border-color: rgba(30, 144, 255, 0.6);
            box-shadow: 0 10px 35px rgba(30, 144, 255, 0.4), 
                        0 0 0 3px rgba(30, 144, 255, 0.2),
                        inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }

        /* 微信登录按钮特效 */
        .social-btn[title*="微信"] {
            background: linear-gradient(135deg, rgba(7, 193, 96, 0.15), rgba(0, 150, 70, 0.08));
        }
        .social-btn[title*="微信"]:hover {
            background: linear-gradient(135deg, rgba(7, 193, 96, 0.35), rgba(0, 150, 70, 0.25));
            border-color: rgba(7, 193, 96, 0.6);
            box-shadow: 0 10px 35px rgba(7, 193, 96, 0.4), 
                        0 0 0 3px rgba(7, 193, 96, 0.2),
                        inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }

        /* 社交按钮加载状态 */
        .social-btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .social-btn.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* 移动端优化 */
        @media (max-width: 480px) {
            .social-btn {
                width: 100px;
                height: 45px;
                font-size: 12px;
            }
            .social-btn img {
                width: 20px;
                height: 20px;
            }
        }

        /* 底部链接 */
        .login-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-sm);
            background: rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* 返回首页按钮 */
        .back-home {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 100;
        }

        .back-home-btn {
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-lg);
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-home-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: var(--shadow-soft);
        }

        /* 提示信息 */
        .login-notice {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--warning-color);
            padding: 1rem;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            margin-top: 1.5rem;
        }

        .login-notice-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            margin: 0;
        }

        /* 动画定义 */
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-10vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            .login-container {
                padding: 1rem;
            }
            
            .login-card {
                padding: 2rem;
                max-width: 100%;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
            
            .back-home {
                top: 1rem;
                right: 1rem;
            }
            
            .back-home-btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
            
            .login-footer {
                flex-direction: column;
                text-align: center;
            }
            
            .shape {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem;
            }
            
            .modern-input {
                padding: 0.875rem 0.875rem 0.875rem 2.5rem;
                font-size: 0.9rem;
            }
            
            .input-icon {
                left: 0.875rem;
                font-size: 1rem;
            }
        }

        /* 加载动画 */
        .loading {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .loading div {
            position: absolute;
            top: 33px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.8);
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }

        .loading div:nth-child(1) {
            left: 8px;
            animation: loading1 0.6s infinite;
        }

        .loading div:nth-child(2) {
            left: 8px;
            animation: loading2 0.6s infinite;
        }

        .loading div:nth-child(3) {
            left: 32px;
            animation: loading2 0.6s infinite;
        }

        .loading div:nth-child(4) {
            left: 56px;
            animation: loading3 0.6s infinite;
        }

        @keyframes loading1 {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }

        @keyframes loading3 {
            0% { transform: scale(1); }
            100% { transform: scale(0); }
        }

        @keyframes loading2 {
            0% { transform: translate(0, 0); }
            100% { transform: translate(24px, 0); }
        }

        /* 页面载入动画 */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
            background-size: 400% 400%;
            animation: gradientShift 3s ease infinite;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }

        .page-loader.fade-out {
            opacity: 0;
            visibility: hidden;
        }

        .loader-content {
            text-align: center;
            transform: translateY(0);
            animation: loaderSlideUp 1s ease-out;
        }

        .loader-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            position: relative;
            animation: logoRotate 2s ease-in-out infinite;
        }

        .loader-logo::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid white;
            animation: logoSpin 1s linear infinite;
        }

        .loader-logo::after {
            content: '🔐';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            animation: logoScale 2s ease-in-out infinite;
        }

        .loader-title {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            opacity: 0;
            animation: textFadeIn 1s ease-out 0.3s forwards;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .loader-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            opacity: 0;
            animation: textFadeIn 1s ease-out 0.6s forwards;
        }

        .loader-progress {
            width: 200px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            overflow: hidden;
            margin: 0 auto;
            opacity: 0;
            animation: textFadeIn 1s ease-out 0.9s forwards;
        }

        .loader-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.8), white, rgba(255, 255, 255, 0.8));
            border-radius: 2px;
            width: 0%;
            animation: progressFill 2.5s ease-out forwards;
        }

        .loader-dots {
            margin-top: 1.5rem;
            opacity: 0;
            animation: textFadeIn 1s ease-out 1.2s forwards;
        }

        .loader-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.8);
            margin: 0 4px;
            animation: dotBounce 1.4s ease-in-out infinite;
        }

        .loader-dot:nth-child(1) { animation-delay: 0s; }
        .loader-dot:nth-child(2) { animation-delay: 0.2s; }
        .loader-dot:nth-child(3) { animation-delay: 0.4s; }

        /* 页面内容初始隐藏 */
        .page-content {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1s ease-out 0.3s, transform 1s ease-out 0.3s;
        }

        .page-content.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* 载入动画关键帧 */
        @keyframes loaderSlideUp {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes logoRotate {
            0%, 100% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
        }

        @keyframes logoSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes logoScale {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.2); }
        }

        @keyframes textFadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes progressFill {
            0% { width: 0%; }
            25% { width: 30%; }
            50% { width: 60%; }
            75% { width: 85%; }
            100% { width: 100%; }
        }

        @keyframes dotBounce {
            0%, 80%, 100% {
                transform: scale(0.8);
                opacity: 0.5;
            }
            40% {
                transform: scale(1.2);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <!-- 页面载入动画 -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <div class="loader-logo"></div>
            <h2 class="loader-title">安全登录</h2>
            <p class="loader-subtitle">正在为您准备安全的登录环境...</p>
            <div class="loader-progress">
                <div class="loader-progress-bar"></div>
            </div>
            <div class="loader-dots">
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
            </div>
        </div>
    </div>

    <!-- 页面主要内容 -->
    <div class="page-content" id="pageContent">
        <!-- 多层动态背景系统 -->
        <div class="modern-login-background">
            <!-- 主背景渐变层 -->
            <div class="bg-gradient-main"></div>
            
            <!-- 几何图形背景层 -->
            <div class="bg-shapes">
                <div class="shape"></div>
                <div class="shape"></div>
                <div class="shape"></div>
            </div>
            
            <!-- 粒子背景层 -->
            <div class="bg-particles" id="particles"></div>
        </div>

        <!-- 返回首页按钮 -->
        <!-- <div class="back-home">
            <a href="../" class="back-home-btn">
                <i class="fa fa-home"></i>
                返回首页
            </a>
        </div> -->

        <!-- 主登录容器 -->
        <div class="login-container">
        <div class="login-card-scale">
        <div class="login-card">
            <!-- 登录头部 -->
            <div class="login-header">
                <h1 class="login-title">
                    <i class="fa fa-user-circle"></i>
                    用户登录
                </h1>
                <p class="login-subtitle">欢迎回到 <?php echo $conf['sitename'] ?></p>
            </div>

            <!-- 登录表单 -->
            <form id="loginForm" autocomplete="off">
                <!-- 用户名输入 -->
                <div class="modern-form-group">
                    <i class="fa fa-user input-icon"></i>
                    <input type="text" name="user" class="modern-input" placeholder="请输入用户名" required autocomplete="username">
                </div>

                <!-- 密码输入 -->
                <div class="modern-form-group">
                    <i class="fa fa-lock input-icon"></i>
                    <input type="password" name="pass" class="modern-input" placeholder="请输入密码" required autocomplete="current-password">
                </div>

                <!-- 验证码区域 -->
                <?php if($conf['captcha_open_login']==1 && $conf['captcha_open']>=1){?>
                <input type="hidden" name="captcha_type" value="<?php echo $conf['captcha_open']?>"/>
                <?php if($conf['captcha_open']>=2){?><input type="hidden" name="appid" value="<?php echo $conf['captcha_id']?>"/><?php }?>
                <div class="captcha-container">
                    <div id="captcha">
                        <div id="captcha_text" class="captcha-loading">
                            <i class="fa fa-shield"></i> 正在加载安全验证...
                        </div>
                        <div id="captcha_wait" style="display: none;">
                            <div class="loading">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <div id="captchaform"></div>
                </div>
                <?php }?>

                <!-- 登录按钮 -->
                <button type="button" id="submit_login" class="login-btn">
                    <i class="fa fa-sign-in"></i>
                    登录系统
                </button>
            </form>

            <!-- 社交登录 -->
            <?php if($conf['login_qq']>=1 || $conf['login_wx']>=1){?>
            <div class="social-login">
                <div class="social-divider">
                    <span>或使用社交账号登录</span>
                </div>
                <div class="social-buttons">
                    <?php if($conf['login_qq']>=1){?>
                    <button type="button" class="social-btn" onclick="connect('qq')" title="QQ登录">
                        <img src="../assets/img/social/qq.png" alt="QQ">
                        <span>QQ登录</span>
                    </button>
                    <?php }?>
                    <?php if($conf['login_wx']>=1){?>
                    <button type="button" class="social-btn" onclick="connect('wx')" title="微信登录">
                        <img src="../assets/img/social/wx.png" alt="微信">
                        <span>微信登录</span>
                    </button>
                    <?php }?>
                </div>
            </div>
            <?php }?>

            <!-- 底部链接 -->
            <div class="login-footer">
                <a href="findpwd.php" class="footer-link">
                    <i class="fa fa-unlock"></i>
                    找回密码
                </a>
                <a href="reg.php" class="footer-link">
                    <i class="fa fa-user-plus"></i>
                    注册账号
                </a>
            </div>

            <!-- 提示信息 -->
            <div class="login-notice">
                <p class="login-notice-text">
                    <i class="fa fa-info-circle"></i>
                    为了更便捷的服务，请先登录或注册账号！
                </p>
            </div>
        </div>
        </div>
        </div>

    <!-- JavaScript 库 -->
    <script src="<?php echo $cdnserver?>assets/js/jquery-1.12.4.min.js"></script>
    <script src="<?php echo $cdnserver?>assets/js/layer-2.3.js"></script>

    <!-- 粒子系统脚本 -->
    <script>
        // 粒子系统
        function createParticles() {
            const particleContainer = document.getElementById('particles');
            const particleCount = window.innerWidth > 768 ? 20 : 10;
            
            for (let i = 0; i < particleCount; i++) {
                setTimeout(() => {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    
                    // 随机位置和大小
                    const size = Math.random() * 4 + 2;
                    const left = Math.random() * 100;
                    const animationDuration = Math.random() * 10 + 10;
                    
                    particle.style.width = size + 'px';
                    particle.style.height = size + 'px';
                    particle.style.left = left + '%';
                    particle.style.animationDuration = animationDuration + 's';
                    particle.style.animationDelay = '0s'; // 立即开始，不再随机延迟
                    
                    particleContainer.appendChild(particle);
                    
                    // 粒子完成动画后移除
                    setTimeout(() => {
                        if (particle.parentNode) {
                            particle.parentNode.removeChild(particle);
                        }
                    }, animationDuration * 1000);
                }, i * 100); // 减少创建间隔从1000ms到100ms，让粒子快速连续出现
            }
        }

        // 立即创建第一批粒子
        createParticles();
        
        // 定期创建新粒子
        setInterval(createParticles, 3000);

        // 登录卡片3D倾斜交互
        function initCardTiltEffect() {
            const card = document.querySelector('.login-card');
            if (!card) return;

            card.addEventListener('mousemove', function(e) {
                const rect = card.getBoundingClientRect();
                const cardCenterX = rect.left + rect.width / 2;
                const cardCenterY = rect.top + rect.height / 2;
                
                // 计算鼠标相对于卡片中心的位置
                const mouseX = e.clientX - cardCenterX;
                const mouseY = e.clientY - cardCenterY;
                
                // 计算倾斜角度 (限制在-15到15度之间)
                const rotateX = (mouseY / (rect.height / 2)) * -5;
                const rotateY = (mouseX / (rect.width / 2)) * 5;
                
                // 应用3D变换
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(20px)`;
            });

            card.addEventListener('mouseleave', function() {
                // 鼠标离开时恢复原状
                card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateZ(0px)';
            });

            card.addEventListener('mouseenter', function() {
                // 鼠标进入时增强阴影效果
                card.style.transition = 'transform 0.1s ease-out, box-shadow 0.3s ease';
            });
        }

        // 表单交互增强
        $(document).ready(function() {
            // 输入框焦点效果
            $('.modern-input').on('focus', function() {
                $(this).parent().addClass('focused');
            }).on('blur', function() {
                if (!$(this).val()) {
                    $(this).parent().removeClass('focused');
                }
            });

            // 表单验证
            function validateForm() {
                const user = $("input[name='user']").val().trim();
                const pass = $("input[name='pass']").val();
                
                if (!user) {
                    layer.alert('👤 请输入用户名', {icon: 0, skin: 'layui-layer-molv'});
                    $("input[name='user']").focus();
                    return false;
                }
                
                if (!pass) {
                    layer.alert('🔒 请输入密码', {icon: 0, skin: 'layui-layer-molv'});
                    $("input[name='pass']").focus();
                    return false;
                }
                
                if (pass.length < 6) {
                    layer.alert('🔒 密码长度不能少于6位', {icon: 0, skin: 'layui-layer-molv'});
                    $("input[name='pass']").focus();
                    return false;
                }
                
                return true;
            }

            // 回车键提交
            $('.modern-input').keypress(function(e) {
                if (e.which === 13) {
                    $('#submit_login').click();
                }
            });
        });
    </script>

    <!-- 登录逻辑脚本 -->
    <script src="../assets/js/login.js?ver=<?php echo VERSION ?>"></script>
    </div> <!-- 关闭 page-content -->

    <!-- 页面载入控制脚本 -->
    <script>
        // 页面载入动画控制
        window.addEventListener('load', function() {
            // 等待所有资源加载完成后，延迟一段时间显示主内容
            setTimeout(function() {
                const pageLoader = document.getElementById('pageLoader');
                const pageContent = document.getElementById('pageContent');
                
                // 开始淡出载入动画
                pageLoader.classList.add('fade-out');
                
                // 延迟显示主内容，确保动画流畅
                setTimeout(function() {
                    pageContent.classList.add('show');
                    // 主内容显示后再启用卡片倾斜效果
                    setTimeout(function() {
                        initCardTiltEffect();
                    }, 500);
                }, 400);
                
                // 完全移除载入器
                setTimeout(function() {
                    if (pageLoader.parentNode) {
                        pageLoader.parentNode.removeChild(pageLoader);
                    }
                }, 1200);
            }, 2800); // 载入动画显示2.8秒
        });

        // 如果页面加载过慢，设置最大等待时间
        setTimeout(function() {
            const pageLoader = document.getElementById('pageLoader');
            const pageContent = document.getElementById('pageContent');
            
            if (pageLoader && !pageLoader.classList.contains('fade-out')) {
                                 pageLoader.classList.add('fade-out');
                 setTimeout(function() {
                     pageContent.classList.add('show');
                     // 主内容显示后再启用卡片倾斜效果
                     setTimeout(function() {
                         initCardTiltEffect();
                     }, 500);
                 }, 400);
                setTimeout(function() {
                    if (pageLoader.parentNode) {
                        pageLoader.parentNode.removeChild(pageLoader);
                    }
                }, 1200);
            }
        }, 5000); // 最多等待5秒

        // 优化载入体验 - 预加载关键资源
        document.addEventListener('DOMContentLoaded', function() {
            // 预加载字体和图片资源
            const preloadLinks = [
                '../assets/css/bootstrap-4.1.3.min.css',
                '../assets/css/font-awesome-4.7.0.min.css',
                '../assets/js/jquery-1.12.4.min.js',
                '../assets/js/layer-2.3.js'
            ];

            preloadLinks.forEach(function(href) {
                const link = document.createElement('link');
                link.rel = 'preload';
                link.href = href;
                link.as = href.endsWith('.css') ? 'style' : 'script';
                document.head.appendChild(link);
            });
        });
    </script>
</body>
</html>