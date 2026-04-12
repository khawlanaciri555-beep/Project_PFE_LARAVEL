<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    /** @use HasFactory<\Database\Factories\PlanningFactory> */
    use HasFactory;

    protected $table = 'planning';

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function planningItems()
    {
        return $this->hasMany(PlanningItem::class);
    }
}
