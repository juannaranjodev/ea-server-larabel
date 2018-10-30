<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class LicenseResource extends JsonResource
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
            'email' => $email,
            'user_id' => $this->user_id,
            'account_number' => $this->account_number,
            'hash_key' => $this->hash_key,
            'allow_flag' => $this->allow_flag,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
