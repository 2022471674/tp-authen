<?php
namespace app\model;

use think\facade\{Cache, Log, Session};
use Exception;

class CodeModel 
{
    public const CODE_EXPIRE = 1800; // 30分钟
    public const MAX_ATTEMPTS = 2000;    // 最大尝试次数
    public const RATE_LIMIT_DURATION = 3600; // 频率限制时长

    /**
     * 生成并存储验证码
     */
    public function getCode(string $userIdentifier): string 
    {
        try {
            $this->checkRequestRate('code_gen', $userIdentifier);

            $code = $this->generateSecureCode(6);
            $this->storeCode($code, $userIdentifier);//vc+sha256生成的验证码

            Log::channel("captcha")->info("info", [
                "user" => $userIdentifier,
                "code" => $code
            ]);
            return $code;
        } catch (Exception $e) {
            Log::channel("captcha")->error("Captcha error", [
                "user"  => $userIdentifier,
                "error" => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * 验证验证码
     */
    public function validateCode(string $inputCode, string $userkey): bool
    {
        try {
            $storedCode = $this->getStoredCode($userkey);
            $result = hash_equals($storedCode, trim($inputCode));
            
            Log::channel("captcha")->info("验证码验证", [
                "userkey" => $userkey,
                "input" => $inputCode,
                "result" => $result
            ]);
            
            return $result;
        } catch (Exception $e) {
            Log::channel("captcha")->error("验证失败", [
                "userkey"  => $userkey,
                "error" => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * 获取存储的验证码
     */
    private function getStoredCode(string $userkey): string
    {
        $cacheKey = $this->generateCacheKey($userkey);
        $code = Cache::get($cacheKey, '');
        if (empty($code)) {
            throw new Exception("验证码不存在或已过期");
        }
        return $code;
    }

    /**
     * 请求频率限制
     */
    private function checkRequestRate(string $type, string $userIdentifier): void
    {
        $cacheKey = "rate_limit_{$type}_{$userIdentifier}";
        $count = Cache::get($cacheKey, 0);

        if ($count >= self::MAX_ATTEMPTS) {
            throw new Exception("操作频繁，请稍后再试");
        }

        Cache::set($cacheKey, $count + 1, self::RATE_LIMIT_DURATION);
    }

    /**
     * 生成高安全验证码
     */
    private function generateSecureCode(int $length): string
    {
        $chars = '346789abcdefgyjkmbuvwsyz';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $chars[random_int(0, strlen($chars)-1)];
        }
        return $code;
    }

    /**
     * 存储验证码
     */
    private function storeCode(string $code, string $userIdentifier): void
    {
        $cacheKey = $this->generateCacheKey($userIdentifier);
        if (!Cache::set($cacheKey, $code, self::CODE_EXPIRE)) {
            throw new Exception("验证码存储失败");
        }
    }

    /**
     * 生成缓存键
     */
    private function generateCacheKey(string $userkey): string
    {
        return 'vc_' . hash('sha256', $userkey);
    }

    /**
     * 生成验证码
     */
    public function generateCode(string $email, string $userkey): string
    {
        try {
            $this->checkRequestRate('code_gen', $userkey);

            $code = $this->generateSecureCode(6);
            $this->storeCode($code, $userkey);

            Log::channel("captcha")->info("验证码生成成功", [
                "email" => $email,
                "userkey" => $userkey,
                "code" => $code
            ]);
            return $code;
        } catch (Exception $e) {
            Log::channel("captcha")->error("验证码生成异常", [
                "email" => $email,
                "userkey" => $userkey,
                "error" => $e->getMessage()
            ]);
            throw $e;
        }
    }
  


}