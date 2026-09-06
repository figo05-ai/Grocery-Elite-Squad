<?php

namespace App\Models\Order\OrderNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order\Order\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'special_note_id',
        'notes',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function specialNote(): BelongsTo
    {
        return $this->belongsTo(SpecialNote::class);
    }
}
