<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default='来辣(^///^)'}</title>
    <link rel="stylesheet" href="/static/css/nav.css">
    <link rel="stylesheet" href="/static/css/login-form.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/static/libs/node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/static/assets/css/register-body.css">

    <script src="/node_modules/particles.js/particles.js"></script>
    <script src="/static/libs/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="/static/js/mouse.js"></script> 
    <style>
        
    </style>
</head>
<body>
    <!-- 在背景容器最前面添加粒子层 -->
    <div class="particle-layer">
        <div id="particles-js"></div>
    </div>
    <div class="background-container">
        <div class="gradient-layer"></div>
        <div class="particle-layer"></div>
        <div class="container">
	<div class="screen">
		<div class="screen__content">
                    <form class="login" method="post" action="{:url('register')}" id="registerForm">
                        <div class="form-header">
                            <h1>来辣(^///^)</h1>

                        </div>

				<input type="hidden" name="__token__" value="{:token()}">
                        
                        <div class="input-group">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="username" class="input-field" 
                    value="{$post.username|default=''}" 
                                placeholder=" "
                                required>
                            <label>用户名</label>
                            <div class="validation-message" id="username-error"></div>
				</div>
                        
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" class="input-field" 
                                placeholder=" "
                                required>
                            <label>密码</label>
                            <div class="password-strength" id="password-strength"></div>
                            <ul class="requirements-list" id="password-requirements">
                                <li id="length"><span>至少8个字符</span></li>
                                <li id="uppercase"><span>包含大写字母</span></li>
                                <li id="lowercase"><span>包含小写字母</span></li>
                                <li id="number"><span>包含数字</span></li>
                                <li id="special"><span>包含特殊字符</span></li>
                            </ul>
				</div>
                        
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="input-field" 
                    value="{$post.email|default=''}" 
                                placeholder=" "
                                required>
                            <label>电子邮箱</label>
                            <div class="validation-message" id="email-error"></div>
				</div>
                        
                        <div class="input-group">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="tel" name="phone" class="input-field" 
                    value="{$post.phone|default=''}" 
                                placeholder=" "
                                required>
                            <label>手机号码</label>
                            <div class="validation-message" id="phone-error"></div>
                        </div>
                        
                        <div class="agreement-checkbox">
                            <input type="checkbox" id="agreement" required>
                            <label for="agreement">我已阅读并同意<a href="#" id="showAgreement">用户协议</a></label>
				</div>
                        
                        <a href="{:url('api/login')}" class="login-link">已有账户？立即登录</a>
                        
                        <button class="button login__submit" type="submit">
					<span class="button__text">注册</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>				
			</form>
                    
			<div class="social-login">
                        <p>其他登录方式</p>
				<div class="social-icons">  
                            <a href="#" class="social-login__icon fab fa-weixin" title="微信登录"></a>
                            <a href="#" class="social-login__icon fab fa-qq" title="QQ登录"></a>
                            <a href="#" class="social-login__icon fab fa-weibo" title="微博登录"></a>
				</div>
			</div>

                    <div class="form-footer">
                        <p>注册即表示您同意我们的<a href="#" id="showPrivacy">隐私政策</a>和<a href="#" id="showTerms">服务条款</a></p>
                    </div>
		</div>
                
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
</div>

    <script>
        // 密码强度检测
        function checkPasswordStrength(password) {
            let strength = 0;
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[^A-Za-z0-9]/.test(password)
            };
            
            // 更新密码要求列表
            Object.keys(requirements).forEach(req => {
                const element = document.getElementById(req);
                if (requirements[req]) {
                    element.classList.add('valid');
                    element.classList.remove('invalid');
                    strength++;
                } else {
                    element.classList.add('invalid');
                    element.classList.remove('valid');
                }
            });
            
            // 更新密码强度指示器
            const strengthBar = document.getElementById('password-strength');
            strengthBar.className = 'password-strength';
            if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
            } else if (strength <= 4) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
            
            return strength;
        }
        
        // 实时验证
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('input', function() {
                const field = this.name;
                const value = this.value;
                const errorElement = document.getElementById(`${field}-error`);
                
                switch(field) {
                    case 'username':
                        if (value.length < 3) {
                            errorElement.textContent = '用户名至少需要3个字符';
                            errorElement.style.display = 'block';
                        } else {
                            errorElement.style.display = 'none';
                        }
                        break;
                        
                    case 'password':
                        checkPasswordStrength(value);
                        break;
                        
                    case 'email':
                        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                            errorElement.textContent = '请输入有效的邮箱地址';
                            errorElement.style.display = 'block';
                        } else {
                            errorElement.style.display = 'none';
                        }
                        break;
                        
                    case 'phone':
                        if (!/^1[3-9]\d{9}$/.test(value)) {
                            errorElement.textContent = '请输入有效的手机号码';
                            errorElement.style.display = 'block';
                        } else {
                            errorElement.style.display = 'none';
                        }
                        break;
                }
            });
        });
        
        // 用户协议弹窗
        document.getElementById('showAgreement').addEventListener('click', function(e) {
            e.preventDefault();
        Swal.fire({
                title: '用户协议',
                html: `
                    <div class="agreement-content">
                        <h3>1. 服务条款</h3>
                        <p>欢迎使用我们的服务。使用我们的服务即表示您同意这些条款。</p>
                        
                        <h3>2. 隐私政策</h3>
                        <p>我们重视您的隐私，承诺保护您的个人信息安全。</p>
                        
                        <h3>3. 用户责任</h3>
                        <p>用户需要对自己的账号安全负责，妥善保管密码。</p>
                    </div>
                `,
                width: '600px',
                confirmButtonText: '我已阅读并同意'
            });
        });
        
        // 表单提交前验证
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = this.elements.password.value;
            if (checkPasswordStrength(password) < 3) {
                e.preventDefault();
        Swal.fire({
                    icon: 'warning',
                    title: '密码强度不足',
                    text: '请确保密码满足所有要求'
                });
            }
        });

        document.getElementById('showPrivacy').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '隐私政策',
                html: `
                    <div class="agreement-content">
                        <h3>1. 信息收集</h3>
                        <p>我们收集的信息包括但不限于：用户名、邮箱地址、手机号码等基本信息。</p>
                        
                        <h3>2. 信息使用</h3>
                        <p>我们使用收集的信息来：提供和改进服务、发送通知、防止欺诈等。</p>
                        
                        <h3>3. 信息保护</h3>
                        <p>我们采取多种安全措施保护您的个人信息安全。</p>
                    </div>
                `,
                width: '600px',
                confirmButtonText: '我知道了'
            });
        });

        document.getElementById('showTerms').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '服务条款',
                html: `
                    <div class="agreement-content">
                        <h3>1. 服务说明</h3>
                        <p>我们提供的服务包括但不限于：用户注册、登录、信息管理等。</p>
                        
                        <h3>2. 用户义务</h3>
                        <p>用户需要遵守相关法律法规，不得利用服务从事违法活动。</p>
                        
                        <h3>3. 服务变更</h3>
                        <p>我们保留随时修改或终止服务的权利。</p>
                    </div>
                `,
                width: '600px',
                confirmButtonText: '我知道了'
            });
        });

        // 表单提交时显示加载动画
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.style.display = 'flex';
        });

        // 页面加载完成后隐藏加载动画
        window.addEventListener('load', function() {
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.style.display = 'none';
    });
</script>
<script>
        // 在页面加载完成后初始化粒子特效
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
                particles: {
                    number: { 
                        value: 80,
                        density: { enable: true, value_area: 800 }
                    },
                    color: { value: "#ffffff" },
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
                        onhover: { enable: true, mode: "grab" },
                        onclick: { enable: true, mode: "push" },
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
    let originalTitle = document.title;

    document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'hidden') {
        document.title = '"w(ﾟДﾟ)w 不要走！再看看嘛！';
    } else {
        document.title = originalTitle;
    }
});
</script>
<footer class="login-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h4>联系我们</h4>
            <p>神火广场老九门武田F1 v3</p>
            <p>2022471677@qq.com</p>
        </div>
        <div class="footer-divider"></div>
        <div class="footer-section">
            <h4>关注我们</h4>
            <div class="footer-social">
                <a href="#" class="fab fa-weixin"></a>
                <a href="https://github.com/2022471674/tp-authen.git" class="fab fa-github"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 AuthSystem. All rights reserved. 
            <a href="/privacy">隐私政策</a> | 
            <a href="/terms">服务条款</a>
        </p>
    </div>
</footer>
</body>
</html>