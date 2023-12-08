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
}
