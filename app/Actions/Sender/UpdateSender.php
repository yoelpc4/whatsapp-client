<?php

namespace App\Actions\Sender;

use App\Models\Sender;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateSender
{
    /**
     * Execute the action
     *
     * @param  Sender  $sender
     * @param  array  $data
     * @return Sender
     * @throws Throwable
     */
    public function execute(Sender $sender, array $data): Sender
    {
        return DB::transaction(fn() => tap($sender)->update([
            'name'  => $data['name'],
            'phone' => $data['phone'],
        ]));
    }
}
