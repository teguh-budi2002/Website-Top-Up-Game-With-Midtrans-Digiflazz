<?php

namespace App\Console;

use App\Jobs\AutoActiveFlashsale;
use App\Jobs\AutoInactiveFlashsale;
use App\Models\FlashSale;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new AutoActiveFlashsale)
                ->everyMinute()
                ->when(function() {
                    $now = Carbon::now();
                    $flashsale = FlashSale::select("id", "is_flash_sale", "start_time", "end_time")
                                            ->where('start_time', '<=', $now->toDateTimeString())
                                            ->where('end_time', '>=', $now->toDateTimeString())
                                            ->first();
                    if (is_null($flashsale)) {
                            return false;
                    }

                    if($flashsale->is_flash_sale === 1) {
                        return false;
                    }

                    if (!is_null($flashsale) && $flashsale->is_flash_sale === 0) {
                        $start_time = Carbon::parse($flashsale->start_time);
                        $end_time = Carbon::parse($flashsale->end_time);

                        return $now->between($start_time, $end_time);
                    }
                });

        $schedule->job(new AutoInactiveFlashsale)
                ->everyMinute()
                ->when(function() {
                    $now = Carbon::now();
                    $flashsale = FlashSale::select("id", "is_flash_sale", "end_time")->where('end_time', '<=', $now->toDateTimeString())->first();
                    
                    if (is_null($flashsale)) {
                            return false;
                    }

                    if($flashsale->is_flash_sale === 0) {
                        return false;
                    }

                    if (!is_null($flashsale) && $flashsale->is_flash_sale === 1) {
                        if ($now->isAfter(Carbon::parse($flashsale->end_time))) {
                            $flashsaleExecuted = true;
                            return true;
                        }
                    }
                });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
