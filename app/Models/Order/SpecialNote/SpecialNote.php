<?php

namespace App\Models\Order\SpecialNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
