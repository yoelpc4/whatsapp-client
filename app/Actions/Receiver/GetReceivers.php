<?php

namespace App\Actions\Receiver;

use App\Models\Receiver;
use App\Models\Sender;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
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
            ->with('sender:id,name')
            ->select([
                $receiver->qualifyColumn('id'),
                $receiver->qualifyColumn('sender_id'),
                $receiver->qualifyColumn('type'),
                $receiver->qualifyColumn('name'),
                $receiver->qualifyColumn('whatsapp_id'),
                $receiver->qualifyColumn('created_at'),
            ])
            ->leftJoin(
                $sender->getTable(),
                $receiver->sender()->getQualifiedParentKeyName(),
                '=',
                $receiver->sender()->getQualifiedForeignKeyName()
            )
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('sender_id'),
                AllowedFilter::exact('sender.id'),
                'sender.name',
                AllowedFilter::exact('type'),
                'name',
                'whatsapp_id',
                'created_at',
                AllowedFilter::callback('global', function (Builder $query, $value) {
                    $query->where(function (Builder $query) use ($value) {
                        $query->where('name', 'LIKE', "%{$value}%")
                            ->orWhere('whatsapp_id', 'LIKE', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts([
                'id',
                AllowedSort::field('sender.name', $sender->qualifyColumn('name')),
                'type',
                'name',
                'whatsapp_id',
                'created_at',
            ])
            ->defaultSort('-created_at')
            ->where($receiver->qualifyColumn('sender_id'), $sender->id)
            ->paginate($data['perPage'] ?? 15)
            ->withQueryString();
    }
}
