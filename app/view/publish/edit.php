<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑文章</title>
    <link rel="stylesheet" href="/static/css/edit.css">
    <link rel="stylesheet" href="/static/css/enum.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="/static/tinymce/tinymce.min.js"></script>
    <script src="/node_modules/particles.js/particles.js"></script>
    <script src="/static/js/main-title.js"></script>
    <script src="/static/js/mouse.js"></script>
    <script src="/static/js/body.js"></script>
</head>
<body>
    <!-- 背景粒子系统 -->
    <div id="particles-js"></div>

    <!-- 主内容结构 -->
    <div class="quantum-grid">
        <main class="primary-zone">
            <article class="fluid-typography">
                <textarea id="quantum-editor">// 开始量子编程...</textarea>
            </article>
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
tinymce.init({
    selector: '#quantum-editor',
    plugins: [
        'code', 'autoresize', 'advlist', 'autolink', 'link', 'image',
        'lists', 'preview', 'charmap', 'textcolor', 'textpattern',
        'textalign', 'blockquote'
    ].join(' '),
    toolbar: [
        'undo redo',
        'styleselect',      // 样式选择器（包含标题）
        'bold italic underline strikethrough',
        'forecolor backcolor',
        'alignleft aligncenter alignright alignjustify',
        'bullist numlist',
        'blockquote',
        'link unlink',
        'image',
        'charmap',
        'code preview',
        'customSave'
    ].join(' | '),
    menubar: false,
    height: '100%',
    // 配置标题格式选项
    block_formats: '段落=p; 标题1=h1; 标题2=h2; 标题3=h3; 标题4=h4; 标题5=h5',
    style_formats: [
        { title: '标题1', block: 'h1', classes: 'heading-1' },
        { title: '标题2', block: 'h2', classes: 'heading-2' },
        { title: '标题3', block: 'h3', classes: 'heading-3' },
        { title: '标题4', block: 'h4', classes: 'heading-4' },
        { title: '标题5', block: 'h5', classes: 'heading-5' },
        { title: '引用', block: 'blockquote', classes: 'quote' },
        { title: '代码块', block: 'pre', classes: 'code-block' },
        { title: '红色文本', inline: 'span', classes: 'red-text', styles: { color: '#ff0000' } }
    ],
    content_style: `
        body { 
            font-family: 'Fira Code', monospace;
            background: rgba(255,255,255,0.9) !important;
            color: #333 !important;
            padding: 20px !important;
            border-radius: 8px;
            line-height: 1.6;
        }

        /* 标题样式 */
        h1.heading-1 {
            font-size: 2.2em;
            margin: 1.2em 0 0.6em;
            border-bottom: 2px solid rgb(130, 178, 233);
        }
        h2.heading-2 {
            font-size: 1.8em;
            margin: 1em 0 0.5em;
            color: #2a6db0;
        }
        h3.heading-3 {
            font-size: 1.5em;
            margin: 0.8em 0 0.4em;
        }
        h4.heading-4 {
            font-size: 1.3em;
            margin: 0.6em 0 0.3em;
            font-weight: 500;
        }
        h5.heading-5 {
            font-size: 1.1em;
            margin: 0.4em 0 0.2em;
            opacity: 0.9;
        }

        blockquote.quote {
            border-left: 4px solid rgb(130, 178, 233);
            margin: 1.5em 0;
            padding: 0.5em 1em;
            color: #666;
            background: rgba(74,144,226,0.1);
        }
        pre.code-block {
            padding: 1em;
            background: #f8f8f8;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        /* 暗黑模式适配 */
        @media (prefers-color-scheme: dark) {
            h1.heading-1 {
                border-color: #4a90e2;
                color: #82b2e9;
            }
            h2.heading-2 {
                color: #6ba3e0;
            }
            h3.heading-3 {
                color: #8fbbeb;
            }
            blockquote.quote {
                background: rgba(74,144,226,0.2);
                border-color: rgb(97, 152, 207);
            }
            pre.code-block {
                background: rgba(0,0,0,0.3);
                border-color: #444;
            }
        }
    `,
    setup: function(editor) {
        // 创建帮助面板
        const createHelpPanel = () => {
            const panel = document.createElement('div');
            panel.id = 'shortcut-help';
            panel.style.cssText = `
                position: fixed;
                bottom: 30px;
                right: 30px;
                background: rgba(255,255,255,0.95);
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                width: 300px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 1000;
                font-family: system-ui, sans-serif;
                display: none;
                transition: opacity 0.2s;
            `;
            
            panel.innerHTML = `
                <h3 style="margin:0 0 15px; color:#2a6db0;">📌 快捷操作指南</h3>
                <ul style="margin:0; padding:0; list-style:none;">
                    <!-- 快捷操作列表 -->
                </ul>
                <ul style="margin:0; padding:0; list-style:none;">
                    <li>Ctrl+S 保存内容</li>
                    <li>Ctrl+Alt+1 标题1</li>
                    <li>Ctrl+Alt+2 标题2</li>
                    <li>Ctrl+Alt+3 标题3</li>
                    <li>Ctrl+Alt+4 标题4</li>
                    <li>Ctrl+Alt+5 标题5</li>
                    
                </ul>
                <div style="margin-top:15px; color:#999; font-size:0.9em;">
                    按住Ctrl键显示本面板
                </div>
                <style>
                    @media (prefers-color-scheme: dark) {
                        /* 暗黑模式样式 */
                    }
                </style>
            `;

            document.body.appendChild(panel);
            return panel;
        };

        // 事件处理逻辑
        let helpPanel = createHelpPanel();
        let ctrlPressed = false;

        const toggleHelp = (show) => {
            if (!helpPanel) return;
            helpPanel.style.display = show ? 'block' : 'none';
            helpPanel.style.opacity = show ? '1' : '0';
        };

        // 监听键盘事件
        editor.on('init', () => {
            const editorWindow = editor.getWin();
            
            editorWindow.addEventListener('keydown', (e) => {
                if (e.ctrlKey || e.metaKey) {
                    if (!ctrlPressed) {
                        ctrlPressed = true;
                        toggleHelp(true);
                    }
                }
            });

            editorWindow.addEventListener('keyup', (e) => {
                if (!e.ctrlKey && !e.metaKey) {
                    ctrlPressed = false;
                    toggleHelp(false);
                }
            });
        });

        // 销毁清理
        editor.on('remove', () => {
            helpPanel?.remove();
        });

        // 保存按钮
        editor.ui.registry.addButton('customSave', {
            text: '发布',
            icon: 'save',
            onAction: () => saveArticle(editor.getContent())
        });

        // 快捷键配置
        editor.addShortcut('Ctrl+S', '保存内容', () => {
            saveArticle(editor.getContent());
            return false;
        });

        editor.addShortcut('Meta+Shift+L', '插入列表', () => {
            editor.execCommand('InsertUnorderedList');
        });

        // 标题快捷键
        [1,2,3,4,5].forEach(level => {
            editor.addShortcut(`Ctrl+Alt+${level}`, `标题${level}`, () => {
                editor.formatter.apply(`h${level}`);
            });
        });
    }
});

        
        
        class ViewportSystem {
            constructor() {
                this.initDynamicLayout();
                this.initResizeHandler();
            }

            initDynamicLayout() {
                const updateGrid = () => {
                    const mainWidth = window.innerWidth / 1.618;
                    document.documentElement.style.setProperty('--grid-columns', 
                        `1fr minmax(300px, ${mainWidth}px) 1fr`);
                };
                window.addEventListener('resize', updateGrid);
                updateGrid();
            }

            initResizeHandler() {
                window.addEventListener('resize', () => {
                    if(window.pJSDom && window.pJSDom[0]){
                        window.pJSDom[0].pJS.fn.vendors.destroy();
                        window.pJSDom[0].pJS.fn.vendors.init();
                    }
                });
            }
        }

        new ViewportSystem();

    async function saveArticle(content) {
            try {
                const response = await fetch('/api/article/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRFToken': getCookie('csrftoken') // CSRF令牌处理
                    },
                    body: JSON.stringify({
                        content: content,
                        timestamp: new Date().toISOString()
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                showNotification(result.message || '发布成功', 'success');
            } catch (error) {
                console.error('保存失败:', error);
                showNotification(`发布失败: ${error.message}`, 'error');
            }
        }


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
</body>
</html>