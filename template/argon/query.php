<?php
if(!defined('IN_CRONLITE'))exit();
include_once TEMPLATE_ROOT.'argon/head.php';
?>

<!-- 专属订单查询页面现代化样式 -->
<style>
    /* CSS变量定义 */
    :root {
        --query-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --query-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --query-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --query-warning: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        --query-info: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
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
    .query-page-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -10;
        overflow: hidden;
    }

    /* 主背景渐变层 */
    .bg-gradient-main {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, 
            #667eea 0%, 
            #764ba2 25%, 
            #a8edea 50%, 
            #fed6e3 75%, 
            #667eea 100%);
        background-size: 600% 600%;
        animation: queryGradientFlow 18s ease infinite;
    }

    /* 网格装饰层 */
    .bg-grid-decoration {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
        background-size: 60px 60px;
        animation: gridFloat 25s linear infinite;
        opacity: 0.7;
    }

    /* 浮动元素层 */
    .bg-floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.4;
    }

    .floating-search-icon {
        position: absolute;
        color: rgba(255, 255, 255, 0.1);
        font-size: 3rem;
        animation: floatSearchIcon 20s ease-in-out infinite;
    }

    .floating-search-icon:nth-child(1) {
        top: 15%;
        left: 10%;
        animation-delay: 0s;
        animation-duration: 22s;
    }

    .floating-search-icon:nth-child(2) {
        top: 60%;
        right: 15%;
        animation-delay: -7s;
        animation-duration: 25s;
    }

    .floating-search-icon:nth-child(3) {
        bottom: 20%;
        left: 20%;
        animation-delay: -14s;
        animation-duration: 28s;
    }

    /* 动画定义 */
    @keyframes queryGradientFlow {
        0%, 100% { background-position: 0% 50%; }
        25% { background-position: 100% 50%; }
        50% { background-position: 100% 100%; }
        75% { background-position: 0% 100%; }
    }

    @keyframes gridFloat {
        0% { transform: translate(0, 0) rotate(0deg); }
        100% { transform: translate(60px, 60px) rotate(360deg); }
    }

    @keyframes floatSearchIcon {
        0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
        25% { transform: translate(15px, -15px) rotate(90deg) scale(1.1); }
        50% { transform: translate(-10px, 10px) rotate(180deg) scale(0.9); }
        75% { transform: translate(-15px, -5px) rotate(270deg) scale(1.05); }
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
    .modern-query-card {
        background: var(--card-bg);
        backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-strong);
        overflow: hidden;
        position: relative;
        animation: fadeInUp 0.8s ease 0.3s both;
    }

    .modern-query-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--query-primary);
    }

    /* 卡片头部 */
    .card-header-query {
        background: rgba(102, 126, 234, 0.05);
        border-bottom: 1px solid var(--glass-border);
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .card-header-query::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        animation: shimmer 4s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        50% { left: 100%; }
        100% { left: 100%; }
    }

    .card-title-query {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        position: relative;
        z-index: 2;
    }

    .card-subtitle-query {
        color: var(--text-secondary);
        margin-top: 0.5rem;
        font-size: 1rem;
        position: relative;
        z-index: 2;
    }

    .tips-link {
        background: var(--query-secondary);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        margin-top: 0.5rem;
        transition: var(--transition);
        position: relative;
        z-index: 2;
    }

    .tips-link:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-soft);
        color: white;
        text-decoration: none;
    }

    /* 卡片主体 */
    .card-body-query {
        padding: 2.5rem;
    }

    /* 搜索区域设计 */
    .search-section {
        animation: slideInLeft 0.6s ease 0.5s both;
        margin-bottom: 2rem;
    }

    .info-section {
        animation: slideInRight 0.6s ease 0.7s both;
    }

    /* 现代化搜索框 */
    .search-container {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        border: 2px solid transparent;
        transition: var(--transition);
        margin-bottom: 1.5rem;
    }

    .search-container:focus-within {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }

    .search-input-group {
        display: flex;
        align-items: stretch;
    }

    .search-type-selector {
        background: var(--query-primary);
        color: white;
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        min-width: 120px;
        cursor: pointer;
        transition: var(--transition);
    }

    .search-type-selector:focus {
        outline: none;
        background: var(--query-secondary);
    }

    .search-input-main {
        flex: 1;
        border: none;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        background: white;
        transition: var(--transition);
        color: var(--text-primary);
    }

    .search-input-main:focus {
        outline: none;
    }

    .search-input-main::placeholder {
        color: var(--text-secondary);
    }

    .search-help-btn {
        background: var(--query-secondary);
        border: none;
        padding: 1rem 1.5rem;
        color: white;
        cursor: pointer;
        transition: var(--transition);
        font-size: 1.1rem;
        min-width: 60px;
    }

    .search-help-btn:hover {
        background: var(--query-warning);
        transform: scale(1.05);
    }

    /* 现代化按钮 */
    .btn-query-modern {
        background: var(--query-primary);
        border: none;
        border-radius: var(--radius-lg);
        color: white;
        font-weight: 600;
        padding: 1rem 2rem;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        box-shadow: var(--shadow-soft);
        width: 100%;
    }

    .btn-query-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.6s ease;
    }

    .btn-query-modern:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-strong);
    }

    .btn-query-modern:hover::before {
        left: 100%;
    }

    /* 信息提示面板 */
    .info-panel-modern {
        background: rgba(74, 172, 254, 0.1);
        border: 1px solid rgba(74, 172, 254, 0.3);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        color: #0c5460;
        font-weight: 500;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .info-panel-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--query-info);
    }

    /* 结果展示区域 */
    .results-container {
        animation: fadeInUp 0.6s ease 0.9s both;
        margin-top: 2rem;
    }

    .results-table-container {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        border: 1px solid var(--glass-border);
    }

    .mobile-tip {
        background: var(--query-warning);
        color: #856404;
        padding: 0.75rem;
        text-align: center;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0;
    }

    .modern-table {
        margin: 0;
        width: 100%;
    }

    .modern-table thead th {
        background: var(--query-primary);
        color: white;
        font-weight: 600;
        border: none;
        padding: 1rem 0.75rem;
        text-align: center;
        font-size: 0.95rem;
    }

    .modern-table tbody td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        text-align: center;
        transition: var(--transition);
    }

    .modern-table tbody tr {
        transition: var(--transition);
    }

    .modern-table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
    }

    /* 浮动操作按钮现代化 */
    .floating-actions-query {
        position: fixed;
        right: 2rem;
        bottom: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        z-index: 1000;
    }

    .floating-btn-query {
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

    .floating-btn-query::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--query-primary);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .floating-btn-query:hover {
        transform: scale(1.15) rotate(5deg);
        box-shadow: var(--shadow-strong);
        color: white;
        text-decoration: none;
    }

    .floating-btn-query:hover::before {
        opacity: 1;
    }

    .floating-btn-query i {
        position: relative;
        z-index: 2;
    }

    /* 现代化模态框 */
    .modal-content-query {
        background: var(--card-bg);
        backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-strong);
    }

    .modal-header-query {
        border-bottom: 1px solid var(--glass-border);
        background: var(--query-primary);
        color: white;
        border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        padding: 1.5rem 2rem;
    }

    .modal-header-query .modal-title {
        font-weight: 600;
        margin: 0;
    }

    .modal-header-query .close {
        color: white;
        opacity: 0.8;
        text-shadow: none;
    }

    .modal-body-query {
        padding: 2rem;
    }

    .modal-footer-query {
        border-top: 1px solid var(--glass-border);
        padding: 1.5rem 2rem;
    }

    /* 帮助文档样式 */
    .help-details {
        margin-bottom: 1rem;
    }

    .help-details summary {
        background: rgba(102, 126, 234, 0.1);
        padding: 1rem;
        border-radius: var(--radius-lg);
        cursor: pointer;
        font-weight: 600;
        color: var(--text-primary);
        transition: var(--transition);
    }

    .help-details summary:hover {
        background: rgba(102, 126, 234, 0.2);
        transform: translateX(5px);
    }

    .help-details p {
        padding: 1rem;
        margin: 0;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        color: var(--text-secondary);
    }

    /* 响应式设计 */
    @media (max-width: 768px) {
        .card-body-query {
            padding: 2rem 1.5rem;
        }
        
        .floating-actions-query {
            right: 1rem;
            bottom: 1rem;
        }
        
        .floating-btn-query {
            width: 56px;
            height: 56px;
            font-size: 1.3rem;
        }
        
        .card-title-query {
            font-size: 1.5rem;
        }
        
        .search-type-selector {
            min-width: 100px;
            font-size: 0.9rem;
        }
        
        .tips-link {
            font-size: 0.9rem;
            padding: 0.4rem 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .search-input-group {
            flex-direction: column;
        }
        
        .search-type-selector {
            min-width: 100%;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }
        
        .search-input-main {
            border-radius: 0;
        }
        
        .search-help-btn {
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        }
    }

    /* 加载动画样式 */
    .loading-container {
        text-align: center;
        padding: 30px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
    }

    .loading-spinner {
        display: inline-block;
        width: 50px;
        height: 50px;
        border: 3px solid rgba(0, 123, 255, 0.1);
        border-radius: 50%;
        border-top-color: #007bff;
        animation: spin 1s ease-in-out infinite;
        margin-bottom: 15px;
    }

    .loading-text {
        color: #333;
        font-size: 16px;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loading-dots {
        display: inline-block;
        margin-left: 5px;
    }

    .loading-dots::after {
        content: '...';
        animation: dots 1.5s steps(4, end) infinite;
        display: inline-block;
        width: 20px;
        text-align: left;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @keyframes dots {
        0%, 20% { content: '.'; }
        40% { content: '..'; }
        60% { content: '...'; }
        80%, 100% { content: ''; }
    }

    /* 进度状态样式 */
    .progress-status {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 14px;
        font-weight: 500;
        margin-top: 10px;
    }

    .status-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .status-loading {
        background-color: #e2e6ea;
        color: #383d41;
        border: 1px solid #d6d8db;
    }
</style>

<!-- 多层动态背景系统 -->
<div class="query-page-background">
    <!-- 主背景渐变层 -->
    <div class="bg-gradient-main"></div>
    
    <!-- 网格装饰层 -->
    <div class="bg-grid-decoration"></div>
    
    <!-- 浮动元素层 -->
    <div class="bg-floating-elements">
        <i class="fa fa-search floating-search-icon"></i>
        <i class="fa fa-search floating-search-icon"></i>
        <i class="fa fa-search floating-search-icon"></i>
    </div>
</div>

<div class="main-content">
    <div class="container-fluid mt--7">
      <div class="row" style="max-width:1200px;margin:0 auto;">
        <div class="col text-center">
          <div class="modern-query-card">
            <div class="card-header-query">
              <h2 class="text-center mb-0">
                <i class="fa fa-search"></i> 在线查单
              </h2>
              <p class="text-center text-muted mt-2 mb-0">
                快速查询您的订单状态和详细信息
              </p>
            </div>
            <div class="card-body-query">
               <div class="container">
                <div class="row">
                  <div class="col-lg-4 col-12">
                      <div class="info-section">
                        <div class="info-panel-modern">
                            📢 <?php echo $conf['gg_search']?>
                            <p></p>
                        </div>
	                  </div>
                  </div>
                  <div class="col-lg-8 col-12">
                        <div class="search-section">
                            <div class="search-container">
                                <div class="search-input-group">
                                    <select class="search-type-selector" id="searchtype">
                                        <option value="0">📱 下单账号</option>
                                        <option value="1">🎫 订单号</option>
                                    </select>
                                    <input type="text" name="qq" id="qq3" value="" class="search-input-main" placeholder="请输入要查询的内容（留空则显示最新订单）" onkeydown="if(event.keyCode==13){submit_query.click()}" required/>
                                    <button href="#querydoc" class="search-help-btn" data-toggle="modal">
                                        <i class="fa fa-question-circle"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <button type="submit" id="submit_query" class="btn-query-modern">
                                <i class="fa fa-search"></i> 立即查询
                            </button>
                        </div>
                        
                        <div id="result2" class="results-container" style="display:none;">
                            <div class="results-table-container">
                                <div class="mobile-tip d-md-none">
                                    <i class="fa fa-hand-o-right"></i> 下方表单可以左右滑动查看
                                </div>
                                <div class="table-responsive">
                                    <table class="modern-table">
                                    <thead><tr><th>下单账号</th><th>商品名称</th><th>数量</th><th>购买时间</th><th>状态</th><th>操作</th></tr></thead>
                                    <tbody id="list">
                                    </tbody>
                                    </table>
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
    </div>
</div>

<!-- 现代化浮动操作栏 -->
<div class="floating-actions-query">
    <a class="floating-btn-query" href="#BKefu" data-toggle="modal" title="联系客服">
        <i class="fa fa-qq"></i>
    </a>
    
    <a class="floating-btn-query" href="#gg" data-toggle="modal" title="查看公告">
        <i class="fa fa-bell"></i>
    </a>
</div>

<!-- 现代化帮助模态框 -->
<div class="modal fade" id="querydoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-query">
            <div class="modal-header-query">
                <h5 class="modal-title" id="exampleModalLabel">
                    🤔 怎么查询订单？
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body-query">
                <div style="background: rgba(255, 193, 7, 0.1); padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border-left: 4px solid #ffc107;">
                    <strong>🚨 重要提示：</strong>请在输入框内输入您下单时，在第一个输入框内填写的信息
                </div>
                
                <div class="bd-example">
                    <details class="help-details">
                        <summary>📱 业务查单教程</summary>
                        <p>输入下单时填写的手机号/学号即可查询订单！</p>
                    </details>
                    <details class="help-details">
                        <summary>📧 邮箱类业务查单教程</summary>
                        <p>例如您购买的是邮箱类商品，需要输入您的邮箱号，需要填写完整的邮箱账号！</p>
                    </details>
                    <details class="help-details">
                        <summary>🎫 其他业务查单教程</summary>
                        <p>输入订单号即可查询！</p>
                    </details>
                </div>
                
                <div style="background: rgba(220, 53, 69, 0.1); padding: 1rem; border-radius: 12px; margin-top: 1.5rem; border-left: 4px solid #dc3545;">
                    <strong>💡 温馨提示：</strong>如果您不知道下单账号是什么，可以不填写，直接点击查询，则会根据浏览器缓存查询
                </div>
            </div>
            <div class="modal-footer-query">
                <button type="button" class="btn-query-modern" data-dismiss="modal" style="width: 100%;">
                    <i class="fa fa-check"></i> 我知道了
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="BKefu" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-query">
            <div class="modal-header-query">
                <h5 class="modal-title">
                    💬 专属客服服务
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body-query text-center">
                <i class="fa fa-comment-dots fa-3x mb-3" style="color: #667eea;"></i>
                <h6 style="margin-bottom: 1rem; color: var(--text-primary);">订单售后客服QQ</h6>
                <a target="_blank" class="btn-query-modern" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=qq&menu=yes" style="display: inline-flex; align-items: center; gap: 0.5rem; width: auto;">
                    <img border="0" src="//wpa.qq.com/pa?p=2:<?php echo $conf['kfqq']?>:52" alt="点击这里给我发消息" style="width: 20px; height: 20px;"/> 
                    <?php echo $conf['kfqq']?>
                </a>
            </div>
            <div class="modal-footer-query">
                <button type="button" class="btn-query-modern" data-dismiss="modal" style="width: 100%;">知道了</button> 
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
var querymode=1;
var isModal=false;
var homepage=false;
var hashsalt=<?php echo $addsalt_js?>;

$(function() {
    // 增强搜索交互
    $('#qq3').on('input', function() {
        var value = $(this).val();
        if (value.length > 0) {
            $(this).closest('.search-container').addClass('has-content');
        } else {
            $(this).closest('.search-container').removeClass('has-content');
        }
    });

    // 增强查询按钮点击效果
    $('#submit_query').click(function() {
        var btn = $(this);
        var originalText = btn.html();
        
        btn.html('<i class="fa fa-spinner fa-spin"></i> 查询中...');
        btn.prop('disabled', true);
        
        // 模拟查询完成后恢复按钮状态
        setTimeout(function() {
            btn.html(originalText);
            btn.prop('disabled', false);
        }, 2000);
    });

    // 结果表格行hover效果增强
    $(document).on('mouseenter', '.modern-table tbody tr', function() {
        $(this).find('td').css('background', 'rgba(102, 126, 234, 0.05)');
    }).on('mouseleave', '.modern-table tbody tr', function() {
        $(this).find('td').css('background', '');
    });

    // 搜索类型切换时的视觉反馈
    $('#searchtype').change(function() {
        var value = $(this).val();
        var placeholder = value == '0' ? 
            '请输入您的下单账号（手机号/邮箱等）' : 
            '请输入您的订单号';
        $('#qq3').attr('placeholder', placeholder);
        
        // 添加切换动画
        $('.search-container').addClass('switching');
        setTimeout(function() {
            $('.search-container').removeClass('switching');
        }, 300);
    });

    // 完全重构的订单详情弹窗函数
    if (typeof window.showOrder !== 'undefined') {
        const originalShowOrder = window.showOrder;
        window.showOrder = function(id, skey) {
            var ii = layer.load(2, {shade:[0.1,'#fff']});
            $.ajax({
                type: "POST",
                url: "ajax.php?act=order",
                data: {id: id, skey: skey},
                dataType: 'json',
                success: function(data) {
                    layer.close(ii);
                    if (data.code == 0) {
                        // 状态映射
                        const statusMap = {
                            0: {text: '已提交', class: 'status-pending'},
                            1: {text: '已完成', class: 'status-completed'},
                            2: {text: '处理中', class: 'status-processing'},
                            3: {text: '异常', class: 'status-error'},
                            4: {text: '已退款', class: 'status-refunded'},
                            20: {text: '待考试', class: 'status-exam'},
                            21: {text: '平时分', class: 'status-score'}
                        };
                        
                        const status = statusMap[data.status] || {text: '未知', class: 'status-error'};
                        
                        // 构建现代化HTML结构
                        let content = `
                            <div class="modern-order-container">
                                <div class="order-section">
                                    <div class="section-title">📋 订单基本信息</div>
                                    <div class="order-row">
                                        <span class="order-label">🆔 订单编号</span>
                                        <span class="order-value">${id}</span>
                                    </div>
                                    <div class="order-row">
                                        <span class="order-label">🛍️ 商品名称</span>
                                        <span class="order-value">${data.name}</span>
                                    </div>
                                    <div class="order-row">
                                        <span class="order-label">💰 订单金额</span>
                                        <span class="order-value">${data.money}元</span>
                                    </div>
                                    <div class="order-row">
                                        <span class="order-label">🕐 购买时间</span>
                                        <span class="order-value">${data.date}</span>
                                    </div>
                                    <div class="order-row">
                                        <span class="order-label">📝 下单信息</span>
                                        <span class="order-value">${data.inputs}</span>
                                    </div>
                                    <div class="order-row">
                                        <span class="order-label">📊 订单状态</span>
                                        <span class="order-value">
                                            <span class="status-badge ${status.class}">${status.text}</span>
                                        </span>
                                    </div>
                                </div>
                        `;
                        
                        // 实时状态信息
                        if (data.list && typeof data.list === "object") {
                            content += `
                                <div class="order-section">
                                    <div class="section-title">📈 订单实时状态</div>
                            `;
                            
                            if (typeof data.list.order_state !== "undefined" && data.list.order_state && typeof data.list.now_num !== "undefined") {
                                content += `
                                    <div class="order-row">
                                        <span class="order-label">📦 下单数量</span>
                                        <span class="order-value">${data.list.num}</span>
                                    </div>
                                    <div class="order-row">
                                        <span class="order-label">🎯 初始数量</span>
                                        <span class="order-value">${data.list.start_num}</span>
                                    </div>
                                    <div class="order-row">
                                        <span class="order-label">📊 当前数量</span>
                                        <span class="order-value">${data.list.now_num}</span>
                                    </div>
                                    <div class="order-row">
                                        <span class="order-label">⚡ 订单状态</span>
                                        <span class="order-value" style="color: #4299e1; font-weight: 600;">${data.list.order_state}</span>
                                    </div>
                                    <div class="order-row">
                                        <span class="order-label">🕒 下单时间</span>
                                        <span class="order-value">${data.list.add_time}</span>
                                    </div>
                                `;
                                
                                if (typeof data.list.result !== "undefined" && data.list.result) {
                                    content += `
                                        <div class="order-row">
                                            <span class="order-label">⚠️ 异常信息</span>
                                            <span class="order-value" style="color: #f56565;">${data.list.result}</span>
                                        </div>
                                    `;
                                }
                            } else {
                                Object.keys(data.list).forEach(function(key) {
                                    content += `
                                        <div class="order-row">
                                            <span class="order-label">${key}</span>
                                            <span class="order-value">${data.list[key]}</span>
                                        </div>
                                    `;
                                });
                            }
                            content += `</div>`;
                        }
                        
                        // 卡密信息
                        if (data.kminfo) {
                            content += `
                                <div class="order-section">
                                    <div class="section-title">🔐 卡密信息</div>
                                    <div class="special-content">${data.kminfo}</div>
                                </div>
                            `;
                        }
                        
                        // 处理结果
                        if (data.result) {
                            content += `
                                <div class="order-section">
                                    <div class="section-title">✅ 处理结果</div>
                                    <div class="special-content">${data.result}</div>
                                </div>
                            `;
                        }
                        
                        // 商品简介
                        if (data.desc) {
                            content += `
                                <div class="order-section">
                                    <div class="section-title">📄 商品简介</div>
                                    <div class="special-content">${data.desc}</div>
                                </div>
                            `;
                        }
                        
                        // 操作按钮
                        if (data.complain) {
                            content += `
                                <div class="order-section">
                                    <div class="section-title">⚙️ 订单操作</div>
                                    <div class="order-actions">
                                        <a href="./user/workorder.php?my=add&orderid=${id}&skey=${skey}" 
                                           target="_blank" 
                                           onclick="return checklogin(${data.islogin})" 
                                           class="modern-btn btn-primary">📞 投诉订单</a>
                            `;
                            
                                                         if (data.selfrefund == 1 && data.islogin == 1 && (data.status == 0 || data.status == 3)) {
                                 content += `
                                     <a onclick="return modernApplyRefund(${id},'${skey}')" 
                                        class="modern-btn btn-danger">💸 申请退款</a>
                                 `;
                             }
                            
                            content += `
                                    </div>
                                </div>
                            `;
                        }
                        
                        content += `</div>`;
                        
                        // 显示弹窗
                        var area = [$(window).width() > 600 ? '600px' : '95%', 'auto'];
                        layer.open({
                            type: 1,
                            area: area,
                            title: '📋 订单详细信息',
                            skin: 'layui-layer-rim',
                            zIndex: 2001,
                            resize: false,
                            maxHeight: $(window).height() * 0.9,
                            content: content,
                            success: function(layero) {
                                // 添加入场动画
                                layero.css({
                                    'transform': 'scale(0.8) translateY(-50px)',
                                    'opacity': '0'
                                }).animate({
                                    'transform': 'scale(1) translateY(0)',
                                    'opacity': '1'
                                }, 400);
                                
                                // 为各个section添加渐入动画
                                setTimeout(function() {
                                    $('.order-section').each(function(index) {
                                        $(this).css({
                                            'opacity': '0',
                                            'transform': 'translateY(20px)'
                                        }).delay(index * 100).animate({
                                            'opacity': '1',
                                            'transform': 'translateY(0)'
                                        }, 300);
                                    });
                                }, 200);
                            }
                        });
                    } else {
                        layer.alert(data.msg, {
                            icon: 2,
                            title: '❌ 查询失败',
                            skin: 'layui-layer-rim'
                        });
                    }
                },
                error: function() {
                    layer.close(ii);
                    layer.alert('网络请求失败，请稍后重试', {
                        icon: 2,
                        title: '❌ 网络错误',
                        skin: 'layui-layer-rim'
                    });
                }
                         });
         };
     }

    // 现代化退款确认函数
    window.modernApplyRefund = function(id, skey) {
        // 使用现代化的确认弹窗
        layer.confirm('🔔 异常状态订单可以申请退款<br><br>💰 退款之后资金会退到用户余额<br><br>❓ 是否确认退款？', {
            icon: 3,
            title: '💸 申请退款确认',
            skin: 'layui-layer-dialog',
            btn: ['✅ 确认退款', '❌ 取消'],
            btn1: function(index) {
                var ii = layer.load(2, {
                    shade: [0.3, '#000'],
                    content: '<div style="color:#667eea;font-size:14px;text-align:center;padding:10px;">正在处理退款申请...</div>'
                });
                
                $.ajax({
                    type: "POST",
                    url: "ajax.php?act=apply_refund",
                    data: {id: id, skey: skey},
                    dataType: 'json',
                    success: function(data) {
                        layer.close(ii);
                        if (data.code == 0) {
                            layer.alert('🎉 成功退款 ' + data.money + ' 元到余额！', {
                                icon: 1,
                                title: '✅ 退款成功',
                                skin: 'layui-layer-dialog',
                                btn: ['知道了'],
                                yes: function() {
                                    window.location.reload();
                                }
                            });
                        } else {
                            layer.alert('❌ ' + data.msg, {
                                icon: 2,
                                title: '退款失败',
                                skin: 'layui-layer-dialog'
                            });
                        }
                    },
                    error: function() {
                        layer.close(ii);
                        layer.alert('❌ 网络请求失败，请稍后重试', {
                            icon: 2,
                            title: '网络错误',
                            skin: 'layui-layer-dialog'
                        });
                    }
                });
            },
            btn2: function(index) {
                layer.close(index);
            }
        });
        return false;
    };
});

// 进度查询功能
function checkProgress(account) {
    // 创建加载中的弹窗
    var loadingLayer = layer.open({
        type: 1,
        title: '正在获取进度信息',
        area: ['300px', '250px'],
        closeBtn: 0,
        shadeClose: false,
        content: `
            <div class="loading-container">
                <div class="loading-spinner"></div>
                <div class="loading-text">
                    正在获取进度信息<span class="loading-dots"></span>
                </div>
                <div class="progress-status status-loading">
                    <i class="fa fa-sync fa-spin"></i> 正在连接服务器...
                </div>
            </div>
        `
    });
    
    $.ajax({
        url: 'https://cd.tomtom.buzz/ajax.php?act=get',
        type: 'POST',
        data: {
            account: account
        },
        dataType: 'json',
        success: function(res) {
            setTimeout(function() { // 添加小延迟使动画更流畅
                layer.close(loadingLayer);
                
                if(res.code === 0) {
                    // 构建进度信息HTML
                    var progressHtml = `
                        <div style="padding: 20px;">
                            <div class="progress-item">
                                <strong><i class="fa fa-book"></i> 课程名称：</strong>
                                <span>${res.kcname || '未知'}</span>
                            </div>
                            <div class="progress-item">
                                <strong><i class="fa fa-info-circle"></i> 课程状态：</strong>
                                <span>${res.status || '未知'}</span>
                            </div>
                            <div class="progress-item">
                                <strong><i class="fa fa-tasks"></i> 详情进度：</strong>
                                <span>${res.remarks || '暂无进度信息'}</span>
                            </div>
                            <div class="progress-item">
                                <strong><i class="fa fa-clock"></i> 开始时间：</strong>
                                <span>${res.addtime || '未知'}</span>
                            </div>
                            <div class="progress-status status-success">
                                <i class="fa fa-check-circle"></i> 获取成功
                            </div>
                        </div>
                        <style>
                            .progress-item {
                                margin-bottom: 15px;
                                padding: 10px;
                                background: #f8f9fa;
                                border-radius: 8px;
                                transition: all 0.3s ease;
                            }
                            .progress-item:hover {
                                background: #e9ecef;
                                transform: translateX(5px);
                            }
                            .progress-item strong {
                                display: block;
                                margin-bottom: 5px;
                                color: #495057;
                            }
                            .progress-item span {
                                color: #212529;
                            }
                            .progress-item i {
                                margin-right: 5px;
                                color: #007bff;
                            }
                        </style>`;
                    
                    // 显示进度信息
                    layer.open({
                        type: 1,
                        title: '订单进度详情',
                        area: ['350px', 'auto'],
                        content: progressHtml,
                        shadeClose: true
                    });
                } else {
                    layer.open({
                        type: 1,
                        title: '获取进度失败',
                        area: ['300px', '200px'],
                        content: `
                            <div class="loading-container">
                                <i class="fa fa-times-circle" style="font-size: 40px; color: #dc3545;"></i>
                                <div style="margin: 15px 0; color: #721c24;">
                                    ${res.msg || '获取进度信息失败'}
                                </div>
                                <div class="progress-status status-error">
                                    <i class="fa fa-exclamation-circle"></i> 获取失败
                                </div>
                            </div>
                        `
                    });
                }
            }, 800); // 800ms的加载动画展示时间
        },
        error: function() {
            setTimeout(function() {
                layer.close(loadingLayer);
                layer.open({
                    type: 1,
                    title: '网络错误',
                    area: ['300px', '200px'],
                    content: `
                        <div class="loading-container">
                            <i class="fa fa-wifi" style="font-size: 40px; color: #dc3545;"></i>
                            <div style="margin: 15px 0; color: #721c24;">
                                网络连接失败，请稍后重试
                            </div>
                            <div class="progress-status status-error">
                                <i class="fa fa-exclamation-circle"></i> 网络错误
                            </div>
                        </div>
                    `
                });
            }, 800);
        }
    });
}

// 为进度按钮添加点击事件
$(document).ready(function() {
    $(document).on('click', 'a:contains("进度")', function(e) {
        e.preventDefault();
        var row = $(this).closest('tr');
        var account = row.find('td:eq(0)').text(); // 假设第一列是账号
        if(account) {
            checkProgress(account.trim());
        } else {
            layer.msg('获取账号信息失败', {icon: 2});
        }
    });
});
</script>

<style>
/* 额外的交互增强样式 */
.search-container.has-content {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-container.switching {
    transform: scale(0.98);
    opacity: 0.8;
}

.btn-query-modern:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none !important;
}

.btn-query-modern:disabled:hover {
    transform: none !important;
}

/* 结果显示动画 */
#result2 {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.4s ease;
}

#result2.show {
    opacity: 1;
    transform: translateY(0);
}

/* 全新订单详情弹窗设计 */
.layui-layer-rim {
    border-radius: 20px !important;
    overflow: hidden !important;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25) !important;
    border: none !important;
    max-width: 600px !important;
}

.layui-layer-title {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    font-weight: 700 !important;
    padding: 24px 30px !important;
    border: none !important;
    font-size: 18px !important;
    position: relative !important;
    text-align: center !important;
}

.layui-layer-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.layui-layer-content {
    background: #ffffff !important;
    padding: 0 !important;
    position: relative !important;
    max-height: 70vh !important;
    overflow-y: auto !important;
}

/* 重构订单信息展示 */
.modern-order-container {
    padding: 30px;
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
}

.order-section {
    margin-bottom: 25px;
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.section-title {
    font-size: 16px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #667eea;
    position: relative;
}

.section-title::before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 30px;
    height: 2px;
    background: #764ba2;
}

.order-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
}

.order-row:last-child {
    border-bottom: none;
}

.order-label {
    font-weight: 600;
    color: #4a5568;
    min-width: 100px;
    font-size: 14px;
}

.order-value {
    color: #2d3748;
    font-size: 14px;
    text-align: right;
    flex: 1;
    margin-left: 20px;
    word-break: break-all;
}

.status-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.status-pending {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.status-completed {
    background: linear-gradient(135deg, #48bb78, #38a169);
    color: white;
}

.status-processing {
    background: linear-gradient(135deg, #ed8936, #dd6b20);
    color: white;
}

.status-error {
    background: linear-gradient(135deg, #f56565, #e53e3e);
    color: white;
}

.status-refunded {
    background: linear-gradient(135deg, #a0aec0, #718096);
    color: white;
}

.status-exam {
    background: linear-gradient(135deg, #4299e1, #3182ce);
    color: white;
}

.status-score {
    background: linear-gradient(135deg, #8B4513, #654321);
    color: white;
}

.order-actions {
    margin-top: 20px;
    display: flex;
    gap: 12px;
    justify-content: center;
}

.modern-btn {
    padding: 10px 20px;
    border-radius: 25px;
    border: none;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    min-width: 100px;
}

.btn-primary {
    background: linear-gradient(135deg, #4299e1, #3182ce);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #f56565, #e53e3e);
    color: white;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    color: white;
    text-decoration: none;
}

.special-content {
    background: linear-gradient(135deg, #f7fafc, #edf2f7);
    padding: 20px;
    border-radius: 12px;
    border-left: 4px solid #667eea;
    font-family: 'Courier New', monospace;
    font-size: 13px;
    line-height: 1.6;
    color: #2d3748;
    margin-top: 15px;
    white-space: pre-wrap;
    word-break: break-all;
}

/* 关闭按钮重设计 */
.layui-layer-close {
    background: rgba(255, 255, 255, 0.9) !important;
    color: #667eea !important;
    border-radius: 50% !important;
    width: 40px !important;
    height: 40px !important;
    line-height: 40px !important;
    text-align: center !important;
    right: 15px !important;
    top: 15px !important;
    transition: all 0.3s ease !important;
    font-weight: 700 !important;
    font-size: 20px !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
    z-index: 99999 !important;
    cursor: pointer !important;
    display: block !important;
    position: absolute !important;
}

.layui-layer-close::before {
    content: '×' !important;
    display: block !important;
    width: 100% !important;
    height: 100% !important;
    line-height: 40px !important;
}

.layui-layer-close:hover {
    background: white !important;
    transform: scale(1.1) rotate(90deg) !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
    color: #f56565 !important;
}

/* 修复LayUI弹窗确认框样式 */
.layui-layer-dialog {
    border-radius: 16px !important;
    overflow: hidden !important;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
}

.layui-layer-dialog .layui-layer-title {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    font-weight: 600 !important;
    padding: 20px 25px !important;
    border: none !important;
    font-size: 16px !important;
    text-align: center !important;
}

.layui-layer-dialog .layui-layer-content {
    background: white !important;
    padding: 25px 30px !important;
    font-size: 15px !important;
    line-height: 1.6 !important;
    color: #2d3748 !important;
    text-align: center !important;
}

.layui-layer-dialog .layui-layer-btn {
    background: #f8f9fa !important;
    border-top: 1px solid #e9ecef !important;
    padding: 15px 20px !important;
    text-align: center !important;
}

.layui-layer-dialog .layui-layer-btn a {
    background: linear-gradient(135deg, #667eea, #764ba2) !important;
    color: white !important;
    border: none !important;
    border-radius: 20px !important;
    padding: 10px 25px !important;
    margin: 0 8px !important;
    font-weight: 600 !important;
    font-size: 14px !important;
    transition: all 0.3s ease !important;
    text-decoration: none !important;
    display: inline-block !important;
    min-width: 80px !important;
}

.layui-layer-dialog .layui-layer-btn a:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3) !important;
}

.layui-layer-dialog .layui-layer-btn1 {
    background: linear-gradient(135deg, #f56565, #e53e3e) !important;
}

.layui-layer-dialog .layui-layer-btn1:hover {
    box-shadow: 0 8px 25px rgba(245, 101, 101, 0.3) !important;
}

.layui-layer-dialog .layui-layer-btn0 {
    background: linear-gradient(135deg, #48bb78, #38a169) !important;
}

.layui-layer-dialog .layui-layer-btn0:hover {
    box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3) !important;
}

/* Alert弹窗样式 */
.layui-layer-msg {
    border-radius: 12px !important;
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(20px) !important;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
}

.layui-layer-msg .layui-layer-content {
    padding: 15px 25px !important;
    font-size: 14px !important;
    color: #2d3748 !important;
    font-weight: 500 !important;
}

/* 响应式设计 */
@media (max-width: 768px) {
    .modern-order-container {
        padding: 20px;
    }
    
    .order-section {
        padding: 15px;
    }
    
    .order-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .order-value {
        text-align: left;
        margin-left: 0;
    }
    
    .order-actions {
        flex-direction: column;
    }
    
    .modern-btn {
        width: 100%;
    }
}
</style>

<script src="assets/js/main.js?ver=<?php echo VERSION ?>"></script>
</body>
</html>