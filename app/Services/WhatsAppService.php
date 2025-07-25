<?php
namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function send($to, $message)
    {
        return $this->client->messages->create(
            "whatsapp:".$to,
            [
                "from" => "whatsapp:".config('services.twilio.whatsapp_from'),
                "body" => $message
            ]
        );
    }
}