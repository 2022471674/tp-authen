<?php
namespace app\service;

use think\facade\{Config, Log, Cache};
use RuntimeException;

class FileService
{
    private $conn;
    private $host;
    private $port;
    private $user;
    private $pass;

    const MAX_CONNECT_TIMEOUT = 30;
    const MAX_RETRY_CONNECT   = 3;

    public function __construct()
    {
        $this->host = Config::get("ftp.host");
        $this->port = Config::get("ftp.port");
        $this->user = Config::get("ftp.user");
        $this->pass = Config::get("ftp.pass");

        $retryCount = 0;
        $isConnected = false;

        while ($retryCount < self::MAX_RETRY_CONNECT) {
            $this->conn = ftp_connect($this->host, $this->port, self::MAX_CONNECT_TIMEOUT);
            if ($this->conn && ftp_login($this->conn, $this->user, $this->pass)) {
                ftp_pasv($this->conn, true);
                $isConnected = true;
                break;
            }
            $retryCount++;
            Log::channel("error")->info("FTP连接失败，第{$retryCount}次重试...");
            sleep(1);
        }

        if (!$isConnected) {
            Log::channel("error")->error("无法连接FTP服务器: {$this->host}:{$this->port}");
            throw new RuntimeException("FTP连接失败，请检查配置或网络状态");
        }
    }

    public function __destruct()
    {
        if ($this->conn) {
            ftp_close($this->conn);
        }
    }
}