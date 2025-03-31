<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default='欢迎'}</title>
    <link rel="stylesheet" href="/static/css/login-form.css">
    <link rel="stylesheet" href="/static/libs/node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/static/css/nav.css">
    <link rel="stylesheet" href="/static/css/body.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script src="/static/libs/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="/static/js/mouse.js"></script>
    <script src="/static/js/login-href.js"></script>
    <style>
        .screen {
            height: 650px;  /* 增加整体高度 */
        }

        .screen__content {
            padding-top: 120px;  /* 增加顶部内边距 */
        }

        .form-header {
            text-align: center;
            margin-bottom: 25px;  /* 增加底部间距 */
            color: #fff;
        }

        .form-header h1 {
            font-size: 24px;  /* 稍微增大标题字号 */
            margin-bottom: 8px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;  /* 增加输入框之间的间距 */
        }

        .input-icon {
            position: absolute;
            left: 12px;  /* 稍微调整图标位置 */
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .input-field {
            width: 100%;
            padding: 12px 12px 12px 40px;  /* 增加输入框内边距 */
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            font-size: 15px;  /* 增大输入框字号 */
        }

        .input-field:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 5px rgba(74,144,226,0.3);
            outline: none;
        }

        .login-link {
            display: block;
            text-align: center;
            color: #fff;
            text-decoration: none;
            margin: 20px 0;  /* 增加链接上下间距 */
            transition: color 0.3s ease;
            font-size: 15px;  /* 增大链接字号 */
        }

        .login-link:hover {
            color: #4a90e2;
        }

        .social-login {
            margin-top: 30px;  /* 增加社交登录区域的上边距 */
            text-align: center;
        }

        .social-login p {
            color: #fff;
            margin-bottom: 20px;  /* 增加文字底部间距 */
            position: relative;
            font-size: 15px;  /* 增大文字字号 */
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
            gap: 25px;  /* 增加图标之间的间距 */
        }

        .social-icons a {
            width: 45px;  /* 增大图标尺寸 */
            height: 45px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 20px;  /* 增大图标字号 */
        }

        .social-icons a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-3px);
        }

        .forgot-password {
            text-align: center;
            margin-top: 25px;  /* 增加忘记密码链接的上边距 */
        }

        .forgot-password a {
            color: #fff;
            text-decoration: none;
            font-size: 15px;  /* 增大链接字号 */
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #4a90e2;
        }

        .button.login__submit {
            margin-top: 15px;  /* 增加按钮的上边距 */
            padding: 12px 30px;  /* 增加按钮内边距 */
            font-size: 16px;  /* 增大按钮文字字号 */
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
                    <form class="login" method="post" action="{:url('index/login')}" id="loginForm">
                        <div class="form-header">
                            <h1>欢迎登录</h1>
                            <p>请使用您的账号密码登录</p>
                        </div>

                        <input type="hidden" name="__token__" value="{:token()}">
                        
                        <div class="input-group">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="username" class="input-field" 
                                value="{$post.username|default=''}" 
                                placeholder="用户名/邮箱"
                                required>
                        </div>
                        
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" class="input-field" 
                                placeholder="密码"
                                required>
                        </div>
                        
                        <a href="{:url('register/index')}" class="login-link">还没有账户？立即注册</a>
                        
                        <button class="button login__submit" type="submit">
                            <span class="button__text">登录</span>
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

                    <div class="forgot-password">
                        <a href="#" id="showForgotPassword">忘记密码？点击修改</a>
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

    <script>
        function showLoadingModal(text) {
            Swal.fire({
                title: text,
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading(),
                timerProgressBar: true,
                willClose: () => clearTimeout(this.timer)
            });
            this.timer = setTimeout(() => Swal.close(), 10000); // 10秒超时
        }
        
        // 显示错误提示
        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: '操作失败',
                text: message,
                confirmButtonColor: '#3085d6'
            });
        }
        
        // 处理登录响应
        function handleLoginResponse(data) {
            Swal.close(); // 关闭所有弹窗
            if (data.code === 200) {
                Swal.fire({
                    icon: 'success',
                    title: '登录成功',
                    text: data.msg,
                    timer: 1500,
                    showConfirmButton: false,
                    willClose: () => {
                        // 动态跳转处理
                        // 修正跳转逻辑
                        const redirectUrl = data.redirect_url || window.location.origin + '/home';
                        window.location.href = redirectUrl;
                        console.log('跳转地址:', data.redirect_url);
                    }
                });
            } else {
                // 增强错误处理
                const errorMap = {
                    401: '用户名或密码错误',
                    403: '验证码错误',
                    429: '尝试次数过多，请5分钟后再试',
                    500: '服务器内部错误'
                };
                
                Swal.fire({
                    icon: data.code === 401 ? 'warning' : 'error',
                    title: `登录失败 (${data.code})`,
                    text: data.msg || errorMap[data.code] || '未知错误',
                    confirmButtonText: '重试',
                    showCancelButton: true,
                    cancelButtonText: '联系支持'
                }).then((result) => {
                    if (result.isDismissed) {
                        window.location.href = '/support';
                    }
                });
            }
        }
        
        // 表单提交事件
        document.querySelector('.login').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // 前端基础验证
            const username = this.elements.username.value.trim();
            const password = this.elements.password.value;
            
            if (!username || !password) {
                showError('用户名和密码不能为空');
                return;
            }
        
            showLoadingModal('安全验证中...');
            
            // 添加CSRF令牌到请求头
            const headers = new Headers({
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': this.elements.__token__.value
            });
        
            // 创建FormData对象并添加额外信息
            const formData = new FormData(this);
            formData.append('user_agent', navigator.userAgent);
            formData.append('language', navigator.language.split('-')[0]); // 只获取主要语言代码

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: headers,
                credentials: 'same-origin' // 携带Cookie
            }).then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            }).then(data => {
                if (typeof data === 'object') {
                    handleLoginResponse(data);
                } else {
                    throw new Error('Invalid response format');
                }
            }).catch(error => {
                console.error('Fetch error:', error);
                showError(error.message.includes('network') ? 
                    '网络连接异常，请检查网络' : 
                    '服务器响应异常，代码：' + error.message
                );
            });
        });

        // 添加忘记密码弹窗
        document.getElementById('showForgotPassword').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '找回密码',
                html: `
                    <div class="agreement-content">
                        <p>请选择找回密码的方式：</p>
                        <div style="margin-top: 20px;">
                            <button class="button login__submit" style="width: 100%; margin-bottom: 10px;">
                                <i class="fas fa-envelope"></i> 通过邮箱找回
                            </button>
                            <button class="button login__submit" style="width: 100%;">
                                <i class="fas fa-mobile-alt"></i> 通过手机号找回
                            </button>
                        </div>
                    </div>
                `,
                width: '400px',
                showConfirmButton: false,
                showCloseButton: true
            });
        });
    </script>
</body>
</html>