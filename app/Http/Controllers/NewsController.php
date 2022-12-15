<?php

namespace App\Http\Controllers;

use App\Events\NewsCreated;
use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Repositories\Contract\NewsRepositoryInterface;
use App\Repositories\Contract\UserRepositoryInterface;

class NewsController extends Controller
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository)
    {
    }

    public function index(): NewsCollection
    {
        $news = $this->newsRepository->paginate(request('per_page') ?? 10);

        return new NewsCollection($news);
    }

    public function show(News $news): NewsResource
    {
        return new NewsResource($news);
    }

    public function store(CreateNewsRequest $request)
    {
        $news = $request->user()->news()->create($request->only([
            'title',
            'content'
        ]));

        event(new NewsCreated($news));

        return new NewsResource($news);
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $this->newsRepository
            ->updateWhere('id', '=', $news->id, $request->only([
                'title',
                'content'
            ]));

        return response()->json([], 204);
    }
}
