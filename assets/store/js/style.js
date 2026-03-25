const canvas = document.getElementById('particles');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let particlesArray = [];
const mouse = { x: null, y: null };

// 用于存储鼠标拖尾的轨迹点，每个点包含 x, y 以及 alpha（透明度）
let mouseTrail = [];

window.addEventListener('mousemove', (event) => {
	mouse.x = event.x;
	mouse.y = event.y;
	// 每次鼠标移动时，添加一个新的轨迹点，初始 alpha 为 1
	mouseTrail.push({ x: event.x, y: event.y, alpha: 1 });
});

window.addEventListener('click', (event) => {
	const x = event.x;
	const y = event.y;
	generateClickParticles(x, y);
	displayClickText(x, y);
});

class Particle {
	constructor(x, y, size, speedX, speedY) {
		this.x = x;
		this.y = y;
		this.baseSize = size; // 记录原始尺寸
		this.size = size;
		this.speedX = speedX;
		this.speedY = speedY;
		this.color = "#00d4ff"; // 默认蓝色
	}

	update() {
		this.x += this.speedX;
		this.y += this.speedY;

		if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
		if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;

		// 如果鼠标存在，则检查与鼠标的距离
		if (mouse.x !== null && mouse.y !== null) {
			const dx = mouse.x - this.x;
			const dy = mouse.y - this.y;
			const distanceToMouse = Math.sqrt(dx * dx + dy * dy);
			const interactionRadius = 150;
			if (distanceToMouse < interactionRadius) {
				// 根据距离动态放大粒子，并使用动态透明度的热粉色
				let scaleFactor = (interactionRadius - distanceToMouse) / 30;
				this.size = this.baseSize + scaleFactor;
				let alpha = (1 - distanceToMouse / interactionRadius).toFixed(2);
				this.color = `rgba(255,105,180,${alpha})`;
			} else {
				this.size = this.baseSize;
				this.color = "#00d4ff";
			}
		}
	}

	draw() {
		ctx.fillStyle = this.color;
		ctx.beginPath();
		ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
		ctx.fill();
	}
}

// 点击产生粒子
function generateClickParticles(x, y) {
	const numberOfParticles = 5;
	for (let i = 0; i < numberOfParticles; i++) {
		const size = Math.random() * 3 + 1;
		const speedX = (Math.random() - 0.5) * 4;
		const speedY = (Math.random() - 0.5) * 4;
		particlesArray.push(new Particle(x, y, size, speedX, speedY));
	}
}

// 显示点击文字
function displayClickText(x, y) {
	const textElement = document.createElement('div');
	textElement.classList.add('click-text');
	textElement.textContent = '千纸雏鸢';
	textElement.style.left = `${x}px`;
	textElement.style.top = `${y}px`;
	document.body.appendChild(textElement);

	setTimeout(() => {
		textElement.style.opacity = '0';
		setTimeout(() => textElement.remove(), 1000);
	}, 1000);
}

function initParticles() {
	particlesArray = [];
	for (let i = 0; i < 200; i++) {
		const size = Math.random() * 3 + 1;
		const x = Math.random() * canvas.width;
		const y = Math.random() * canvas.height;
		const speedX = (Math.random() - 0.5) * 2;
		const speedY = (Math.random() - 0.5) * 2;
		particlesArray.push(new Particle(x, y, size, speedX, speedY));
	}
}

// 连接粒子
function connectParticles() {
	const connectionDistance = 50;
	for (let a = 0; a < particlesArray.length; a++) {
		for (let b = a + 1; b < particlesArray.length; b++) {
			let dx = particlesArray[a].x - particlesArray[b].x;
			let dy = particlesArray[a].y - particlesArray[b].y;
			let distance = Math.sqrt(dx * dx + dy * dy);
			if (distance < connectionDistance) {
				// 透明度根据距离调节
				let opacity = 1 - distance / connectionDistance;
				ctx.strokeStyle = `rgba(255,105,180,${opacity})`;
				ctx.lineWidth = 1;
				ctx.beginPath();
				ctx.moveTo(particlesArray[a].x, particlesArray[a].y);
				ctx.lineTo(particlesArray[b].x, particlesArray[b].y);
				ctx.stroke();
			}
		}
	}
}

// 绘制从鼠标到附近粒子的连线，突出悬停区域
function connectMouseToParticles() {
	const hoverDistance = 200;
	particlesArray.forEach(particle => {
		const dx = mouse.x - particle.x;
		const dy = mouse.y - particle.y;
		const distance = Math.sqrt(dx * dx + dy * dy);
		if(distance < hoverDistance) {
			let opacity = 1 - distance / hoverDistance;
			ctx.strokeStyle = `rgba(255,105,180,${opacity})`;
			ctx.lineWidth = 1;
			ctx.beginPath();
			ctx.moveTo(mouse.x, mouse.y);
			ctx.lineTo(particle.x, particle.y);
			ctx.stroke();
		}
	});
}

// 更新并绘制鼠标拖尾效果
function drawMouseTrail() {
	// 遍历拖尾数组，绘制每个轨迹点
	for (let i = 0; i < mouseTrail.length; i++) {
		let point = mouseTrail[i];
		// 以圆点形式绘制，颜色同样使用热粉色
		ctx.fillStyle = `rgba(255,105,180,${point.alpha})`;
		ctx.beginPath();
		ctx.arc(point.x, point.y, 3, 0, Math.PI * 2);
		ctx.fill();
		// 逐渐降低透明度
		point.alpha -= 0.01;
		// 当透明度降低到 0 以下时，从数组中移除
		if (point.alpha <= 0) {
			mouseTrail.splice(i, 1);
			i--;
		}
	}
}

function animateParticles() {
	ctx.clearRect(0, 0, canvas.width, canvas.height);
	particlesArray.forEach((particle) => {
		particle.update();
		particle.draw();
	});
	// 绘制粒子之间的连线
	connectParticles();
	// 绘制鼠标与附近粒子的连线，增强悬停效果
	if (mouse.x !== null && mouse.y !== null) {
		connectMouseToParticles();
	}
	// 绘制鼠标拖尾效果
	drawMouseTrail();
	requestAnimationFrame(animateParticles);
}

window.addEventListener('resize', () => {
	canvas.width = window.innerWidth;
	canvas.height = window.innerHeight;
	initParticles();
});

initParticles();
animateParticles();