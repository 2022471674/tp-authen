<?php
namespace app\validate;

use think\Validate;

class LoginValidate extends Validate
{
    protected $rule = [
        'username|用户名' => 'require|alphaDash|length:3,20',
        'password|密码'  => 'require|min:6|max:32',
    ];
    

    protected function prepareData($data)
    {
        $data['username'] = trim($data['username']);
        $data['password'] = htmlspecialchars($data['password']);
        return $data;
    }
}