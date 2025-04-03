<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>量子态视口管理系统 v3.0</title>
    <style>
        :root {
            --golden-ratio: 1.618;
            --control-opacity: 0.2;
            --grid-columns: 1fr minmax(300px, calc(100vw / var(--golden-ratio))) 1fr;
        }

        /* 背景系统 */
        #particles-js {
            transition: opacity 0.5s ease;
            background: linear-gradient(135deg, rgb(184, 198, 236) 0%, #55acee 100%);
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }

        @media (prefers-color-scheme: dark) {
            body {
                background: #2d2d2d;
            }
            #particles-js {
                background: linear-gradient(90deg, #2D3748, #4A5568);
            }
        }

        /* 量子网格系统 */
        .quantum-grid {
            display: grid;
            grid-template-columns: var(--grid-columns);
            height: 100vh;
            position: relative;
            container-type: inline-size;
        }

        /* 动态主内容域 */
        .primary-zone {
            grid-column: 2;
            position: relative;
            z-index: 1000;
            background: rgba(255,255,255,0.95);
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin: 2rem 0;
            border-radius: 8px;
        }

        /* 流体排版系统 */
        .fluid-typography {
            font-size: clamp(1rem, 0.5rem + 1vw, 1.5rem);
            line-height: calc(1.2em + 0.3vw);
            padding: 2rem;
        }

        /* 响应式断点系统 */
        @container (width < 800px) {
            .quantum-grid {
                grid-template-columns: [left-gutter] 0fr [primary] 1fr [right-gutter] 0fr;
            }
        }

        /* 移动端优化 */
        @media (max-width: 768px) {
            .primary-zone {
                margin: 1rem;
                height: calc(100vh - 2rem);
            }
        }
    </style>
    <script src="/static/tinymce/tinymce.min.js"></script>
    <script src="/node_modules/particles.js/particles.js"></script>
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

    <script>
        // 粒子系统初始化
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
                particles: {
                    number: { 
                        value: window.innerWidth < 768 ? 40 : 80,
                        density: { enable: true, value_area: 800 }
                    },
                    color: { value: "#4a90e2" },
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
        });

        // 编辑器系统
        document.addEventListener('DOMContentLoaded', () => {
            tinymce.init({
                selector: '#quantum-editor',
                plugins: 'code preview autoresize',
                toolbar: 'undo redo | styleselect | bold italic | code preview',
                menubar: false,
                height: '100%',
                content_style: `
                    body { 
                        font-family: 'Fira Code', monospace;
                        background: rgba(255,255,255,0.9) !important;
                        color: #333 !important;
                        padding: 20px !important;
                        border-radius: 8px;
                    }
                    @media (prefers-color-scheme: dark) {
                        body {
                            background: rgba(30,30,30,0.9) !important;
                            color: #e0e0e0 !important;
                        }
                    }
                `,
                setup: (editor) => {
                    editor.on('init', () => {
                        editor.getBody().setAttribute('contenteditable', true);
                    });
                }
            });
        });

        // 视口响应系统
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
    </script>
</body>
</html>