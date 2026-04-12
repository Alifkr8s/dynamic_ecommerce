<?php

use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\CancelExpiredDeals;

// Run every minute to check for expired deals
Schedule::command('deals:cancel-expired')->everyMinute();