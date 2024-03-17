<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'status', 'customer_id', 'owner_id', 'value',
    ];

    public const array status = [
        'contacted',
        'arranged-call',
        'analysis',
        'proposed-price',
        'negotiation',
        'lost',
        'won',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
