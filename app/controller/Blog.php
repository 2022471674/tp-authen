<?php
namespace app\controller;

use think\facade\{View,Session};


class Blog
{
    public function index()
    {
        if (Session::has("user")) {
            $userid = Session::get("userid");
            $user = Session::get("user");
            $name = isset($user) ? "欢迎"." " .htmlspecialchars($user) : "欢迎用户";
            $action = url('logout'); 
        }else{
            $action = url('index/login'); 
            $name = "登录";
        }

        return View::fetch('home/index', [
            "userid" => $userid,
            "name"   => $name,
            "action" => $action
        ]);
    }
}