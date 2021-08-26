<?php


namespace App\Resources\Holidays;


use Illuminate\Http\Resources\Json\JsonResource;

class HolidaysCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'date' => $this->date
        ];
    }
}
