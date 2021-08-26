<?php


namespace App\Resources\User;


class UserResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'e_mail' => $this->email,
            'active' => $this->active,
            //'admin' => $this->admin,
            'driver' => $this->driver
        ];
    }
}
