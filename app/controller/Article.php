<?php
namespace app\controller;

use think\facade\Request;
use think\facade\{Session, View, Log};
use app\service\ArticleService;

class Article 
{
    function __construct()
    {
        $this->articleService = new ArticleService();
    }

    function save()
    {
        try {
            // 1. 获取请求数据
            $data = Request::post();
            
            // 2. 正确记录日志 - 使用 json_encode 转换数组
            Log::channel('user_action')->info("发布文章", [
                'data' => json_encode($data, JSON_UNESCAPED_UNICODE)
            ]);

            // 3. 调用服务处理
            $result = $this->articleService->authSave($data);

            // 4. 记录处理结果 - 同样使用 json_encode
            Log::channel('user_action')->info("发布文章结果", [
                'code' => $result['code'] ?? '',
                'msg' => $result['msg'] ?? '',
                'result' => json_encode($result, JSON_UNESCAPED_UNICODE)
            ]);

            return json($result);
            
        } catch (\Exception $e) {
            // 5. 异常日志记录
            Log::channel('user_action')->info("发布文章异常{$e->getMessage()}");
            
            return json([
                'code' => 500,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
