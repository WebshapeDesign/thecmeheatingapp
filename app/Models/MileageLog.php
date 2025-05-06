<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MileageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id', 'user_id', 'week_starting', 'status', 'entries',
    ];

    protected $casts = [
        'entries' => 'array',
        'week_starting' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isEditable()
    {
        return $this->status === 'draft';
    }
}
