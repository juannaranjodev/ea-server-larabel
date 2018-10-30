<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class EaProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $email = User::find($this->user_id)["email"];
        return [
            'id' => $this->id,
            'ea_id' => $this->ea_id,
            'ea_name' => $this->ea_name,
            'email' => $email,
            'user_id' => $this->user_id,
            'parameter' => $this->parameter,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
