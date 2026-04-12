<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD
use Illuminate\Support\Facades\Schema;
=======
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
<<<<<<< HEAD
        // Fix for older MySQL versions (optional but safe)
        Schema::defaultStringLength(191);
    }
}
=======
        //
    }
}
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
