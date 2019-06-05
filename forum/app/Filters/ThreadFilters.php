<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{

    protected $filters = ['by', 'popular'];

    /**
     * Filter a query by a given username
     *
     * @param string $username
     * @return mixed
     */
    public function by($username)
    {
        $user = \App\User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads
     *
     * @return mixed
     */
    public function popular()
    {
        $this->builder->getQuery()->orders =[];

        return $this->builder->orderBy('replies_count', 'desc');
    }
}