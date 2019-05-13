<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\User;
use App\ObserversModels\UserObserver;

use App\Admin;
use App\ObserversModels\AdminObserver;

use App\Models\Project\Project;
use App\ObserversModels\ProjectObserver;

use App\Models\GiftProject\Gift;
use App\ObserversModels\GiftObserver;

use App\Models\Project\RequisitesProject;
use App\ObserversModels\RequisitesProjectObserver;

use App\Models\Project\GalleryProject;
use App\ObserversModels\GalleryProjectObserver;

class BasicObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Admin::observe(AdminObserver::class);
        
        Project::observe(ProjectObserver::class);
        RequisitesProject::observe(RequisitesProjectObserver::class);
        GalleryProject::observe(GalleryProjectObserver::class);
        
        Gift::observe(GiftObserver::class);
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
