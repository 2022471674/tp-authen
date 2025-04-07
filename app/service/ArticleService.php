<?php
namespace app\service;

use app\model\ArticleModel;
use think\facade\{Cache, Log, Session};

class ArticleService
{
    const ERROR_CODES = [
        1001 => '分类名称不能为空',
        1002 => '分类名称已存在',
        1003 => '添加分类失败',
        1004 => '分类ID不能为空',
        1005 => '更新分类失败',
        1006 => '该分类下存在文章,不能删除',
        1007 => '删除分类失败',
        1008 => '用户ID不能为空',
        1009 => '文章标题不能为空',
        1010 => '文章内容不能为空',
        1011 => '分类信息不能为空',
        500 => '系统错误',
        200 => '成功'
    ];

    const SUCCESS_URL  = "main/login";
    const ERROR_URL    = "index/login";

    /**
     * 构造函数
     */
    function __construct()
    {
        $this->articleModel = new ArticleModel();
    }

    /**
     * 添加分类
     * @param array $data 分类数据
     * @return array
     */
    public function authSave($data)
    {
        try{
            // 验证用户是否登录
            $userid = Session::get("userid");
            if (empty($userid))
            {
                return $this->errorResponse(1008, '用户不能为空,请登录后尝试');
            }
            
            // 验证必要数据
            if (empty($data['title'])) {
                return $this->errorResponse(1009, '文章标题不能为空');
            }
            
            if (empty($data['content'])) {
                return $this->errorResponse(1010, '文章内容不能为空');
            }
            
            if (empty($data['category_id']) || empty($data['category_name'])) {
                return $this->errorResponse(1011, '分类信息不能为空');
            }
            
            // 生成文章ID
            $data['article_id'] = base64_encode($userid.time());
            $data['user_id'] = $userid;
            
            // 调用模型处理分类和文章保存（使用事务）
            $result = $this->articleModel->category($data);
            
            // 记录日志
            Log::channel("user_action")->info("添加文章结果", ['result' => json_encode($result, JSON_UNESCAPED_UNICODE)]);
            
            // 检查结果
            if (is_array($result) && isset($result['code'])) {
                if ($result['code'] == 200) {
                    return $this->successResponse(200, '文章发布成功');
                } else {
                    $errorMsg = isset($result['msg']) ? $result['msg'] : '文章发布失败';
                    Log::channel("user_action")->error("文章发布失败", ['result' => json_encode($result, JSON_UNESCAPED_UNICODE)]);
                    return $this->errorResponse(1003, $errorMsg);
                }
            } else {
                Log::channel("user_action")->error("文章发布失败 - 结果格式不正确", ['result' => json_encode($result, JSON_UNESCAPED_UNICODE)]);
                return $this->errorResponse(500, '系统错误：结果格式不正确');
            }
        } catch (\Exception $e) {
            Log::channel("user_action")->error("文章发布异常: " . $e->getMessage());
            return $this->errorResponse(500, '系统错误: ' . $e->getMessage());
        }
    }

    private function errorResponse($code, $message, $url = self::ERROR_URL) 
    {
        return [
            'status' => 'error',
            'code'   => $code,
            'msg'    => $message,
            'url'    => $url,
            'data'   => null
        ];
    }

    private function successResponse($code, $message, $url = self::SUCCESS_URL) 
    {
        return [
            'status' => 'success',
            'code'   => $code,
            'msg'    => $message,
            'url'    => $url,
            'data'   => null
        ];
    }
}
