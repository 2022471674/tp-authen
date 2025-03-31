<?php
namespace app\listener;

use app\model\UserLoginLog;

class UserLoginListener
{
    public function handle($user)
{
    // 更新最后登录时间
    $user->last_login_time = time();
    $user->save();
    
    // 写入日志
    Log::record("用户{$user}:{$user->name}");
}
}