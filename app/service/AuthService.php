<?php
namespace app\service;

use Rtgm\sm\RtSm2;
use app\service\JwtService;
use app\job\EmailJob;
use think\facade\{Session, Cache, Log, Queue, Db};
use app\model\{UserModel,CodeModel};
use app\validate\RegisterUserdate;
use Exception;

class AuthService
{
    private $userModel;
    private $jwt;
    private $email;
    private $attemptLimit;
    private $attemptTime;
    private $job;
    private $dirtydata;

    private CONST ATTEMPT_LIMIT = 5;

    const TEMP_TOKEN_EXPIRE = 600;
    const VERIFY_CODE_LIMIT = 5;

    public function __construct() 
    {
        $this->userModel = new UserModel();
        $this->job       = new EmailJob();
        $this->dirtydata = new RegisterUserdate();
    }

    /**
     * @param string $username Dirty username
     * @param string $password Dirty password
     * @param array $httpenv Dirty http env
     */

    public function login(string $username, string $password, array $httpenv)
    {
        // 第一步：执行基础的用户认证
        try {
            $user = $this->basicAuthentication($username, $password);
            if (isset($user['code']) && $user['code'] != 200) 
            {
                return $user;
            }

            // 开始事务
            Db::startTrans();
            try {
                // 第二步：脏数据清洗
                $httpenv['username'] = $username;
                $httpenv['password'] = $password;
                $rows = $this->dirtydata->check($httpenv);

                // 生成设备指纹
                $userdevice = $httpenv['userAgent'].$httpenv['ip'].$httpenv['language'];
                $userdevicekey = hash('sha256', $userdevice);
                Log::channel("user_action")->info("用户设备指纹", [
                    'user_id' => $user['id'],
                    'device_key' => $userdevicekey
                ]);
                // 检查设备信任状态
                $divese = $this->userModel->usertrustDevice($rows, $user['id'], $userdevicekey);

                if ($divese['code'] != 200) 
                {
                    // 新设备登录，发送邮件通知
                    $this->job->push($user['email'], $user['id']);
                    Log::channel("user_action")->info("用户新设备登录", [
                        'user_id' => $user['id'],
                        'device_key' => $userdevicekey
                    ]);
                    
                    // 记录新设备信息
                    $device = Db::name("user_history")->insert([
                        'user_id' => $user['id'],
                        'ua' => $httpenv['userAgent'],
                        'langua' => $httpenv['language'],
                        'ip' => $httpenv['ip'],
                        'trust_key' => $userdevicekey
                    ]);
                    
                    if (!$device) 
                    {
                        throw new Exception("设备信息记录失败");
                    }
                }

                // 设置session
                Session::set("userid", $user['id']);
                
                Db::commit();
                return [
                    'code' => 200,
                    'msg' => "欢迎",
                    "redirect_url" => (string)url('main/login', [], true, true)
                ];
            } catch (Exception $e) {
                Db::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::channel('user_action')->error("登录失败", [
                "username" => $username,
                "msg" => $e->getMessage()
            ]);
            return ['code' => 500, 'msg' => '系统错误'];
        }
    }

    private function basicAuthentication($username, $password)
    {
        /**
         * 基础认证
         */
        $user = $this->userModel->authenticate($username, $password);
        return $user;
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