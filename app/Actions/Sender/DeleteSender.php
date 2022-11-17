<?php

namespace App\Actions\Sender;

use App\Models\Sender;
use App\Services\WhatsappService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteSender
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
     * @return void
     * @throws ConnectionException
     * @throws RequestException
     * @throws Throwable
     */
    public function execute(Sender $sender): void
    {
        DB::transaction(function() use ($sender) {
            $sender->delete();
        });

        $this->whatsappService->deleteSession($sender);
    }
}
