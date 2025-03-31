<?php
namespace app\service;

use app\model\UserModel;
use Rtgm\sm\RtSm2;
use app\model\UserSelt;
use think\facade\{Log, Session, Db, Cache, Config};
use app\job\EmailJob;
use think\Exception;
use app\validate\RegisterUserdate;

class RegisterService
{
    private $sm2;
    private $publicKey;
    private $emailJob;
    private $registerUserdate;

    const TEMP_TOKEN_EXPIRE = 600;//临时token过期时间
    const VERIFY_CODE_LIMIT = 5; //验证码限制次数

    /**
     * 构造函数
     */
    public function __construct()
    {
        try {
            $this->registerUserdate = new RegisterUserdate();
            $this->publicKey = (new userSelt)->getPublicKey();
            if (!$this->publicKey) 
            {
                throw new Exception("获取公钥失败");
            }
            $this->emailJob = new EmailJob();
        } catch (Exception $e) {
            Log::error("RegisterService初始化失败: " . $e->getMessage());
            throw new Exception("服务初始化失败: " . $e->getMessage());
        }
    }

    /**
     * @param array $data 注册数据
     * @return array 注册结果
     */
    function register(array $data)
    {
        try {
            $id = $this->createToken();
            // 数据过滤
            $filteredData = (new RegisterUserdate())->check($data);
            if (!$filteredData) {
                throw new Exception("数据过滤失败");
            }
            
            // 密码加密
            $checkdata['password'] = $this->EncryptionService($filteredData['password']);
            
            // 开始事务
            Db::startTrans();
            try {
                // 插入用户数据
                $result = Db::name('users')->insert([
                    'id'        => $id,
                    'name'      => $filteredData['username'],
                    'password'  => $checkdata['password'],
                    'email'     => $filteredData['email'],
                    'phone'     => $filteredData['phone']
                ]);
                
                if (!$result) 
                {
                    throw new Exception("用户数据插入失败");
                }
                Log::debug("用户数据插入成功", ['id' => $id]);
                
                // 插入设备信息
                $userdevice = $data['userAgent'].$data['ip'].$data['language'];
                $userdevicekey = hash('sha256', $userdevice);

                $device = Db::name("user_history")->insert([
                    'user_id' => $id,
                    'ua' => $data['userAgent'],
                    'langua' => $data['language'],
                    'ip' => $data['ip'],
                    'trust_key' => $userdevicekey
                ]);
                if (!$device) {
                    throw new Exception("设备信息插入失败");
                }
                Log::debug("设备信息插入成功", ['id' => $id]);
                
                // 使用用户ID作为userkey,生成相应的用户隔离键
                $userkey = $id;
                
                // 生成认证token
                $token = bin2hex(random_bytes(32));
                Log::channel("user_action")->info("用户注册", ['token' => $token]);
                
                // 推送邮件任务
                $this->emailJob->push($filteredData['email'], $userkey);
                Log::debug("邮件任务已推送", [
                    'email' => $filteredData['email'],
                    'userkey' => $userkey,
                    'token' => $token
                ]);
                
                Db::commit();
                Session::set('userid', $id);
                return [
                    'code' => 200,
                    'msg' => '注册成功，需要核验',
                    'userkey' => $userkey,
                    'token' => $token
                ];
                
            } catch (Exception $e) {
                // 回滚事务
                Db::rollback();
                throw $e;
            }
            
        } catch (Exception $e) {
            Log::error("注册失败: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);
            throw new Exception("注册失败: " . $e->getMessage());
        }
    }

    /**
     * @param string $data 密码
     * @return string 加密后的密码
     */
    private function EncryptionService(string $data): string 
    {
        try {
            $sm2 = new RtSm2('base64', false);
            $password = $data;
            $data = $sm2->doEncrypt($data, $this->publicKey);
            if (!$data) 
            {
                throw new Exception("加密结果为空");
            }
            return $data;
        } catch (Exception $e) {
            Log::error("密码加密失败: " . $e->getMessage());
            throw new Exception("加密失败: " . $e->getMessage());
        }
    }

    private function userauthentication()
    {
        try {
            $token = bin2hex(random_bytes(32));
            Log::channel("user_action")->info("用户注册", ['token' => $token]);
            
            $code = mt_rand(100000, 999999);
            $cacheData = [
                'code' => $code,
                'attempts' => 0,
                'expire' => time() + self::TEMP_TOKEN_EXPIRE
            ];
            
            if (!Cache::set("verify:{$token}", $cacheData, self::TEMP_TOKEN_EXPIRE)) {
                throw new Exception("验证码缓存失败");
            }
            
            Log::debug("验证码生成成功", [
                'token' => $token,
                'code' => $code,
                'expire' => self::TEMP_TOKEN_EXPIRE
            ]);
            
            return [
                'token' => $token,
                'expire' => self::TEMP_TOKEN_EXPIRE
            ];
        } catch (Exception $e) {
            Log::error("用户认证失败: " . $e->getMessage());
            throw new Exception("用户认证失败: " . $e->getMessage());
        }
    }

    function createToken()
    {
        try {
            $token = bin2hex(random_bytes(4));
            if (!$token) 
            {
                throw new Exception("Token生成失败");
            }
            return $token;
        } catch (Exception $e) {
            Log::error("Token创建失败: " . $e->getMessage());
            throw new Exception("Token创建失败: " . $e->getMessage());
        }
    }
}