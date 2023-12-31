<?php

namespace App\Models;

use App\Models\Traits\DonutChartDataGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Project extends Model
{
    use HasFactory, Searchable, DonutChartDataGenerator;

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'deadline', 'user_id', 'client_id', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
