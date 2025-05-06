<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'week_starting',
        'days',
        'expenses_materials',
        'expenses_other',
        'expenses_total',
        'status',
    ];

    protected $casts = [
        'week_starting' => 'date',
        'days' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
