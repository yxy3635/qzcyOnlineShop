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

$addsalt=md5(mt_rand(0,999).time());
$_SESSION['addsalt']=$addsalt;
$x = new \lib\hieroglyphy();
$addsalt_js = $x->hieroglyphyString($addsalt);
list($background_image, $background_css) = \lib\Template::getBackground();
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <title>用户注册 - <?php echo $conf['sitename'];  ?></title>
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

        /* 注册卡片 */
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

        /* 表单输入 */
        .form-input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .form-input-group input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            font-size: 15px;
            transition: var(--transition);
        }

        .form-input-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-input-group input:focus {
            border-color: rgba(255, 255, 255, 0.4);
            outline: none;
        }

        .form-input-group i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 16px;
        }

        /* 验证码区域 */
        #captcha {
            margin: 15px 0;
            padding: 15px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-align: center;
        }

        .loading {
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .loading-dot {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            animation: bounce 0.5s ease-in-out infinite;
        }

        .loading-dot:nth-child(2) { animation-delay: 0.1s; }
        .loading-dot:nth-child(3) { animation-delay: 0.2s; }
        .loading-dot:nth-child(4) { animation-delay: 0.3s; }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
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
                    <i class="fa fa-user-plus"></i>
                </div>
                <h1 class="login-title">用户注册</h1>
                <p class="login-subtitle">欢迎加入 <?php echo $conf['sitename'] ?></p>
            </div>

            <form>
                <div class="form-input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="user" required="required" placeholder="输入登录用户名"/>
                </div>

                <div class="form-input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="pwd" required="required" placeholder="输入6位以上密码"/>
                </div>

                <div class="form-input-group">
                    <i class="fa fa-qq"></i>
                    <input type="text" name="qq" required="required" placeholder="输入QQ号，用于找回密码"/>
                </div>

                <?php if($conf['captcha_open']>=1 && $conf['captcha_open_reg'] == 1){?>
                <input type="hidden" name="captcha_type" value="<?php echo $conf['captcha_open']?>"/>
                <?php if($conf['captcha_open']>=2){?><input type="hidden" name="appid" value="<?php echo $conf['captcha_id']?>"/><?php }?>
                <div id="captcha">
                    <div id="captcha_text">正在加载验证码</div>
                    <div id="captcha_wait">
                        <div class="loading">
                            <div class="loading-dot"></div>
                            <div class="loading-dot"></div>
                            <div class="loading-dot"></div>
                            <div class="loading-dot"></div>
                        </div>
                    </div>
                </div>
                <div id="captchaform"></div>
                <?php }?>

                <button type="button" id="submit_reg" class="btn">立即注册</button>
                <a href="login.php" class="btn btn-link">已有账号，返回登录</a>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo $cdnserver?>assets/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/layer-2.3.js"></script>
<script src="../assets/js/reguser.js?ver=<?php echo VERSION ?>"></script>
<script>
var hashsalt=<?php echo $addsalt_js?>;
</script>
</body>
</html>