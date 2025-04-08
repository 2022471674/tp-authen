<?php
namespace app\model\tools;

use Rtgm\sm\RtSm2;

class Sm2CryptModel
{
    private $sm2;

    function __construct()
    {
        $this->sm2 = new RtSm2("base64",false);
    }
    
    /**
     * @param string $data 需要加密的数据
     * @param string $publicKey 公钥
     * @return string 加密后的数据
     */
    function sm2DoEncrypt($data,$publicKey)
    {
        $publicKey = $publicKey;
        return $this->sm2->doEncrypt($data,$publicKey);
    }

    /**
     * @param string $data 需要解密的数据
     * @param string $privateKey 私钥
     * @return string 解密后的数据
     */
    function sm2DoDecrypt($data,$privateKey)
    {
        $privateKey = hex2bin($privateKey);
        return $this->sm2->doDecrypt($data,$privateKey);
    }

}
