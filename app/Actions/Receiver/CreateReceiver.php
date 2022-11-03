<?php

namespace App\Actions\Receiver;

use App\Models\Receiver;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateReceiver
{
    /**
     * Execute the action
     *
     * @param  User  $user
     * @param  array  $data
     * @return Receiver
     * @throws Throwable
     */
    public function execute(User $user, array $data): Receiver
    {
        return DB::transaction(fn() => $user->receivers()->create([
            'type'        => $data['type'],
            'name'        => $data['name'],
            'whatsapp_id' => $data['whatsapp_id'],
        ]));
    }
}
