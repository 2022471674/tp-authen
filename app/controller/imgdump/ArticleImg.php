<?php
namespace app\controller\imgdump;

use think\Request;
use think\Response;
use think\facade\Filesystem;
use think\exception\ValidateException;

class ArticleImg 
{
    public function index(Request $request)
    {
        try {
            // 验证CSRF令牌
            $request->checkToken();

            // 获取文件并设置验证规则
            $file = $request->file('file', null, true, [
                'size' => 5 * 1024 * 1024, // 5MB
                'ext'  => 'jpg,jpeg,png,gif,bmp,webp',
                'mime' => 'image/jpeg,image/png,image/gif,image/bmp,image/webp'
            ]);

            if (!$file) 
            {
                throw new ValidateException('文件上传失败: ' . $request->file('file')->getError());
            }

            // 生成存储路径
            $saveName = Filesystem::disk('public')->putFile('uploads', $file);
            
            // 返回可访问URL
            $fullUrl = $request->domain() . '/storage/' . $saveName;

            return json([
                'location' => $fullUrl,
                'url'      => $fullUrl,
                'title'    => $file->getOriginalName(),
                'size'     => $file->getSize()
            ]);

        } catch (\Exception $e) {
            return json([
                'error' => [
                    'code'    => $e->getCode() ?: 500,
                    'message' => $e->getMessage()
                ]
            ], 500);
        }
    }
}