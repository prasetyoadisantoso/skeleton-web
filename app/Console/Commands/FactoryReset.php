<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class FactoryReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset All Skeleton Web';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Storage::deleteDirectory('public');
        Storage::makeDirectory('public');
        Artisan::call('migrate:reset');
        Artisan::call('migrate:fresh --seed');
        Artisan::call('storage:link --force');
        Artisan::call('config:cache');

        return Command::SUCCESS;
    }
}
