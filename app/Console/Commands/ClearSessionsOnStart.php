<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearSessionsOnStart extends Command
{
    protected $signature   = 'session:clear-all';
    protected $description = 'Clear all session files on server start';

    public function handle()
    {
        $sessionPath = storage_path('framework/sessions');

        if (File::exists($sessionPath)) {
            $files = File::files($sessionPath);
            foreach ($files as $file) {
                File::delete($file);
            }
            $this->info('✅ All sessions cleared. Please login again.');
        } else {
            $this->info('No session directory found.');
        }

        return 0;
    }
}