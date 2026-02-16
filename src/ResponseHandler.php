<?php

namespace Daitsuna\AmcpClient;

use Exception;

class ResponseHandler
{
    public function parseResponse($response)
    {
        $lines = explode("\r\n", $response);
        $statusLine = array_shift($lines);

        if (preg_match('/^(\d{3}) (.*)/', $statusLine, $matches)) {
            $statusCode = intval($matches[1]);
            $statusMessage = $matches[2];
        } else {
            $statusCode = 0;
            $statusMessage = 'Неизвестный ответ';
        }

        $data = implode("\n", $lines);

        return [
            'statusCode'    => $statusCode,
            'statusMessage' => $statusMessage,
            'data'          => trim($data),
        ];
    }

    public function handleResponse($response)
    {
        $parsedResponse = $this->parseResponse($response);
        $statusCode = $parsedResponse['statusCode'];
        $statusMessage = $parsedResponse['statusMessage'];

        switch ($statusCode) {
            case 100:
            case 101:
                // Information about an event
                break;
            case 200:
            case 201:
            case 202:
                // Successful execution
                break;
            case 400:
                throw new Exception("ERROR: Command not understood. {$statusMessage}");
            case 401:
                throw new Exception("ERROR: Illegal video_channel. {$statusMessage}");
            case 402:
                throw new Exception("ERROR: Parameter missing. {$statusMessage}");
            case 403:
                throw new Exception("ERROR: Illegal parameter. {$statusMessage}");
            case 404:
                throw new Exception("ERROR: Media file not found. {$statusMessage}");
            case 500:
                throw new Exception("FAILED: Internal server error. {$statusMessage}");
            case 501:
                throw new Exception("FAILED: Internal server error. {$statusMessage}");
            case 502:
                throw new Exception("FAILED: Media file unreadable. {$statusMessage}");
            case 503:
                throw new Exception("FAILED: Access error. {$statusMessage}");
            default:
                if ($statusCode >= 400) {
                    throw new Exception("Ошибка: {$statusMessage}");
                }
                break;
        }

        return $parsedResponse;
    }
}