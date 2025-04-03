<?php
namespace app\controller;

use think\facade\{View, Session,Log};

class Main
{
    /**
     * function login "/" 路由下的内容渲染
     */
    function login()
    {
        if (!Session::has("userid"))
        {
            $userid = 'null';
            $name = '登录';
            $action = url('api/login');
        }else{
            $userid = md5(Session::get("userid"));
            $user = Session::get("user");
            $name = isset($user) ? "欢迎"." " .htmlspecialchars($user) : "欢迎用户";
            $action = url('logout'); 
        }
        return View::fetch('home/index', [
            "userid" => $userid,
            "name"   => $name,
            "action" => $action
        ]);
    }

    /**
     * 阅读文章
     */
    function read()
    {
        return View::fetch('home/read/single');
    }

    /**
     * 发布文章
     */
    function edit()
    {
        return View::fetch('publish/edit');
    } 

    /**
     * ctf工具
     */
    function md5_encode()
    {
        return View::fetch('md5/index');
    }

    /**
     * 用户配置中心
     */
    function setting()
    {
        return View::fetch('home/setting/setting');
    }
}


    