// 超现代化Argon模板JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // 初始化所有功�?
    initParticles();
    initLazyLoading();
    initScrollEffects();
    initSearchFunctionality();
    initFilterTabs();
    initCounterAnimation();
    initThemeToggle();
    initSoundEffects();
    
    console.log('🚀 超现代化模板已启�?);
});

// 粒子背景初始�?
function initParticles() {
    if (typeof particlesJS !== 'undefined') {
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: '#ffffff' },
                shape: { type: 'circle' },
                opacity: { value: 0.5, random: false },
                size: { value: 3, random: true },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#ffffff',
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 6,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out',
                    bounce: false
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: { enable: true, mode: 'repulse' },
                    onclick: { enable: true, mode: 'push' },
                    resize: true
                }
            },
            retina_detect: true
        });
    }
}

// 懒加载图�?
function initLazyLoading() {
    const images = document.querySelectorAll('.lazy');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    } else {
        // 降级处理
        images.forEach(img => {
            img.src = img.dataset.src;
            img.classList.remove('lazy');
            img.classList.add('loaded');
        });
    }
}

// 滚动效果
function initScrollEffects() {
    const backToTop = document.getElementById('backToTop');
    
    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset;
        
        // 返回顶部按钮显示/隐藏
        if (backToTop) {
            if (scrollTop > 300) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        }
        
        // 视差效果
        const parallaxElements = document.querySelectorAll('.floating-card');
        parallaxElements.forEach((element, index) => {
            const speed = 0.5 + (index * 0.1);
            const yPos = -(scrollTop * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    });
    
    // 返回顶部点击事件
    if (backToTop) {
        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// 搜索功能
function initSearchFunctionality() {
    const searchInput = document.getElementById('advancedSearch');
    const productCards = document.querySelectorAll('.product-card-ultra');
    const emptyState = document.getElementById('emptyState');
    
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            let visibleCount = 0;
            
            productCards.forEach(card => {
                const title = card.querySelector('.product-title')?.textContent.toLowerCase() || '';
                const desc = card.querySelector('.product-desc')?.textContent.toLowerCase() || '';
                
                if (title.includes(searchTerm) || desc.includes(searchTerm)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // 显示/隐藏空状�?
            if (emptyState) {
                if (visibleCount === 0 && searchTerm.length > 0) {
                    emptyState.classList.remove('d-none');
                } else {
                    emptyState.classList.add('d-none');
                }
            }
        });
    }
}

// 筛选标签功�?
function initFilterTabs() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card-ultra');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // 移除所有活动状�?
            filterBtns.forEach(b => b.classList.remove('active'));
            // 添加当前活动状�?
            btn.classList.add('active');
            
            const filter = btn.dataset.filter;
            
            productCards.forEach(card => {
                if (filter === 'all') {
                    card.style.display = 'block';
                } else if (filter === 'hot') {
                    // 显示有HOT标签的产�?
                    const hasHotBadge = card.querySelector('.product-badge.hot');
                    card.style.display = hasHotBadge ? 'block' : 'none';
                } else {
                    // 其他筛选逻辑可以在这里添�?
                    card.style.display = 'block';
                }
            });
        });
    });
}

// 数字计数动画
function initCounterAnimation() {
    const counters = document.querySelectorAll('.stat-number');
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.dataset.count);
        const duration = 2000; // 2秒动�?
        const start = performance.now();
        
        const update = (currentTime) => {
            const elapsed = currentTime - start;
            const progress = Math.min(elapsed / duration, 1);
            
            // 使用缓动函数
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            const current = Math.floor(target * easeOutQuart);
            
            counter.textContent = current;
            
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                counter.textContent = target;
            }
        };
        
        requestAnimationFrame(update);
    };
    
    // 使用Intersection Observer来触发动�?
    if ('IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        });
        
        counters.forEach(counter => counterObserver.observe(counter));
    }
}

// 主题切换功能
function initThemeToggle() {
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const currentTheme = html.dataset.theme;
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.dataset.theme = newTheme;
            localStorage.setItem('theme', newTheme);
            
            // 更新图标
            const icon = themeToggle.querySelector('i');
            if (newTheme === 'dark') {
                icon.className = 'fas fa-sun';
            } else {
                icon.className = 'fas fa-moon';
            }
            
            // 添加切换动画
            document.body.style.transition = 'all 0.3s ease';
            setTimeout(() => {
                document.body.style.transition = '';
            }, 300);
        });
        
        // 加载保存的主�?
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.dataset.theme = savedTheme;
        
        const icon = themeToggle.querySelector('i');
        if (savedTheme === 'dark') {
            icon.className = 'fas fa-sun';
        }
    }
}

// 音效功能
function initSoundEffects() {
    const soundToggle = document.getElementById('soundToggle');
    let soundEnabled = localStorage.getItem('soundEnabled') !== 'false';
    
    // 创建音效
    const createSound = (frequency, duration) => {
        if (!soundEnabled) return;
        
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = frequency;
        oscillator.type = 'sine';
        
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + duration);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + duration);
    };
    
    // 按钮点击音效
    document.addEventListener('click', (e) => {
        if (e.target.matches('button, .btn, .filter-btn')) {
            createSound(800, 0.1);
        }
    });
    
    // 悬浮音效
    document.addEventListener('mouseenter', (e) => {
        if (e.target.matches('.product-card-ultra, .feature-card')) {
            createSound(600, 0.05);
        }
    }, true);
    
    // 音效切换
    if (soundToggle) {
        soundToggle.addEventListener('click', () => {
            soundEnabled = !soundEnabled;
            localStorage.setItem('soundEnabled', soundEnabled);
            
            const icon = soundToggle.querySelector('i');
            if (soundEnabled) {
                icon.className = 'fas fa-volume-up';
                createSound(1000, 0.2);
            } else {
                icon.className = 'fas fa-volume-mute';
            }
        });
        
        // 设置初始图标
        const icon = soundToggle.querySelector('i');
        if (!soundEnabled) {
            icon.className = 'fas fa-volume-mute';
        }
    }
}

// 平滑滚动到锚�?
document.addEventListener('click', (e) => {
    if (e.target.matches('a[href^="#"]')) {
        e.preventDefault();
        const target = document.querySelector(e.target.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
});

// 清除搜索
function clearSearch() {
    const searchInput = document.getElementById('advancedSearch');
    const productCards = document.querySelectorAll('.product-card-ultra');
    const emptyState = document.getElementById('emptyState');
    
    if (searchInput) {
        searchInput.value = '';
    }
    
    productCards.forEach(card => {
        card.style.display = 'block';
    });
    
    if (emptyState) {
        emptyState.classList.add('d-none');
    }
}

// 滚动到顶�?
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// 添加收藏到书�?
function addToBookmarks() {
    if (window.sidebar && window.sidebar.addPanel) {
        // Firefox
        window.sidebar.addPanel(document.title, window.location.href, '');
    } else if (window.external && ('AddFavorite' in window.external)) {
        // Internet Explorer
        window.external.AddFavorite(window.location.href, document.title);
    } else if (window.opera && window.print) {
        // Opera
        const elem = document.createElement('a');
        elem.setAttribute('href', window.location.href);
        elem.setAttribute('title', document.title);
        elem.setAttribute('rel', 'sidebar');
        elem.click();
    } else {
        // 其他浏览�?
        alert('请按 Ctrl+D (Windows/Linux) �?Cmd+D (Mac) 来收藏本页面');
    }
}

// 性能监控
if (window.performance) {
    window.addEventListener('load', () => {
        setTimeout(() => {
            const perfData = performance.timing;
            const loadTime = perfData.loadEventEnd - perfData.navigationStart;
            console.log(`📊 页面加载耗时: ${loadTime}ms`);
        }, 0);
    });
} 
