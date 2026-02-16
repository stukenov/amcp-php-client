<?php

namespace Daitsuna\AmcpClient;

use InvalidArgumentException;
use Daitsuna\AmcpClient\ResponseHandler;
use Daitsuna\AmcpClient\ConnectionInterface;
use Daitsuna\AmcpClient\SocketConnection;
use Daitsuna\AmcpClient\CommandInterface;
use Daitsuna\AmcpClient\Commands\LoadCommand;
use Daitsuna\AmcpClient\Commands\PlayCommand;
use Daitsuna\AmcpClient\Commands\StopCommand;
use Daitsuna\AmcpClient\Commands\ClearCommand;

class AmcpClient
{
    private $connection;
    private $responseHandler;

    public function __construct($host, $port)
    {
        $this->connection = new SocketConnection($host, $port);
        $this->responseHandler = new ResponseHandler();
    }

    public function executeCommand(CommandInterface $command)
    {
        return $command->execute($this->connection, $this->responseHandler);
    }

    public function load($channel, $layer, $clip)
    {
        $command = new LoadCommand($channel, $layer, $clip);
        return $this->executeCommand($command);
    }

    public function play($channel, $layer, $clip = '')
    {
        $command = new PlayCommand($channel, $layer, $clip);
        return $this->executeCommand($command);
    }

    public function stop($channel, $layer)
    {
        $command = new StopCommand($channel, $layer);
        return $this->executeCommand($command);
    }

    public function clear($channel, $layer)
    {
        $command = new ClearCommand($channel, $layer);
        return $this->executeCommand($command);
    }
}