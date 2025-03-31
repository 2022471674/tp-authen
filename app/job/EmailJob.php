<?php
namespace app\job;

use think\queue\Job;
use app\service\EmailService;
use think\facade\Log;


class EmailJob
{
    public $max_attempt = 20000;
    public function fire(Job $job, array $data)
    {
        try {
            if (empty($data['email']) || empty($data['userkey'])) {
                throw new \Exception("邮件数据不完整");
            }

            $title = $data['title'] ?? 'register';
            
            $emailService = new EmailService();
            $result = $emailService->sendQmail($data, $title);

            if ($result['code'] === 200) 
            {
                $job->delete();
                Log::debug("邮件发送成功", ['email' => $data['email']]);
            } else {
                if ($job->attempts() >= $this->max_attempt) {
                    Log::error("邮件发送已达最大重试次数 | 用户: {$data['email']}");
                    $job->delete();
                } else {
                    $job->release(60);
                    Log::warning("邮件发送失败，将在60秒后重试", ['email' => $data['email'], 'attempt' => $job->attempts()]);
                }
            }
        } catch (\Exception $e) {
            Log::error("邮件任务异常: {$e->getMessage()}", ['email' => $data['email'] ?? 'unknown']);
            $job->release(300); // 5分钟后重试
        }
    }

    public function push(string $email, string $userkey)
    {
        try {
            $data = [
                'email' => $email, 
                'title' => 'register',
                'userkey' => $userkey
            ];
            \think\facade\Queue::push('app\job\EmailJob@fire', $data);
            Log::debug("邮件任务已加入队列", ['email' => $email, 'userkey' => $userkey]);
            return true;
        } catch (\Exception $e) {
            Log::error("邮件任务入队失败: {$e->getMessage()}");
            return false;
        }
    }
}