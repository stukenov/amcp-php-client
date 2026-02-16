<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Daitsuna\AmcpClient\AmcpClient;

// Создаем экземпляр клиента с указанием хоста и порта
$client = new AmcpClient('localhost', 5250);

try {
    // Пример использования команды LOAD
    $loadResponse = $client->load(1, 10, 'my_clip');
    echo "LOAD Response:\n";
    print_r($loadResponse);

    // Пример использования команды PLAY
    $playResponse = $client->play(1, 10);
    echo "PLAY Response:\n";
    print_r($playResponse);

    // Пример использования команды STOP
    $stopResponse = $client->stop(1, 10);
    echo "STOP Response:\n";
    print_r($stopResponse);

    // Пример использования команды CLEAR
    $clearResponse = $client->clear(1, 10);
    echo "CLEAR Response:\n";
    print_r($clearResponse);

} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
