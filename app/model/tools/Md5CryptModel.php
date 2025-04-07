<?php
namespace app\model\tools;

use think\Model;

class Md5CryptModel 
{
    function md5_16($char,bool $upper)
    {
        $encrypt_char = substr(md5($char), 8, 16);
        if (isset($upper) && $upper == true)
        {
            return strtoupper($encrypt_char);
        }
        return $encrypt_char;

    }

    function md5_32($char,bool $upper)
    {
        $encrypt_char = md5($char);
        if (isset($upper) && $upper == true)
        {
            return strtoupper($encrypt_char);
        }
        return $encrypt_char;
    }
}