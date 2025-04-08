<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8" />
    <title>SecHub-tools</title>
    <meta name="description" content="SecHub Tools - 安全工具集" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/static/css/enum.css">
    <link rel="stylesheet" href="/static/css/MD5.css">
    <link rel="stylesheet" href="/md5/css/slider.css">
    <link rel="stylesheet" href="/md5/css/footer.css">
    <script src="/node_modules/particles.js/particles.js"></script>
    <script src="/static/assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="/md5/js/slider.js"></script>
  </head>
  <body>
  <nav class="navbar navbar-expand-custom navbar-mainbg">
        <button class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-tachometer-alt"></i>sm2加密</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="javascript:void(0);"><i class="far fa-address-book"></i>type7加密</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="far fa-clone">Rot13加密</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="far fa-calendar-alt">url编码/解码</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= url('main/tools_encrypt') ?>"><i class="far fa-chart-bar"></i>md5(16)(32)加/解密</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="far fa-copy"></i>更多工具</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
      <div class="tool-section">
        <h2>SM2 加密</h2>
        <div class="sm2-intro">
          <p>SM2是国家密码管理局于2010年12月发布的椭圆曲线公钥密码算法。它是一种非对称加密算法，基于椭圆曲线密码（ECC）构建，具有以下特点：</p>
          <ul>
            <li>密钥长度：256位</li>
            <li>安全性：与RSA 2048位相当</li>
            <li>运算速度：比RSA更快</li>
            <li>适用场景：数字签名、密钥交换、数据加密等</li>
          </ul>
          <p>SM2已成为中国商用密码的重要组成部分，广泛应用于金融、电子政务等领域。</p>
          <strong>注意：</strong>
          <p>公钥和私钥需要使用16进制格式</p>
        </div>
        <div class="input-group">
          <input type="text" id="input" placeholder="请输入需要加密的值">
        </div>
        <div class="button-group">
          <input type = "text" id="public_key" placeholder="请输入16进制公钥">
          <button id ="encrypt_16">加密</button>
        </div>
        <p>加密结果</p>
        <div class="input-group">
          <input type="text" id="result" placeholder="加密结果" readonly>
        </div>
      </div>
    </div>
    
    <div id="particles-js"></div>

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

    <footer class="footer">
      <div class="footer-content">
        <div class="footer-section">
          <h3>关于我们</h3>
          <p>SecHub Tools 是一个专注于提供安全工具和加密服务的平台。</p>
        </div>
        <div class="footer-section">
          <h3>联系方式</h3>
          <p>Email: contact@sechub.com</p>
          <p>电话: 123-456-7890</p>
        </div>
        <div class="footer-section">
          <h3>快速链接</h3>
          <ul>
            <li><a href="#">首页</a></li>
            <li><a href="#">工具列表</a></li>
            <li><a href="#">API文档</a></li>
            <li><a href="#">帮助中心</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 SecHub Tools. All rights reserved.</p>
      </div>
    </footer>

    <script src="/static/js/main-title.js"></script>
    <script src="/md5/js/md5.js"></script>
    <script src="/static/js/body.js"></script>
  </body>

  <script>
    <!--button-id -->
document.addEventListener('DOMContentLoaded', () => {
  const encrypt16 = document.getElementById('encrypt_16');
  const input = document.getElementById('input');
  const public_key = document.getElementById('public_key');
  const result = document.getElementById('result');

  const handleEncrypt = async (bits) => {
    const text = input.value.trim();
    if (!text) 
    {
      alert('请输入需要加密的内容');
      return;
    }

    try {
      const response = await fetch('/api/sm2/sm2_encrypt', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: bits,
          input: text,
          public_key: public_key.value
        })
      });

      if (!response.ok) throw new Error('加密失败');
      
      const data = await response.json();
      result.value = data.result;
    } catch (error) {
      console.error('Error:', error);
      result.value = '加密失败，请重试';
    }
  };

  encrypt16.addEventListener('click', () => handleEncrypt(16));
});
</script>


<script>
let isDragging = false;
let currentX = 0, currentY = 0;
const fab = document.getElementById('fabMenu');

fab.addEventListener('mousedown', dragStart);
document.addEventListener('mousemove', drag);
document.addEventListener('mouseup', dragEnd);

function dragStart(e) {
  isDragging = true;
  currentX = e.clientX - fab.offsetLeft;
  currentY = e.clientY - fab.offsetTop;
}

function drag(e) {
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

function dragEnd() {
  isDragging = false;
}

// 折叠菜单切换
fab.addEventListener('click', function(e) {
  if (!isDragging) {
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
</html>
