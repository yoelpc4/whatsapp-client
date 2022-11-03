<?php

namespace App\Actions\Sender;

use App\Models\Sender;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetSenders
{
    /**
     * Execute the action
     *
     * @param  array  $data
     * @return LengthAwarePaginator
     */
    public function execute(array $data): LengthAwarePaginator
    {
        $sender = new Sender;

        $user = new User;

        return QueryBuilder::for($sender)
            ->with('user:id,name')
            ->select([
                $sender->qualifyColumn('id'),
                $sender->qualifyColumn('user_id'),
                $sender->qualifyColumn('phone'),
                $sender->qualifyColumn('created_at'),
            ])
            ->leftJoin(
                $user->getTable(),
                $sender->user()->getQualifiedParentKeyName(),
                '=',
                $sender->user()->getQualifiedForeignKeyName()
            )
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('user.id'),
                'user.name',
                'phone',
                'created_at',
                AllowedFilter::callback('global', function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->whereHas('user', function ($query) use ($value) {
                            $query->where('name', 'LIKE', "%{$value}%");
                        })->orWhere('phone', 'LIKE', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts([
                'id',
                'user.name',
                'phone',
                'created_at',
            ])
            ->defaultSort('-created_at')
            ->paginate($data['perPage'] ?? 15)
            ->withQueryString();
    }
}
