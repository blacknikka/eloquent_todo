<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Todo\TodoRepositoryInterface::class,
            \App\Repositories\Todo\TodoRepository::class
        );

        $this->app->bind(
            \App\Repositories\Todo\CommentRepositoryInterface::class,
            \App\Repositories\Todo\CommentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 商用環境以外だった場合、SQLログを出力する
        if (config('app.env') !== 'production') {
            DB::listen(
                function ($query) {
                    \Log::info("Query Time:{$query->time}s] $query->sql");
                }
            );
        }
    }
}
