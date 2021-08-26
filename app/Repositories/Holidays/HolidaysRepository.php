<?php


namespace App\Repositories\Holidays;


use App\Models\Holidays;
use App\Resources\Holidays\HolidaysCollection;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HolidaysRepository implements HolidaysRepositoryInterface
{
    /**
     * @var Holidays
     */
    private $holidays;

    public function __construct(Holidays $holidays)
    {
        $this->holidays = $holidays;
    }
    public function store(array $request)
    {
        Holidays::create([
            'name' => $request[0]['name'],
            'type' => $request[0]['type'],
            'date' => Carbon::CreateFromFormat('m/d/Y', $request[0]['date'])->format('Y-m-d')
        ]);
    }

    public function get()
    {

    }

    public function getFromApi(string $year, string $month, string $day): array
    {
        $response = Http::get('https://holidays.abstractapi.com/v1', [
            'api_key' => 'fadadb0b9699458eb93a7a18e81a78d2',
            'country' => 'AR',
            'year' => $year,
            'month' => $month,
            'day' => $day
        ]);

        return $response->json();

    }

    public function all()
    {
        return HolidaysCollection::collection($this->holidays->all());
    }
}
