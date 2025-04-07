<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>量子编辑器 - 创作你的世界</title>
    <link rel="stylesheet" href="/static/css/edit.css">
    <link rel="stylesheet" href="/static/css/enum.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="/static/tinymce/tinymce.min.js"></script>
    <script src="/node_modules/particles.js/particles.js"></script>
    <script src="/static/js/main-title.js"></script>
    <script src="/static/js/mouse.js"></script>                 
    <script src="/static/js/body.js"></script>
    <script src="/static/tinymce/tinymce.js"></script>
    <script src="/static/tinymce/themes/silver/theme.min.js"></script>
    <script src="/static/assets/js/edit.js"></script>

</head>
<body>
    <!-- 背景粒子系统 -->
    <div id="particles-js"></div>


    <!-- 主内容结构 -->
    <div class="quantum-grid">
        <main class="primary-zone"> 
                <div class="editor-header">
                    <div class="editor-title">
                        <input type="text" id="article-title" placeholder="输入文章标题..." class="title-input">
                    </div>
                    <div class="editor-meta">
                        <div class="category-input">
                            <input type="text" id="article-category" placeholder="选择分类专栏..." class="category-select">
                            <div class="category-dropdown">
                                <div class="category-list"></div>
                            </div>
                        </div>
                    </div>
                    <div class="editor-actions">
                        <button id="saveBtn" class="action-btn">
                            <i class="fas fa-save"></i> 保存
                        </button>
                        <button id="previewBtn" class="action-btn">
                            <i class="fas fa-eye"></i> 预览
                        </button>
                    </div>
                </div>
                <hr class="content-divider">
                <div class="editor-body">
                    <textarea id="quantum-editor" placeholder="//正文,."></textarea>
                </div>
            </div>
        </main>
    </div>

    <!-- 悬浮按钮 -->
    <div class="fab-container">
        <div class="fab-main" id="fabMenu">
            <div class="fab-icon-holder">
                <i class="fas fa-plus"></i>
            </div>
            <ul class="fab-options">
                <li data-tooltip="返回上级" onclick="history.back()">
                    <i class="fas fa-arrow-left"></i>
                </li>
                <li data-tooltip="ctf工具" onclick="location.href='<?= url('main/md5_encode') ?>'">
                    <i class="fas fa-key"></i>
                </li>
                <li data-tooltip="发布文章" onclick="location.href='<?= url('main/edit') ?>'">
                    <i class="fas fa-pen"></i>
                </li>
                <li data-tooltip="提交BUG" onclick="showBugForm()">
                    <i class="fas fa-bug"></i>
                </li>
            </ul>
        </div>
    </div>

<script>



    let isDragging = false;
    let currentX = 0, currentY = 0;
    const fab = document.getElementById('fabMenu');

    fab.addEventListener('mousedown', dragStart);
    document.addEventListener('mousemove', drag);
    document.addEventListener('mouseup', dragEnd);

        function dragStart(e) 
        {
            isDragging = true;
            currentX = e.clientX - fab.offsetLeft;
            currentY = e.clientY - fab.offsetTop;
        }

        function drag(e) 
        {
            if (isDragging) 
            {
                e.preventDefault();
                const x = e.clientX - currentX;
                const y = e.clientY - currentY;
    
                const maxX = window.innerWidth - fab.offsetWidth;
                const maxY = window.innerHeight - fab.offsetHeight;
    
                fab.style.left = `${Math.min(Math.max(x, 0), maxX)}px`;
                fab.style.top = `${Math.min(Math.max(y, 0), maxY)}px`;
            }
        }

    function dragEnd() 
    {
    isDragging = false;
    }

// 折叠菜单切换
    fab.addEventListener('click', function(e) 
    {
        if (!isDragging) 
        {
        this.classList.toggle('open');
        }
});

// 显示BUG反馈表单
        function showBugForm() 
        {
        const form = `
            <div class="bug-form">
                <textarea placeholder="请详细描述遇到的问题"></textarea>
                <button onclick="submitBug()">提交</button>
            </div>
  `;
  // 这里需要实现表单弹出逻辑
        alert('BUG提交功能需要后端支持');
        }
</script>



<script>
    function getCookie(name) 
    {
        let cookieValue = null;
        if (document.cookie && document.cookie !== '') 
        {
            const cookies = document.cookie.split(';');
            for (let i = 0; i < cookies.length; i++) 
            {
                const cookie = cookies[i].trim();
                if (cookie.substring(0, name.length + 1) === (name + '=')) 
                {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }

    function showNotification(message, type = 'info') 
    {
        const colors = {
            success: '#4CAF50',
            error: '#F44336',
            info: '#2196F3'
                };
            
            const notification = document.createElement('div');
            notification.style = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 25px;
                color: white;
                background: ${colors[type]};
                border-radius: 4px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                z-index: 1000;
                animation: slideIn 0.3s ease-out;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); }
                to { transform: translateX(0); }
            }
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
        `;
        document.head.appendChild(style);
</script>
<script src="/static/js/edit.js"></script>
</body>
</html>