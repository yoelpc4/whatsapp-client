<?php

namespace App\Actions\Receiver;

use App\Models\Receiver;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteReceiver
{
    /**
     * Execute the action
     *
     * @param  Receiver  $receiver
     * @return void
     * @throws Throwable
     */
    public function execute(Receiver $receiver): void
    {
        DB::transaction(fn() => $receiver->delete());
    }
}
