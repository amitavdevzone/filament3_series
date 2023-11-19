<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Contact extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', 'email', 'phone_number', 'owner_id', 'is_active',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'phone_number']);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class)->orderByDesc('id');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', '=', 1);
    }
}
