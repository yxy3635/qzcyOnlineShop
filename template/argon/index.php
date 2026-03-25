<?php
if(!defined('IN_CRONLITE'))exit();
if($_GET['buyok']==1){include_once TEMPLATE_ROOT.'argon/query.php';exit;}
if(isset($_GET['cid'])){include_once TEMPLATE_ROOT.'argon/buy.php';exit;}

include_once TEMPLATE_ROOT.'argon/head.php';
?>

<!-- 高级现代化样式 -->
<style>
    :root {
        --primary: #667eea;
        --primary-dark: #5a6fd8;
        --secondary: #764ba2;
        --accent: #f093fb;
        --accent-light: #f5576c;
        --success: #4facfe;
        --success-light: #00f2fe;
        --warning: #ffecd2;
        --danger: #fcb69f;
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --border-light: rgba(255, 255, 255, 0.1);
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
        --shadow-lg: 0 8px 25px rgba(0,0,0,0.12);
        --shadow-xl: 0 12px 40px rgba(0,0,0,0.15);
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        box-sizing: border-box;
    }

    body {
        background: #0f0f23;
        min-height: 100vh;
        position: relative;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        overflow-x: hidden;
    }

    /* 多层动态背景系统 */
    .dynamic-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -10;
        overflow: hidden;
    }

    /* 主背景渐变层 */
    .bg-gradient-layer {
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
            #764ba2 100%);
        background-size: 800% 800%;
        animation: morphingGradient 20s ease infinite;
    }

    /* 几何图形背景层 */
    .bg-shapes-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.15;
    }

    .floating-shape {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
        backdrop-filter: blur(2px);
        animation: floatingShapes 25s infinite ease-in-out;
    }

    .floating-shape:nth-child(1) {
        width: 200px;
        height: 200px;
        top: 10%;
        left: 10%;
        animation-delay: 0s;
        animation-duration: 20s;
    }

    .floating-shape:nth-child(2) {
        width: 150px;
        height: 150px;
        top: 60%;
        left: 80%;
        animation-delay: -5s;
        animation-duration: 25s;
    }

    .floating-shape:nth-child(3) {
        width: 300px;
        height: 300px;
        top: 40%;
        left: 60%;
        animation-delay: -10s;
        animation-duration: 30s;
        border-radius: 30%;
    }

    .floating-shape:nth-child(4) {
        width: 100px;
        height: 100px;
        top: 20%;
        left: 70%;
        animation-delay: -15s;
        animation-duration: 18s;
    }

    .floating-shape:nth-child(5) {
        width: 250px;
        height: 250px;
        top: 70%;
        left: 20%;
        animation-delay: -8s;
        animation-duration: 22s;
        border-radius: 40%;
    }

    /* 网格背景层 */
    .bg-grid-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: gridMove 30s linear infinite;
        opacity: 0.5;
    }

    /* 光效层 */
    .bg-lights-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.4;
    }

    .light-beam {
        position: absolute;
        background: radial-gradient(ellipse at center, 
            rgba(255,255,255,0.15) 0%, 
            rgba(255,255,255,0.05) 40%, 
            transparent 70%);
        border-radius: 50%;
        animation: lightPulse 8s ease-in-out infinite;
    }

    .light-beam:nth-child(1) {
        width: 400px;
        height: 400px;
        top: -200px;
        left: -200px;
        animation-delay: 0s;
    }

    .light-beam:nth-child(2) {
        width: 600px;
        height: 600px;
        bottom: -300px;
        right: -300px;
        animation-delay: -4s;
    }

    .light-beam:nth-child(3) {
        width: 500px;
        height: 500px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation-delay: -2s;
    }

    /* 动画定义 */
    @keyframes morphingGradient {
        0%, 100% { 
            background-position: 0% 0%; 
            filter: hue-rotate(0deg);
        }
        25% { 
            background-position: 100% 100%; 
            filter: hue-rotate(90deg);
        }
        50% { 
            background-position: 0% 100%; 
            filter: hue-rotate(180deg);
        }
        75% { 
            background-position: 100% 0%; 
            filter: hue-rotate(270deg);
        }
    }

    @keyframes floatingShapes {
        0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
        25% { transform: translate(30px, -30px) rotate(90deg) scale(1.1); }
        50% { transform: translate(-20px, 20px) rotate(180deg) scale(0.9); }
        75% { transform: translate(-30px, -20px) rotate(270deg) scale(1.05); }
    }

    @keyframes gridMove {
        0% { transform: translate(0, 0); }
        100% { transform: translate(50px, 50px); }
    }

    @keyframes lightPulse {
        0%, 100% { 
            transform: scale(1) rotate(0deg);
            opacity: 0.3;
        }
        50% { 
            transform: scale(1.2) rotate(180deg);
            opacity: 0.6;
        }
    }

    /* 主内容层 */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(1px);
        z-index: -1;
    }

    /* 增强版粒子系统 */
    .particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
        opacity: 0.7;
    }

    .particle {
        position: absolute;
        border-radius: 50%;
        animation: advancedFloat 25s infinite linear;
    }

    .particle::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, 
            rgba(255,255,255,0.8) 0%, 
            rgba(255,255,255,0.4) 30%, 
            rgba(255,255,255,0.1) 60%, 
            transparent 100%);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        animation: particleGlow 3s ease-in-out infinite alternate;
    }

    @keyframes advancedFloat {
        0% {
            opacity: 0;
            transform: translateY(100vh) translateX(0) scale(0) rotate(0deg);
        }
        10% {
            opacity: 0.8;
        }
        50% {
            transform: translateY(50vh) translateX(20px) scale(1) rotate(180deg);
        }
        90% {
            opacity: 0.8;
        }
        100% {
            opacity: 0;
            transform: translateY(-10vh) translateX(-20px) scale(0.5) rotate(360deg);
        }
    }

    @keyframes particleGlow {
        0% { 
            transform: translate(-50%, -50%) scale(0.8);
            filter: blur(1px);
        }
        100% { 
            transform: translate(-50%, -50%) scale(1.2);
            filter: blur(2px);
        }
    }

    /* 星星粒子特效 */
    .star-particle {
        position: absolute;
        background: white;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        animation: starTwinkle 4s ease-in-out infinite;
    }

    @keyframes starTwinkle {
        0%, 100% { 
            opacity: 0.3;
            transform: scale(0.8) rotate(0deg);
        }
        50% { 
            opacity: 1;
            transform: scale(1.2) rotate(180deg);
        }
    }

    /* Hero区域样式 */
.hero-section {
    background: transparent;
    padding: 3rem 0 4rem 0;
    text-align: center;
    position: relative;
    z-index: 20;
}

    .hero-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 2rem;
        animation: fadeInUp 0.6s ease 0.6s both;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
        animation: fadeInUp 0.8s ease 0.8s both;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.3rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 2.5rem;
        font-weight: 400;
        animation: fadeInUp 0.8s ease 1s both;
        line-height: 1.6;
    }

    .hero-cta {
        display: inline-block;
        background: rgba(255, 255, 255, 0.15);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.8s ease 1.2s both;
        position: relative;
        overflow: hidden;
    }

    .hero-cta::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .hero-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
        color: white;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .hero-cta:hover::before {
        left: 100%;
    }

    /* 主要内容区域 */
    .main-content {
        position: relative;
        z-index: 10;
    }

    /* 玻璃态卡片系统 */
    .glass-card {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xl);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
        transform: scaleX(0);
        transition: transform 0.6s ease;
    }

    .glass-card:hover::before {
        transform: scaleX(1);
    }

    .glass-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        background: rgba(255, 255, 255, 0.18);
    }

    /* 产品卡片 - 高级设计 */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        padding: 2rem;
    }

    .product-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: var(--transition);
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        opacity: 0;
        transition: opacity 0.4s ease;
        pointer-events: none;
    }

    .product-card:hover {
        transform: translateY(-12px) rotateX(5deg);
        box-shadow: 0 25px 60px rgba(102, 126, 234, 0.3);
    }

    .product-card:hover::after {
        opacity: 0.05;
    }

    .product-image {
        position: relative;
        height: 220px;
        overflow: hidden;
        background: linear-gradient(45deg, #f0f2f5, #e2e8f0);
    }

    .product-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.5) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.8s ease;
    }

    .product-card:hover .product-image::before {
        transform: translateX(100%);
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.1);
    }

    .product-content {
        padding: 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        position: relative;
        z-index: 2;
    }

    .product-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .product-description {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex: 1;
    }

    /* 高级按钮设计 */
    .btn-premium {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border: none;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        padding: 1rem 2rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .btn-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.6s ease;
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl);
        color: white;
        text-decoration: none;
    }

    .btn-premium:hover::before {
        left: 100%;
    }

    /* 浮动操作栏 - 重新设计 */
    .floating-dock {
        position: fixed;
        right: 2rem;
        bottom: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        z-index: 1000;
    }

    .dock-item {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
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
    }

    .dock-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .dock-item:hover {
        transform: scale(1.15) rotate(10deg);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .dock-item:hover::before {
        opacity: 1;
    }

    .dock-item span {
        position: relative;
        z-index: 2;
    }

    .cart-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: linear-gradient(135deg, #ff4757, #ff3742);
        color: white;
        border-radius: 12px;
        padding: 4px 8px;
        font-size: 0.75rem;
        font-weight: 700;
        min-width: 20px;
        text-align: center;
        box-shadow: var(--shadow-md);
    }

    /* 现代化页脚 */
    .modern-footer {
        background: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(20px);
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        color: white;
        padding: 3rem 0 2rem;
        margin-top: 4rem;
        position: relative;
        z-index: 100;
    }

    .footer-content {
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
    }

    .footer-brand {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #ffffff, #f0f0f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
    }

    .footer-text {
        opacity: 0.8;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .footer-links {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .footer-link {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: var(--transition);
        padding: 0.5rem 1rem;
        border-radius: var(--radius-sm);
    }

    .footer-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
        text-decoration: none;
    }

    /* 加载动画 - 精美版 */
    .premium-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        transition: opacity 0.8s ease;
    }

    .premium-loader.fade-out {
        opacity: 0;
        pointer-events: none;
    }

    .loader-content {
        text-align: center;
        color: white;
    }

    .loader-animation {
        width: 80px;
        height: 80px;
        margin: 0 auto 2rem;
        position: relative;
    }

    .loader-ring {
        width: 100%;
        height: 100%;
        border: 3px solid rgba(255, 255, 255, 0.2);
        border-top: 3px solid white;
        border-radius: 50%;
        animation: spin 1.2s linear infinite;
        position: absolute;
    }

    .loader-ring:nth-child(2) {
        width: 60px;
        height: 60px;
        top: 10px;
        left: 10px;
        animation-duration: 1.8s;
        animation-direction: reverse;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* 响应式设计 */
    @media (max-width: 768px) {
        .hero-section {
            min-height: 50vh;
            margin: -1rem -15px 2rem -15px;
        }

        .product-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .floating-dock {
            right: 1rem;
            bottom: 1rem;
            gap: 0.75rem;
        }

        .dock-item {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }

        .footer-links {
            flex-direction: column;
            gap: 1rem;
        }
    }

    @media (max-width: 480px) {
        .hero-section {
            min-height: 45vh;
        }

        /* 移动端背景优化 */
        .bg-gradient-layer {
            animation-duration: 30s; /* 减慢动画速度 */
        }

        .floating-shape {
            animation-duration: 40s; /* 减慢几何图形动画 */
        }

        .bg-lights-layer {
            opacity: 0.2; /* 降低光效强度 */
        }

        .light-beam {
            animation-duration: 12s; /* 减慢光效动画 */
        }
    }

    /* 低性能设备优化 */
    @media (max-width: 768px) and (max-resolution: 150dpi) {
        .dynamic-background {
            transform: translateZ(0); /* 强制硬件加速 */
        }

        .bg-shapes-layer,
        .bg-lights-layer {
            display: none; /* 移除复杂层 */
        }

        .bg-gradient-layer {
            animation: simpleGradient 40s ease infinite;
        }

        @keyframes simpleGradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
    }

    /* 滚动条美化 */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 10px;
        border: 2px solid transparent;
        background-clip: content-box;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
        background-clip: content-box;
    }

    /* 卡片入场动画 */
    .animate-card {
        opacity: 0;
        transform: translateY(40px) scale(0.95);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .animate-card.visible {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
</style>

<!-- 精美加载器 -->
<div class="premium-loader" id="premiumLoader">
    <div class="loader-content">
        <div class="loader-animation">
            <div class="loader-ring"></div>
            <div class="loader-ring"></div>
        </div>
        <h3 style="margin-bottom: 1rem; font-weight: 700;"><?php echo $conf['sitename']?></h3>
        <p style="opacity: 0.9;">正在为您准备精彩内容...</p>
    </div>
</div>

<!-- 粒子背景 -->
<!-- 多层动态背景系统 -->
<div class="dynamic-background">
    <!-- 主背景渐变层 -->
    <div class="bg-gradient-layer"></div>
    
    <!-- 几何图形背景层 -->
    <div class="bg-shapes-layer">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>
    
    <!-- 网格背景层 -->
    <div class="bg-grid-layer"></div>
    
    <!-- 光效层 -->
    <div class="bg-lights-layer">
        <div class="light-beam"></div>
        <div class="light-beam"></div>
        <div class="light-beam"></div>
    </div>
</div>

<!-- 增强版粒子系统 -->
<div class="particles" id="particles"></div>

    <!-- Hero区域 -->
    <div class="hero-section">
        <div class="container-fluid">
            <span class="hero-badge">✨ 欢迎来到全新版本！</span>
            <h1 class="hero-title"><?php echo $conf['sitename']?></h1>
            <p class="hero-subtitle">体验前所未有的优质服务，让每一次选择都成为美好回忆</p>
            <a href="#services" class="hero-cta">🚀 开始探索</a>
        </div>
    </div>

    <!-- 主要内容区域 -->
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto;">
        <div class="row">
            <div class="col-12">
                <div class="glass-card">
                    <div style="padding: 3rem 2rem 1rem; text-align: center;">
                        <h2 style="color: white; font-weight: 700; font-size: 2.5rem; margin-bottom: 1rem;">
                            🎯 精选服务
                        </h2>
                        <p style="color: rgba(255,255,255,0.9); font-size: 1.1rem; margin-bottom: 0;">
                            为您精心挑选的优质服务项目，每一项都经过严格筛选
                        </p>
            </div>
            
                    <!-- 公告提示 -->
               <div class="container">
                        <div class="alert alert-primary alert-dismissible" role="alert" style="display:none; margin: 1rem; border-radius: var(--radius-md); border: none; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); color: white; border: 1px solid rgba(255,255,255,0.2);">
                            <span class="alert-inner--icon">🔔</span>
                        <span class="alert-inner--text"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    </div>

                    <!-- 产品网格 -->
                    <div class="product-grid" id="services">
<?php
$classhide = explode(',',$siterow['class']);
$rs=$DB->query("select * from pre_class where active=1 order by sort asc");
while($row = $rs->fetch()){
	if($is_fenzhan && in_array($row['cid'], $classhide))continue;
	if(!empty($row["shopimg"])){
		$productimg = $row["shopimg"];
	}else{
		$productimg = 'assets/img/Product/default.png';
	}
?>
                        <div class="cid<?php echo $row['cid']?>">
                            <div class="product-card animate-card">
                                <div class="product-image">
                                    <img class="lazy" data-original="<?php echo $productimg?>" alt="<?php echo $row["name"]?>" />
                                </div>
                                <div class="product-content">
                                    <h3 class="product-title"><?php echo $row["name"]?></h3>
                                    <p class="product-description">
                                        高品质服务，专业团队保障，为您提供最优质的体验
                                    </p>
                                    <a href="./?cid=<?php echo $row["cid"]?>" class="btn-premium">
                                        <span>立即选购</span>
                                        <span>→</span>
                                    </a>
                </div>
                </div>
              </div>
                        <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>

<!-- 浮动操作栏 -->
<div class="floating-dock">
    <?php if($conf['shoppingcart']==1){?>
    <div id="alert_carts" style="display: none; position: relative;">
        <a class="dock-item" href="./?mod=cart" title="购物车">
            <span>🛒</span>
            <div class="cart-badge" id="cart_counts"></div>
        </a>
    </div>
    <?php }?>
    
    <a class="dock-item" href="#BKefu" data-toggle="modal" title="联系客服">
        <span>💬</span>
    </a>
    
    <a class="dock-item" href="#gg" data-toggle="modal" title="查看公告">
        <span>📢</span>
    </a>
    
    <div id="top" style="display: none;">
        <button class="dock-item" title="返回顶部">
            <span>↑</span>
        </button>
    </div>
</div>

<!-- 客服弹窗 - 现代化设计 -->
<div class="modal fade" id="BKefu" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); border-radius: var(--radius-lg); box-shadow: var(--shadow-xl);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                <h5 class="modal-title" style="font-weight: 700; color: var(--text-primary);">
                    💬 专属客服
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color: var(--text-primary);">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="text-center">
                    <div style="margin-bottom: 2rem;">
                        <h6 style="color: var(--text-primary); margin-bottom: 1rem;">专业售后客服QQ</h6>
                        <a target="_blank" class="btn-premium" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=qq&menu=yes" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            <img border="0" src="//wpa.qq.com/pa?p=2:<?php echo $conf['kfqq']?>:52" alt="点击这里给我发消息" style="vertical-align: middle; width: 20px; height: 20px;"/> 
                            <span><?php echo $conf['kfqq']?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(0,0,0,0.1); padding: 1.5rem 2rem;">
                <button type="button" class="btn-premium" data-dismiss="modal" style="width: 100%;">知道了</button> 
            </div>
        </div>
    </div>
</div>

<div class="shuaibi-zhezhao" id="ShuaibiZhezhao"></div>
<div class="shuaibi-zzimg" id="ShuaibiZzimg">
    <span id="ShuaibiZzclose"><i class="fa fa-times fa-3x"></i></span>
    <img src="assets/img/bookmark.png" alt="bookmark">
</div>

<!-- 现代化页脚 -->
<footer class="modern-footer">
    <div class="container">
        <div class="footer-content">
            <h5 class="footer-brand"><?php echo $conf['sitename']?></h5>
            <p class="footer-text">
                致力于为用户提供最优质的数字化服务体验，让科技改变生活
            </p>
            <div class="footer-links">
                <a href="javascript:void(0)" class="footer-link" onclick="layer.alert('电脑用户请按键盘 <kbd>Ctrl</kbd> + <kbd>D</kbd> 将本站存为书签！', {icon: 7,title: '小提示',skin: 'layui-layer-molv layui-layer-wxd'})">
                    📎 收藏本站
                </a>
        </div>
            <p style="opacity: 0.6; font-size: 0.9rem; margin: 0;">
                &copy; <?php echo date("Y")?> <?php echo $conf['sitename']?> • 版权所有
                <?php if(!empty($conf['footer'])): ?>
                <br><?php echo $conf['footer']?>
                <?php endif; ?>
            </p>
      </div>
    </div>
</footer>

<script src="<?php echo $cdnserver?>assets/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/jquery.lazyload-1.9.1.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/bootstrap-4.1.3.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/jquery.cookie-1.4.1.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/layer-2.3.js"></script>

<script type="text/javascript">
var isModal=<?php echo empty($conf['modal'])?'false':'true';?>;
var homepage=true;
var hashsalt=<?php echo $addsalt_js?>;

$(function() {
    // 创建现代化粒子系统
    function createAdvancedParticles() {
        const particlesContainer = document.getElementById('particles');
        const particleCount = 60;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            
            // 随机选择粒子类型
            const particleType = Math.random();
            
            if (particleType < 0.8) {
                // 普通发光粒子
                particle.className = 'particle';
                const size = Math.random() * 5 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
            } else {
                // 星星粒子
                particle.className = 'star-particle';
                const size = Math.random() * 8 + 4;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
            }
            
            // 随机位置和动画参数
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 25 + 's';
            particle.style.animationDuration = (Math.random() * 15 + 20) + 's';
            
            // 随机透明度
            particle.style.opacity = Math.random() * 0.6 + 0.3;
            
            particlesContainer.appendChild(particle);
        }
    }

    // 创建交互式鼠标跟随效果
    function createMouseTrail() {
        let mouseTrail = [];
        const trailLength = 10;
        
        document.addEventListener('mousemove', function(e) {
            // 添加新的鼠标位置
            mouseTrail.push({
                x: e.clientX,
                y: e.clientY,
                time: Date.now()
            });
            
            // 限制轨迹长度
            if (mouseTrail.length > trailLength) {
                mouseTrail.shift();
            }
            
            // 创建轨迹粒子
            if (Math.random() < 0.3) {
                createTrailParticle(e.clientX, e.clientY);
            }
        });
    }

    // 创建轨迹粒子
    function createTrailParticle(x, y) {
        const particle = document.createElement('div');
        particle.style.position = 'fixed';
        particle.style.left = x + 'px';
        particle.style.top = y + 'px';
        particle.style.width = '3px';
        particle.style.height = '3px';
        particle.style.background = 'rgba(255,255,255,0.6)';
        particle.style.borderRadius = '50%';
        particle.style.pointerEvents = 'none';
        particle.style.zIndex = '1000';
        particle.style.animation = 'trailFade 1s ease-out forwards';
        
        document.body.appendChild(particle);
        
        // 移除粒子
        setTimeout(() => {
            if (particle.parentNode) {
                particle.parentNode.removeChild(particle);
            }
        }, 1000);
    }

    // 添加轨迹粒子动画
    const trailStyle = document.createElement('style');
    trailStyle.textContent = `
        @keyframes trailFade {
            0% {
                opacity: 0.8;
                transform: scale(1);
            }
            100% {
                opacity: 0;
                transform: scale(0.5) translateY(-20px);
            }
        }
    `;
    document.head.appendChild(trailStyle);

    // 性能优化的设备检测
    function getDeviceCapability() {
        const width = window.innerWidth;
        const height = window.innerHeight;
        const pixelRatio = window.devicePixelRatio || 1;
        
        // 计算设备性能等级
        const performanceScore = (width * height * pixelRatio) / 1000000;
        
        return {
            isMobile: width <= 768,
            isTablet: width > 768 && width <= 1024,
            isDesktop: width > 1024,
            isHighPerformance: performanceScore > 2,
            isMediumPerformance: performanceScore > 1 && performanceScore <= 2,
            isLowPerformance: performanceScore <= 1
        };
    }

    // 根据设备性能初始化效果
    function initializeEffects() {
        const device = getDeviceCapability();
        
        if (device.isDesktop && device.isHighPerformance) {
            // 高性能桌面：全部效果
            createAdvancedParticles();
            createMouseTrail();
        } else if (device.isDesktop && device.isMediumPerformance) {
            // 中等性能桌面：减少粒子数量
            createAdvancedParticles();
        } else if (device.isTablet) {
            // 平板：简化粒子系统
            createSimpleParticles();
        }
        // 移动端：不创建粒子效果
    }

    // 简化版粒子系统
    function createSimpleParticles() {
        const particlesContainer = document.getElementById('particles');
        const particleCount = 20;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            
            const size = Math.random() * 3 + 1;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 20 + 's';
            particle.style.animationDuration = '20s';
            
            particlesContainer.appendChild(particle);
        }
    }

    // 初始化效果
    initializeEffects();

    // 页面加载动画
    setTimeout(function() {
        $('#premiumLoader').addClass('fade-out');
        setTimeout(function() {
            $('#premiumLoader').remove();
            // 显示导航栏和功能按钮
            $('.modern-navbar').css('opacity', '1');
            $('.function-buttons-area').css('opacity', '1');
            $('.navbar-vertical.bg-white').css('opacity', '1');
        }, 800);
    }, 1200);

    // 卡片入场动画
    function animateCards() {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry, index) {
                if (entry.isIntersecting) {
                    setTimeout(function() {
                        entry.target.classList.add('visible');
                    }, index * 150);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        document.querySelectorAll('.animate-card').forEach(function(card) {
            observer.observe(card);
        });
    }

    // 初始化动画
    setTimeout(animateCards, 1500);

    // 原有功能保持不变
	$("img.lazy").lazyload({effect: "fadeIn"});
    
    var gotop = $("#top");
    $(window).scroll(function () {
        if ($(window).scrollTop() > 400) {
            gotop.fadeIn(400);
    } else {
            gotop.fadeOut(400);
        }
    });

    gotop.click(function () {
        $('body,html').animate({ scrollTop: 0 }, 800);
    });

    // 购物车信息
<?php if($conf['shoppingcart']==1){?>
$.ajax({
        type: "GET",
        url: "ajax.php?act=cart_info",
        dataType: 'json',
	async: true,
        success: function(data) {
            if(data.count != null && data.count > 0){
			$('#cart_counts').html(data.count);
                $('#alert_carts').show();
		}
	}
});
<?php }?>

    // 平滑滚动
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if(target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });

    // 窗口调整时的响应式处理
    let resizeTimer;
    $(window).resize(function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            const device = getDeviceCapability();
            const particlesContainer = document.getElementById('particles');
            
            // 清空现有粒子
            particlesContainer.innerHTML = '';
            
            // 根据新的设备状态重新初始化
            if (device.isDesktop && device.isHighPerformance) {
                createAdvancedParticles();
            } else if (device.isDesktop && device.isMediumPerformance) {
                createAdvancedParticles();
            } else if (device.isTablet) {
                createSimpleParticles();
            }
        }, 250);
    });

    // 添加性能监控
    function monitorPerformance() {
        if ('requestIdleCallback' in window) {
            requestIdleCallback(function() {
                const now = performance.now();
                const memoryInfo = performance.memory;
                
                // 如果内存使用过高，降低效果复杂度
                if (memoryInfo && memoryInfo.usedJSHeapSize > memoryInfo.totalJSHeapSize * 0.8) {
                    console.log('高内存使用检测到，降低动画复杂度');
                    document.documentElement.style.setProperty('--animation-complexity', '0.5');
                }
            });
        }
    }

    // 启动性能监控
    setTimeout(monitorPerformance, 5000);
});
</script>
<script src="assets/js/main.js?ver=<?php echo VERSION ?>"></script>
<?php if($conf['classblock']==1 || $conf['classblock']==2 && checkmobile()==false)include TEMPLATE_ROOT.'default/classblock.inc.php'; ?>
</body>
</html>