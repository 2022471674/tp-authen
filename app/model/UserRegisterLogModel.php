<?php
namespace app\model;

use app\service\HttpEnv;
use think\facade\Log;

class UserRegisterLog
{

function __construct(HttpEnv $HttpEnv)
    
{
    $this->HttpEnv=new HttpEnv();
}

function env(array $data)
{
    $env = $this->httpenv->envget();
    if (!empty($env))
    {
    Log::channel('user')->info("用户注册", [
        'data' => $data,  
        'ip'   => $env,
        'ua'   => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);
    }
}
}