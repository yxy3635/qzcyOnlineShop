/**
 * 超现代化交互效果 - 本地优化版本
 * 快速加载，炫酷动画，完美性能
 */

// 防抖函数
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// 自定义光标效�?
class CustomCursor {
  constructor() {
    this.cursor = document.getElementById('cursor');
    this.isVisible = window.innerWidth > 768; // 仅桌面端显示
    this.isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    
    if (!this.isVisible || !this.cursor || this.isTouch) {
      // 移动设备或触摸设备不启用自定义光�?
      return;
    }
    
    this.init();
  }
  
  init() {
    // 强制显示光标
    this.cursor.style.cssText = `
      position: fixed;
      width: 24px;
      height: 24px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.8), rgba(102, 126, 234, 0.6));
      border: 2px solid rgba(102, 126, 234, 0.8);
      border-radius: 50%;
      pointer-events: none;
      z-index: 999999;
      transform: translate(-50%, -50%);
      transition: all 0.15s ease;
      box-shadow: 0 0 10px rgba(102, 126, 234, 0.5);
      visibility: visible !important;
      opacity: 1 !important;
      left: 50px;
      top: 50px;
    `;
    
    // 隐藏默认光标
    document.body.classList.add('custom-cursor');
    
    // 鼠标移动跟随
    document.addEventListener('mousemove', (e) => {
      requestAnimationFrame(() => {
        const x = e.clientX;
        const y = e.clientY;
        
        this.cursor.style.left = x + 'px';
        this.cursor.style.top = y + 'px';
        this.cursor.style.visibility = 'visible';
        this.cursor.style.opacity = '1';
      });
    });
    
    // 鼠标进入/离开页面控制
    document.addEventListener('mouseenter', () => {
      this.cursor.style.visibility = 'visible';
      this.cursor.style.opacity = '1';
    });
    
    document.addEventListener('mouseleave', () => {
      this.cursor.style.visibility = 'hidden';
      this.cursor.style.opacity = '0';
    });
    
    // 悬停效果
    const hoverElements = document.querySelectorAll('a, button, .product-card, .btn-modern, input, .search-box');
    hoverElements.forEach(el => {
      el.addEventListener('mouseenter', () => {
        this.cursor.classList.add('active');
        el.style.cursor = 'none';
      });
      el.addEventListener('mouseleave', () => {
        this.cursor.classList.remove('active');
      });
    });
    
    // 滚动时光标效�?
    window.addEventListener('scroll', () => {
      this.cursor.style.opacity = '0.5';
      clearTimeout(this.scrollTimeout);
      this.scrollTimeout = setTimeout(() => {
        this.cursor.style.opacity = '1';
      }, 150);
    });
  }
}

// 波纹效果
class RippleEffect {
  constructor() {
    this.container = document.getElementById('rippleContainer');
    if (!this.container) return;
    
    this.init();
  }
  
  init() {
    document.addEventListener('click', (e) => {
      this.createRipple(e.clientX, e.clientY);
    });
  }
  
  createRipple(x, y) {
    const ripple = document.createElement('div');
    ripple.className = 'ripple';
    ripple.style.left = x + 'px';
    ripple.style.top = y + 'px';
    
    this.container.appendChild(ripple);
    
    // 清理动画完成的波�?
    setTimeout(() => {
      if (ripple.parentNode) {
        ripple.parentNode.removeChild(ripple);
      }
    }, 800);
  }
}

// 滚动动画
class ScrollAnimations {
  constructor() {
    this.init();
  }
  
  init() {
    // 视差滚动效果
    this.initParallax();
    
    // 滚动时元素动�?
    this.initScrollReveal();
  }
  
  initParallax() {
    const shapes = document.querySelectorAll('.shape');
    const heroSection = document.querySelector('.hero-section');
    
    const handleParallax = () => {
      const scrolled = window.pageYOffset;
      const rate = scrolled * -0.5;
      
      // 背景形状视差
      shapes.forEach((shape, index) => {
        const speed = 0.1 + (index * 0.05);
        const yPos = scrolled * speed;
        shape.style.transform = `translate3d(0, ${yPos}px, 0)`;
      });
      
      // Hero区域视差
      if (heroSection) {
        heroSection.style.transform = `translate3d(0, ${rate}px, 0)`;
        heroSection.style.opacity = 1 - scrolled / 800;
      }
    };
    
    window.addEventListener('scroll', debounce(handleParallax, 5));
  }
  
  initScrollReveal() {
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.animationPlayState = 'running';
        }
      });
    }, observerOptions);
    
    // 观察所有需要动画的元素
    const animatedElements = document.querySelectorAll('.product-card, .stat-item, .main-card');
    animatedElements.forEach(el => {
      el.style.animationPlayState = 'paused';
      observer.observe(el);
    });
  }
}

// 3D倾斜效果
class TiltEffect {
  constructor() {
    this.init();
  }
  
  init() {
    const cards = document.querySelectorAll('.product-card');
    
    cards.forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        
        const rotateX = (y - centerY) / 10;
        const rotateY = (centerX - x) / 10;
        
        requestAnimationFrame(() => {
          card.style.transform = `
            translateY(-12px) 
            rotateX(${rotateX}deg) 
            rotateY(${rotateY}deg)
            perspective(1000px)
          `;
        });
      });
      
      card.addEventListener('mouseleave', () => {
        card.style.transform = '';
      });
    });
  }
}

// 数字计数动画
class CountAnimation {
  constructor() {
    this.init();
  }
  
  init() {
    const counters = document.querySelectorAll('[data-count]');
    
    const observerOptions = {
      threshold: 0.5
    };
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          this.animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);
    
    counters.forEach(counter => observer.observe(counter));
  }
  
  animateCounter(element) {
    const target = parseFloat(element.getAttribute('data-count'));
    const text = element.textContent;
    const hasPlus = text.includes('+');
    const hasPercent = text.includes('%');
    
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    
    const timer = setInterval(() => {
      current += step;
      if (current >= target) {
        current = target;
        clearInterval(timer);
      }
      
      let displayValue;
      if (hasPercent) {
        displayValue = current.toFixed(1) + '%';
      } else if (hasPlus) {
        displayValue = Math.floor(current).toLocaleString() + '+';
      } else {
        displayValue = Math.floor(current).toLocaleString();
      }
      
      element.textContent = displayValue;
    }, 16);
  }
}

// 主题切换效果
class ThemeSwitch {
  constructor() {
    this.currentTheme = 'default';
    this.themes = {
      default: {
        '--primary-gradient': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        '--secondary-gradient': 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'
      },
      sunset: {
        '--primary-gradient': 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
        '--secondary-gradient': 'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)'
      },
      ocean: {
        '--primary-gradient': 'linear-gradient(135deg, #667db6 0%, #0082c8 100%)',
        '--secondary-gradient': 'linear-gradient(135deg, #74b9ff 0%, #0984e3 100%)'
      },
      forest: {
        '--primary-gradient': 'linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%)',
        '--secondary-gradient': 'linear-gradient(135deg, #88d8a3 0%, #d5f5e3 100%)'
      }
    };
    
    this.init();
  }
  
  init() {
    // 创建主题切换按钮
    this.createThemeButton();
    
    // 键盘快捷�?Ctrl+T
    document.addEventListener('keydown', (e) => {
      if (e.ctrlKey && e.key === 't') {
        e.preventDefault();
        this.switchTheme();
      }
    });
  }
  
  createThemeButton() {
    const button = document.createElement('button');
    button.innerHTML = '🎨';
    button.className = 'theme-switch-btn';
    button.title = '切换主题 (Ctrl+T)';
    button.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      border: none;
      background: var(--primary-gradient);
      color: white;
      font-size: 20px;
      cursor: pointer;
      z-index: 1001;
      box-shadow: var(--shadow);
      transition: var(--transition);
    `;
    
    button.addEventListener('click', () => this.switchTheme());
    button.addEventListener('mouseenter', () => {
      button.style.transform = 'scale(1.1) rotate(15deg)';
    });
    button.addEventListener('mouseleave', () => {
      button.style.transform = 'scale(1) rotate(0deg)';
    });
    
    document.body.appendChild(button);
  }
  
  switchTheme() {
    const themeNames = Object.keys(this.themes);
    const currentIndex = themeNames.indexOf(this.currentTheme);
    const nextIndex = (currentIndex + 1) % themeNames.length;
    this.currentTheme = themeNames[nextIndex];
    
    const root = document.documentElement;
    const theme = this.themes[this.currentTheme];
    
    // 主题切换动画
    document.body.style.filter = 'brightness(1.2) saturate(1.3)';
    
    setTimeout(() => {
      Object.entries(theme).forEach(([property, value]) => {
        root.style.setProperty(property, value);
      });
      
      document.body.style.filter = 'brightness(1) saturate(1)';
    }, 100);
    
    // 显示主题名称
    this.showThemeNotification(this.currentTheme);
  }
  
  showThemeNotification(themeName) {
    const themeNames = {
      default: '🌟 默认',
      sunset: '🌅 夕阳',
      ocean: '🌊 海洋',
      forest: '🌲 森林'
    };
    
    const notification = document.createElement('div');
    notification.textContent = `主题: ${themeNames[themeName]}`;
    notification.style.cssText = `
      position: fixed;
      top: 80px;
      right: 20px;
      padding: 12px 20px;
      background: rgba(0, 0, 0, 0.8);
      color: white;
      border-radius: 8px;
      z-index: 1002;
      opacity: 0;
      transform: translateX(100px);
      transition: all 0.3s ease;
      font-weight: 500;
    `;
    
    document.body.appendChild(notification);
    
    requestAnimationFrame(() => {
      notification.style.opacity = '1';
      notification.style.transform = 'translateX(0)';
    });
    
    setTimeout(() => {
      notification.style.opacity = '0';
      notification.style.transform = 'translateX(100px)';
      setTimeout(() => notification.remove(), 300);
    }, 1500);
  }
}

// 音效系统（可选）
class SoundEffects {
  constructor() {
    this.enabled = false; // 默认关闭，避免打扰用�?
    this.init();
  }
  
  init() {
    // 创建音效开关按�?
    this.createSoundToggle();
  }
  
  createSoundToggle() {
    const button = document.createElement('button');
    button.innerHTML = '🔊';
    button.className = 'sound-toggle-btn';
    button.title = '音效开�?;
    button.style.cssText = `
      position: fixed;
      top: 80px;
      right: 20px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: none;
      background: rgba(0, 0, 0, 0.5);
      color: white;
      font-size: 16px;
      cursor: pointer;
      z-index: 1001;
      transition: all 0.3s ease;
    `;
    
    button.addEventListener('click', () => {
      this.enabled = !this.enabled;
      button.innerHTML = this.enabled ? '🔊' : '🔇';
      button.style.background = this.enabled ? 'var(--primary-gradient)' : 'rgba(0, 0, 0, 0.5)';
    });
    
    document.body.appendChild(button);
  }
  
  playSound(type) {
    if (!this.enabled) return;
    
    // 使用Web Audio API创建简单音�?
    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    const oscillator = audioCtx.createOscillator();
    const gainNode = audioCtx.createGain();
    
    oscillator.connect(gainNode);
    gainNode.connect(audioCtx.destination);
    
    switch(type) {
      case 'click':
        oscillator.frequency.setValueAtTime(800, audioCtx.currentTime);
        break;
      case 'hover':
        oscillator.frequency.setValueAtTime(600, audioCtx.currentTime);
        break;
    }
    
    gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);
    gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.1);
    
    oscillator.start(audioCtx.currentTime);
    oscillator.stop(audioCtx.currentTime + 0.1);
  }
}

// 页面加载完成后初始化所有效�?
document.addEventListener('DOMContentLoaded', () => {
  // 页面加载动画
  document.body.style.opacity = '0';
  document.body.style.transform = 'scale(0.98)';
  
  requestAnimationFrame(() => {
    document.body.style.transition = 'all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
    document.body.style.opacity = '1';
    document.body.style.transform = 'scale(1)';
  });
  
  // 初始化所有效�?
  setTimeout(() => {
    try {
      new CustomCursor();
    } catch (error) {
      initSimpleCursor();
    }
    
    new RippleEffect();
    new ScrollAnimations();
    new TiltEffect();
    new CountAnimation();
    new ThemeSwitch();
    new SoundEffects();
  }, 300);
  
  // 简化版本光�?
  function initSimpleCursor() {
    if (window.innerWidth <= 768) return;
    
    const cursor = document.getElementById('cursor');
    if (!cursor) return;
    
    cursor.style.cssText = `
      position: fixed;
      width: 16px;
      height: 16px;
      background: rgba(102, 126, 234, 0.8);
      border: 2px solid white;
      border-radius: 50%;
      pointer-events: none;
      z-index: 999999;
      transform: translate(-50%, -50%);
      transition: all 0.1s ease;
      visibility: visible;
      opacity: 1;
    `;
    
    document.addEventListener('mousemove', (e) => {
      cursor.style.left = e.clientX + 'px';
      cursor.style.top = e.clientY + 'px';
    });
    
    document.body.classList.add('custom-cursor');
  }
  

});



// 导出给全局使用
window.UltraEffects = {
  CustomCursor,
  RippleEffect,
  ScrollAnimations,
  TiltEffect,
  CountAnimation,
  ThemeSwitch,
  SoundEffects
}; 
