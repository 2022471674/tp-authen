<?php
namespace app\service;

class FileAuth
{
    public function handle($request, $next)
    {
        $fileId = $request->param('id');
        $user = Session::get('user');

        // 获取文件信息
        $file = Db::name('virtual_file')
            ->where('id', $fileId)
            ->field('user_id,is_public,path')
            ->find();

        // 公开资源直接放行
        if ($file['is_public']) {
            return $next($request);
        }

        // 所有者检查
        if ($file['user_id'] == $user['id']) {
            return $next($request);
        }

        // 路径权限验证
        $pathSegments = explode('/', trim($file['path'], '/'));
        $currentPath = '';
        foreach ($pathSegments as $segment) {
            $currentPath .= '/' . $segment;
            $dir = Db::name('virtual_file')
                ->where('path', $currentPath)
                ->field('is_public')
                ->find();
            if (!$dir || !$dir['is_public']) {
                break;
            }
        }

        // 详细权限验证
        $hasPermission = Db::name('file_permission')
            ->where('file_id', $fileId)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user['id'])
                      ->whereOr('role', $user['role']);
            })
            ->where('can_read', 1)
            ->count();

        if (!$hasPermission) {
            return json(['code' => 403, 'msg' => '无访问权限']);
        }

        return $next($request);
    }
}