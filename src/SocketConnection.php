<?php

namespace Daitsuna\AmcpClient;

use Exception;

class SocketConnection implements ConnectionInterface
{
    private $host;
    private $port;
    private $socket;
    private $connected = false;

    public function __construct($host = 'localhost', $port = 5250)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function connect()
    {
        if ($this->connected) {
            return true;
        }

        $this->socket = @fsockopen($this->host, $this->port, $errno, $errstr, 5);

        if (!$this->socket) {
            throw new Exception("Ошибка подключения: $errstr ($errno)");
        }

        $this->connected = true;
        return true;
    }

    public function disconnect(): bool
    {
        if ($this->connected && $this->socket) {
            fclose($this->socket);
            $this->connected = false;
            return true;
        }
        return false;
    }

    public function sendCommand(string $command): bool // Updated method signature
    {
        $this->connect();

        $command = trim($command) . "\r\n";
        fwrite($this->socket, $command);

        $response = '';
        while (($line = fgets($this->socket)) !== false) {
            $response .= $line;
            if (preg_match('/^\d{3} .*/', $line)) {
                break;
            }
        }

        return !empty($response); // Return a boolean as per the interface
    }
}