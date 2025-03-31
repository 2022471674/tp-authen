<?php
namespace app\controller;

use app\BaseController;
use think\facade\{Request, Log, Db};
use app\model\UserInfoModel;

class UserInfo extends BaseController
{
    /**
     * 处理用户信息
     */
    public function handleInfo()
    {
        try {
            $data = Request::post();
            
            // 检查是否同意协议
            if (!isset($data['agreement_accepted']) || !$data['agreement_accepted']) {
                return json([
                    'code' => 403,
                    'msg' => '请先同意用户协议'
                ]);
            }
            
            // 获取真实IP
            $ip = $this->getRealIp();
            
            // 获取用户代理信息
            $userAgent = Request::header('user-agent');
            
            // 解析用户代理
            $uaInfo = $this->parseUserAgent($userAgent);
            
            // 合并信息
            $userInfo = array_merge($data, [
                'ip' => $ip,
                'ip_location' => $this->getIpLocation($ip),
                'browser' => $uaInfo['browser'],
                'browser_version' => $uaInfo['version'],
                'os' => $uaInfo['os'],
                'device' => $uaInfo['device'],
                'agreement_accepted' => true,
                'agreement_accepted_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            // 保存到数据库
            $model = new UserInfoModel();
            $model->save($userInfo);
            
            return json([
                'code' => 200,
                'msg' => 'success'
            ]);
            
        } catch (\Exception $e) {
            Log::error('用户信息处理失败: ' . $e->getMessage());
            return json([
                'code' => 500,
                'msg' => '系统错误'
            ]);
        }
    }
    
    /**
     * 获取真实IP
     */
    private function getRealIp()
    {
        $ip = Request::server('REMOTE_ADDR');
        
        // 检查代理IP
        if (Request::server('HTTP_X_FORWARDED_FOR')) {
            $ips = explode(',', Request::server('HTTP_X_FORWARDED_FOR'));
            $ip = trim($ips[0]);
        }
        
        return $ip;
    }
    
    /**
     * 解析用户代理
     */
    private function parseUserAgent($userAgent)
    {
        $result = [
            'browser' => 'Unknown',
            'version' => 'Unknown',
            'os' => 'Unknown',
            'device' => 'Unknown'
        ];
        
        // 解析浏览器
        if (preg_match('/Chrome\/([0-9.]+)/', $userAgent, $matches)) {
            $result['browser'] = 'Chrome';
            $result['version'] = $matches[1];
        } elseif (preg_match('/Firefox\/([0-9.]+)/', $userAgent, $matches)) {
            $result['browser'] = 'Firefox';
            $result['version'] = $matches[1];
        } elseif (preg_match('/Safari\/([0-9.]+)/', $userAgent, $matches)) {
            $result['browser'] = 'Safari';
            $result['version'] = $matches[1];
        } elseif (preg_match('/Edge\/([0-9.]+)/', $userAgent, $matches)) {
            $result['browser'] = 'Edge';
            $result['version'] = $matches[1];
        }
        
        // 解析操作系统
        if (preg_match('/Windows NT ([0-9.]+)/', $userAgent, $matches)) {
            $result['os'] = 'Windows ' . $matches[1];
        } elseif (preg_match('/Macintosh/', $userAgent)) {
            $result['os'] = 'MacOS';
        } elseif (preg_match('/Linux/', $userAgent)) {
            $result['os'] = 'Linux';
        }
        
        // 解析设备类型
        if (preg_match('/Mobile/', $userAgent)) {
            $result['device'] = 'Mobile';
        } elseif (preg_match('/Tablet/', $userAgent)) {
            $result['device'] = 'Tablet';
        } else {
            $result['device'] = 'Desktop';
        }
        
        return $result;
    }
    
    /**
     * 获取IP地理位置
     */
    private function getIpLocation($ip)
    {
        try {
            // 使用IP-API服务获取地理位置
            $response = file_get_contents("http://ip-api.com/json/{$ip}");
            $data = json_decode($response, true);
            
            if ($data && $data['status'] === 'success') {
                return [
                    'country' => $data['country'],
                    'region' => $data['regionName'],
                    'city' => $data['city'],
                    'isp' => $data['isp']
                ];
            }
        } catch (\Exception $e) {
            Log::error('IP地理位置获取失败: ' . $e->getMessage());
        }
        
        return [
            'country' => 'Unknown',
            'region' => 'Unknown',
            'city' => 'Unknown',
            'isp' => 'Unknown'
        ];
    }
} 