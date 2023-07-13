<?php

namespace App\Helper;

class ApiMessage {
    private $message = [];

    public function __construct(string $message, array $data = [])
    {
        $this->message['message'] = $message;
        $this->message['errors'] = $data;
    }

    public function sendMessage()
    {
        return $this->message;
    }
}
