<?php

namespace App\Actions\Sender;

use App\Models\Sender;
use App\Services\WhatsappService;
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
     * @throws Throwable
     */
    public function execute(Sender $sender): void
    {
        DB::transaction(function() use ($sender) {
            $this->whatsappService->deleteSession($sender->phone);

            $sender->delete();
        });
    }
}
