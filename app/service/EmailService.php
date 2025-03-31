<?php
namespace app\service;

use think\facade\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use app\model\CodeModel;
use think\facade\Log;
use think\facade\View;
use think\facade\Session;

class EmailService
{
    private $mailer;
    private $codeModel;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->codeModel = new CodeModel();
        $this->configureMailer();
    }

    /**
     * 初始化邮件配置
     */
    private function configureMailer(): void
    {
        $config = Config::get('email');
        
        $this->mailer->isSMTP();
        $this->mailer->Host       = $config['Host'];    
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $config['Username'];
        $this->mailer->Password   = $config['Password'];
        $this->mailer->SMTPSecure = $config['Encryption'];
        $this->mailer->Port       = $config['Port'];
        $this->mailer->setFrom($config['Username'], $config['From_name']);
        
        // 根据环境配置调试模式
        $this->mailer->SMTPDebug = Config::get('app.debug') ? 2 : 0;
    }

    /**
     * 发送验证码邮件
     */
    public function sendQmail(array $user, string $title): array
    {
        try {
            if (empty($user['email'])) {
                throw new \RuntimeException('邮件地址不能为空');
            }

            if (empty($user['userkey'])) {
                throw new \RuntimeException('用户标识不能为空');
            }

            // 生成验证码
            $code = $this->codeModel->generateCode($user['email'], $user['userkey']);
            
            // 空值检查
            if (empty($code)) {
                throw new \RuntimeException('验证码生成失败');
            }

            // 根据邮件类型选择模板
            switch ($title) {
                case 'login':
                    $content = $this->renderTemplate('login', $code);
                    break;
                case 'register':
                    $content = $this->renderTemplate('register', $code);
                    break;
                default:
                    $content = $this->buildEmailContent($code);
                    break;
            }

            // 重置邮件配置
            $this->mailer->clearAddresses();
            $this->mailer->clearAttachments();
            
            $this->mailer->addAddress($user['email']);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $title;
            $this->mailer->Body    = $content;

            // 发送邮件
            if (!$this->mailer->send()) {
                throw new \RuntimeException($this->mailer->ErrorInfo);
            }
            
            Log::channel('captcha')->info("邮件发送成功", [
                "email" => $user['email'],
                "title" => $title,
                "userkey" => $user['userkey'],
                "code" => $code
            ]);
            
            return ['code' => 200, 'msg' => '邮件发送成功'];
        } catch (Exception $e) {
            Log::channel("file")->error("邮件发送失败: | " . $e->getMessage());
            return ['code' => 500, 'msg' => '邮件发送失败，请稍后重试'];
        } catch (\Throwable $t) {
            Log::channel("file")->error("系统异常: {$t->getMessage()}");
            return ['code' => 500, 'msg' => '系统繁忙，请稍后重试'];
        }
    }

    /**
     * @param  string $templateName login || register || filewarn
     */
    private function renderTemplate(string $templateName, string $code): string
    {
        try {
            $codeChars = str_split($code);
            $expireMinutes = floor(\app\model\CodeModel::CODE_EXPIRE / 60);
    
            return View::fetch("email/{$templateName}", [
                'action'      => '注册账号',       
                'code_chars'  => $codeChars,     
                'expire'      => $expireMinutes   
            ]);
        } catch (\Exception $e) {
            Log::channel("captcha")->error("模板渲染失败: {$e->getMessage()}");
            return $this->buildEmailContent($code);
        }
    }

    /**
     * 默认邮件内容
     */
    private function buildEmailContent(string $code): string
    {
        return <<<HTML
        <html>
            <body>
                <h3>您的验证码为：</h3>
                <p style="color: #1890ff; font-size: 24px;">{$code}</p>
                <p>有效期 5 分钟，请勿泄露。</p>
            </body>
        </html>
        HTML;
    }
}