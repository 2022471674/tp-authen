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

/**
 * @注册路由
 */
Route::get('api/register', 'register/index');
/**
 * @登录路由
 */
Route::get('api/login', 'index/index');
Route::get('login', 'index/index');
/**
 * @主页面渲染
 */
Route::get('/', 'main/login'); 
/**
 * @登录路由
 */
Route::get('login','index/index'); 
/**
 * @登出路由
 */
Route::post('logout', 'user/logout')->name('logout');
/**
 * @处理文章路由
 */
Route::post('api/article/save','article/save');
Route::post('api/upload/image', 'imgdump/ArticleImg/index');
/**
 * @加密工具路由
 */
Route::post('api/md5/encrypt', 'main/md5_encode');
Route::post('api/sm2/sm2_encrypt', 'main/sm2_encrypt');