<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['street_address', 'city', 'state', 'zip_code', 'organization_id'];

    public $timestamps = false;

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    protected function fullAddress(): Attribute
    {
        return Attribute::make(get: fn () => "{$this->street_address}, {$this->city}, {$this->state} {$this->zip_code}");
    }
}
