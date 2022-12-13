<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Models\News;

class NewsController extends Controller
{
    public function index(): NewsCollection
    {
        $news = News::query()->paginate(request('per_page') ?? 10);

        return new NewsCollection($news);
    }

    public function show(News $news): NewsResource
    {
        return new NewsResource($news);
    }

    public function create(CreateNewsRequest $request)
    {
        $news = News::query()->create($request->only([
            'title' ,
            'content'
        ]));
    }
}
