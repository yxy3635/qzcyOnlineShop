<?php
if (!defined('IN_CRONLITE')) die();
@header('Content-Type: text/html; charset=UTF-8');

// 设置CDN服务器路径
$cdnpublic = '../assets/';
if(!empty($conf['staticurl'])){
	$cdnserver = '//'.$conf['staticurl'].'/';
}else{
	$cdnserver = '../';
}

list($background_image, $background_css) = \lib\Template::getBackground();
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <title>找回密码 - <?php echo $conf['sitename'];  ?></title>
    <meta name="keywords" content="<?php echo $conf['keywords'] ?>">
    <meta name="description" content="<?php echo $conf['description'] ?>">
    <link rel="shortcut icon" href="<?php echo $conf['default_ico_url'] ?>">
    <link href="<?php echo $cdnserver?>assets/css/bootstrap-3.3.7.min.css" rel="stylesheet"/>
    <link href="<?php echo $cdnserver; ?>assets/css/font-awesome-4.7.0.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/foxui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/iconfont.css">
<style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow-soft: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-strong: 0 25px 50px rgba(0, 0, 0, 0.15);
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
            line-height: 1.6;
            background: transparent;
        }

        /* 动态背景系统 */
        .modern-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -10;
            overflow: hidden;
        }

        .bg-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        .bg-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
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

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(120deg); }
            66% { transform: translateY(20px) rotate(240deg); }
        }

        /* 主容器 */
        #body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            position: relative;
            z-index: 1;
            overflow-y: auto;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            position: relative;
        }

        /* 找回密码卡片 */
        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            padding: 25px 25px;
            box-shadow: var(--shadow-strong);
            position: relative;
            overflow: hidden;
            transition: var(--transition);
            animation: slideUp 0.8s ease-out;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 80px rgba(102, 126, 234, 0.3);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 头部 */
        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-soft);
            animation: logoSpin 3s ease-in-out infinite;
        }

        .login-logo i {
            font-size: 24px;
            color: white;
        }

        @keyframes logoSpin {
            0%, 100% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
        }

        .login-title {
            font-size: 22px;
            font-weight: 700;
            color: white;
            margin-bottom: 5px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .login-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 400;
        }

        /* QR码区域 */
        #qrimg {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }

        #qrimg img {
            max-width: 200px;
            height: auto;
            border-radius: 8px;
        }

        #loginmsg {
            color: white;
            font-weight: 500;
            display: block;
            margin-bottom: 10px;
            text-align: center;
        }

        #loginload {
            color: rgba(255, 255, 255, 0.8);
        }

        /* 按钮样式 */
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 10px;
            text-align: center;
            text-decoration: none;
            display: block;
            line-height: 1.2;
            height: auto;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-link {
            background: none;
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
        }

        .btn-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.4);
            color: white;
            text-decoration: none;
        }

        /* 提示信息 */
        .alert {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 15px;
            color: white;
            margin: 15px 0;
            text-align: center;
            font-size: 14px;
        }

        /* 底部导航栏 */
        .fui-navbar {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 650px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-around;
            padding: 8px 0;
            z-index: 1000;
        }

        .nav-item {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 12px;
            padding: 4px 0;
        }

        .nav-item .icon {
            font-size: 20px;
            margin-bottom: 2px;
            display: block;
            line-height: 1;
        }

        .nav-item .label {
            display: block;
            line-height: 1.2;
            margin-top: 2px;
            font-size: 12px;
            color: inherit;
            background: none;
            padding: 0;
        }

        .nav-item.active {
            color: white;
        }
</style>
</head>
<body>
<div class="modern-bg">
    <div class="bg-gradient"></div>
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
</div>

<div id="body">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fa fa-unlock"></i>
                </div>
                <h1 class="login-title">找回密码</h1>
                <p class="login-subtitle">扫描二维码快速找回</p>
            </div>

            <div id="loginmsg">请使用QQ手机版扫描二维码</div>
            <span id="loginload" style="color: rgba(255, 255, 255, 0.8);">.</span>
            
            <div id="qrimg"></div>

            <div id="mobile" style="display:none;">
                <button type="button" id="mlogin" onclick="mloginurl()" class="btn">跳转QQ快捷登录</button>
                <button type="button" onclick="qrlogin()" class="btn btn-link">我已完成登录</button>
            </div>

            <?php if($conf['login_qq']==1){?>
            <div class="alert">
                提示：只能找回注册时填写了QQ号码的帐号密码，QQ快捷登录的暂不持支该方式找回密码。
            </div>
            <?php }?>

            <a href="login.php" class="btn btn-link">返回登录</a>
        </div>
    </div>
</div>

<script src="<?php echo $cdnserver?>assets/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/layer-2.3.js"></script>
<script src="../assets/js/qrlogin.js?ver=<?php echo VERSION ?>"></script>
</body>
</html>