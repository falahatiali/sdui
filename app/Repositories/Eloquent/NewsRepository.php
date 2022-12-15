<?php

namespace App\Repositories\Eloquent;

use App\Models\News;
use App\Repositories\Contract\NewsRepositoryInterface;
use App\Repositories\RepositoryAbstract;

class NewsRepository extends RepositoryAbstract implements NewsRepositoryInterface
{
    public function entity(): string
    {
        return News::class;
    }
}
