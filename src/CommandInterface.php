<?php

namespace Daitsuna\AmcpClient;

use Daitsuna\AmcpClient\ConnectionInterface;
use Daitsuna\AmcpClient\ResponseHandler;

interface CommandInterface
{
    public function execute(ConnectionInterface $connection, ResponseHandler $responseHandler);
}