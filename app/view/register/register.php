<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default='ThinkPHP8 站点'}</title>
    <link rel="stylesheet" href="/static/css/nav.css">
    <link rel="stylesheet" href="/static/css/login-form.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/static/libs/node_modules/sweetalert2/dist/sweetalert2.min.css">
    <script src="/static/libs/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="/static/js/mouse.js"></script> 
    <style>
        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 3px;
            transition: all 0.3s ease;
        }
        .strength-weak { background-color: #ff4d4d; width: 30%; }
        .strength-medium { background-color: #ffd700; width: 60%; }
        .strength-strong { background-color: #2ecc71; width: 100%; }
        
        .input-group {
            position: relative;
            margin-bottom: 15px;
        }
        
        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }
        
        .input-field {
            width: 100%;
            padding: 10px 10px 10px 35px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 5px rgba(74,144,226,0.3);
        }
        
        .validation-message {
            font-size: 12px;
            color: #ff4d4d;
            margin-top: 5px;
            display: none;
        }
        
        .requirements-list {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            padding-left: 20px;
            list-style: none;
            display: none;
        }
        
        .input-field:focus + label + .requirements-list {
            display: block;
        }
        
        .requirements-list li {
            margin: 3px 0;
            display: flex;
            align-items: center;
            color: #fff;
            opacity: 0.7;
        }
        
        .requirements-list li::before {
            content: "✗";
            margin-right: 8px;
            color: #ff4d4d;
            font-weight: bold;
        }
        
        .requirements-list li.valid {
            opacity: 1;
        }
        
        .requirements-list li.valid::before {
            content: "✓";
            color: #2ecc71;
        }
        
        .requirements-list li.valid span {
            color: #2ecc71;
        }
        
        .requirements-list li span {
            color: #fff;
        }
        
        .social-icons a {
            transition: transform 0.3s ease;
        }
        
        .social-icons a:hover {
            transform: translateY(-3px);
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
            color:#fff;
        }

        .form-header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .form-header p {
            font-size: 14px;
            opacity: 0.8;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group label {
            position: absolute;
            left: 35px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .input-field:focus + label,
        .input-field:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            background: #fff;
            padding: 0 5px;
            color: #4a90e2;
        }

        .agreement-checkbox {
            margin: 20px 0;
            display: flex;
            align-items: center;
            color: #fff;
        }

        .agreement-checkbox input[type="checkbox"] {
            margin-right: 10px;
        }

        .agreement-checkbox a {
            color: #4a90e2;
            text-decoration: none;
        }

        .agreement-checkbox a:hover {
            text-decoration: underline;
        }

        .login-link {
            display: block;
            text-align: center;
            color: #fff;
            text-decoration: none;
            margin: 20px 0;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: #4a90e2;
        }

        .social-login {
            margin-top: 30px;
            text-align: center;
        }

        .social-login p {
            color: #fff;
            margin-bottom: 15px;
            position: relative;
        }

        .social-login p::before,
        .social-login p::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background: rgba(255,255,255,0.3);
        }

        .social-login p::before {
            left: 0;
        }

        .social-login p::after {
            right: 0;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(105, 116, 211, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background: rgba(114, 143, 223, 0.2);
            transform: translateY(-3px);
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #4a90e2;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
            color: #fff;
            font-size: 12px;
        }

        .form-footer a {
            color: #4a90e2;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="main-bg">
    <div class="background-container">
        <div class="gradient-layer"></div>
        <div class="particle-layer"></div>
        <div class="container">
	<div class="screen">
		<div class="screen__content">
                    <form class="login" method="post" action="{:url('register')}" id="registerForm">
                        <div class="form-header">
                            <h1>欢迎注册</h1>
                            <p>请填写以下信息完成注册</p>
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
</body>
</html>