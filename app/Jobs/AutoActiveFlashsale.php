<?php

namespace App\Jobs;

use App\Models\FlashSale;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AutoActiveFlashsale implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $currentDateTime = Carbon::now()->toDateTimeString();
            $flashsale = FlashSale::select("id", "is_flash_sale", "start_time", "end_time")
                                    ->where('start_time', '<=', $currentDateTime)
                                    ->where('end_time', '>=', $currentDateTime)
                                    ->first();
            if ($flashsale) {
                $flashsale->is_flash_sale = 1;
                $flashsale->save();
            }
        } catch (\Throwable $th) {
            Log::error('ERROR AUTO ACTIVE FLASHSALE', $th->getMessage());
        }
    }
}
