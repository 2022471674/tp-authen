<?php

// +----------------------------------------------------------------------
// | 日志设置
// +----------------------------------------------------------------------
return [
    'default' => 'file', 

    'channels' => [
        // 系统运行日志（错误日志独立）
        'file'          => [
            'type'              => 'File',
            'path'              => app()->getRuntimePath() . 'log/system/',
            'single'            => false,
            'apart_level'       => ['error'], // 错误日志分离
            'max_files'         => 30,
            'json'              => true,  // 关闭JSON
            'realtime_write'    => false
        ],

        // 验证码日志（延长保留周期）
        // config/log.php
        'captcha'       => [
            'type'              => 'File',  // 改用 File 驱动
            'path'              => app()->getRuntimePath() . 'log/captcha/',
            'level'             => ['info', 'error'],
            'apart_level'       => ['error'],
            'max_files'         => 30,
            'single'            => false,  // 启用日期分割
            'json'              => true
        ],
        'user_action'   => [
            'type'              => 'File',  // 统一使用 File 驱动
            'path'              => app()->getRuntimePath() . 'log/action/',
            'single'            => false,
            'apart_level'       => ['error','warning'],
            'max_files'         => 90,
            'json'              => true,
            'realtime_write'    => false
        ]
    ]
];
