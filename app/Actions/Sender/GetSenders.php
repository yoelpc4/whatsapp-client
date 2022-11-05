<?php

namespace App\Actions\Sender;

use App\Models\Sender;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class GetSenders
{
    /**
     * Execute the action
     *
     * @param  User  $user
     * @param  array  $data
     * @return LengthAwarePaginator
     */
    public function execute(User $user, array $data): LengthAwarePaginator
    {
        $sender = new Sender;

        return QueryBuilder::for($sender)
            ->select([
                $sender->qualifyColumn('id'),
                $sender->qualifyColumn('name'),
                $sender->qualifyColumn('phone'),
                $sender->qualifyColumn('created_at'),
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('user.id'),
                'user.name',
                'name',
                'phone',
                'created_at',
                AllowedFilter::callback('global', function (Builder $query, $value) {
                    $query->where(function (Builder $query) use ($value) {
                        $query->where('name', 'LIKE', "%{$value}%")
                            ->orWhere('phone', 'LIKE', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts([
                'id',
                AllowedSort::field('user.name', $user->qualifyColumn('name')),
                'name',
                'phone',
                'created_at',
            ])
            ->defaultSort('-created_at')
            ->where($sender->qualifyColumn('user_id'), $user->id)
            ->paginate($data['perPage'] ?? 15)
            ->withQueryString();
    }
}
