<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default='欢迎'}</title>
        <link rel="stylesheet" href="/static/css/login-form.css">
        <link rel="stylesheet" href="/static/libs/node_modules/sweetalert2/dist/sweetalert2.min.css">
        

        <script src="/static/libs/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>

<div class="background-container">
</head>
    

<body class="main-bg">


<div class="container">
    <div class="screen">
        <div class="screen__content">
            <form method="POST" action="{:url('home/checkCaptcha')}" class="login">

            <input type="hidden" name="__token__" value="{:token()}">
                <div class="login__field">
                    <i class="login__icon fas fa-envelope"></i>
                    <input type="text" 
                           name="emailcaptcha" 
                           class="login__input"
                           required
                           placeholder="请输入邮箱验证码"
                           pattern="[A-Za-z0-9]{6}"
                           title="请输入6位邮箱验证码">
                </div>

                <div class="login__field">
                    <i class="login__icon fas fa-shield-alt"></i>
                    <input type="text" 
                           name="captcha" 
                           class="login__input"
                           required
                           placeholder="请输入验证码"
                           pattern="[A-Za-z0-9]{5}"
                           title="请输入5位字母或数字">
                </div>


                <img src="{:url('home/captchaImage')}" 
                     class="login__captcha-image"
                     onclick="this.src='{:url('home/captchaImage')}?t='+Date.now()"
                     alt="点击刷新验证码">


                <button type="submit" class="button login__submit">
                    <span class="button__text">提交验证</span>
                    <i class="button__icon fas fa-check"></i>
                </button>
            </form>


            <div class="social-login">
                <div class="social-icons">
                    <a href="#" class="social-login__icon fab fa-life-ring"></a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</form>

</body>

<script>
    // 定义全局定时器引用
    let loadingTimer;

    // 显示加载状态
    function showLoadingModal(text) {
        Swal.fire({
            title: text,
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
            timerProgressBar: true,
            willClose: () => clearTimeout(loadingTimer)
        });
        loadingTimer = setTimeout(() => Swal.close(), 10000);
    }
    
    // 统一错误处理
    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: '验证失败',
            text: message,
            confirmButtonColor: '#3085d6',
            confirmButtonText: '重新输入'
        }).then(() => {
            document.querySelector('[name="captcha"]').focus();
        });
    }
    
    // 处理验证响应
    function handleCaptchaResponse(data) {
        Swal.close();
        if (data.code === 200) {
            Swal.fire({
                icon: 'success',
                title: '验证通过',
                text: data.msg,
                timer: 1500,
                showConfirmButton: false,
                willClose: () => {
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        window.location.reload();
                    }
                }
            });
        } else {
            const errorMap = {
                403: '验证码错误，请重新输入',
                429: '尝试次数过多，请5分钟后再试',
                500: '服务器繁忙，请稍后重试'
            };
            
            Swal.fire({
                icon: 'error',
                title: `验证失败 (${data.code})`,
                text: data.msg || errorMap[data.code] || '未知错误',
                confirmButtonText: '刷新验证码',
                showDenyButton: true,
                denyButtonText: '联系支持'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('.login__captcha-image').click();
                } else if (result.isDenied) {
                    window.location.href = 'mailto:support@example.com';
                }
            });
        }
    }
    

    document.querySelector('.login').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const captchaInput = this.elements.captcha.value.trim();
        if (!captchaInput) {
            showError('请输入验证码');
            return;
        }
    
        showLoadingModal('验证码校验中...');
        const formData = new FormData(this);
        const headers = new Headers({
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': this.elements.__token__.value
        });
    
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: headers,
            credentials: 'same-origin'
        }).then(response => {
            if (!response.ok) throw new Error(`HTTP错误! 状态码: ${response.status}`);
            return response.json();
        }).then(handleCaptchaResponse)
        .catch(error => {
            console.error('请求异常:', error);
            showError(error.message.includes('Failed to fetch') ? 
                '网络连接异常，请检查网络设置' : 
                '服务器响应异常，请稍后重试'
            );
        });
    });
</script>