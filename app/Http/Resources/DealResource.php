<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
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
            'name' => $this->name,
            'value' => $this->value,
            'currency' => $this->currency,
            'close_date' => $this->close_date,
            'status' => $this->status,
            'description' => $this->description,
            'company_name' => $this->company->name,
            'contact_fullname' => $this->contact->fullname,
        ];
    }
}
