<?php

namespace App\Console\Commands;

use App\Repositories\Holidays\HolidaysRepository;
use App\Repositories\Holidays\HolidaysRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SaveHolidays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holidays:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save Holidays from API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param HolidaysRepositoryInterface $holidaysRepository
     * @return mixed
     */
    public function handle(HolidaysRepositoryInterface $holidaysRepository)
    {
        for ($m = 1; $m <= 12; $m++) {
            for ($d = 1; $d <= $this->getDaysOfMonth($m); $d++) {
                $response = $holidaysRepository->getFromApi(Carbon::now()->year, $m, $d);
                if (count($response) > 0) {
                    $holidaysRepository->store($response);
                    Log::info(json_encode([
                        'method' => __METHOD__,
                        'response' => $response
                    ]));
                }
                sleep(1);
            }
        }
    }

    private function getDaysOfMonth(string $month): int
    {
        $dt = Carbon::createFromDate(Carbon::now()->year, $month);

        return $dt->daysInMonth;
    }
}
