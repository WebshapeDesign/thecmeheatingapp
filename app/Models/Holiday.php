<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_requested',
        'holiday_start_date',
        'holiday_end_date',
        'number_of_days',
        'status',
    ];

    /**
     * Cast these attributes as Carbon dates
     */
    protected $casts = [
        'date_requested' => 'date',
        'holiday_start_date' => 'date',
        'holiday_end_date' => 'date',
    ];

    /**
     * Relationship: Holiday belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
