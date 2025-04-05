<?php
namespace app\controller;

use think\facade\Request;
use think\facade\Session;


class Article extends Controller
{
    public function save()
    {
        $data = Request::post();
        $user = Session::get("username");
        $data['user'] = $user;
        $data['time'] = time();
        $articleModel = new ArticleModel();
        $articleModel->save($data);
        return json(['message' => '发布成功']);
    }
}