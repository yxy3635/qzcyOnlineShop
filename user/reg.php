<?php
/**
 * 注册用户
**/
$is_defend=true;
include("../includes/common.php");
if($islogin2==1){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已登录！');window.location.href='./';</script>");
}
if(!$conf['user_open'] && $conf['fenzhan_buy']==1){
	exit("<script language='javascript'>window.location.href='./regsite.php';</script>");
}elseif(!$conf['user_open']){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('未开放新用户注册');window.location.href='./';</script>");
}
$title='用户注册';

$addsalt=md5(mt_rand(0,999).time());
$_SESSION['addsalt']=$addsalt;
$x = new \lib\hieroglyphy();
$addsalt_js = $x->hieroglyphyString($addsalt);

include 'head2.php';

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

		/* 动画定义 */
		@keyframes gradientShift {
			0% { background-position: 0% 50%; }
			50% { background-position: 100% 50%; }
			100% { background-position: 0% 50%; }
		}

		@keyframes float {
			0%, 100% { transform: translateY(0) rotate(0deg); }
			50% { transform: translateY(-20px) rotate(180deg); }
		}

		/* 主容器 */
		.login-container {
			position: relative;
			z-index: 10;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 2rem;
		}

		/* 注册卡片 */
		.login-card {
			background: var(--card-bg);
			backdrop-filter: blur(25px);
			border: 1px solid var(--glass-border);
			border-radius: var(--radius-xl);
			padding: 3rem;
			width: 100%;
			max-width: 420px;
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

		/* 验证码区域样式 */
		.captcha-group {
			position: relative;
			display: flex;
			align-items: stretch;
			margin-bottom: 1.5rem;
			gap: 0;
		}

		.captcha-input-wrapper {
			position: relative;
			flex: 1;
		}

		.captcha-input {
			width: 100%;
			height: 100%;
			padding: 1rem 1rem 1rem 3rem;
			background: rgba(255, 255, 255, 0.15);
			border: 2px solid transparent;
			border-radius: var(--radius-lg) 0 0 var(--radius-lg);
			font-size: 1rem;
			color: white;
			transition: var(--transition);
			backdrop-filter: blur(10px);
		}

		.captcha-input::placeholder {
			color: rgba(255, 255, 255, 0.7);
		}

		.captcha-input:focus {
			outline: none;
			border-color: rgba(255, 255, 255, 0.4);
			background: rgba(255, 255, 255, 0.2);
			box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
		}

		#codeimg {
			height: 48px;
			border-radius: 0 var(--radius-lg) var(--radius-lg) 0;
			cursor: pointer;
			transition: var(--transition);
			background: rgba(255, 255, 255, 0.2);
			backdrop-filter: blur(10px);
		}

		#codeimg:hover {
			opacity: 0.8;
		}

		/* 按钮样式 */
		.modern-btn {
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
			margin: 0.5rem 0;
			text-align: center;
			text-decoration: none;
			display: inline-block;
		}

		.modern-btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
			color: white;
			text-decoration: none;
		}

		.modern-btn:active {
			transform: translateY(0);
		}

		/* 底部链接 */
		.login-footer {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-top: 2rem;
			gap: 1rem;
		}

		.login-footer a {
			color: white;
			text-decoration: none;
			font-size: 0.9rem;
			transition: var(--transition);
			flex: 1;
		}

		.login-footer a:hover {
			color: var(--accent-color);
		}

		/* 验证码容器 */
		#captcha {
			background: rgba(255, 255, 255, 0.1);
			border-radius: var(--radius-lg);
			padding: 1.5rem;
			margin: 1.5rem 0;
			backdrop-filter: blur(10px);
			text-align: center;
			color: white;
		}

		#captcha_text {
			color: rgba(255, 255, 255, 0.9);
		}

		.loading-dot {
			background: rgba(255, 255, 255, 0.7);
		}

		/* 背景动画样式 */
		.particle {
			position: absolute;
			bottom: -10px;
			width: 6px;
			height: 6px;
			background: rgba(255, 255, 255, 0.3);
			border-radius: 50%;
			animation: floatUp linear forwards;
		}

		@keyframes floatUp {
			0% {
				transform: translateY(0) scale(1);
				opacity: 1;
			}
			100% {
				transform: translateY(-100vh) scale(0);
				opacity: 0;
			}
		}

		/* 优化卡片悬浮效果 */
		.login-card::before {
			content: '';
			position: absolute;
			inset: -2px;
			background: linear-gradient(135deg, rgba(255,255,255,0.3), rgba(255,255,255,0.1));
			border-radius: var(--radius-xl);
			z-index: -1;
			transition: opacity 0.3s;
			opacity: 0;
		}

		.login-card:hover::before {
			opacity: 1;
		}

		/* 优化输入框悬浮效果 */
		.modern-input:hover,
		.captcha-input:hover {
			background: rgba(255, 255, 255, 0.2);
		}

		/* 按钮悬浮效果增强 */
		.modern-btn {
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		}

		.modern-btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
		}

		.modern-btn:active {
			transform: translateY(0);
		}
	</style>
</head>
<body>
	<!-- 背景 -->
	<div class="modern-login-background">
		<div class="bg-gradient-main"></div>
		<div class="bg-shapes">
			<div class="shape"></div>
			<div class="shape"></div>
			<div class="shape"></div>
		</div>
            </div>

	<!-- 主容器 -->
	<div class="login-container">
		<div class="login-card">
			<div class="login-header">
				<h1 class="login-title">用户注册</h1>
				<p class="login-subtitle">欢迎加入 <?php echo $conf['sitename'] ?></p>
        </div>

          <form>
		    <input type="hidden" name="captcha_type" value="<?php echo $conf['captcha_open']?>"/>
				
				<div class="modern-form-group">
					<i class="fa fa-user input-icon"></i>
					<input type="text" name="user" class="modern-input" required="required" placeholder="输入登录用户名"/>
				</div>

				<div class="modern-form-group">
					<i class="fa fa-lock input-icon"></i>
					<input type="password" name="pwd" class="modern-input" required="required" placeholder="输入6位以上密码"/>
				</div>

				<div class="modern-form-group">
					<i class="fa fa-qq input-icon"></i>
					<input type="text" name="qq" class="modern-input" required="required" placeholder="输入QQ号，用于找回密码"/>
				</div>

			<?php if($conf['captcha_open']>=1){?>
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
			<?php }else{?>
				<div class="captcha-group">
					<div class="captcha-input-wrapper">
						<i class="fa fa-adjust input-icon"></i>
						<input type="text" name="code" class="captcha-input" required="required" placeholder="输入验证码"/>
					</div>
					<img id="codeimg" src="./code.php?r=<?php echo time();?>" onclick="this.src='./code.php?r='+Math.random();" title="点击更换验证码">
				</div>
			<?php }?>

				<button type="button" id="submit_reg" class="modern-btn">立即注册</button>

				<div class="login-footer">
					<a href="findpwd.php" class="modern-btn">
						<i class="fa fa-unlock"></i>&nbsp;找回密码
					</a>
					<a href="login.php" class="modern-btn">
						<i class="fa fa-user"></i>&nbsp;返回登录
					</a>
			</div>
          </form>
    </div>
	</div>

<script src="<?php echo $cdnserver?>assets/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/bootstrap-3.3.7.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/layer-2.3.js"></script>
<script>
var hashsalt=<?php echo $addsalt_js?>;
</script>
<script src="../assets/js/reguser.js?ver=<?php echo VERSION ?>"></script>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		// 鼠标移动交互
		const card = document.querySelector('.login-card');
		const container = document.querySelector('.login-container');

		container.addEventListener('mousemove', (e) => {
			const rect = container.getBoundingClientRect();
			const x = e.clientX - rect.left;
			const y = e.clientY - rect.top;
			
			const xRotation = ((y - rect.height / 2) / rect.height) * 10;
			const yRotation = ((x - rect.width / 2) / rect.width) * 10;
			
			card.style.transform = `
				perspective(1000px)
				rotateX(${-xRotation}deg)
				rotateY(${yRotation}deg)
				scale3d(1.02, 1.02, 1.02)
			`;
		});

		container.addEventListener('mouseleave', () => {
			card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
		});

		// 背景动画
		function createParticle() {
			const particle = document.createElement('div');
			particle.className = 'particle';
			particle.style.left = Math.random() * 100 + '%';
			particle.style.animationDuration = (Math.random() * 3 + 2) + 's';
			document.querySelector('.bg-shapes').appendChild(particle);

			particle.addEventListener('animationend', () => {
				particle.remove();
			});
		}

		setInterval(createParticle, 200);
	});
	</script>
</body>
</html>