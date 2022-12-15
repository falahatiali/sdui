<?php

namespace App\Console\Commands;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NewsDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:delete_all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all news that created more than 14 days ago';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('start command');
        News::query()
            ->where('created_at', '<', Carbon::now()->subDays(14))
            ->each(function ($news) {
                Log::info("News with id {$news->id} deleted");
                return $news->delete();
            });
        Log::info('end command');
        return true;
    }
}
