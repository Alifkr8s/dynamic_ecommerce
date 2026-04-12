<?php

<<<<<<< HEAD
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
=======
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\CancelExpiredDeals;

// Run every minute to check for expired deals
Schedule::command('deals:cancel-expired')->everyMinute();
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
