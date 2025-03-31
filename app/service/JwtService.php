<?php
namespace app\service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use think\facade\Config;
use think\facade\Db;
use Exception;

class JwtService {
    private $secretKey; 
    
    public function __construct() {
        $this->secretKey = env('JWT_SECRET', '');
        if (empty($this->secretKey)) {
            throw new Exception('JWT_SECRET 未配置');
        }
    }

    public function JTWgenerateToken(array $data, $expireHours = 24) 
    {
        if (!Config::has('jwt')) {
            throw new Exception('JWT配置缺失');
        }

        $payload = [
            "iss" => Config::get("jwt.iss"), // 签发者
            "iat" => time(),                // 动态生成签发时间
            "exp" => time() + $expireHours * 3600,
            "vscode" => $data['code'],
            "attempts" => $data['attempts']
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }
}