<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户控件</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/setting/css/main.css">
    <link rel="stylesheet" href="/setting/css/toggle-switch.css">
    <link rel="stylesheet" href="/static/assets/css/color.css">

    <script src="/node_modules/particles.js/particles.js"></script>
    <style>
        {
            #particles-js {
                background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            }
        }   
        /* 粒子容器修正 */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            transition: opacity 0.5s ease;
        }
        #particles-js {
			transition: opacity 0.5s ease;
			background: linear-gradient(135deg,rgb(184, 198, 236) 0%,#55acee 100%);
			}
			@media (prefers-color-scheme: dark) {	
    	
		}
		#particles-js:hover {
    	opacity: 0.9;
		}
    	position: fixed;
    	width: 100%;
    	height: 100%;
    	top: 0;
    	left: 0;
			z-index: -1; /* 确保在其他内容下方 */
    </style>
</head>
<body>
<div id="particles-js"></div>
<div class="brand-header">
        <img src="/favicon.ico" alt="SecHub Logo" class="brand-logo">
        <span class="brand-name">SecHub</span>
    </div>
    <div class="settings-container">
        <section class="setting-card">
            <h2><i class="fas fa-shield-alt"></i> 权限与隐私</h2>
            
            <!-- 文件相关设置 -->
            <div class="privacy-category">
                <h3 class="category-title">文件管理</h3>
                <div class="toggle-group">
                    <label class="toggle-switch">
                        <input type="checkbox" id="fileVisibilityToggle" checked>
                        <span class="slider"></span>
                        公开我的文件库
                    </label>
                    <small><i><span id="fileHelpText" class="help-text">
                        启用后其他用户可查看您的文件库目录
                    </span></i></small>
                </div>
            </div>
            
            <hr class="hr-wavy">
		        <p class="type"></p>

            <div class="privacy-category">
                <h3 class="category-title">内容发布</h3>
                <div class="toggle-group">
                    <label class="toggle-switch">
                        <input type="checkbox" id="articlePrivacySwitch">
                        <span class="slider"></span>
                        是否将我的文章设为隐私
                    </label>
                    <label class="toggle-switch">
                        <input type="checkbox" id="commentPrivacySwitch">
                        <span class="slider"></span>
                        是否将我的评论设为隐私
                    </label>
                </div>
            </div>

            <hr class="hr-wavy">
		        <p class="type"></p>

            <!-- 社交互动设置 -->
            <div class="privacy-category">
                <h3 class="category-title">社交互动</h3>
                <div class="toggle-group">
                    <label class="toggle-switch">
                        <input type="checkbox" id="likePrivacySwitch">
                        <span class="slider"></span>
                        是否将我的点赞设为隐私
                    </label>
                </div>
            </div>

            <hr class="hr-wavy">
		        <p class="type"></p>

            <!-- 空间管理设置 -->
            <div class="privacy-category">
                <h3 class="category-title">空间管理</h3>
                <div class="toggle-group">
                    <label class="toggle-switch">
                        <input type="checkbox" id="spacePrivacySwitch">
                        <span class="slider"></span>
                        是否将我的个人空间设为隐私
                    </label>
                    <label class="toggle-switch">
                        <input type="checkbox" id="albumPrivacySwitch">
                        <span class="slider"></span>
                        是否将我的相册设为隐私
                    </label>
                </div>
            </div>
        </section>
        <section class="setting-card">


    <div class="privacy-category">
        <h3 class="category-title">FTP 被动模式端口范围</h3>
        
        <!-- 端口输入表单 -->
        <div class="form-group">
            <div class="input-pair">
                <input type="number" id="minPort" class="port-input" 
                    placeholder="最小端口" min="1024" max="65534">
                <span class="separator">-</span>
                <input type="number" id="maxPort" class="port-input" 
                    placeholder="最大端口" min="1025" max="65535">
            </div>
            <button class="btn-save" onclick="savePortRange()">保存配置</button>
            <p class="status-msg" id="portStatus"></p>
        </div>
    </div>
</section>
    </div>
</body>

<script>
	let originalTitle = document.title;

	document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'hidden') {
        document.title = '"w(ﾟДﾟ)w 不要走！再看看嘛！';
    } else {
        document.title = originalTitle;
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    particlesJS('particles-js', {
        particles: {
            number: { 
                value: 80,  // 桌面端粒子数
                density: { enable: true, value_area: 800 }
            },
            color: { value: "#4a90e2" },  // 匹配主题蓝色
            shape: { type: "circle" },
            opacity: { value: 0.5 },
            size: { value: 3, random: true },
            line_linked: {
                enable: true,
                distance: 150,
                color: "#ffffff",
                opacity: 0.4,
                width: 1
            },
            move: {
                enable: true,
                speed: 2,
                direction: "none",
                out_mode: "out"
            }
        },
        interactivity: {
            detect_on: "canvas",
            events: {
                onhover: { enable: true, mode: "grab" },  // 悬停抓取效果
                onclick: { enable: true, mode: "push" },   // 点击生成新粒子
                resize: true
            }
        },
        retina_detect: true
    });
    
    // 移动端优化
    if(window.innerWidth < 768) {
        window.pJSDom[0].pJS.particles.number.value = 40;
    }
});
</script>
<script>
    function savePortRange() {
    const min = document.getElementById('minPort').value;
    const max = document.getElementById('maxPort').value;
    
    fetch('/admin/ftpSettings/updatePortRange', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // ThinkPHP的CSRF令牌
        },
        body: JSON.stringify({ 
            min_port: min,
            max_port: max 
        })
    })
    .then(response => response.json())
    .then(data => {
        const statusEl = document.getElementById('portStatus');
        statusEl.style.color = data.code === 200 ? '#28a745' : '#dc3545';
        statusEl.textContent = data.msg;
    });
}
</script>
</html>