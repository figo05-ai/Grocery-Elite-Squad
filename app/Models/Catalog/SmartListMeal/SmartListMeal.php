<?php

namespace App\Models\Catalog\SmartListMeal;

use App\Models\Catalog\Meal\Meal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartListMeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'smart_list_id',
        'meal_id',
    ];

    public function smartList()
    {
        return $this->belongsTo(SmartList::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
