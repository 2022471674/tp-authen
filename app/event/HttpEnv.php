<?php
namespace app\event;

use think\facade\Log;
class HttpEnv 
{
function envget($user) 
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'; 
    
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $this->isTrustedProxy()) 
    {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim(end($ips));
    }
    $log=filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6) 
        ? $ip 
        : '127.0.0.1';
    Log::record("用户{$user}:{$log}");
        
    }
}