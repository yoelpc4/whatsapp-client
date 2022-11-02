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
     * @param  User  $user
     * @param  array  $data
     * @return LengthAwarePaginator
     */
    public function execute(User $user, array $data): LengthAwarePaginator
    {
        return QueryBuilder::for(Sender::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('user.id'),
                'user.name',
                'name',
                'phone',
                'created_at',
                AllowedFilter::callback('global', function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('name', 'LIKE', "%{$value}%")->orWhere('phone', 'LIKE', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts([
                'id',
                'name',
                'phone',
                'created_at',
            ])
            ->defaultSort('-created_at')
            ->where('user_id', $user->id)
            ->paginate($data['perPage'] ?? 15)
            ->withQueryString();
    }
}
