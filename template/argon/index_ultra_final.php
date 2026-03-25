<?php
if(!defined('IN_CRONLITE'))exit();
if($_GET['buyok']==1){include_once TEMPLATE_ROOT.'argon/query.php';exit;}
if(isset($_GET['cid'])){include_once TEMPLATE_ROOT.'argon/buy.php';exit;}

include_once TEMPLATE_ROOT.'argon/head.php';
?>

<!-- 超现代化样式 -->
<style>
    /* 动态背景 */
    body {
        position: relative;
        overflow-x: hidden;
    }
    
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(-45deg, #f5f7fa, #c3cfe2, #e0c3fc, #9bb5ff);
        background-size: 400% 400%;
        animation: gradientShift 30s ease infinite;
        z-index: -1;
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* 自定义光标 */
    body {
        cursor: none;
    }
    
    .custom-cursor {
        position: fixed;
        width: 20px;
        height: 20px;
        background: radial-gradient(circle, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        pointer-events: none;
        z-index: 9999;
        transform: translate(-50%, -50%);
        transition: all 0.1s ease;
        box-shadow: 0 0 20px rgba(102, 126, 234, 0.4);
    }
    
    .custom-cursor.hover {
        width: 40px;
        height: 40px;
        background: radial-gradient(circle, #f093fb 0%, #f5576c 100%);
        box-shadow: 0 0 30px rgba(240, 147, 251, 0.6);
    }
    
    /* 美化卡片 */
    .card {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 20px !important;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
        background-size: 200% 100%;
        animation: shimmer 3s linear infinite;
    }
    
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
    }
    
    .card img {
        transition: all 0.3s ease;
    }
    
    .card:hover img {
        transform: scale(1.05);
    }
    
    /* 美化按钮 */
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border: none !important;
        border-radius: 50px !important;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-primary:hover::before {
        left: 100%;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3) !important;
    }
    
    /* 浮动装饰 */
    .floating-decoration {
        position: fixed;
        border-radius: 50%;
        opacity: 0.1;
        pointer-events: none;
        z-index: 1;
    }
    
    .floating-decoration:nth-child(1) {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, #667eea, #764ba2);
        top: 20%;
        left: 10%;
        animation: float 6s ease-in-out infinite;
    }
    
    .floating-decoration:nth-child(2) {
        width: 120px;
        height: 120px;
        background: linear-gradient(45deg, #f093fb, #f5576c);
        top: 60%;
        right: 10%;
        animation: float 8s ease-in-out infinite reverse;
    }
    
    .floating-decoration:nth-child(3) {
        width: 60px;
        height: 60px;
        background: linear-gradient(45deg, #4facfe, #00f2fe);
        bottom: 20%;
        left: 20%;
        animation: float 7s ease-in-out infinite;
    }
    
    .floating-decoration:nth-child(4) {
        width: 100px;
        height: 100px;
        background: linear-gradient(45deg, #43e97b, #38f9d7);
        top: 30%;
        right: 30%;
        animation: float 9s ease-in-out infinite reverse;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
    
    /* 美化浮动按钮 */
    .wxd-b-but {
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.2) !important;
        transition: all 0.3s ease;
    }
    
    .wxd-b-but:hover {
        transform: translateY(-3px) scale(1.1);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2) !important;
    }
    
    /* 头部标题美化 */
    .card-header h3 {
        background: linear-gradient(135deg, #2d3748, #667eea);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
        font-size: 2rem;
    }
    
    /* 页面加载动画 */
    .page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 1;
        transition: opacity 0.5s ease;
    }
    
    .page-loader.hidden {
        opacity: 0;
        pointer-events: none;
    }
    
    .loader-content {
        text-align: center;
        color: white;
    }
    
    .loader-spinner {
        width: 50px;
        height: 50px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top: 3px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* 响应式设计 */
    @media (max-width: 768px) {
        body {
            cursor: auto;
        }
        
        .custom-cursor {
            display: none;
        }
        
        .floating-decoration {
            display: none;
        }
    }
</style>

<!-- 页面加载器 -->
<div class="page-loader" id="pageLoader">
    <div class="loader-content">
        <div class="loader-spinner"></div>
        <h4><?php echo $conf['sitename']?></h4>
        <p>正在加载精彩内容...</p>
    </div>
</div>

<!-- 自定义光标 -->
<div class="custom-cursor" id="customCursor"></div>

<!-- 浮动装饰元素 -->
<div class="floating-decoration"></div>
<div class="floating-decoration"></div>
<div class="floating-decoration"></div>
<div class="floating-decoration"></div>

<div class="container-fluid mt--7">
  <div class="row" style="max-width:1200px;margin:0 auto;">
    <div class="col text-center">
      <div class="card shadow">
        <div class="card-header bg-transparent">
          <h3 class="mb-0">🚀 <?php echo $conf['sitename']?> 超现代版</h3>
        </div>
        
        <div class="card-body px-0 py-1">
           <div class="container">
                <div class="alert alert-primary alert-dismissible" role="alert"  style="display:none;">
                    <span class="alert-inner--icon"><i class="fa fa-bell"></i></span>
                    <span class="alert-inner--text"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="row">
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
    <div class="col-lg-4 col-md-6 col-6 my-2 px-1 cid<?php echo $row['cid']?>">
        <div class="card">   
            <a href="./?cid=<?php echo $row["cid"]?>" title="<?php echo $row["name"]?>">
                <img class="card-img-top lazy" data-original="<?php echo $productimg?>" />
                <div class="card-body p-2">
                    <span class='btn btn-primary btn-block p-2'><?php echo $row["name"]?></span>
                </div>
            </a>
        </div>
    </div>
<?php
}
?>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="position-fixed wxd-b-menu">
<div class="mt-3 d-none" id="alert_carts">
    <a class="btn btn-info wxd-b-but" href="./?mod=cart" title="购物车列表">
        <i class="fa fa-shopping-cart fa-2x"></i>
    </a><div class="nav-counter nav-counter-big" id="cart_counts"></div>
</div>
<div class="mt-3 d-none d-md-block">
    <a class="btn btn-success wxd-b-but" href="#BKefu" data-toggle="modal">
        <i class="fa fa-qq fa-2x"></i>
    </a>
</div>
<div class="mt-3 d-none d-md-block">
    <a class="btn btn-primary wxd-b-but" href="#gg" data-toggle="modal">
        <i class="fa fa-bell fa-2x"></i>
    </a>
</div>
<div class="mt-3" id="top" style="display: none;">
    <button class="btn btn-info wxd-b-but" style="padding:1rem 1.3rem;">
        <i class="fa fa-angle-up fa-2x"></i>
    </button>
</div>
</div>

<div class="modal fade" id="BKefu" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-" role="document">
    <div class="modal-content">
        <div class="modal-body">
        <div class="py-1 text-center">
            <i class="fa fa-comment-dots fa-3x mb-3"></i>
            <div class="row">
                <div class="col-12 mb-3">
                    <h6 class="">订单售后客服ＱＱ</h6>
                    <a target="_blank" class="dropdown-item" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=qq&menu=yes"><img border="0" src="//wpa.qq.com/pa?p=2:<?php echo $conf['kfqq']?>:52" alt="点击这里给我发消息" title="点击这里给我发消息"/> <?php echo $conf['kfqq']?></a>
                </div>
            </div>
        </div>
        </div>
        <div class="modal-footer py-2">
            <button type="button" class="btn btn-primary" data-dismiss="modal">知道啦</button> 
        </div>
    </div>
</div>
</div>

<div class="shuaibi-zhezhao" id="ShuaibiZhezhao"></div>
<div class="shuaibi-zzimg" id="ShuaibiZzimg">
<span id="ShuaibiZzclose"><i class="fa fa-times fa-3x"></i></span>
<img src="assets/img/bookmark.png" alt="bookmark">
</div>

<footer class="footer">
<div class="row align-items-center justify-content-xl-between m-0">
  <div class="col-lg-12">
    <div class="copyright text-center text-muted">
      &copy; <?php echo date("Y")?> <a href="./" class="font-weight-bold ml-1" target="_blank"><?php echo $conf['sitename']?></a>&nbsp;•&nbsp;<a href="javascript:void(0)" class="font-weight-bold ml-1" onclick="layer.alert('电脑用户请按键盘 <kbd>Ctrl</kbd> + <kbd>D</kbd> 将本站存为书签！', {icon: 7,title: '小提示',skin: 'layui-layer-molv layui-layer-wxd'})">收藏</a>
      <br/><?php echo $conf['footer']?>
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
var isModal=<?php echo empty($conf['modal'])?'false':'true';?>;
var homepage=true;
var hashsalt=<?php echo $addsalt_js?>;

$(function() {
    // 页面加载动画
    setTimeout(function() {
        $('#pageLoader').addClass('hidden');
        setTimeout(function() {
            $('#pageLoader').remove();
        }, 500);
    }, 1000);

    // 自定义光标效果
    const cursor = document.getElementById('customCursor');
    let mouseX = 0, mouseY = 0;

    if (window.innerWidth > 768) {
        document.addEventListener('mousemove', function(e) {
            mouseX = e.clientX;
            mouseY = e.clientY;
            
            requestAnimationFrame(function() {
                cursor.style.left = mouseX + 'px';
                cursor.style.top = mouseY + 'px';
            });
        });

        // 悬停效果
        document.querySelectorAll('a, button, .card').forEach(element => {
            element.addEventListener('mouseenter', () => cursor.classList.add('hover'));
            element.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
        });
    }

    // 原有功能保持不变
    $("img.lazy").lazyload({effect: "fadeIn"});
    var gotop = $("#top");
    $(window).scroll(function () {
    if ($(window).scrollTop() > 288) {
        gotop.fadeIn(588);
    } else {
        gotop.fadeOut(288);
    }
});
<?php if($conf['shoppingcart']==1){?>
$.ajax({
    type : "GET",
    url : "ajax.php?act=cart_info",
    dataType : 'json',
    async: true,
    success : function(data) {
        if(data.count != null && data.count>0){
            $('#cart_counts').html(data.count);
            $('#alert_carts').addClass('d-md-block');
        }
    }
});
<?php }?>
gotop.click(function () {
    $('body,html').animate({ scrollTop: 0 }, 688);
});

    // 卡片动画
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
});
</script>
<script src="assets/js/main.js?ver=<?php echo VERSION ?>"></script>
<?php if($conf['classblock']==1 || $conf['classblock']==2 && checkmobile()==false)include TEMPLATE_ROOT.'default/classblock.inc.php'; ?>
</body>
</html> 