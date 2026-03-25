<?php
if(!defined('IN_CRONLITE'))exit();
$cid = isset($_GET['cid'])?$_GET['cid']:exit('分类ID不正确');
$info=$DB->getRow("SELECT * FROM pre_class WHERE cid=$cid");
include_once TEMPLATE_ROOT.'argon/head.php';
?>

<!-- 专属购买页面现代化样式 -->
<style>
    /* CSS变量定义 */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --card-bg: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(255, 255, 255, 0.2);
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --shadow-soft: 0 8px 32px rgba(0, 0, 0, 0.1);
        --shadow-strong: 0 16px 64px rgba(0, 0, 0, 0.15);
        --radius-lg: 20px;
        --radius-xl: 24px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* 页面主体样式 */
    body {
        background: #0f0f23;
        position: relative;
        overflow-x: hidden;
    }

    /* 多层动态背景系统 */
    .buy-page-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -10;
        overflow: hidden;
    }

    /* 主背景渐变层 */
    .bg-main-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, 
            #667eea 0%, 
            #764ba2 25%, 
            #f093fb 50%, 
            #667eea 75%, 
            #f5576c 100%);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
    }

    /* 浮动装饰层 */
    .bg-decoration-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.6;
    }

    .floating-orb {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, 
            rgba(255, 255, 255, 0.4) 0%, 
            rgba(255, 255, 255, 0.1) 50%, 
            transparent 100%);
        backdrop-filter: blur(2px);
        animation: floatOrb 20s ease-in-out infinite;
    }

    .floating-orb:nth-child(1) {
        width: 120px;
        height: 120px;
        top: 10%;
        left: 15%;
        animation-delay: 0s;
        animation-duration: 25s;
    }

    .floating-orb:nth-child(2) {
        width: 80px;
        height: 80px;
        top: 70%;
        right: 20%;
        animation-delay: -8s;
        animation-duration: 18s;
    }

    .floating-orb:nth-child(3) {
        width: 200px;
        height: 200px;
        top: 40%;
        left: 70%;
        animation-delay: -15s;
        animation-duration: 30s;
    }

    /* 光效层 */
    .bg-light-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.3;
    }

    .light-spot {
        position: absolute;
        background: radial-gradient(ellipse at center,
            rgba(255, 255, 255, 0.2) 0%,
            rgba(255, 255, 255, 0.05) 40%,
            transparent 70%);
        border-radius: 50%;
        animation: lightPulse 6s ease-in-out infinite;
    }

    .light-spot:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -150px;
        left: -150px;
        animation-delay: 0s;
    }

    .light-spot:nth-child(2) {
        width: 400px;
        height: 400px;
        bottom: -200px;
        right: -200px;
        animation-delay: -3s;
    }

    /* 动画定义 */
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        25% { background-position: 100% 50%; }
        50% { background-position: 100% 100%; }
        75% { background-position: 0% 100%; }
    }

    @keyframes floatOrb {
        0%, 100% { transform: translate(0, 0) scale(1) rotate(0deg); }
        25% { transform: translate(20px, -20px) scale(1.1) rotate(90deg); }
        50% { transform: translate(-10px, 10px) scale(0.9) rotate(180deg); }
        75% { transform: translate(-20px, -5px) scale(1.05) rotate(270deg); }
    }

    @keyframes lightPulse {
        0%, 100% { opacity: 0.2; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(1.1); }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* 主内容区域 */
    .main-content {
        position: relative;
        z-index: 10;
        min-height: 100vh;
        padding-top: 2rem;
    }

    /* 现代化卡片设计 */
    .modern-buy-card {
        background: var(--card-bg);
        backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-strong);
        overflow: hidden;
        position: relative;
        animation: fadeInUp 0.8s ease 0.3s both;
    }

    .modern-buy-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }

    /* 卡片头部 */
    .card-header-modern {
        background: rgba(102, 126, 234, 0.05);
        border-bottom: 1px solid var(--glass-border);
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .card-header-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        50% { left: 100%; }
        100% { left: 100%; }
    }

    .card-title-modern {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        position: relative;
        z-index: 2;
    }

    .card-subtitle-modern {
        color: var(--text-secondary);
        margin-top: 0.5rem;
        font-size: 1rem;
        position: relative;
        z-index: 2;
    }

    /* 卡片主体 */
    .card-body-modern {
        padding: 2.5rem;
    }

    /* 现代化表单组 */
    .form-group-modern {
        margin-bottom: 2rem;
        position: relative;
        animation: slideInLeft 0.6s ease calc(var(--delay, 0) * 0.1s) both;
    }

    .form-group-modern:nth-child(1) { --delay: 1; }
    .form-group-modern:nth-child(2) { --delay: 2; }
    .form-group-modern:nth-child(3) { --delay: 3; }
    .form-group-modern:nth-child(4) { --delay: 4; }

    /* 输入组现代化 */
    .input-group-modern {
        position: relative;
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        border: 2px solid transparent;
        transition: var(--transition);
        display: flex;
        align-items: stretch;
    }

    .input-group-modern:focus-within {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }

    .input-group-addon-modern {
        background: var(--primary-gradient);
        color: white;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        display: flex;
        align-items: center;
        min-width: 120px;
        justify-content: center;
    }

    .form-control-modern {
        border: none;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        background: white;
        transition: var(--transition);
        flex: 1;
    }

    .form-control-modern:focus {
        outline: none;
        box-shadow: none;
    }

    .form-control-modern:disabled {
        background: rgba(0, 0, 0, 0.05);
        color: var(--text-secondary);
    }

    /* 兼容原有表单样式 */
    #inputsname .input-group {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        border: 2px solid transparent;
        transition: var(--transition);
        margin-bottom: 1.5rem;
    }

    #inputsname .input-group:focus-within {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }

    #inputsname .input-group-addon {
        background: var(--primary-gradient);
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        min-width: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #inputsname .form-control {
        border: none;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        background: white;
        transition: var(--transition);
    }

    #inputsname .form-control:focus {
        outline: none;
        box-shadow: none;
    }

    /* 现代化数量选择器 */
    .quantity-selector-modern {
        display: flex;
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-soft);
        border: 2px solid transparent;
        transition: var(--transition);
    }

    .quantity-selector-modern:focus-within {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .quantity-btn-modern {
        width: 50px;
        height: 50px;
        border: none;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        font-size: 1.1rem;
    }

    .quantity-btn-modern:hover {
        background: var(--secondary-gradient);
        transform: scale(1.05);
    }

    .quantity-input-modern {
        flex: 1;
        border: none;
        padding: 1rem;
        text-align: center;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .quantity-input-modern:focus {
        outline: none;
    }

    /* 现代化按钮组 */
    .btn-group-modern {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        animation: slideInUp 0.6s ease 0.8s both;
    }

    .btn-modern {
        flex: 1;
        padding: 1rem 2rem;
        border: none;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        box-shadow: var(--shadow-soft);
    }

    .btn-cart-modern {
        background: var(--success-gradient);
        color: white;
    }

    .btn-buy-modern {
        background: var(--primary-gradient);
        color: white;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.6s ease;
    }

    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-strong);
    }

    .btn-modern:hover::before {
        left: 100%;
    }

    .btn-block-modern {
        width: 100%;
    }

    /* 警告框现代化 */
    .alert-modern {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.3);
        border-radius: var(--radius-lg);
        padding: 1.25rem 1.5rem;
        color: #856404;
        font-weight: 500;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .alert-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #ffc107;
    }

    /* 右侧信息面板 */
    .info-panel {
        position: sticky;
        top: 2rem;
    }

    /* 信息面板容器动画 */
    #info-panel-container {
        opacity: 0;
        transform: translateX(30px) scale(0.95);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #info-panel-container.show {
        opacity: 1;
        transform: translateX(0) scale(1);
    }

    /* 左侧表单区域适应性布局 */
    .form-container {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        transform-origin: center;
    }

    .form-container.full-width {
        max-width: 600px;
        margin: 0 auto;
        transform: scale(1.05);
    }

    .form-container:not(.full-width) {
        transform: scale(1);
    }

    /* 响应式布局优化 */
    @media (max-width: 991px) {
        .form-container.full-width {
            transform: scale(1);
            max-width: 100%;
        }
        
        #info-panel-container {
            margin-top: 2rem;
        }
    }

    /* 浮动操作按钮现代化 */
    .floating-actions-modern {
        position: fixed;
        right: 2rem;
        bottom: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        z-index: 1000;
    }

    .floating-btn-modern {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        text-decoration: none;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-soft);
    }

    .floating-btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--primary-gradient);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .floating-btn-modern:hover {
        transform: scale(1.15) rotate(5deg);
        box-shadow: var(--shadow-strong);
        color: white;
        text-decoration: none;
    }

    .floating-btn-modern:hover::before {
        opacity: 1;
    }

    .floating-btn-modern i {
        position: relative;
        z-index: 2;
    }

    .cart-badge-modern {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--secondary-gradient);
        color: white;
        border-radius: 12px;
        padding: 4px 8px;
        font-size: 0.75rem;
        font-weight: 700;
        min-width: 20px;
        text-align: center;
        box-shadow: var(--shadow-soft);
        z-index: 3;
    }

    /* 现代化模态框 */
    .modal-content-modern {
        background: var(--card-bg);
        backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-strong);
    }

    .modal-header-modern {
        border-bottom: 1px solid var(--glass-border);
        background: var(--primary-gradient);
        color: white;
        border-radius: var(--radius-xl) var(--radius-xl) 0 0;
    }

    .modal-body-modern {
        padding: 2rem;
    }

    .modal-footer-modern {
        border-top: 1px solid var(--glass-border);
        padding: 1.5rem 2rem;
    }

    /* 响应式设计 */
    @media (max-width: 768px) {
        .card-body-modern {
            padding: 2rem 1.5rem;
        }
        
        .btn-group-modern {
            flex-direction: column;
        }
        
        .floating-actions-modern {
            right: 1rem;
            bottom: 1rem;
        }
        
        .floating-btn-modern {
            width: 56px;
            height: 56px;
            font-size: 1.3rem;
        }
        
        .card-title-modern {
            font-size: 1.5rem;
        }
        
        .input-group-addon-modern {
            min-width: 100px;
            padding: 0.8rem 1rem;
        }
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
</style>

<!-- 多层动态背景系统 -->
<div class="buy-page-background">
    <!-- 主背景渐变层 -->
    <div class="bg-main-layer"></div>
    
    <!-- 浮动装饰层 -->
    <div class="bg-decoration-layer">
        <div class="floating-orb"></div>
        <div class="floating-orb"></div>
        <div class="floating-orb"></div>
    </div>
    
    <!-- 光效层 -->
    <div class="bg-light-layer">
        <div class="light-spot"></div>
        <div class="light-spot"></div>
    </div>
</div>

<div class="main-content">
    <div class="container-fluid mt--7">
      <div class="row" style="max-width:1200px;margin:0 auto;">
        <div class="col text-center">
          <div class="modern-buy-card">
            <div class="card-header-modern">
              <h3 class="card-title-modern"><?php echo $info['name']?></h3>
              <p class="card-subtitle-modern">🛍️ 选择您需要的商品，享受优质服务</p>
            </div>
            <div class="card-body-modern">
                               <div class="container">
                <div class="row">
                  <div class="col-lg-6 col-12">
                      <div class="form-container full-width">
                      <div class="panel-body">
                        <input type="hidden" name="cid" id="cid" value="0"/>
                        
                        <div class="form-group-modern">
                            <div class="input-group-modern">
                                <div class="input-group-addon-modern">
                                    🏷️ 选择商品
                                </div>
                                <select name="tid" id="tid" class="form-control-modern" onChange="getPoint();">
                                    <option value="0">请选择商品</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group-modern">
                            <div class="input-group-modern">
                                <div class="input-group-addon-modern">
                                    💰 商品价格
                                </div>
                                <input type="text" name="need" id="need" class="form-control-modern" disabled/>
                            </div>
                        </div>
                        
                        <div class="form-group-modern" id="display_left" style="display:none;">
                            <div class="input-group-modern">
                                <div class="input-group-addon-modern">
                                    📦 库存数量
                                </div>
                                <input type="text" name="leftcount" id="leftcount" class="form-control-modern" disabled/>
                            </div>
                        </div>
                        
                        <div class="form-group-modern" id="display_num" style="display:none;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-primary);">
                                📝 下单份数
                            </label>
                            <div class="quantity-selector-modern">
                                <button type="button" id="num_min" class="quantity-btn-modern">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input id="num" name="num" class="quantity-input-modern" type="number" min="1" value="1"/>
                                <button type="button" id="num_add" class="quantity-btn-modern">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        
			            <div id="inputsname"></div>
                        <div class="alert-modern" style="display:none;"></div>
                        
						<?php if($conf['shoppingcart']==1){?>
						<div class="btn-group-modern">
							<button class="btn-modern btn-cart-modern" type="button" id="submit_cart_shop">
							    <i class="fa fa-shopping-cart"></i> 加入购物车
							</button>
							<button type="submit" id="submit_buy" class="btn-modern btn-buy-modern">
							    <i class="fa fa-credit-card"></i> 立即购买
							</button>
						</div>
						<?php }else{?>
						<div class="form-group-modern">
							<button type="submit" id="submit_buy" class="btn-modern btn-buy-modern btn-block-modern">
							    <i class="fa fa-credit-card"></i> 立即购买
							</button>
						</div>
						 						<?php }?>
 	                  </div>
 	                  </div>
                  </div>
                  <div class="col-lg-6 col-12" id="info-panel-container" style="display: none;">
                        <div class="info-panel">
                            <div id="alert_frame" class="alert-modern" style="display:none;"></div>
                        </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- 现代化浮动操作栏 -->
<div class="floating-actions-modern">
    <?php if($conf['shoppingcart']==1){?>
    <div id="alert_carts" style="display: none; position: relative;">
        <a class="floating-btn-modern" href="./?mod=cart" title="购物车列表">
            <i class="fa fa-shopping-cart"></i>
            <div class="cart-badge-modern" id="cart_counts"></div>
        </a>
    </div>
    <?php }?>
    
    <a class="floating-btn-modern" href="#BKefu" data-toggle="modal" title="联系客服">
        <i class="fa fa-qq"></i>
    </a>
    
    <a class="floating-btn-modern" href="#gg" data-toggle="modal" title="查看公告">
        <i class="fa fa-bell"></i>
    </a>
    
    <a class="floating-btn-modern" href="javascript:void(0)" onClick="javascript :history.back(-1);" title="返回上页" style="background: var(--secondary-gradient);">
        <i class="fa fa-arrow-left"></i>
    </a>
</div>

<div class="modal fade" id="BKefu" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <h5 class="modal-title" style="margin: 0; font-weight: 600;">
                    💬 专属客服服务
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.8;">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body-modern text-center">
                <i class="fa fa-comment-dots fa-3x mb-3" style="color: #667eea;"></i>
                <h6 style="margin-bottom: 1rem; color: var(--text-primary);">订单售后客服QQ</h6>
                <a target="_blank" class="btn-modern btn-buy-modern" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=qq&menu=yes" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                    <img border="0" src="//wpa.qq.com/pa?p=2:<?php echo $conf['kfqq']?>:52" alt="点击这里给我发消息" style="width: 20px; height: 20px;"/> 
                    <?php echo $conf['kfqq']?>
                </a>
            </div>
            <div class="modal-footer-modern text-center">
                <button type="button" class="btn-modern btn-cart-modern" data-dismiss="modal" style="width: 100%;">知道了</button> 
            </div>
        </div>
    </div>
</div>

<div class="shuaibi-zhezhao" id="ShuaibiZhezhao"></div>
<div class="shuaibi-zzimg" id="ShuaibiZzimg">
    <span id="ShuaibiZzclose"><i class="fa fa-times fa-3x"></i></span>
    <img src="assets/img/bookmark.png" alt="bookmark">
</div>

<footer class="footer" style="background: rgba(0, 0, 0, 0.2); backdrop-filter: blur(20px); border-top: 1px solid rgba(255, 255, 255, 0.1); color: white; position: relative; z-index: 100;">
    <div class="row align-items-center justify-content-xl-between m-0">
      <div class="col-lg-12">
        <div class="copyright text-center" style="color: rgba(255, 255, 255, 0.8);">
          &copy; <?php echo date("Y")?> <a href="./" style="color: white; font-weight: 600;" target="_blank"><?php echo $conf['sitename']?></a>&nbsp;•&nbsp;<a href="javascript:void(0)" style="color: rgba(255, 255, 255, 0.8);" onclick="layer.alert('电脑用户请按键盘 <kbd>Ctrl</kbd> + <kbd>D</kbd> 将本站存为书签！', {icon: 7,title: '小提示',skin: 'layui-layer-molv layui-layer-wxd'})">收藏</a>
        </div>
      </div>
    </div>
</footer>

<script src="<?php echo $cdnserver?>assets/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/jquery.lazyload-1.9.1.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/bootstrap-4.1.3.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/jquery.cookie-1.4.1.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/layer-2.3.js"></script>

<script type="text/javascript">
var isModal=false;
var homepage=false;
var hashsalt=<?php echo $addsalt_js?>;

$(function() {
    // 现代化数量选择器功能
    $('#num_min').click(function() {
        var num = parseInt($('#num').val());
        if (num > 1) {
            $('#num').val(num - 1);
        }
    });

    $('#num_add').click(function() {
        var num = parseInt($('#num').val());
        $('#num').val(num + 1);
    });

    // 商品选择时显示右侧面板的函数
    window.showInfoPanel = function() {
        // 显示右侧信息面板
        $('#info-panel-container').show();
        setTimeout(function() {
            $('#info-panel-container').addClass('show');
        }, 50);
        
        // 调整左侧布局
        $('.form-container').removeClass('full-width');
    }

    // 隐藏右侧面板的函数
    window.hideInfoPanel = function() {
        $('#info-panel-container').removeClass('show');
        setTimeout(function() {
            $('#info-panel-container').hide();
        }, 300);
        
        // 恢复左侧布局
        $('.form-container').addClass('full-width');
    }

    // 重写getPoint函数来集成面板显示逻辑
    var originalGetPoint = window.getPoint;
    window.getPoint = function() {
        // 执行原始的getPoint逻辑
        if (originalGetPoint) {
            originalGetPoint();
        }
        
        // 检查是否选择了商品
        var tid = $('#tid option:selected').val();
        if (tid && tid != '0' && tid != undefined) {
            // 选择了商品，显示右侧面板
            showInfoPanel();
        } else {
            // 未选择商品，隐藏右侧面板
            hideInfoPanel();
        }
    }

    // 页面加载时检查初始状态
    setTimeout(function() {
        var tid = $('#tid option:selected').val();
        if (!tid || tid == '0' || tid == undefined) {
            hideInfoPanel();
        }
    }, 100);

    // 优化的提示样式
	setTimeout(function () { 
        layer.tips('🎯 点我选择心仪的商品', '#tid', {
            tips: [1, '#667eea'],
            time: 4000,
            skin: 'layui-layer-molv'
        }); 
    }, 800); 

    <?php if($conf['shoppingcart']==1){?>
    $.ajax({
    	type : "GET",
    	url : "ajax.php?act=cart_info",
    	dataType : 'json',
    	async: true,
    	success : function(data) {
    		if(data.count != null && data.count>0){
    			$('#cart_counts').html(data.count);
    			$('#alert_carts').show();
    		}
    	}
    });
    <?php }?>
});
</script>
<script src="assets/js/main.js?ver=<?php echo VERSION ?>"></script>
</body>
</html>