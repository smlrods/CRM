<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'role_name' => $this->roles->first()->name ?? null,
            'role_id' => $this->roles->first()->id ?? null,
            'email' => $this->email,
            'membership' => $this->memberships()->where('organization_id', session('organization_id'))->first(),
        ];
    }
}
