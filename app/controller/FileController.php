<?php
namespace app\controller;

class FileController
{
    public function getTree()
    {
        $userId=Session::get('user.id');
        $cacheKey="file_tree_{$userId}";

        if (!Cache::has($cacheKey)) 
        {
            $tree = Db::name('virtual_file')
                ->where('user_id', $userId)
                ->whereOr('is_public', 1)
                ->field('id,parent_id,name,type,path')
                ->select()
                ->toArray();
            
            Cache::set($cacheKey, $tree, 3600);
        }
        return json([
            'code' => 200,
            'data' => $this->buildTree(Cache::get($cacheKey))
        ]);
    }

    private function buildTree($items,$parentId = '0')
    {
        $branch = [];
        foreach ($items as $item) {
            if ($item['parent_id'] == $parentId) {
                $children = $this->buildTree($items, $item['id']);
                if ($children) {
                    $item['children'] = $children;
                }
                $branch[] = $item;
            }
        }
        return $branch;
    }
}