<?php

namespace App\Actions\Receiver;

use App\Models\Sender;
use App\Services\WhatsappService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class GetGroups
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
     * @return array
     * @throws ConnectionException
     * @throws RequestException
     */
    public function execute(Sender $sender): array
    {
        $response = $this->whatsappService->getGroups($sender);

        return $response->json();
    }
}
