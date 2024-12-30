<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private $model;

    /**
     * Create a new class instance.
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $users = $this->model
            ->when(!empty($params['search']['name']), function ($query) use ($params) {
                return $query->where('name', 'LIKE', '%'.$params['search']['name'].'%');
            })
            ->when(!empty($params['search']['email']), function ($query) use ($params) {
                return $query->where('email', 'LIKE', '%'.$params['search']['email'].'%');
            })
            ->when(!empty($params['sort']['name']), function ($query) use ($params) {
                return $query->orderBy('name', $params['sort']['name']);
            })
            ->when(!empty($params['sort']['email']), function ($query) use ($params) {
                return $query->orderBy('email', $params['sort']['email']);
            });

        if (!empty($params['perPage'])) {
            return $users->paginate($params['perPage']);
        }

        return $users->get();
    }

    public function save(User $user)
    {
        $user->save();

        return $user;
    }
}
