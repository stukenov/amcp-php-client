<?php

namespace Daitsuna\AmcpClient\Commands;

use Daitsuna\AmcpClient\CommandInterface;
use Daitsuna\AmcpClient\ConnectionInterface;
use Daitsuna\AmcpClient\ResponseHandler;
    
class ClearCommand implements CommandInterface
{
    private $channel;
    private $layer;

    public function __construct($channel, $layer)
    {
        $this->channel = $channel;
        $this->layer = $layer;
    }

    public function execute(ConnectionInterface $connection, ResponseHandler $responseHandler)
    {
        $command = "CLEAR {$this->channel}-{$this->layer}";
        $response = $connection->sendCommand($command);
        return $responseHandler->handleResponse($response);
    }
}