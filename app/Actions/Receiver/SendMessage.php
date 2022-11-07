<?php

namespace App\Actions\Receiver;

use App\Models\LogMessage;
use App\Models\Receiver;
use App\Models\Sender;
use App\Services\WhatsappService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\DB;
use Throwable;

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
     * @return void
     * @throws ConnectionException
     * @throws RequestException
     * @throws Throwable
     */
    public function execute(Sender $sender, Receiver $receiver, array $data): void
    {
        if ($receiver->isGroup()) {
            $response = $this->whatsappService->sendMessageToGroup($sender, $receiver, $data['message']);
        } else {
            $response = $this->whatsappService->sendMessageToPerson($sender, $receiver, $data['message']);
        }

        DB::transaction(function () use ($sender, $receiver, $response, $data) {
            if ($response->successful()) {
                $sender->logMessages()->create([
                    'receiver_id' => $receiver->id,
                    'message'     => $data['message'],
                    'status'      => LogMessage::STATUS_SENT,
                    'sent_at'     => now(),
                ]);

                return;
            }

            $sender->logMessages()->create([
                'receiver_id' => $receiver->id,
                'message'     => $data['message'],
                'status'      => LogMessage::STATUS_FAILED,
                'failed_at'   => now(),
            ]);
        });
    }
}
