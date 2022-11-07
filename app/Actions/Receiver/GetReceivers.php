<?php

namespace App\Actions\Receiver;

use App\Models\Receiver;
use App\Models\Sender;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class GetReceivers
{
    /**
     * Execute the action
     *
     * @param  Sender  $sender
     * @param  array  $data
     * @return LengthAwarePaginator
     */
    public function execute(Sender $sender, array $data): LengthAwarePaginator
    {
        $receiver = new Receiver;

        return QueryBuilder::for($receiver)
            ->allowedFields([
               'id',
               'sender_id',
               'sender.id',
               'sender.name',
               'type',
               'name',
               'whatsapp_id',
               'created_at',
                'updated_at',
            ])
            ->allowedIncludes([
                'sender',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('sender_id'),
                AllowedFilter::exact('sender.id'),
                'sender.name',
                AllowedFilter::exact('type'),
                'name',
                'whatsapp_id',
                'created_at',
                'updated_at',
                AllowedFilter::callback('global', function (Builder $query, $value) {
                    $query->where(function (Builder $query) use ($value) {
                        $query->where('name', 'LIKE', "%{$value}%")
                            ->orWhere('whatsapp_id', 'LIKE', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts([
                'id',
                'type',
                'name',
                'whatsapp_id',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at')
            ->where($receiver->qualifyColumn('sender_id'), $sender->id)
            ->with('sender:id,name')
            ->withCount('logMessages')
            ->paginate($data['perPage'] ?? 15)
            ->withQueryString();
    }
}
