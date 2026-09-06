<?php

namespace App\Models\Support\SupportReport;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportReport extends Model
{
    protected $fillable = [
        'user_id',
        'issue_type',
        'order_number',
        'message',
        'ip_address',
        'user_agent',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
