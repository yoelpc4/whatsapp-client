<?php

namespace App\Actions\Sender;

use App\Models\Sender;
use App\Services\WhatsappService;
use Illuminate\Http\Client\RequestException;

class LinkDevice
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
     * @return string
     * @throws RequestException
     */
    public function execute(Sender $sender): string
    {
        $response = $this->whatsappService->createSession($sender->phone);

        return $response->json('data.qrCodeDataUrl');
    }
}
