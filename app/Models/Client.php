<?php

namespace App\Models;

use App\Models\Traits\BarChartDataGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Client extends Model
{
    use HasFactory, Searchable, BarChartDataGenerator;

    protected $fillable = ['company', 'vat', 'address_id'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function toArray()
    {
        $address = $this->address;

        return [
            'company' => $this->company,
            'vat' => $this->vat,
            'address' => $address->street_address . ', ' . $address->city . ', ' . $address->state . ' ' . $address->zip_code,
        ];
    }
}
