<?php

namespace App\Policies;

use App\Models\Receiver;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReceiverPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @param  Sender  $sender
     * @return Response|bool
     */
    public function viewAny(User $user, Sender $sender): Response|bool
    {
        return $sender->user_id === $user->id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Receiver  $receiver
     * @param  Sender  $sender
     * @return Response|bool
     */
    public function view(User $user, Receiver $receiver, Sender $sender): Response|bool
    {
        return $receiver->sender_id === $sender->id && $sender->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @param  Sender  $sender
     * @return Response|bool
     */
    public function create(User $user, Sender $sender): Response|bool
    {
        return $sender->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Receiver  $receiver
     * @param  Sender  $sender
     * @return Response|bool
     */
    public function update(User $user, Receiver $receiver, Sender $sender): Response|bool
    {
        return $receiver->sender_id === $sender->id && $sender->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Receiver  $receiver
     * @param  Sender  $sender
     * @return Response|bool
     */
    public function delete(User $user, Receiver $receiver, Sender $sender): Response|bool
    {
        return $receiver->sender_id === $sender->id && $sender->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Receiver  $receiver
     * @param  Sender  $sender
     * @return Response|bool
     */
    public function restore(User $user, Receiver $receiver, Sender $sender): Response|bool
    {
        return $receiver->sender_id === $sender->id && $sender->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Receiver  $receiver
     * @param  Sender  $sender
     * @return Response|bool
     */
    public function forceDelete(User $user, Receiver $receiver, Sender $sender): Response|bool
    {
        return $receiver->sender_id === $sender->id && $sender->user_id === $user->id;
    }
}
