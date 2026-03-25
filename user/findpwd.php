<?php
/**
 * 找回密码
**/
$is_defend=true;
include("../includes/common.php");
if(isset($_GET['act']) && $_GET['act']=='qrlogin'){
	if(isset($_SESSION['findpwd_qq']) && $qq=$_SESSION['findpwd_qq']){
		$row=$DB->getRow("SELECT zid,user,pwd,status FROM pre_site WHERE qq=:qq LIMIT 1", [':qq'=>$qq]);
		unset($_SESSION['findpwd_qq']);
		if($row['user']){
			if($row['status']==0){
				exit('{"code":-1,"msg":"当前账号已被封禁！"}');
			}
			$session=md5($row['user'].$row['pwd'].$password_hash);
			$token=authcode("{$row['zid']}\t{$session}", 'ENCODE', SYS_KEY);
			setcookie("user_token", $token, time() + 604800, '/');
			log_result('分站找回密码', 'User:'.$row['user'].' IP:'.$clientip, null, 1);
			$DB->exec("UPDATE pre_site SET lasttime='$date' WHERE zid='{$row['zid']}'");
			exit('{"code":1,"msg":"登录成功，请在用户资料设置里重置密码","url":"./"}');
		}else{
			@header('Content-Type: application/json; charset=UTF-8');
			exit('{"code":-1,"msg":"当前QQ不存在，请确认你已注册过账号或开通过分站"}');
		}
	}else{
		@header('Content-Type: application/json; charset=UTF-8');
		exit('{"code":-2,"msg":"验证失败，请重新扫码"}');
	}
}elseif(isset($_GET['act']) && $_GET['act']=='qrcode'){
	$image=trim($_POST['image']);
	$result = qrcodelogin($image);
	exit(json_encode($result));
}elseif($islogin2==1){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已登陆！');window.location.href='./';</script>");
}
$title='找回密码';

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

		/* 找回密码卡片 */
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

		/* 二维码区域 */
		#qrimg {
			background: rgba(255, 255, 255, 0.1);
			border-radius: var(--radius-lg);
			padding: 1.5rem;
			margin: 1.5rem 0;
			backdrop-filter: blur(10px);
			text-align: center;
		}

		#loginmsg {
			color: white;
			font-size: 1rem;
		}

		#loginload {
			color: rgba(255, 255, 255, 0.7) !important;
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

		.modern-btn-warning {
			background: linear-gradient(135deg, var(--warning-color), var(--danger-color));
		}

		.modern-btn-success {
			background: linear-gradient(135deg, var(--success-color), var(--info-color));
		}

		/* 提示信息 */
		.modern-alert {
			background: rgba(255, 255, 255, 0.1);
			border-radius: var(--radius-lg);
			padding: 1rem;
			margin: 1rem 0;
			color: white;
			backdrop-filter: blur(10px);
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
		}

		.login-footer a:hover {
			color: var(--accent-color);
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
				<h1 class="login-title">找回密码</h1>
				<p class="login-subtitle">欢迎回到 <?php echo $conf['sitename'] ?></p>
				</div>

			<div id="login" class="modern-alert">
				<span id="loginmsg">请使用QQ手机版扫描二维码</span>
				<span id="loginload" style="padding-left: 10px;">.</span>
				</div>

			<div id="qrimg"></div>

			<div id="mobile" style="display:none;">
				<button type="button" id="mlogin" onclick="mloginurl()" class="modern-btn modern-btn-warning">跳转QQ快捷登录</button>
				<button type="button" onclick="qrlogin()" class="modern-btn modern-btn-success">我已完成登录</button>
			</div>

			<?php if($conf['login_qq']==1){?>
			<div class="modern-alert">
				提示：只能找回注册时填写了QQ号码的帐号密码，QQ快捷登录的暂不持支该方式找回密码。
			</div>
			<?php }?>

			<div class="login-footer">
				<a href="login.php" class="modern-btn">
					<i class="fa fa-user"></i>&nbsp;返回登录
				</a>
				<a href="reg.php" class="modern-btn">
					<i class="fa fa-user-plus"></i>&nbsp;注册用户
				</a>
        </div>
      </div>
    </div>

<script src="<?php echo $cdnserver?>assets/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/bootstrap-3.3.7.min.js"></script>
<script src="../assets/js/qrlogin.js?ver=<?php echo VERSION ?>"></script>
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