<?php

namespace App\Actions\Receiver;

use App\Models\Receiver;
use App\Models\Sender;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateReceiver
{
    /**
     * Execute the action
     *
     * @param  Sender  $sender
     * @param  array  $data
     * @return Receiver
     * @throws Throwable
     */
    public function execute(Sender $sender, array $data): Receiver
    {
        return DB::transaction(fn() => $sender->receivers()->create([
            'type'        => $data['type'],
            'name'        => $data['name'],
            'whatsapp_id' => $data['whatsapp_id'],
        ]));
    }
}
