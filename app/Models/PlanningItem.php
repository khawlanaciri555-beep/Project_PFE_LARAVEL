<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningItem extends Model
{
    /** @use HasFactory<\Database\Factories\PlanningItemFactory> */
    use HasFactory;

    protected $fillable = [
        'planning_id',
        'place_id',
        'time',
    ];

    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
