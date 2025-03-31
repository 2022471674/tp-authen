<?php
namespace app\controller;

use app\BaseController;
use think\facade\{Request, Log, Session};
use app\model\UserModel;
use app\service\RegisterService;

class Register extends BaseController
{
    /**
     * 注册页面
     */
    public function index()
    {
        return view("/register/register");
    }

    /**
     * 注册
     */
    public function register()
    {
        try {
            // 检查CSRF token
            if (!Request::header('X-CSRF-TOKEN')) {
                Log::warning('缺少CSRF token', [
                    'headers' => Request::header(),
                    'ip' => Request::ip()
                ]);
                return json([
                    'code' => 403,
                    'msg' => '缺少安全验证信息'
                ]);
            }

            // 验证CSRF token
            $token = Request::header('X-CSRF-TOKEN');
            if (empty($token)){
                return json([
                    'code' => 403,
                    'msg' => '安全验证失败'
                ]);
            }

            $data = Request::post();
            $data['ip'] = Request::ip();
            $registerService = new RegisterService();
            $result = $registerService->register($data,true);
            
            if ($result['code'] == 200) 
            {
                return json([
                        'code' => 200,
                        'msg' => '注册成功，需要核验',
                        'redirect_url' => url('home/index')->build() // 确保生成完整URL
                    ]);
            } else {
                throw new \Exception('注册处理失败');
            }
           
        } catch (Exception $e) {
            Log::error('注册失败: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'post_data' => Request::post(),
                'headers' => Request::header()
            ]);
            return json([
                'code' => 500,
                'msg' => '注册失败，请稍后重试'
            ]);
        }
    }
}