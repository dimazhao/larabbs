<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if (app()->environment('local')) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
		\App\Models\User::observe(\App\Observers\UserObserver::class);
		\App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
		\App\Models\Topic::observe(\App\Observers\TopicObserver::class);
        \Illuminate\Pagination\Paginator::useBootstrap();
        // 加载自定义配置文件
    $userConfig = require config_path('administrator/users.php');
    // 合并到框架配置中（键为 administrator.users）
    config()->set('administrator.users', $userConfig);
        //
    }
}
