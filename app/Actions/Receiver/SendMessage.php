<?php

namespace App\Actions\Receiver;

use App\Models\Receiver;
use App\Models\Sender;
use App\Services\WhatsappService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class SendMessage
{
    private WhatsappService $whatsappService;

    /**
     * Create a new action
     *
     * @param  WhatsappService  $whatsappService
     */
    public function __construct(WhatsappService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Execute the action
     *
     * @param  Sender  $sender
     * @param  Receiver  $receiver
     * @param  array  $data
     * @return string
     * @throws ConnectionException
     * @throws RequestException
     */
    public function execute(Sender $sender, Receiver $receiver, array $data): string
    {
        if ($receiver->isPerson()) {
            $this->whatsappService->sendMessageToPerson($sender, $receiver, $data['message']);
        } else if ($receiver->isGroup()) {
            $this->whatsappService->sendMessageToGroup($sender, $receiver, $data['message']);
        }
    }
}
