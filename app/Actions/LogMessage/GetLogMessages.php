<?php

namespace App\Actions\LogMessage;

use App\Models\LogMessage;
use App\Models\Receiver;
use App\Models\Sender;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetLogMessages
{
    /**
     * Execute the action
     *
     * @param  Sender  $sender
     * @param  Receiver  $receiver
     * @param  array  $data
     * @return LengthAwarePaginator
     */
    public function execute(Sender $sender, Receiver $receiver, array $data): LengthAwarePaginator
    {
        $logMessage = new LogMessage;

        return QueryBuilder::for($logMessage)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('sender_id'),
                AllowedFilter::exact('sender.id'),
                'sender.name',
                AllowedFilter::exact('receiver_id'),
                AllowedFilter::exact('receiver.id'),
                'receiver.name',
                'message',
                AllowedFilter::exact('status'),
                'created_at',
                'sent_at',
                'failed_at',
                AllowedFilter::callback('global', function (Builder $query, $value) {
                    $query->where(function (Builder $query) use ($value) {
                        $query->where('message', 'LIKE', "%{$value}%")
                            ->orWhere('status', 'LIKE', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts([
                'id',
                'message',
                'status',
                'created_at',
                'sent_at',
                'failed_at',
            ])
            ->defaultSort('-created_at')
            ->where($logMessage->qualifyColumn('sender_id'), $sender->id)
            ->where($logMessage->qualifyColumn('receiver_id'), $receiver->id)
            ->paginate($data['perPage'] ?? 15)
            ->withQueryString();
    }
}
