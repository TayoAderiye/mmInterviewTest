<?php

namespace App\Console\Commands;

use App\Jobs\creditEmailJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:recon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Recon Command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            creditEmailJob::dispatch();
        } catch (\Exception $e) {
            Log::info("Error from Command tryCatch " . $e->getMessage());
        }
    }
}
