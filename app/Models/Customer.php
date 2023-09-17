<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone_number', 'user_id',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
