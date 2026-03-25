<?php
if (!defined('IN_CRONLITE')) die();
@header('Content-Type: text/html; charset=UTF-8');

// 处理退出登录
if(isset($_GET['logout'])){
    setcookie("user_token", "", time() - 3600, '/');
    unset($_SESSION['user_token']);
    exit("<script language='javascript'>alert('您已成功注销登录！');window.location.href='./login.php';</script>");
}

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
    <title>用户登录 - <?php echo $conf['sitename'];  ?></title>
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

        /* 登录卡片 */
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
            outline: none;
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .form-input-group .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 16px;
            transition: var(--transition);
        }

        .form-input-group input:focus + .input-icon {
            color: rgba(255, 255, 255, 0.9);
            transform: translateY(-50%) scale(1.1);
        }

        /* 登录按钮 */
        .login-btn {
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
            position: relative;
            overflow: hidden;
            margin: 15px 0 10px;
}

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        /* 辅助链接 */
        .login-links {
            text-align: center;
            margin: 8px 0;
        }

        .login-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
        }

        .login-links a:hover {
            color: white;
            text-decoration: none;
        }

        .register-link {
            background: rgba(255, 255, 255, 0.1);
            padding: 12px 20px;
            border-radius: 8px;
            display: inline-block;
            margin: 10px 0;
            transition: var(--transition);
        }

        .register-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        /* 第三方登录 */
        .social-login {
            margin-top: 12px;
            text-align: center;
        }

        .social-divider {
            position: relative;
            margin: 10px 0;
            text-align: center;
        }

        .social-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
        }

        .social-divider span {
            background: transparent;
            padding: 0 15px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        .social-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 8px;
}

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            background-size: 60% 60%;
            background-repeat: no-repeat;
            background-position: center;
        }

        .social-btn:hover {
            transform: translateY(-3px) scale(1.05);
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* 验证码 */
        #captcha {
            margin: 0;
            text-align: center;
        }

        .captcha-loading {
            padding: 0;
            color: rgba(255, 255, 255, 0.8);
        }

        #captchaform {
            margin-top: 0;
        }

        #captchaform .form-input-group {
            margin-bottom: 10px;
        }

        .loading {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin: 5px 0;
        }

        .loading-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            animation: loadingBounce 1.4s ease-in-out infinite both;
        }

        .loading-dot:nth-child(1) { animation-delay: -0.32s; }
        .loading-dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes loadingBounce {
            0%, 80%, 100% {
                transform: scale(0.8);
                opacity: 0.5;
            }
            40% {
                transform: scale(1.2);
                opacity: 1;
            }
        }

        /* 提示信息 */
        .login-notice {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 8px 12px;
            margin: 10px 0 15px;
            text-align: center;
}

        .notice-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            animation: textShine 3s ease-in-out infinite;
        }

        @keyframes textShine {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }

        /* 响应式 */
        @media (max-width: 480px) {
            #body {
                padding: 10px;
                min-height: 100vh;
            }
            
            .login-card {
                padding: 20px 15px;
                margin: 5px;
            }
            
            .login-title {
                font-size: 20px;
            }
            
            .login-logo {
                width: 50px;
                height: 50px;
                margin-bottom: 10px;
            }
            
            .login-logo i {
                font-size: 20px;
            }
            
            .form-input-group input {
                padding: 10px 14px 10px 35px;
                font-size: 14px;
            }
            
            .form-input-group .input-icon {
                left: 12px;
                font-size: 14px;
            }
            
            .login-btn {
                padding: 10px;
                font-size: 15px;
            }
        }
</style>
</head>
<body>
    <!-- 动态背景 -->
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
                <!-- 登录头部 -->
                <div class="login-header">
                    <div class="login-logo">
                        <i class="fa fa-user-circle"></i>
                                    </div>
                    <h1 class="login-title">用户登录</h1>
                    <p class="login-subtitle">欢迎回到 <?php echo $conf['sitename']; ?></p>
                                </div>

                <!-- 登录表单 -->
                <form id="form1">
                    <!-- 用户名 -->
                    <div class="form-input-group">
                        <input type="text" name="user" value="" placeholder="请输入用户名" required>
                        <i class="fa fa-user input-icon"></i>
                            </div>
                                
                    <!-- 密码 -->
                    <div class="form-input-group">
                        <input type="password" name="pass" placeholder="请输入密码" required>
                        <i class="fa fa-lock input-icon"></i>
                    </div>

                    <!-- 验证码 -->
                            <?php if($conf['captcha_open_login']==1 && $conf['captcha_open']>=1){?>
                            <input type="hidden" name="captcha_type" value="<?php echo $conf['captcha_open']?>"/>
                            <?php if($conf['captcha_open']>=2){?><input type="hidden" name="appid" value="<?php echo $conf['captcha_id']?>"/><?php }?>
                    <div id="captcha">
                        <div class="captcha-loading">
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
                    </div>
                    <?php }?>

                    <!-- 登录按钮 -->
                    <button type="button" class="login-btn" id="submit_login">
                        <i class="fa fa-sign-in"></i> 登录系统
                    </button>
                </form>

                <!-- 辅助链接 -->
                <div class="login-links">
                    <a href="findpwd.php"><i class="fa fa-question-circle"></i> 忘记密码？</a>
                </div>
                <div class="login-links">
                    <a href="reg.php" class="register-link">
                        <i class="fa fa-user-plus"></i> 还没有账号？立即注册
                    </a>
                        </div>
                        
                <!-- 第三方登录 -->
                        <?php if($conf['login_qq']>=1 || $conf['login_wx']>=1){?>
                <div class="social-login">
                    <div class="social-divider">
                        <span>第三方登录</span>
                    </div>
                    <div class="social-buttons">
                        <?php if($conf['login_qq']>=1){?>
                        <div class="social-btn" onclick="javascript:connect('qq')" style="background-image: url(../assets/img/logo2.png);" title="QQ登录"></div>
                        <?php }?>
                        <?php if($conf['login_wx']>=1){?>
                        <div class="social-btn" onclick="javascript:connect('wx')" style="background-image: url(../assets/img/wx.png);" title="微信登录"></div>
                        <?php }?>
                    </div>
                </div>
                <?php }?>

                <!-- 温馨提示 -->
                <div class="login-notice">
                    <div class="notice-text">
                        <i class="fa fa-info-circle"></i> 为了更好的服务体验，请先登录您的账号
                        </div>
                </div>
            </div>
    </div>
</div>

<script src="<?php echo $cdnserver?>assets/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/layer-2.3.js"></script>
<script src="../assets/js/login.js?ver=<?php echo VERSION ?>"></script>
<script>
    function goback() {
        document.referrer === '' ? window.location.href = '/' : window.history.go(-1);
    }

    // 输入框焦点效果
    $(document).ready(function() {
        $('.form-input-group input').on('focus', function() {
            $(this).parent().addClass('focused');
        }).on('blur', function() {
            if (!$(this).val()) {
                $(this).parent().removeClass('focused');
            }
        });

        // 登录按钮点击效果
        $('#submit_login').on('click', function() {
            $(this).addClass('clicked');
            setTimeout(() => {
                $(this).removeClass('clicked');
            }, 200);
        });
    });
</script>
</body>
</html>