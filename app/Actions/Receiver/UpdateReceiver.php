<?php

namespace App\Actions\Receiver;

use App\Models\Receiver;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateReceiver
{
    /**
     * Execute the action
     *
     * @param  Receiver  $receiver
     * @param  array  $data
     * @return Receiver
     * @throws Throwable
     */
    public function execute(Receiver $receiver, array $data): Receiver
    {
        return DB::transaction(fn() => tap($receiver)->update([
            'type'        => $data['type'],
            'name'        => $data['name'],
            'whatsapp_id' => $data['whatsapp_id'],
        ]));
    }
}
