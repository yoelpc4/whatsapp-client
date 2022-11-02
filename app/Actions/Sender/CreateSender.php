<?php

namespace App\Actions\Sender;

use App\Models\Sender;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateSender
{
    /**
     * Execute the action
     *
     * @param  User  $user
     * @param  array  $data
     * @return Sender
     * @throws Throwable
     */
    public function execute(User $user, array $data): Sender
    {
        return DB::transaction(fn() => $user->senders()->create([
            'name'  => $data['name'],
            'phone' => $data['phone'],
        ]));
    }
}
