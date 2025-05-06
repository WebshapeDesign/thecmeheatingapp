<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    protected $fillable = ['registration_number', 'make', 'model', 'user_id', 'mileage',];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vanLogs()
{
    return $this->hasMany(VanLog::class);
}

public function mileageLogs()
{
    return $this->hasMany(\App\Models\MileageLog::class);
}

}
