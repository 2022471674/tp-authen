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
    
    /**
     * 收录分支
     * @username
     * @password
     * @ip
     * @__token__
     * @user_agent
     * @language
     */
    public function login(Request $request) 
    { 
        try {
            $data = [
                'username'   => $request->post('username'),
                'password'   => $request->post('password'),
                '__token__'  => $request->post('__token__'),
            ];
            
            $httpenv = [
                'ua'  => $request->post('user-agent'),
                'language'   => $request->post('language'),
                'ip'         => $request->ip()
            ];

            Log::channel('user_action')->info("登录请求", [
                'data' => $data['__token__'],
                'httpenv' => $httpenv['ua']
            ]);

            if (empty($httpenv['ua']))
            {
                Log::channel('user_action')->error("登录请求", [
                    'data' => $data['__token__'],
                    'httpenv' => $httpenv['ua']
                ]);
            }
            if (empty($data['__token__'])) 
            {
                return json([
                    'code' => 403,
                    'msg' => '未授权的登录',
                    'redirect_url' => (string)url('api/login', [], true, true)
                ]);
            }
            //传入用户名密码环境(脏数据)
            $result = $this->authService->login($data['username'], $data['password'], $httpenv);
            
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
