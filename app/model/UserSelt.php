<?php
namespace app\model;

use think\facade\Config;
use Rtgm\sm\RtSm2;
use Exception;

class UserSelt
{
    private $keyConfig;

    public function __construct()
    {
        
        $this->keyConfig=[
            'privatekey'=>Config::get("pem.private"),
            'publickey'=>Config::get("pem.public")
        ];

        if (!is_dir(dirname($this->keyConfig['privatekey'])))
        {
            mkdir(dirname($this->keyConfig['privatekey']), 0755, true);
        }

        if (!file_exists($this->keyConfig['privatekey']) 
            || !file_exists($this->keyConfig['publickey'])) 
        {
        $this->generateSm2KeyPair();
        }
    }

    /**
     * function generatesm2keypair 生成sm2密钥对
     */
    private function generatesm2keypair()
    {
        try
        {
            $sm2=new RtSm2("base64",false);
            list($privateKeyHex, $publicKeyHex) = $sm2->generateKey();
        } catch (Exception $e){
            Log::channel("file")->error("密钥生成失败: " . $e->getMessage());
            throw new Exception("密钥生成失败，请检查目录权限");
        }


    }
    /**
     * function getprivatekey 获取私钥
     */
    public function getprivatekey()
    {
        return file_get_contents($this->keyConfig['privatekey']);
    }

    /**
     * function getpublickey 获取公钥
     */
    public function getPublicKey()
    {
        return file_get_contents($this->keyConfig['publickey']);
    }

}