<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8" />
    <title>SecHub-tools</title>
    <meta
      name="description"
      content="JavaScript MD5 implementation. Compatible with server-side environments like Node.js, module loaders like RequireJS, Browserify or webpack and all web browsers."
    />
    <!-- 在<head>中添加字体图标库 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/md5/css/demo.css" />
    <link rel="stylesheet" href="/static/css/enum.css">
    <link rel="stylesheet" href="/md5/css/slider.css">

    
  </head>
  <body>
  <div class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</div>
  <aside class="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-shield-alt"></i>
        <h2>SecHub Tools</h2>
    </div>
    <nav class="sidebar-nav">
        <a href="#" class="active">
            <nav class="sidebar-nav">
    <li class="has-submenu active">
        <a href="#">
            <i class="fas fa-lock"></i>
            <span>CTF常见加密解密</span>
            <i class="fas fa-chevron-down dropdown-icon"></i>
        </a>
        <ul class="submenu">
            <li>
                <a href="#">
                    <i class="fas fa-shield-alt"></i>
                    <span>Base64编码/解码</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-exchange-alt"></i>
                    <span>ROT13转换</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-exchange-alt"></i>
                    <span>md5加密</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-project-diagram"></i>
                    <span>凯撒密码分析</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-cube"></i>
                    <span>Hex转换工具</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-random"></i>
                    <span>XOR加解密</span>
                </a>
            </li>
        </ul>
    </li>
    <!-- 其他原有菜单项保持不变 -->
</nav>
        </a>
        <a href="#">
            <i class="fas fa-code"></i>
            <span>CTF工具</span>
        </a>
        <a href="#">
            <i class="fas fa-bug"></i>
            <span>漏洞检测</span>
        </a>
        <div class="nav-divider"></div>
        <a href="#">
            <i class="fas fa-book"></i>
            <span>技术文档</span>
        </a>
    </nav>
</aside>
    <!-- 粒子特效 -->
  <div id="particles-js" style="position: fixed; width: 100%; height: 100%; z-index: -1;"></div>
  
  <div id="page-wrapper">
	
</div>


  <!-- 加密md5 -->
    <h1>这里可以帮助你加密md5值</h1>
    <form>
      <p>
        <label for="input">Input</label>
        <textarea rows="6" id="input"></textarea>
      </p>
      <p>
        <button
          type="submit"
          id="calculate"
          onclick="result.value=md5(input.value);return false"
        >
          Calculate
        </button>
        <button type="reset" id="reset">Reset</button>
      </p>
      <p>
        <label for="result">Result</label>
        <input id="result" readonly />
      </p>
    </form>
    <div class="fab-container">
  					<div class="fab-main" id="fabMenu">
    				<div class="fab-icon-holder">
      					<i class="fas fa-plus"></i>
    				</div>
            <ul class="fab-options">
  <!-- 新增返回按钮 -->
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
  </body>



<script>
// 拖拽功能
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
  if (isDragging) {
    e.preventDefault();
    const x = e.clientX - currentX;
    const y = e.clientY - currentY;
    
    // 限制在可视区域内
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
function showBugForm() {
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
// 动态切换函数
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}
// 子菜单切换功能
document.querySelectorAll('.has-submenu > a').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        const parent = this.parentElement;
        parent.classList.toggle('active');
        
        // 关闭其他展开的菜单
        document.querySelectorAll('.has-submenu').forEach(other => {
            if (other !== parent) other.classList.remove('active');
        });
    });
});

// 点击外部关闭菜单
document.addEventListener('click', function(e) 
{
    if (!e.target.closest('.has-submenu')) {
        document.querySelectorAll('.has-submenu').forEach(item => {
            item.classList.remove('active');
        });
    }
});
</script>

<script src="/static/js/main-title.js"></script>
<script src="/node_modules/particles.js/particles.js"></script>
<script src="/md5/js/md5.js"></script>
<script src="/static/js/body.js"></script>
</html>
