<?php
namespace app\service;

class FileService
{
    /*
     * 当用户想要创建一个文件或者目录时，查询数据库中是否存在上级目录
     * 如果用户没有设置权限的化，初始化权限则为1
     */
    public static function createNode($userId, $data)
    {
        Db::startTrans();
        try
        {
            $fileId=uniqid('file_',true);
            $parentPath='/';
            if ($data['parent_id']!=0)
            {
                $parent=Db::name('virtual_file')
                ->where("id",$data['parent_id'])
                ->field('path,user_id')
                ->find();
                if (!$parent || $parent['user_id'] !=$userId)
                {
                    return json([
                        'code',"403",
                        'msg',"父目录不存在或者无权访问"
                    ]);
                }
                $parentPath = $parent['path'];
            }
            $fileData=[
                'id'=>$fileId,
                'parent_id'=>$data['parent_id'],
                'path'=>rtrim($parentPath,'/') . '/' .$data['name'],
                'name'=>$data['name'],
                'type'=>$data['type'],
                'is_public'=>$data['is_public'] ?? 0
            ];
            Db::name('virtual_file')->insert($fileData);
            if (!$fileData['is_public']) {
                Db::name('file_permission')->insert([
                    'id' => uniqid('perm_', true),
                    'file_id' => $fileId,
                    'user_id' => $userId,
                    'can_read' => 1,
                    'can_write' => 1
                ]);
            }
            Db::commit();
            return $fileId;
        }catch(Exception $e)
        {
            Db::rollback();
            throw $e;
        }
    }
}