<?php
namespace app\event;

use app\model\UserRegisterLog;
use think\facade\Log;

class UserRegisterEvent
{
    protected $userRegisterLog;

    // 依赖注入
    public function __construct(UserRegisterLog $userRegisterLog)
    {
        $this->userRegisterLog = $userRegisterLog;
    }

    /**
     * 记录用户注册日志
     * @param array $data 用户数据
     */
    public function handle(array $data)
    {
        try {
            // 数据校验
            if (empty($data['username'])  || empty($data['password']) || empty($data['email'])  || empty($data['phone']) )
            {
                throw new \InvalidArgumentException("缺少必要日志参数");
            }

            
            $result = $this->userRegisterLog->env($data ??'null');
            
            if (!$result) 
            {
                Log::error("用户注册日志写入失败：" . json_encode($data));
            }
        } catch (\Exception $e) {
            Log::error("事件处理异常：" . $e->getMessage());
        }
    }
}