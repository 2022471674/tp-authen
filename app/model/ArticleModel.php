<?php
namespace app\model;

use think\facade\Db;
use think\facade\Log;
// +----------------------------------------------------------------------
// | Title: SecHub-28.7
// +----------------------------------------------------------------------
// | Licensed: (2022471677@qq.com)
// +----------------------------------------------------------------------
// | Author: 28.7 <2022471677@qq.com>
// +----------------------------------------------------------------------
// | Last modified: 2025-04-06 16:00:00
// +----------------------------------------------------------------------
// | Main: 发现前端传来的分类id ，查询分类信息，创建或者更新分类
// +----------------------------------------------------------------------

class ArticleModel
{
    // 错误码常量定义
    const ERROR_SYSTEM = [
        1001 => '分类名称不能为空',
        1002 => '分类名称已存在',
        1003 => '添加分类失败',
        1004 => '分类ID不能为空',
        1005 => '更新分类失败',
        1006 => '该分类下存在文章,不能删除',
        1007 => '删除分类失败',
        500 => '系统错误',
        200 => '成功'
    ];
    const SUCCESS = 200;


    /**
     * 在模型层，将相应的数据插入到对应表
     * 执行插入分类表
     * 执行插入文章表
     */
    function category(array $data): array
    {
        // 开启事务
        Db::startTrans();
        try {
            // 1. 处理分类
            $categoryResult = $this->addCategory($data['category_id'], $data['category_name']);
            
            // 2. 记录日志时正确处理数组
            Log::channel("user_action")->info('分类处理结果：' . json_encode($categoryResult, JSON_UNESCAPED_UNICODE));

            // 如果分类处理失败，回滚事务并返回错误
            if ($categoryResult['code'] !== self::SUCCESS) {
                Db::rollback();
                return $categoryResult;
            }

            // 3. 准备文章数据
            $BlogData = [
                'user_id' => $data['user_id'],
                'article_id' => $data['article_id'],
                'content' => $data['content'],
                'category_id' => $data['category_id'],
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'title' => $data['title'],
            ];
            
            Log::channel("user_action")->info("文章分类-id {$data['category_id']}");
            
            // 4. 插入文章
            $insertBlog = Db::name('user_article')->insert($BlogData);

            // 如果文章插入失败，回滚事务并返回错误
            if (!$insertBlog) {
                Db::rollback();
                return [
                    'code' => self::ERROR_SYSTEM,
                    'msg' => '添加文章失败'
                ];
            }

            // 5. 提交事务
            Db::commit();

            return [
                'code' => self::SUCCESS,
                'msg' => '文章创建成功',
                'data' => [
                    'category_id' => $data['category_id'],
                    'article_id' => Db::name('user_article')->getLastInsID()
                ]
            ];

        } catch (\Exception $e) {
            // 发生异常，回滚事务
            Db::rollback();
            return [
                'code' => self::ERROR_SYSTEM,
                'msg' => '系统错误：' . $e->getMessage()
            ];
        }
    }
    /**
     * 添加文章分类
     * 
     */

    public function addCategory(string $category_id, string $category_name): array
    {
        try {
            // 1. 验证参数
            if (empty($category_id) || empty($category_name)) {
                return [
                    'code' => self::ERROR_SYSTEM,
                    'msg' => '分类ID和名称不能为空'
                ];
            }

            // 2. 查询分类是否存在
            $exists = Db::name('article_categories')
                ->where('id', $category_id)
                ->find();
                
            // 记录日志
            if ($exists) {
                Log::channel("user_action")->info("分类已存在: {$category_id}");
            } else {
                Log::channel("user_action")->info("分类不存在，将创建新分类: {$category_id}");
            }

            // 3. 如果分类已存在，直接返回成功
            if ($exists) 
            {
                return [
                    'code' => self::SUCCESS,
                    'msg' => '分类已存在',
                    'data' => $category_id
                ];
            }

            // 4. 创建新分类
            $insertData = [
                'id' => $category_id,
                'category_name' => $category_name  // 添加分类名称
            ];

            // 5. 执行插入操作
            $result = Db::name('article_categories')->insert($insertData);

            // 6. 处理插入结果
            if ($result) {
                Log::channel("user_action")->info("新分类创建成功: {$category_id}");
                return [
                    'code' => self::SUCCESS,
                    'msg' => '添加分类成功',
                    'data' => $category_id
                ];
            }
            
            Log::channel("user_action")->error("分类创建失败: {$category_id}");
            return [
                'code' => self::ERROR_SYSTEM,
                'msg' => '添加分类失败'
            ];
        } catch (\Exception $e) {
            Log::channel("user_action")->error("分类处理异常: " . $e->getMessage());
            return [
                'code' => self::ERROR_SYSTEM,
                'msg' => '系统错误：' . $e->getMessage()
            ];
        }
    }

    /**
     * 获取分类列表
     * @return array
     */
    public function getCategories(array $data): array
    {
        try {
            $categories = Db::name('article_categories')
            ->where("id",$data['category_id'])
            ->select();
            Log::channel("user_action")->info("获取分类列表{$categories}");

            if (empty($categories)) 
            {
                $addCategory = $this->addCategory($data['category_id']);
            }

            return ['code' => self::SUCCESS, 'data' => $categories];
        } catch (\Exception $e) {
            return ['code' => self::ERROR_SYSTEM, 'msg' => '系统错误:'.$e->getMessage()];
        }
    }

    /**
     * 更新分类
     * @param array $data 分类数据
     * @return array
     */
    public function updateCategory(array $data): array
    {
        try {
            if (empty($data['category_name'])) 
            {
                return $this->errorResponse(self::ERROR_EMPTY_CATEGORY_ID, '分类ID不能为空');
            }

            if (empty($data['category_name'])) 
            {
                return $this->errorResponse(self::ERROR_EMPTY_CATEGORY_NAME, '分类名称不能为空');
            }

            $exists = Db::name('article_categories')
                ->where('category_name', $data['category_name'])
                ->find();

            if ($result === false) {
                return $this->errorResponse(self::ERROR_UPDATE_CATEGORY_FAILED, '更新分类失败');
            }

            return $this->successResponse('更新分类成功');
        } catch (\Exception $e) {
            return $this->errorResponse(self::ERROR_SYSTEM, '系统错误:'.$e->getMessage());
        }
    }

    /**
     * 删除分类
     * @param int $id 分类ID
     * @return array
     */
    public function deleteCategory(int $id): array
    {
        try {
            // 检查分类下是否有文章
            $hasArticles = Db::name('article_categories')
                ->where('category_id', $id)
                ->find();

            if ($hasArticles) {
                return $this->errorResponse(self::ERROR_CATEGORY_HAS_ARTICLES, '该分类下存在文章,不能删除');
            }

            $result = Db::name('article_categories')
                ->where('id', $id)
                ->delete();

            if (!$result) {
                return $this->errorResponse(self::ERROR_DELETE_CATEGORY_FAILED, '删除分类失败');
            }

            return $this->successResponse('删除分类成功');
        } catch (\Exception $e) {
            return $this->errorResponse(self::ERROR_SYSTEM, '系统错误:'.$e->getMessage());
        }
    }

    private function errorResponse(int $code, string $msg): array
    {
        return [
            'code' => $code,
             'msg' => $msg,
             'data' => null,
             'redirect_url' => 'index/login'
            ];
    }

    private function successResponse($data): array
    {
        return [
            'code' => self::SUCCESS, 
            'data' => $data,
            'msg' => '成功',
            'redirect_url' => 'index/login'
        ];
    }
}
