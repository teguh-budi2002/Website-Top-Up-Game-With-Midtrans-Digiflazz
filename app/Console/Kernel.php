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
                    $flashsale = FlashSale::select("id", "start_time", "end_time")
                                            ->where('start_time', '<=', $now->toDateTimeString())
                                            ->where('end_time', '>=', $now->toDateTimeString())
                                            ->first();

                    if ($flashsale) {
                        $start_time = Carbon::parse($flashsale->start_time);
                        $end_time = Carbon::parse($flashsale->end_time);

                        return $now->between($start_time, $end_time);
                    }

                    return false;
                });

        $schedule->job(new AutoInactiveFlashsale)
                ->everyMinute()
                ->when(function() {
                    $now = Carbon::now();
                    $flashsale = FlashSale::select("id", "end_time")->where('end_time', '<=', $now->toDateTimeString())->first();

                    if ($flashsale) {
                        $end_time = Carbon::parse($flashsale->end_time);

                        return $now->isAfter($end_time);
                    }

                    return false;
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
