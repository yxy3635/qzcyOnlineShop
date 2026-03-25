<?php
if($newuserfoot){
	include($newuserfoot);
	return;
}
?>
</div>
<script src="<?php echo $cdnserver?>assets/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/bootstrap-3.4.1.min.js"></script>
<script src="<?php echo $cdnserver?>assets/js/layer-3.1.1.js"></script>
<script src="<?php echo $cdnserver?>assets/user/js/app.js"></script>
<script src="<?php echo $cdnserver?>assets/js/umodal.js"></script>
<script>
$(document).ready(function() {
    // 侧边栏动画增强
    $('.navi .nav > li').each(function(index) {
        $(this).css('animation-delay', (index * 0.05 + 0.1) + 's');
    });
    
    // 重写ui-nav点击处理，保持原有功能但添加我们的动画
    $(document).off('click', '[ui-nav] a').on('click', '[ui-nav] a', function (e) {
        var $this = $(e.target), $active;
        $this.is('a') || ($this = $this.closest('a'));
        
        // 如果点击的是有子菜单的链接
        if ($this.next().is('ul')) {
            e.preventDefault();
            
            var $parent = $this.parent();
            var $submenu = $this.next('ul');
            
            // 添加点击涟漪效果
            var $ripple = $('<span class="ripple"></span>');
            var offset = $this.offset();
            var x = e.pageX - offset.left;
            var y = e.pageY - offset.top;
            
            $ripple.css({
                position: 'absolute',
                left: x + 'px',
                top: y + 'px',
                width: '0',
                height: '0',
                borderRadius: '50%',
                background: 'rgba(255,255,255,0.3)',
                transform: 'translate(-50%, -50%)',
                animation: 'ripple 0.6s ease-out',
                pointerEvents: 'none',
                zIndex: 999
            });
            
            $this.css('position', 'relative').append($ripple);
            
            setTimeout(function() {
                $ripple.remove();
            }, 600);
            
            // 关闭其他活跃的菜单
            $active = $parent.siblings(".active");
            if ($active.length) {
                $active.toggleClass('active').find('> ul:visible').slideUp(200);
            }
            
            // 切换当前菜单
            if ($parent.hasClass('active')) {
                $submenu.slideUp(200);
            } else {
                $submenu.slideDown(200);
            }
            $parent.toggleClass('active');
            
        } else {
            // 普通链接，添加点击效果
            var $this_link = $this;
            $this_link.addClass('clicked');
            
            setTimeout(function() {
                $this_link.removeClass('clicked');
            }, 200);
        }
    });
    
    // 菜单项悬停效果
    $('.navi .nav > li > a').hover(
        function() {
            $(this).addClass('hover-active');
        },
        function() {
            $(this).removeClass('hover-active');
        }
    );
    
    // 子菜单项点击效果
    $('.navi .nav-sub > li > a').click(function() {
        $('.navi .nav-sub > li').removeClass('active');
        $(this).parent().addClass('active');
    });
    
    // 移动端菜单切换
    $('.navbar-toggle, [ui-toggle="off-screen"]').click(function() {
        $('.app-aside').toggleClass('show');
    });
    
    // 点击内容区域关闭移动端菜单
    $('#content').click(function() {
        if ($(window).width() <= 767) {
            $('.app-aside').removeClass('show');
        }
    });
    
    // 滚动到活跃菜单项
    var $activeItem = $('.navi .nav > li.active');
    if ($activeItem.length > 0) {
        var scrollTop = $activeItem.offset().top - $('.aside-wrap').offset().top - 100;
        $('.aside-wrap').scrollTop(scrollTop);
    }
    
    // 初始化已展开的菜单状态
    $('.navi .nav > li.active .nav-sub').show();

    // ========= PJAX 局部加载 =========
    var basePath = window.location.pathname.replace(/[^\/]+$/, '');
    var pjaxState = {
        inFlight: false,
        xhr: null,
        lastUrl: null,
        lastClickAt: 0
    };

    function isSameOrigin(url) {
        try { var u = new URL(url, window.location.href); return u.origin === window.location.origin; } catch(e) { return false; }
    }

    function isInternalUserPage(url) {
        try {
            var u = new URL(url, window.location.href);
            return isSameOrigin(u.href) && u.pathname.indexOf(basePath) === 0 && /\.php($|\?)/.test(u.pathname);
        } catch(e) { return false; }
    }

    // 仅哈希导航（如 #query/#tab）检测，避免拦截框架内的切换
    function isHashOnlyNavigation(href) {
        if(!href) return false;
        if(href.charAt(0) === '#') return true;
        try {
            var u = new URL(href, window.location.href);
            // 仅 hash 变化，路径与查询参数不变
            return u.pathname === window.location.pathname && u.search === window.location.search && u.hash && u.hash !== window.location.hash;
        } catch(e) { return false; }
    }

    function setActiveNav(targetUrl) {
        var matched = null;
        $('.navi a[href]').each(function(){
            var href = this.getAttribute('href');
            if(!href || href === '#' || $(this).hasClass('auto')) return;
            var full = new URL(href, window.location.href).href;
            if(full === targetUrl) { matched = $(this); return false; }
        });
        if(matched){
            $('.navi .nav > li, .navi .nav-sub > li').removeClass('active');
            var li = matched.closest('li');
            li.addClass('active');
            var parent = matched.closest('.nav-sub').parent('li');
            if(parent.length){ parent.addClass('active'); parent.find('> .nav-sub').show(); }
        }
    }

    function executeScripts($container){
        $container.find('script').each(function(){
            var $old = $(this);
            var s = document.createElement('script');
            if($old.attr('src')){
                s.src = $old.attr('src');
            } else {
                s.text = $old.html();
            }
            document.body.appendChild(s);
            $old.remove();
        });
    }

    function pjaxLoad(url, opts){
        opts = opts || {};
        var shouldPush = opts.push !== false; // 默认 pushState，popstate 时传入 {push:false}
        // 防重复：同一地址且仍在加载时忽略
        if(pjaxState.inFlight && pjaxState.lastUrl === url){ return; }
        // 终止上一次未完成请求，避免竞态
        if(pjaxState.xhr && pjaxState.inFlight){ try{ pjaxState.xhr.abort(); }catch(e){} }
        pjaxState.inFlight = true;
        pjaxState.lastUrl = url;
        if(!isInternalUserPage(url)) { window.location.href = url; return; }
        var $contentBody = $('.app-content-body');
        if($contentBody.length === 0){ window.location.href = url; return; }
        var $mask = $('<div id="pjax-loading" style="position:absolute;inset:0;background:rgba(255,255,255,0.4);backdrop-filter:blur(2px);display:flex;align-items:center;justify-content:center;z-index:9999;"><div class="spinner" style="width:36px;height:36px;border:3px solid rgba(0,0,0,.15);border-top-color:#667eea;border-radius:50%;animation:spin .8s linear infinite"></div></div>');
        $contentBody.css('position','relative').append($mask);
        pjaxState.xhr = $.ajax({
            url: url,
            method: 'GET',
            cache: false
        }).done(function(html){
            var doc = new DOMParser().parseFromString(html, 'text/html');
            var newBody = doc.querySelector('#content .app-content-body');
            var newTitle = doc.querySelector('title');
            if(!newBody){ window.location.href = url; return; }
            $contentBody.html(newBody.innerHTML);
            if(newTitle) document.title = newTitle.textContent;
            executeScripts($contentBody);
            setActiveNav(new URL(url, window.location.href).href);
            if(shouldPush && url !== window.location.href){
                history.pushState({pjax:true, url:url}, document.title, url);
            }
        }).fail(function(xhr, status){
            if(status !== 'abort'){
                window.location.href = url; // 出错则退回普通跳转
            }
        }).always(function(){
            pjaxState.inFlight = false;
            pjaxState.xhr = null;
            $('#pjax-loading').remove();
        });
    }

    // 拦截侧边栏与内容区域内部的内链点击（排除 tab、#hash 和 layer/UModal 内部链接）
    $(document).on('click', 'a[href]', function(e){
        var href = this.getAttribute('href');
        if(!href || href === '#' || $(this).hasClass('auto') || this.hasAttribute('download') || this.target === '_blank' || this.getAttribute('data-no-pjax')==='true') return;
        // 忽略仅 hash 导航或前端组件（tab/pill）切换
        var dataToggle = (this.getAttribute('data-toggle') || '').toLowerCase();
        if(isHashOnlyNavigation(href) || dataToggle === 'tab' || dataToggle === 'pill' || this.closest('.nav-tabs') || $(this).closest('.layui-layer, .umodal').length) return;
        var url = new URL(href, window.location.href).href;
        if(isInternalUserPage(url)){
            // 点击节流，避免快速连点造成竞态
            var now = Date.now();
            if(now - pjaxState.lastClickAt < 250 && url === pjaxState.lastUrl){ e.preventDefault(); return; }
            pjaxState.lastClickAt = now;
            e.preventDefault();
            pjaxLoad(url, {push:true});
        }
    });

    // 处理浏览器前进后退
    window.addEventListener('popstate', function(e){
        if(e.state && e.state.pjax){
            pjaxLoad(location.href, {push:false});
        }
    });
});

// 添加涟漪动画CSS
$('<style>')
    .prop('type', 'text/css')
    .html(`
        @keyframes ripple {
            0% {
                width: 0;
                height: 0;
                opacity: 1;
            }
            100% {
                width: 60px;
                height: 60px;
                opacity: 0;
            }
        }
        
        .navi .nav > li > a.clicked {
            transform: translateX(8px) scale(0.98);
        }
        
        .navi .nav > li > a.hover-active {
            transition: all 0.2s ease;
        }
        
        /* 特殊菜单项的加载动画 */
        .navi .nav > li:last-child {
            animation-delay: 0.8s;
        }
        
        /* 改进的子菜单动画 */
        .navi .nav-sub > li {
            transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        /* 活跃状态的增强动画 */
        .navi .nav > li.active > a {
            animation: pulse 2s infinite;
        }
        
        /* 移动端适配 */
        @media (max-width: 767px) {
            .app-aside.show {
                animation: slideInFromLeft 0.3s ease;
            }
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    `)
    .appendTo('head');
</script>
