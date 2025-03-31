<?php
namespace app\validate;

use app\model\UserRegisterLog;
class RegisterUserdate
{
    protected $rules = [
                'email' => 'regex:/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
                'username' => 'require|alphaDash|length:6,20',
                'password' => 'require|min:8|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/',
                'mobile' => 'require|regex:/^1[3-9]\d{9}$/',
                'ip' => 'require|ip',
                'userAgent' => 'require|max:255',
                'language' => 'require|regex:/^[a-z]{2}(-[a-z]{2})?$/'
            ];
                
    function check(array $data)
    {
        if (isset($data['username'])) 
        {
            $data['username'] = preg_replace('/[^\w]/', '', $data['username']);
        }
        
        if (isset($data['email'])) 
        {
            $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        }
    
        if (isset($data['phone'])) 
        {
            $data['phone'] = preg_replace('/[^0-9]/', '', $data['phone']);
        }


        if (isset($data['ip'])) 
        {
            $data['ip'] = filter_var($data['ip'], FILTER_VALIDATE_IP);
            if (!$data['ip']) {
                throw new \Exception('无效的IP地址');
            }
        }


        if (isset($data['userAgent'])) 
        {
            $data['userAgent'] = htmlspecialchars($data['userAgent'], ENT_QUOTES, 'UTF-8');
            $data['userAgent'] = substr($data['userAgent'], 0, 255);
        }


        if (isset($data['language'])) 
        {
            $data['language'] = strtolower($data['language']);
            $data['language'] = preg_replace('/[^a-z-]/', '', $data['language']);
            if (!preg_match('/^[a-z]{2}(-[a-z]{2})?$/', $data['language'])) {
                throw new \Exception('无效的语言代码格式，应为类似 zh-cn 的格式');
            }
        }

        return $data;
    }
    
}