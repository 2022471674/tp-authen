<?php
namespace app\service;

use Rtgm\sm\RtSm2;
use app\service\JwtService;
use app\job\EmailJob;
use think\facade\{Session, Cache, Log, Queue};
use app\model\{UserModel,CodeModel};

class AuthService
{
    private $userModel;
    private $jwt;
    private $email;
    private $attemptLimit;
    private $attemptTime;
    private $job;

    private CONST ATTEMPT_LIMIT = 5;

    const TEMP_TOKEN_EXPIRE = 600;
    const VERIFY_CODE_LIMIT = 5;

    public function __construct() 
    {
        $this->userModel = new UserModel();
        $this->job       = new EmailJob();
    }

    /**
    * return [
    *'code' => $code,
    *'msg' => $msg,
    *'trace_id' => $this->generateTraceId(),
    *'timestamp' => date('Y-m-d H:i:s')
    *];
    */
    public function login($username, $password)
    {
        try {
            $user = $this->basicAuthentication($username, $password);
            if (isset($user['code']) && $user['code'] != 200) 
            {
                return $user;
            }

            return $user;
        } catch (\Exception $e) {
            Log::channel('user_action')->error("登录失败", [
            "username" => $username,
            "msg" => $e->getMessage(),
            "trace_id" => $this->generateTraceId()]);
            return ['code' => 500, 'msg' => '系统错误'];
        }
    }

    private function basicAuthentication($username, $password)
    {
        $user = $this->userModel->authenticate($username, $password);
       switch ($user['code'])
       {
        case 200:
            return ['code'=>200,'msg'=>'核验还在继续，请稍后'];
        case 500:
            return ['code'=>500,'msg'=>'系统错误'];
        case 1005:
            return ['code'=>401,'msg'=>'用户不存在'];
        case 1004:
            return ['code'=>401,'msg'=>'账户已冻结'];
       }

        $result = $this->userModel->verifyPassword($password, $user['password'],$user['email']);
        return $result ? $user : ['code' => 401, 'msg' => '密码错误'];
    }
    
    private function userdevicecheck(string $userid, array $httpenv, string $email)
    {
        $envcheck = $this->userModel->envcheck($httpenv);
        if ($envcheck['code'] != 200)
        {
            $this->job->emailJobSend($email);
            return $envcheck;
        }
    }
}