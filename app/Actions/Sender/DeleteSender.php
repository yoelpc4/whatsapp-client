<?php

namespace App\Actions\Sender;

use App\Models\Sender;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteSender
{
    /**
     * Execute the action
     *
     * @param  Sender  $sender
     * @return void
     * @throws Throwable
     */
    public function execute(Sender $sender): void
    {
        DB::transaction(fn() => $sender->forceDelete());
    }
}
