<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    // You might set a public property like guard_name or connection, or override other Eloquent Model methods/properties
    use HasFactory;

    protected $fillable = ['name'];
}
