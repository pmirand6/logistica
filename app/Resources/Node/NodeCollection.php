<?php
/**
 * Class NodeCollection
 * @package App\Resources\Node
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 30/11/20 21:41
 */

namespace App\Resources\Node;
use Illuminate\Http\Resources\Json\JsonResource;

class NodeCollection extends JsonResource
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
            'node_id' => $this->nodeId,
            'name' => $this->name,
            'businessName' => $this->name,
            'work_days' => $this->workDays,
            'work_hour_start' => $this->workHourStart,
            'work_hour_end' => $this->workHourEnd,
            'geo' => $this->geo,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'street_name' => $this->streetName,
            'floor' => $this->floor,
            'departmentNumber' => $this->departmentNumber,
            'logo' => $this->logo,
            'phoneNumber' => $this->phoneNumber,
            'email' => $this->email,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at
        ];
    }


}
