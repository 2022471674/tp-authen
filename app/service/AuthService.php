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
            $rows['username'] =$username;
            $rows['password'] =$password;
            $chechColumn = $this->dirtydata->check($rows);
            $user = $this->basicAuthentication($chechColumn['username'], $chechColumn['password']);

            if (isset($user['code']) && $user['code'] != 200) 
            {
                return $user;
            }

            Db::startTrans();
            try {
                // 第二步：脏数据清洗
                $devise = $this->userModel->usertrustDevice($httpenv, $user['data']['id']);
                if ($devise['code'] == 200) 
                {
                    return ['code' => 200,
                     'msg' => "欢迎",
                     'redirect_url' => (string)url('main/login', [], true, true)
                    ];
                }
                elseif($devise['code'] == 1006)
                {
                    {
                        $deviceKey = $httpenv['ua'].$httpenv['language'].$httpenv['ip'];
                        $deviceKey = hash('sha256', $deviceKey);
                        $insertData = [
                            'user_id' => $user['data']['id'],
                            'ua' => $httpenv['ua'],
                            'langua' => $httpenv['language'],
                            'ip' => $httpenv['ip'],
                            'trust_key' => $deviceKey
                        ];

                        $userkey = Session::get("userid");
                        $this->job->push($user['data']['email'], $userkey);
    
                        Db::name("user_history")
                        ->duplicate([
                            'ua' => Db::raw('VALUES(ua)'),
                            'langua' => Db::raw('VALUES(langua)'),
                            'ip' => Db::raw('VALUES(ip)'),
                            'trust_key' => Db::raw('VALUES(trust_key)')
                        ])
                        ->insert($insertData);
                    }
    
                    Db::commit();
                    $userkey = Session::get("userid");
                    return [
                        'code' => 200,
                        'msg' => "我们需要验证您的身份",
                        "redirect_url" => (string)url('home/index', [], true, true)
                    ];
                }
            } catch (Exception $e) {
                Db::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::channel('user_action')->info("登录失败{$e->getMessage()}");
            return ['code' => 500, 'msg' => '系统错误'];
        }
    }

    private function basicAuthentication($username, $password)
    {
        $user = $this->userModel->authenticate($username, $password);
        Log::channel('user_action')->info("基础认证{$user['data']['id']}");
        return $user;
    }
    
}