<?php

namespace Daitsuna\AmcpClient\Commands;

use Daitsuna\AmcpClient\CommandInterface;
use Daitsuna\AmcpClient\ConnectionInterface;
use Daitsuna\AmcpClient\ResponseHandler;

class LoadCommand implements CommandInterface
{
    private $channel;
    private $layer;
    private $clip;

    public function __construct($channel, $layer, $clip)
    {
        $this->channel = $channel;
        $this->layer = $layer;
        $this->clip = $clip;
    }

    public function execute(ConnectionInterface $connection, ResponseHandler $responseHandler)
    {
        $command = "LOAD {$this->channel}-{$this->layer} {$this->clip}";
        $response = $connection->sendCommand($command);
        return $responseHandler->handleResponse($response);
    }
}