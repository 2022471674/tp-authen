<?php
namespace app\controller;

use app\BaseController;
use think\facade\{View, Session,Log};
use app\service\TuringTestService;
use app\model\CodeModel;
use think\Response;



class Home extends BaseController 
{
    protected $captchaService;
    protected $codeModel;
    
    public function __construct()
    {
        $this->captchaService   = new TuringTestService();
        $this->codeModel        = new CodeModel();        
        
    }

    /**
     * function index 验证码页
     */
    public function index()
    {
        return View::fetch('captcha/base');
    }

    /**
     * function captchaImage 验证码图片
     */
    public function captchaImage()
    {
        try {
            $userkey = Session::get('userid');  // 直接使用用户ID，不需要md5
            return response($this->captchaService->generate($userkey))
                ->contentType('image/png')
                ->header([
                    'Cache-Control' => 'no-store, no-cache, max-age=0',
                    'Pragma'        => 'no-cache'
                ]);
                
        } catch (\Exception $e) {
            Log::channel('captcha')->error("验证码生成失败: ".$e->getMessage());
            return json(['code'=>500, 'msg'=>'系统繁忙']);
        }
    }

    public function checkCaptcha()
    {
        try {
            $userkey = Session::get('userid');  // 直接使用用户ID，不需要md5
            $token = request()->post('__token__'); 
            if (empty($token))
            {
                return json(['code' => 403, 'msg' => '非法请求']);
            }
            if (!Session::has('userid')) {
                throw new \Exception('会话已过期');
            }

            $post = request()->post();
            $this->validate($post, [
                'captcha' => 'require|length:5',
                'emailcaptcha' => 'require|length:6'
            ]);
           
            Log::debug("验证码验证", [
                "userkey" => $userkey,
                "emailcaptcha" => $post['emailcaptcha']
            ]);

            // 图形验证码验证
            if (!$this->captchaService->verify($post['captcha'], $userkey)) {
                return json(['code' => 403, 'msg' => '图形验证码错误']);
            }

            // 邮箱验证码验证
            if (!$this->codeModel->validateCode($post['emailcaptcha'], $userkey)) {
                return json(['code' => 403, 'msg' => '邮箱验证码错误']);
            }

            Session::delete('token');
        
            return json([
                'code' => 200,
                'msg' => '登录成功',
                'redirect_url' => url('main/login')->build() 
            ]);
        } catch (\Exception $e) {
            Log::error("系统异常: " . $e->getMessage());
            return json(['code' => 500, 'msg' => '系统繁忙']);
        }
    }

}