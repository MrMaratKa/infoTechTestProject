<?php

namespace app\services;

use SMSPilot\Client;
use SMSPilot\Exception\SMSPilotException;
use SMSPilot\Request;
use yii\base\Component;

class SmsPilotService extends Component
{
    public function __construct(private string $apiKey, $config = [])
    {
        parent::__construct($config);
    }


    /**
     * Отправка SMS
     *
     * @param string $to
     * @param string $text
     * @param string $from
     * @return bool
     */
    public function send(string $to, string $text, string $from = ''): bool
    {
        $client = new Client($this->apiKey);
        $request = new Request(
            $from,
            $to,
            $text
        );

        try {
            $response = $client->send($request);
            return array_key_exists('send', $response);
        } catch (SMSPilotException) {
            return false;
        }
    }
}