// 获取元素
const closeModalBtn = document.querySelector('#closeModalBtn');
const modalOverlay = document.querySelector('#modalOverlay');
const particlesContainer = document.querySelector('#particles');

// 生成粒子
function createParticles() {
    if (!particlesContainer) return; // 安全检查
    
    const particleCount = 50; // 粒子数量
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
        particle.style.animationDuration = `${Math.random() * 3 + 2}s`; // 随机动画时长
        particlesContainer.appendChild(particle);
    }
}

// 页面加载后自动弹出
window.onload = () => {
    if (modalOverlay) {
        modalOverlay.style.display = 'flex';
        createParticles(); // 生成粒子
    }
};

// 关闭弹出窗口
if (closeModalBtn) {
    closeModalBtn.addEventListener('click', () => {
        if (modalOverlay) {
            modalOverlay.style.display = 'none';
        }
    });
}

// 点击背景不关闭弹出窗口
if (modalOverlay) {
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            e.stopPropagation(); // 阻止事件冒泡
        }
    });
}