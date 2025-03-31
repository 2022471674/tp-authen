<?php
namespace app\model;

use think\Model;
use think\model\concern\SoftDelete;
use think\facade\{Session, Log, Db, Cache};
use Rtgm\sm\RtSm2;
use app\model\UserSelt;

class UserModel extends Model
{
    use SoftDelete;
    public $user;
    private $sm2PrivateKey;
    private $UserSelt;
    private $sm2;

    const ERROR_CODES = [
        400 => '请求参数错误',
        401 => '未授权访问',
        403 => '禁止访问',
        404 => '资源不存在',
        429 => '请求过于频繁',
        405 => '请求方法错误',
        500 => '服务器内部错误',
        503 => '服务暂时不可用',
        
        1001 => '验证码错误',
        1002 => '密码错误',
        1003 => '账号已被锁定',
        1004 => '账户已冻结',
        1005 => '用户不存在',
        1006 => '指纹验证失败',
        1007 => '权限不足'
    ];

    // 用户状态常量
    const STATUS_NORMAL = 1;
    const STATUS_FROZEN = 0;
    const STATUS_LOCKED = 2;

    // 缓存时间常量
    const CACHE_TIME = 3600;
    const CACHE_PREFIX = 'user_';//缓存前缀

    //test
    /**
     * 构造函数
     */
    public function __construct()
    {
        try {
            // 初始化获得国窖sm2加密私钥
            $this->UserSelt = new UserSelt();
            
            // 获取私钥
            $this->sm2PrivateKey = $this->UserSelt->getprivatekey();
            if (empty($this->sm2PrivateKey)) {
                throw new \RuntimeException('SM2 私钥获取失败');
            }
            
            // 初始化 SM2
            $this->sm2 = new RtSm2('base64');
            
            // 加载加密密钥
            $this->privateKey = $this->loadEncryptionKeys();
            
        } catch (\Exception $e) {
            Log::channel('file')->error("初始化失败: " . $e->getMessage());
            throw new \RuntimeException('系统初始化失败: ' . $e->getMessage());
        }
    }

    /**
     * 加载加密密钥
     * @return string
     * @throws \RuntimeException
     */
    private function loadEncryptionKeys(): string
    {
        try {
            if (empty($this->sm2PrivateKey)) 
            {
                throw new \RuntimeException('SM2 私钥未初始化');//降级处理
            }
            return $this->sm2PrivateKey;
        } catch (\Exception $e) {
            Log::channel('file')->error("SM2 私钥加载失败: " . $e->getMessage());
            throw new \RuntimeException('SM2 私钥加载失败: ' . $e->getMessage());
        }
    }
    
    /**
     * 用户指纹识别
     * @param string $username 用户名
     * @param string $identify 用户指纹数据  用户hash 256加密（user_agent.ip.language ）
     * @return array $trustDevice 用户仓库中的已有指纹数据
     */
    private function findidentify(string $username, string $trustDevice, array $identify): array
    {
        try {
            $result = hash_equals($identify, $trustDevice);
            if ($result) 
            {
                return true;// 对比成功返回true，直接执行登录，否则需要邮箱验证
            }
            $addDevice = $this->addDevice($username, $identify);

            if ($addDevice)
            {
                return true;
            }
            return false;

        } catch (\Exception $e) {
            Log::channel('user_action')->error('指纹识别失败', [
                'username' => $username,
                'error' => $e->getMessage(),
                'trace_id' => $this->generateTraceId()
            ]);
            return $this->errorResponse(500, '系统繁忙，请稍后重试');
        }
    }

    /**
     * #后续为用户初始化权限表再用
     * @param string $username 用户名
     * @param string $permission 权限标识
     * @return array
     */
    public function userpowers(string $username, string $permission): array
    {
        try {
            $user = $this->findByUsername($username);
            if ($user['code'] !== 200) {
                return $user;
            }

            // 检查用户权限
            if (!$this->checkPermission($user['data']['id'], $permission)) {
                Log::channel('user_action')->warning('权限不足', [
                    'username' => $username,
                    'permission' => $permission,
                    'trace_id' => $this->generateTraceId()
                ]);
                return $this->errorResponse(1007, '没有操作权限');
            }

            return $this->successResponse(['has_permission' => true]);
        } catch (\Exception $e) {
            Log::channel('user_action')->error('权限检查失败', [
                'username' => $username,
                'permission' => $permission,
                'error' => $e->getMessage(),
                'trace_id' => $this->generateTraceId()
            ]);
            return $this->errorResponse(500, '系统繁忙，请稍后重试');
        }
    }

    /**
     * 基础的认证分支
     * @param string $username 用户名
     * @param string $password 密码
     * @return array
     */
    public function authenticate(string $username, string $password): array
    {
        try {
            Log::channel('user_action')->info("基础认证", [
                'username' => $username,
            ]);
            $user = $this->findByUsername($username);

            switch ($user['code']) 
            {
                case 200:
                    // 用户存在的时候验证密码
                    if ($this->verifyPassword($user['data']['password'], $password)) 
                    {
                        return $this->successResponse($user['data']);
                    }
                    return $this->errorResponse(1002, '密码错误');
                    
                case 1004:
                    Log::channel('user_action')->warning('账户已冻结', [
                        'username' => $username,
                        'trace_id' => $this->generateTraceId()
                    ]);
                    return $this->errorResponse(1004, '账户已冻结，请联系管理员');
                    
                case 1005:
                    Log::channel('user_action')->warning('用户不存在', [
                        'username' => $username,
                        'trace_id' => $this->generateTraceId()
                    ]);
                    return $this->errorResponse(1005, '用户不存在');
                    
                case 1003:
                    Log::channel('user_action')->warning('账号已被锁定', [
                        'username' => $username,
                        'trace_id' => $this->generateTraceId()
                    ]);
                    return $this->errorResponse(1003, '账号已被锁定，请联系管理员');
                    
                default:
                    Log::channel('user_action')->warning('未知错误状态', [
                        'username' => $username,
                        'code' => $user['code'],
                        'trace_id' => $this->generateTraceId()
                    ]);
                    return $this->errorResponse(500, '系统繁忙，请稍后重试');
            }
            
        } catch (\Exception $e) {
            Log::channel('user_action')->warning('用户认证失败', [
                'username' => $username,
                'error' => $e->getMessage(),
                'trace_id' => $this->generateTraceId()
            ]);
            Log::channel('user_action')->info("用户认证失败 {$e->getMessage()}");
            return $this->errorResponse(500, '系统繁忙，请稍后重试');
        }
    }

    /**
     * function findByUsername 基础用户信息,用户角色
     * 用户不存在 || 账户冻结 || 账户锁定 || 系统错误
     * @param string $username 用户名
     * @return array
     */
    protected function findByUsername(string $username)
    {
        try {
            Log::channel('user_action')->info("查询用户信息", [
                'username' => $username,
            ]);
            Log::channel('user_action')->info("查询用户信息 {$username}");
            $result = Db::name('users')
                ->where("name", $username)
                ->cache(self::CACHE_PREFIX . $username, self::CACHE_TIME)
                ->find();
                
            if (empty($result)) 
            {
                Log::channel('user_action')->warning('用户不存在', [
                    'username' => $username,
                ]);
                return $this->errorResponse(1005, '用户不存在');
            }


            if ($result['status'] != self::STATUS_NORMAL) 
            {
                $statusMsg = $result['status'] == self::STATUS_FROZEN ? '账户已冻结' : '账户已锁定';
                Log::channel('user_action')->warning($statusMsg, [
                    'username' => $username,
                    'status' => $result['status'],
                    'trace_id' => $this->generateTraceId()
                ]);
                return $this->errorResponse(1004, $statusMsg . '，请联系管理员');
            }
            Cache::set(self::CACHE_PREFIX."id",$result['id']);
            return $this->successResponse($result);
        } catch (\Exception $e) {
            Log::channel('user_action')->info('查询用户信息失败', [
                'username' => $username,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'trace_id' => $this->generateTraceId()
            ]);
            return $this->errorResponse(500, '系统繁忙，请稍后重试');
        }
    }

    

    /**
     * 用户信任设备
     * @param array $trustDevice 信任设备
     * @param string $userid 用户ID
     * @param string $deviceKey 当前设备指纹
     * @return array
     */
    public function usertrustDevice(array $trustDevice, string $userid, string $deviceKey)
    {
        try {
            // 查询用户历史设备
            $devices = Db::name('user_history')
                ->where('user_id', $userid)
                ->select();

            if (empty($devices)) 
            {
                return $this->errorResponse(1006, "指纹验证错误,需核验邮箱");
            }

            // 检查当前设备是否在信任设备列表中
            foreach ($devices as $device) 
            {
                if (hash_equals($deviceKey, $device['trust_key'])) 
                {
                    return $this->successResponse($device);
                }
            }

            return $this->errorResponse(1006, "指纹验证错误,需核验邮箱");
        } catch (\Exception $e) {
            Log::channel('user_action')->warning('设备验证失败', [
                'user_id' => $userid,
                'error' => $e->getMessage(),
                'trace_id' => $this->generateTraceId()
            ]);
            return $this->errorResponse(500, '系统繁忙，请稍后重试');
        }
    }
    /**
     * 检查用户权限
     * @param string $userId 用户ID
     * @param string $permission 权限标识
     * @return bool
     */
    private function checkPermission(string $userId, string $permission): bool
    {
        try {
            // 从缓存获取用户权限
            $userPermissions = Cache::get('user_permissions_' . $userId);
            if (!$userPermissions) 
            {
                // 从数据库获取用户权限
                $userPermissions = Db::name('user_permissions')
                    ->where('user_id', $userId)
                    ->column('permission');
                Cache::set('user_permissions_' . $userId, $userPermissions, self::CACHE_TIME);
            }

            return in_array($permission, $userPermissions);
        } catch (\Exception $e) {
            Log::channel('user_action')->warning('权限检查异常', [
                'user_id' => $userId,
                'permission' => $permission,
                'error' => $e->getMessage(),
                'trace_id' => $this->generateTraceId()
            ]);
            return false;
        }
    }

    /**
     * 验证密码
     * @param string $input 输入的密码
     * @param string $stored 存储的密码
     * @return bool
     */
    private function verifyPassword( string $stored, string $input): bool
    {
        try {
            Log::channel('user_action')->info("解密密码", [
                'input' => $input,
                'stored' => $stored,
            ]);
            $this->loadEncryptionKeys(); 
            $decrypted = $this->sm2->doDecrypt($stored, $this->privateKey);
            Log::channel('user_action')->info("输入密码 {$input}");
            Log::channel('user_action')->info("解密数据库密码 {$decrypted}");
 
            return hash_equals($decrypted, $input);
        } catch (\Exception $e) 
        {
            Log::channel('file')->error("SM2 解密失败: " . $e->getMessage());
            return false;
        }
    }

    private function addDevice(string $userid, array $identify)
    {
        $result = Db::name('user_history')
        ->insert([
            'user_id' => $userid,
            'device' => $identify['ua'],
            'ip' => $identify['ip'],
            'langua' => $identify['language']
        ]);
        return $result;
    }

    /**
     * 生成错误响应
     * @param int $code 错误码
     * @param string $msg 错误信息
     * @return array
     */
    private function errorResponse(int $code, string $msg): array
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'trace_id' => $this->generateTraceId(),
            'timestamp' => date('Y-m-d H:i:s'),
            'redirect_url' => (string)url('Home/index', [], true, true)
        ];
    }

    /**
     * 生成成功响应
     * @param mixed $data 响应数据
     * @return array
     */
    private function successResponse($data): array
    {
        return [
            'code' => 200,
            'msg' => 'success',
            'data' => $data,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * 生成追踪ID
     * @return string
     */
    private function generateTraceId(): string
    {
        return uniqid('trace_', true);
    }

    /**
     * 清除用户缓存
     * @param string $username 用户名
     * @return bool
     */
    public function clearUserCache(string $username): bool
    {
        try {
            Cache::delete(self::CACHE_PREFIX . $username);
            return true;
        } catch (\Exception $e) {
            Log::channel('user_action')->error('清除用户缓存失败', [
                'username' => $username,
                'error' => $e->getMessage(),
                'trace_id' => $this->generateTraceId()
            ]);
            return false;
        }
    }
}