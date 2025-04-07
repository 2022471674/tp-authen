<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;


Route::get('api/register', 'register/index');

Route::get('api/login', 'index/index');
Route::get('login', 'index/index');
Route::get('/', 'main/login'); //首页
Route::get('login','index/index'); //登录页
Route::post('logout', 'user/logout')->name('logout');// 登出路由
Route::get('api/email', 'home/index');
Route::post('api/article/save','article/save');
Route::post('api/upload/image', 'imgdump/ArticleImg/index');
Route::post('/api/md5/encrypt', 'main/md5_encode');