<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>
  <title><?php echo $hometitle?></title>
  <meta name="keywords" content="<?php echo $conf['keywords']?>">
  <meta name="description" content="<?php echo $conf['description']?>">
  <link href="<?php echo $cdnserver?>assets/css/font-awesome-4.7.0.min.css" rel="stylesheet"/>
  <link type="text/css" href="<?php echo $cdnserver?>assets/css/argon.css" rel="stylesheet">
  <link type="text/css" href="<?php echo $cdnserver?>assets/css/argon2.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $cdnserver?>assets/css/common.css?ver=<?php echo VERSION ?>">
  <!--[if lt IE 9]>
    <script src="<?php echo $cdnserver?>assets/js/html5shiv-3.7.3.min.js"></script>
    <script src="<?php echo $cdnserver?>assets/js/respond-1.4.2.min.js"></script>
  <![endif]-->
<style>
.nav-counter-big{top:18px;right:20px;}
.nav-counter-small{height:15px;width:15px;line-height:15px;font-size:10px;}

/* 现代化头部样式 */
.modern-navbar {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(20px);
    border: none !important;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 200;
    opacity: 0;
    transition: opacity 0.6s ease;
}

.modern-navbar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
    pointer-events: none;
}

.modern-navbar .navbar-brand-img {
    filter: brightness(1.2) contrast(1.1);
    transition: all 0.3s ease;
}

.modern-navbar .navbar-brand-img:hover {
    transform: scale(1.05);
}

.nav-shuaibi-link {
    color: white !important;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px !important;
    padding: 0.5rem 1.5rem !important;
    margin: 0 0.5rem;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    display: inline-block;
}

.nav-shuaibi-link:hover {
    color: white !important;
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
    text-decoration: none;
}

/* 独立的功能按钮区域 */
.function-buttons-area {
    position: relative;
    padding: 1.5rem 0;
    margin: 0;
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    z-index: 50;
    opacity: 0;
    transition: opacity 0.6s ease 0.3s;
}

.function-buttons-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    max-width: 800px;
    margin: 0 auto;
    padding: 0 1rem;
}

.function-button {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 12px;
    padding: 1.2rem 1rem;
    text-align: center;
    text-decoration: none;
    color: white;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    min-width: 120px;
    flex: 1;
    max-width: 150px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

.function-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.function-button:hover::before {
    opacity: 1;
}

.function-button:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.12);
    color: white;
    text-decoration: none;
    background: rgba(255, 255, 255, 0.12);
    border-color: rgba(255, 255, 255, 0.2);
}

.function-button-icon {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.8rem;
    font-size: 1.3rem;
    transition: all 0.3s ease;
}

.function-button:hover .function-button-icon {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.2);
}

.function-button-title {
    font-size: 0.9rem;
    font-weight: 500;
    margin: 0;
    position: relative;
    z-index: 2;
    line-height: 1.3;
}

/* 移除原有header区域 */
.header.bg-gradient-primary {
    display: none !important;
}

/* 移动端导航美化 */
.navbar-vertical.bg-white {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(20px);
    border: none !important;
    opacity: 0;
    transition: opacity 0.6s ease;
}

.nav-link-icon {
    background: rgba(102, 126, 234, 0.1);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.nav-link-icon:hover {
    background: rgba(102, 126, 234, 0.2);
    transform: scale(1.1);
}

/* 模态框美化 */
.modal-content.bg-gradient-primary,
.modal-content.bg-gradient-warning {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    color: #2d3748;
}

.modal-content .ni {
    color: #667eea;
}

.btn-secondary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 25px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

/* 响应式设计 */
@media (max-width: 768px) {
    .function-buttons-area {
        padding: 1.2rem 0;
    }
    
    .function-buttons-container {
        gap: 0.8rem;
        padding: 0 1rem;
    }
    
    .function-button {
        min-width: 110px;
        max-width: 130px;
        padding: 1rem 0.8rem;
        flex: 1 1 calc(50% - 0.4rem);
    }
    
    .function-button-icon {
        width: 38px;
        height: 38px;
        font-size: 1.1rem;
        margin-bottom: 0.6rem;
    }
    
    .function-button-title {
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    .function-buttons-area {
        padding: 1rem 0;
    }
    
    .function-buttons-container {
        gap: 0.6rem;
        padding: 0 0.5rem;
    }
    
    .function-button {
        min-width: 95px;
        max-width: 110px;
        padding: 0.8rem 0.6rem;
        flex: 1 1 calc(33.333% - 0.4rem);
    }
    
    .function-button-icon {
        width: 32px;
        height: 32px;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .function-button-title {
        font-size: 0.75rem;
    }
}

/* 隐藏原来的btn-icon-clipboard样式 */
.btn-icon-clipboard {
    display: none !important;
}

/* JavaScript禁用时的fallback */
.no-js .modern-navbar,
.no-js .function-buttons-area,
.no-js .navbar-vertical.bg-white {
    opacity: 1 !important;
}
</style>
</head>
<body class="no-js">
<script>document.body.classList.remove('no-js');</script>
  <nav class="navbar navbar-vertical navbar-expand-md navbar-light bg-white d-md-none">
      <!-- 侧栏按钮 -->
      <!--LOGO-->
      <a class="navbar-brand pt-0" href="./">
        <img src="<?php echo $logo?>" class="navbar-brand-img" alt="LOGO">
      </a>
      <!--导航right-->
      <ul class="nav align-items-center d-md-none">
	    <li class="nav-item page-item" id="alert_cart" style="display: none;">
          <a class="nav-link page-link nav-link-icon" href="./?mod=cart" title="购物车列表">
            <i class="fa fa-shopping-cart"></i><div class="nav-counter nav-counter-small" id="cart_count"></div>
          </a>
        </li>
        <li class="nav-item page-item dropdown">
          <a class="nav-link page-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-qq"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
            <h6 class="dropdown-header text-dark">订单售后客服ＱＱ</h6>
            <a target="_blank" class="dropdown-item" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=qq&menu=yes"><img border="0" src="//wpa.qq.com/pa?p=2:<?php echo $conf['kfqq']?>:52" alt="点击这里给我发消息" title="点击这里给我发消息"/> <?php echo $conf['kfqq']?></a>
          </div>
        </li>
        <li class="nav-item page-item">
          <a class="nav-link page-link nav-link-icon" href="#gg" data-toggle="modal">
            <i class="fa fa-bell"></i>
          </a>
        </li>
        <li class="nav-item dropdown ml-3">
			<?php if($islogin2==1){?>
            <a href="./user/" class="nav-shuaibi-link">用户中心</a>
			<?php }else{?>
			<a href="./user/login.php" class="nav-shuaibi-link">登录</a>
            <a href="./user/reg.php" class="nav-shuaibi-link">注册</a>
			<?php }?>
        </li>
      </ul>
  </nav>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-" role="document">
        <div class="modal-content bg-gradient-warning">
            <div class="modal-body">
            <div class="py-1 text-center">
                <i class="ni ni-bell-55 ni-3x mb-3"></i>
<?php echo $conf['modal']?>
            </div>
            </div>
            <div class="modal-footer py-2">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">知道啦</button> 
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gg" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-" role="document">
        <div class="modal-content bg-gradient-primary">
            <div class="modal-body">
            <div class="py-1 text-center">
                <i class="ni ni-bell-55 ni-3x mb-3"></i>
<?php echo $conf['anounce']?>
            </div>
            </div>
            <div class="modal-footer py-2">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">知道啦</button> 
            </div>
        </div>
    </div>
</div>

<!-- 现代化顶部导航 -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark modern-navbar" id="navbar-main">
  <div class="container-fluid">
    <!-- Brand -->
    <a class="mb-0 text-white text-uppercase d-none d-md-inline-block" href="./">
        <img src="<?php echo $logo?>" class="navbar-brand-img" alt="LOGO" style="max-width: 200px;max-height: 80px;">
    </a>
    <!-- 导航right -->
    <ul class="navbar-nav align-items-center d-none d-md-flex">
        <li class="nav-item dropdown">
		<?php if($islogin2==1){?>
        <a href="./user/" class="nav-shuaibi-link">🏠 用户中心</a>
		<?php }else{?>
		<a href="./user/login.php" class="nav-shuaibi-link">🔑 登录</a>
        <a href="./user/reg.php" class="nav-shuaibi-link">📝 注册</a>
		<?php }?>
        </li>
    </ul>
  </div>
</nav>

<!-- 独立的功能按钮区域 -->
<div class="function-buttons-area">
  <div class="function-buttons-container">
    <?php if($conf['fenzhan_buy']==0 && $conf['gift_open']==0){?>
      <a href="./" class="function-button">
        <div class="function-button-icon">🛒</div>
        <p class="function-button-title">在线下单</p>
      </a>
      <a href="./?mod=query" class="function-button">
        <div class="function-button-icon">🔍</div>
        <p class="function-button-title">查询订单</p>
      </a>
    <?php }else{?>
      <a href="./" class="function-button">
        <div class="function-button-icon">🛒</div>
        <p class="function-button-title">在线下单</p>
      </a>
      <a href="./?mod=query" class="function-button">
        <div class="function-button-icon">🔍</div>
        <p class="function-button-title">查询订单</p>
      </a>
      <a href="./?mod=site" class="function-button" <?php if($conf['fenzhan_buy']==0){?>style="display:none;"<?php }?>>
        <div class="function-button-icon">👥</div>
        <p class="function-button-title">成为代理</p>
      </a>
      <a href="./?mod=gift" class="function-button" <?php if($conf['gift_open']==0){?>style="display:none;"<?php }?>>
        <div class="function-button-icon">🎁</div>
        <p class="function-button-title">每日抽奖</p>
      </a>
      <?php if($conf['articlenum']>0 && $conf['gift_open']==0){?>
      <a href="<?php echo article_url()?>" class="function-button">
        <div class="function-button-icon">📰</div>
        <p class="function-button-title">文章列表</p>
      </a>
      <?php }?>
    <?php }?>
  </div>
</div>

<div class="main-content">