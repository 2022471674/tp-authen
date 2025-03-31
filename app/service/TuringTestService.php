<?php
namespace app\service;

use think\captcha\facade\Captcha;

class TuringTestService 
{
    /**
     * @param string $userkey
     */
    public function generate(string $userKey) 
    {
        return Captcha::create($userKey)->getContent(); 
    }

    /**
     * @param string $code
     * @param string $userkey 
     */
    public function verify(string $code, string $userKey) 
    {
        return Captcha::check($code, $userKey);
    }
}