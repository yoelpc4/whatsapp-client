<?php

namespace App\Actions\Receiver;

use App\Models\Receiver;
use App\Models\User;
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
     * @param  array  $data
     * @return LengthAwarePaginator
     */
    public function execute(array $data): LengthAwarePaginator
    {
        $receiver = new Receiver;

        $user = new User;

        return QueryBuilder::for($receiver)
            ->with('user:id,name')
            ->select([
                $receiver->qualifyColumn('id'),
                $receiver->qualifyColumn('user_id'),
                $receiver->qualifyColumn('type'),
                $receiver->qualifyColumn('name'),
                $receiver->qualifyColumn('whatsapp_id'),
                $receiver->qualifyColumn('created_at'),
            ])
            ->leftJoin(
                $user->getTable(),
                $receiver->user()->getQualifiedParentKeyName(),
                '=',
                $receiver->user()->getQualifiedForeignKeyName()
            )
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('user.id'),
                'user.name',
                AllowedFilter::exact('type'),
                'name',
                'whatsapp_id',
                'created_at',
                AllowedFilter::callback('global', function (Builder $query, $value) {
                    $query->where(function (Builder $query) use ($value) {
                        $query
                            ->whereHas('user', fn(Builder $query) => $query->where('name', 'LIKE', "%{$value}%"))
                            ->orWhere('name', 'LIKE', "%{$value}%")
                            ->orWhere('whatsapp_id', 'LIKE', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts([
                'id',
                AllowedSort::field('user.name', $user->qualifyColumn('name')),
                'type',
                'name',
                'whatsapp_id',
                'created_at',
            ])
            ->defaultSort('-created_at')
            ->paginate($data['perPage'] ?? 15)
            ->withQueryString();
    }
}
