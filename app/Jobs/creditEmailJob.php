<?php

namespace App\Jobs;

use App\Helpers\HelperFunctions;
use App\Models\LogTransaction;
use App\Services\Implementations\EMailService;
use App\Services\Interfaces\IEMailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class creditEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        try {
            DB::table('log_transactions')->where('processed', "N")->orderBy('id')->chunk(100, function ($tranData) {
                foreach ($tranData as $recon) {
                    $getLog = HelperFunctions::getLogById($recon->id);
                    $emailServiceInstance = new EMailService();
                    $logInstance = new LogTransaction();
                    $emailServiceInstance->sendCreditEmail($recon->creditor_email, $recon->amount);
                    $emailServiceInstance->sendDebitEmail($recon->debitor_email, $recon->amount);
                    $logInstance->UpdateTransaction($getLog);
                }
            });
        } catch (\Exception $e) {
            Log::info($e);
        }
    }
}
