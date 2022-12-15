<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contract\UserRepositoryInterface;
use App\Repositories\RepositoryAbstract;

class UserRepository extends RepositoryAbstract implements UserRepositoryInterface
{
    public function entity(): string
    {
        return User::class;
    }
}
