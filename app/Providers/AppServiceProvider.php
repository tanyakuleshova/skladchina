<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        
        View::composer(['layouts/nav_bar','front/user/personal_area'], function ($view) {            
            $balance_user = \App\Models\Billing\Balance::where('user_id',  Auth::id())
                    ->where('currency_id',1)
                    ->where('status_id',3)
                    ->sum('summa');
            return $view->with(['balance_user'=>$balance_user]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
