<?php
if (!defined('IN_CRONLITE')) die();
$qqlink = 'https://wpa.qq.com/msgrd?v=3&uin='.$conf['kfqq'].'&site=qq&menu=yes';
if($is_fenzhan && !empty($conf['kfwx']) && file_exists(ROOT.'assets/img/qrcode/wxqrcode_'.$siterow['zid'].'.png')){
	$qrcodeimg = './assets/img/qrcode/wxqrcode_'.$siterow['zid'].'.png';
	$qrcodename = '微信';
}elseif(!empty($conf['kfwx']) && file_exists(ROOT.'assets/img/wxqrcode.png')){
	$qrcodeimg = './assets/img/wxqrcode.png';
	$qrcodename = '微信';
}else{
	// 使用稳定的备用二维码API
	$qrcodeimg = 'https://quickchart.io/qr?text='.urlencode($qqlink).'&size=300';
	$qrcodename = 'QQ';
}
?>
<!DOCTYPE html>
<html lang="zh" style="font-size: 20px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover,user-scalable=no">
    <script> document.documentElement.style.fontSize = document.documentElement.clientWidth / 750 * 40 + "px";</script>
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-param" content="_csrf">
    <title>客服中心 - <?php echo $conf['sitename'] ?></title>
    <meta name="keywords" content="<?php echo $conf['keywords'] ?>">
    <meta name="description" content="<?php echo $conf['description'] ?>">
    <!-- Vendor styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/css/layui-2.5.7.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/foxui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/foxui.diy.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/iconfont.css">
	<?php echo str_replace('body','html',$background_css)?>
</head>

<style>
    body {
        margin: auto;
        max-width: 650px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
        min-height: 100vh;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        25% { background-position: 100% 50%; }
        50% { background-position: 50% 100%; }
        75% { background-position: 0% 0%; }
        100% { background-position: 0% 50%; }
    }

    .custormer-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
        overflow: hidden;
    }

    /* 背景装饰元素 */
    .custormer-page::before {
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
        animation: rotate 20s linear infinite;
        pointer-events: none;
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .service-container {
        position: relative;
        z-index: 10;
        opacity: 0;
        transform: translateY(50px) scale(0.9);
        animation: containerEntrance 1.2s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    @keyframes containerEntrance {
        0% {
            opacity: 0;
            transform: translateY(50px) scale(0.9) rotateX(15deg);
            filter: blur(10px);
        }
        50% {
            opacity: 0.8;
            transform: translateY(-10px) scale(1.05) rotateX(5deg);
            filter: blur(2px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1) rotateX(0deg);
            filter: blur(0px);
        }
    }

    .service-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 32px;
        text-align: center;
        box-shadow: 
            0 20px 40px rgba(0, 0, 0, 0.1),
            0 10px 20px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.3);
        max-width: 400px;
        width: 100%;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .service-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.4), 
            transparent
        );
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        50% { left: 100%; }
        100% { left: -100%; }
    }

    .service-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 
            0 30px 60px rgba(0, 0, 0, 0.15),
            0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .service-title {
        font-size: 24px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 24px;
        opacity: 0;
        transform: translateY(20px);
        animation: titleSlideIn 0.8s ease-out 0.3s forwards;
    }

    @keyframes titleSlideIn {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .contact-info {
        margin-bottom: 24px;
        opacity: 0;
        transform: translateX(-30px);
        animation: infoSlideIn 0.8s ease-out 0.5s forwards;
    }

    @keyframes infoSlideIn {
        0% {
            opacity: 0;
            transform: translateX(-30px);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .contact-item {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        padding: 12px 20px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .contact-item:hover {
        background: rgba(102, 126, 234, 0.2);
        transform: translateX(5px);
    }

    .contact-label {
        font-weight: 600;
        color: #333;
        margin-right: 12px;
    }

    .contact-value {
        color: #667eea;
        font-weight: 500;
    }

    .contact-action {
        margin-left: 12px;
        padding: 6px 12px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        text-decoration: none;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

         .contact-action:hover {
         transform: translateY(-2px);
         box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
         color: white;
         text-decoration: none;
     }

     .contact-action.clicked {
         transform: scale(0.95);
         background: linear-gradient(135deg, #5a67d8, #6b46c1);
     }

    .qrcode-container {
        margin: 24px 0;
        opacity: 0;
        transform: scale(0.8) rotateY(180deg);
        animation: qrcodeFlipIn 1s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.7s forwards;
    }

    @keyframes qrcodeFlipIn {
        0% {
            opacity: 0;
            transform: scale(0.8) rotateY(180deg);
        }
        50% {
            opacity: 0.5;
            transform: scale(1.1) rotateY(90deg);
        }
        100% {
            opacity: 1;
            transform: scale(1) rotateY(0deg);
        }
    }

    .qrcode-wrapper {
        position: relative;
        display: inline-block;
        padding: 16px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .qrcode-wrapper:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
    }

    .qrcode-image {
        width: 200px;
        height: 200px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

         .qrcode-image:hover {
         transform: scale(1.02);
     }

     .qrcode-fallback {
         width: 200px;
         height: 200px;
         background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
         border-radius: 12px;
         display: flex;
         align-items: center;
         justify-content: center;
         color: white;
         text-align: center;
         position: relative;
         overflow: hidden;
     }

     .qrcode-fallback::before {
         content: '';
         position: absolute;
         top: -50%;
         left: -50%;
         width: 200%;
         height: 200%;
         background: radial-gradient(circle at center, 
             rgba(255, 255, 255, 0.2) 0%, 
             rgba(255, 255, 255, 0.1) 40%,
             transparent 70%
         );
         animation: rotate 10s linear infinite;
     }

     .fallback-content {
         position: relative;
         z-index: 2;
     }

     .qr-icon {
         font-size: 32px;
         margin-bottom: 12px;
         animation: bounce 2s ease-in-out infinite;
     }

     @keyframes bounce {
         0%, 20%, 50%, 80%, 100% {
             transform: translateY(0);
         }
         40% {
             transform: translateY(-8px);
         }
         60% {
             transform: translateY(-4px);
         }
     }

     .qr-title {
         font-size: 18px;
         font-weight: 700;
         margin-bottom: 8px;
     }

     .qr-number {
         font-size: 16px;
         font-weight: 600;
         margin-bottom: 8px;
         background: rgba(255, 255, 255, 0.2);
         padding: 4px 12px;
         border-radius: 12px;
         display: inline-block;
     }

     .qr-text {
         font-size: 12px;
         opacity: 0.9;
     }

    .scan-instruction {
        margin-top: 20px;
        padding: 16px 24px;
        background: linear-gradient(135deg, #f093fb, #f5576c);
        color: white;
        border-radius: 25px;
        font-weight: 600;
        font-size: 16px;
        box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
        opacity: 0;
        transform: translateY(30px);
        animation: instructionSlideUp 0.8s ease-out 0.9s forwards;
        position: relative;
        overflow: hidden;
    }

    @keyframes instructionSlideUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .scan-instruction::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.3), 
            transparent
        );
        animation: scanShine 2s infinite 1s;
    }

    @keyframes scanShine {
        0% { left: -100%; }
        50% { left: 100%; }
        100% { left: -100%; }
    }

    .floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }

    .floating-element {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .floating-element:nth-child(1) {
        width: 60px;
        height: 60px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .floating-element:nth-child(2) {
        width: 40px;
        height: 40px;
        top: 60%;
        right: 15%;
        animation-delay: 2s;
    }

    .floating-element:nth-child(3) {
        width: 80px;
        height: 80px;
        bottom: 20%;
        left: 15%;
        animation-delay: 4s;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
            opacity: 0.3;
        }
        50% {
            transform: translateY(-20px) rotate(180deg);
            opacity: 0.8;
        }
    }

    /* 移动端优化 */
    @media (max-width: 768px) {
        .custormer-page {
            padding: 16px;
        }
        
        .service-card {
            padding: 24px 20px;
            margin: 0 10px;
        }
        
        .service-title {
            font-size: 20px;
        }
        
        .qrcode-image {
            width: 180px;
            height: 180px;
        }
        
        .scan-instruction {
            font-size: 14px;
            padding: 12px 20px;
        }
    }

    .fix-iphonex-bottom {
        padding-bottom: 34px;
    }

    .fui-navbar {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(20px);
        border-top: 1px solid rgba(255, 255, 255, 0.3) !important;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
    }
</style>

<body>
<div id="body">
    <div class="custormer-page">
        <!-- 浮动装饰元素 -->
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>

        <div class="service-container">
            <div class="service-card">
                <h2 class="service-title">🎯 客服中心</h2>
                
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="contact-label">客服QQ：</span>
                        <span class="contact-value"><?php echo $conf['kfqq'] ?></span>
                        <a href="<?php echo $qqlink ?>" target="_blank" class="contact-action">添加</a>
                    </div>
                    
                    <?php if(!empty($conf['kfwx'])){?>
                    <div class="contact-item">
                        <span class="contact-label">客服微信：</span>
                        <span class="contact-value"><?php echo $conf['kfwx']; ?></span>
                        <button class="contact-action wx_hao" data-clipboard-text="<?php echo $conf['kfwx']; ?>">复制</button>
                    </div>
                    <?php }?>
                </div>

                <div class="qrcode-container">
                    <div class="qrcode-wrapper">
                        <img class="qrcode-image" id="qrcode-img" src="<?php echo $qrcodeimg ?>" alt="<?php echo $qrcodename?>二维码" onerror="handleQRCodeError(this)">
                        <div class="qrcode-fallback" id="qrcode-fallback" style="display: none;">
                            <div class="fallback-content">
                                <div class="qr-icon">📱</div>
                                <div class="qr-title">客服<?php echo $qrcodename?></div>
                                <div class="qr-number"><?php echo $conf['kfqq'] ?></div>
                                <div class="qr-text">点击下方按钮添加客服</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="scan-instruction">
                    📱 打开<?php echo $qrcodename?>扫一扫添加客服
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fui-navbar" style="bottom:-34px;background-color: white;max-width: 650px">
</div>
<div class="fui-navbar" style="max-width: 650px;z-index: 100;">
    <a href="./" class="nav-item"> <span class="icon icon-home"></span> <span class="label">首页</span></a>
    <a href="./?mod=query" class="nav-item"> <span class="icon icon-dingdan1"></span> <span class="label">订单</span></a>
	<a href="./?mod=cart" class="nav-item" <?php if($conf['shoppingcart']==0){?>style="display:none"<?php }?>> <span class="icon icon-cart2"></span> <span class="label">购物车</span></a>
    <a href="?mod=kf" class="nav-item active"> <span class="icon icon-service1"></span> <span class="label">客服</span></a>
    <a href="./user/" class="nav-item"> <span class="icon icon-person2"></span> <span class="label">会员中心</span></a>
</div>

<script src="<?php echo $cdnserver; ?>assets/js/jquery-3.4.1.min.js"></script>
<script src="<?php echo $cdnserver; ?>assets/js/layer-2.3.js"></script>
<script src="<?php echo $cdnserver; ?>assets/js/clipboard-1.7.1.min.js"></script>
<script>
         // 处理二维码加载错误的函数
     var qrCodeAttempts = 0;
     var qrCodeAPIs = [
         'https://qr-server.com/api/v1/create-qr-code/?size=300x300&data=',
         'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=',
         'https://api.qrcode-generator.com/v1/create?access-token=&qr_code_text=',
         'https://quickchart.io/qr?text=',
         'https://qrcode.tec-it.com/API/QRCode?data='
     ];
     
     function handleQRCodeError(img) {
         qrCodeAttempts++;
         
         if (qrCodeAttempts < qrCodeAPIs.length) {
             // 尝试下一个API
             var qqLink = '<?php echo urlencode($qqlink); ?>';
             img.src = qrCodeAPIs[qrCodeAttempts] + qqLink;
             console.log('尝试API ' + (qrCodeAttempts + 1) + ': ' + img.src);
         } else {
             // 所有API都失败了，显示备用方案
             console.log('所有二维码API都失败，显示备用方案');
             img.style.display = 'none';
             document.getElementById('qrcode-fallback').style.display = 'flex';
             
             // 显示友好的错误信息
             layer.msg('二维码暂时无法加载，请直接点击添加按钮', {icon: 3, time: 3000});
         }
     }

     // 复制功能
     var clipboard = new Clipboard('.wx_hao');
     clipboard.on('success', function (e) {
         layer.msg('复制成功！', {icon: 1});
     });
     clipboard.on('error', function (e) {
         layer.msg('复制失败，请手动复制', {icon: 2});
     });

         // 页面加载完成后的额外动画和二维码检查
     $(document).ready(function() {
         // 检查二维码是否成功加载
         var qrImage = document.getElementById('qrcode-img');
         var checkImage = new Image();
         checkImage.onload = function() {
             console.log('二维码加载成功');
         };
         checkImage.onerror = function() {
             console.log('初始二维码加载失败，触发错误处理');
             handleQRCodeError(qrImage);
         };
         checkImage.src = qrImage.src;
         
         // 为卡片添加鼠标跟踪效果
         $('.service-card').mousemove(function(e) {
             const card = $(this);
             const rect = card[0].getBoundingClientRect();
             const x = e.clientX - rect.left;
             const y = e.clientY - rect.top;
             
             const centerX = rect.width / 2;
             const centerY = rect.height / 2;
             
             const rotateX = (y - centerY) / 10;
             const rotateY = (centerX - x) / 10;
             
             card.css({
                 'transform': `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`
             });
         });
         
         $('.service-card').mouseleave(function() {
             $(this).css({
                 'transform': 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateZ(0px)'
             });
         });
         
         // 增强联系按钮的动画效果
         $('.contact-action').click(function() {
             $(this).addClass('clicked');
             setTimeout(() => {
                 $(this).removeClass('clicked');
             }, 300);
         });
     });
</script>
</body>
</html>