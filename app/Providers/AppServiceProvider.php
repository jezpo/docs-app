<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Documento;
use App\Models\User;
use App\Models\Programa;
use App\Models\Gestion;
use App\Observers\ActivityLogObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Documento::observe(ActivityLogObserver::class);
        User::observe(ActivityLogObserver::class);
        Programa::observe(ActivityLogObserver::class);
        Gestion::observe(ActivityLogObserver::class);
    }

    public function register()
    {
        //
    }
}

