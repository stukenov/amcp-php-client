<?php

namespace Daitsuna\AmcpClient;

use PHPUnit\Framework\TestCase;
use Daitsuna\AmcpClient\ConnectionInterface;
use Daitsuna\AmcpClient\ResponseHandler;
use Daitsuna\AmcpClient\CommandInterface;
use Daitsuna\AmcpClient\Commands\PlayCommand;
use Daitsuna\AmcpClient\Commands\StopCommand;
use Daitsuna\AmcpClient\Commands\ClearCommand;

class AmcpClientTest extends TestCase
{
    private $client;
    private $mockConnection;
    private $mockResponseHandler;

    protected function setUp(): void
    {
        $this->mockConnection = $this->createMock(ConnectionInterface::class);
        $this->mockResponseHandler = $this->createMock(ResponseHandler::class);
        $this->client = new AmcpClient('localhost', 5250);
    }

    public function testLoadCommand()
    {
        $this->mockConnection->expects($this->once())
            ->method('sendCommand')
            ->with($this->stringContains('LOAD 1-10 my_clip'))
            ->willReturn('200 OK');

        $this->mockResponseHandler->expects($this->once())
            ->method('handleResponse')
            ->with('200 OK')
            ->willReturn(['statusCode' => 200, 'statusMessage' => 'OK', 'data' => '']);

        $response = $this->client->load(1, 10, 'my_clip');
        $this->assertEquals(200, $response['statusCode']);
    }

    public function testPlayCommand()
    {
        $this->mockConnection->expects($this->once())
            ->method('sendCommand')
            ->with($this->stringContains('PLAY 1-10'))
            ->willReturn('200 OK');

        $this->mockResponseHandler->expects($this->once())
            ->method('handleResponse')
            ->with('200 OK')
            ->willReturn(['statusCode' => 200, 'statusMessage' => 'OK', 'data' => '']);

        $response = $this->client->play(1, 10);
        $this->assertEquals(200, $response['statusCode']);
    }

    public function testStopCommand()
    {
        $this->mockConnection->expects($this->once())
            ->method('sendCommand')
            ->with($this->stringContains('STOP 1-10'))
            ->willReturn('200 OK');

        $this->mockResponseHandler->expects($this->once())
            ->method('handleResponse')
            ->with('200 OK')
            ->willReturn(['statusCode' => 200, 'statusMessage' => 'OK', 'data' => '']);

        $response = $this->client->stop(1, 10);
        $this->assertEquals(200, $response['statusCode']);
    }

    public function testClearCommand()
    {
        $this->mockConnection->expects($this->once())
            ->method('sendCommand')
            ->with($this->stringContains('CLEAR 1-10'))
            ->willReturn('200 OK');

        $this->mockResponseHandler->expects($this->once())
            ->method('handleResponse')
            ->with('200 OK')
            ->willReturn(['statusCode' => 200, 'statusMessage' => 'OK', 'data' => '']);

        $response = $this->client->clear(1, 10);
        $this->assertEquals(200, $response['statusCode']);
    }
}