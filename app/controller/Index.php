<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use app\service\AuthService;
use think\Request; 
use think\facade\{Session,Log};
  

class Index extends BaseController
{
    /**
     * function index 登录页
     */
    function __construct()
    {
        $this->authService = new AuthService();
    }

    public function index()
    {
    return View::fetch('common/base',[]);
    }
    
    public function login(Request $request) 
    { 
        try {
            $data = [
                'username'   => $request->post('username'),
                'password'   => $request->post('password'),
                '__token__'  => $request->post('__token__'),
            ];
            
            $httpenv = [
                'ip'         => $request->post('ip'),
                'user_agent' => $request->post('user_agent'),
                'language'   => $request->post('language'),
            ];
            if (empty($data['__token__'])) 
            {
                return json([
                    'code' => 403,
                    'msg' => '未授权的登录',
                    'redirect_url' => (string)url('api/login', [], true, true)
                ]);
            }

            $result = (new AuthService())->login($data['username'], $data['password']);
            if ($result['code'] == 200)
            {
                $device = $this->authService->userdevicecheck($result['name'],$httpenv);
                if (!$device['code'] == '200')
                {
                    return View('commond/login',[
                        'code'  => 401,
                        'msg'   => "新设备登录,需要核验邮箱,请前往邮箱查看验证邮件",
                        'redirect_url' => (string)url('api/email', [], true, true)
                    ]);
                }
            }
            
            ob_clean();
            return json($result);
    
        } catch (\Exception $e) {
            header('Content-Type: application/json; charset=utf-8');
            return json([
                'code' => 500,
                'msg' => '服务器内部错误',
                'redirect_url' => (string)url('index', [], true, true)
            ]);
        }
    }
    
}
