<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\Vehicle;
use App\Models\VanLog;
use App\Models\Timesheet;
use App\Models\Holiday;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'role',
        'holiday_days_remaining', // ✅ Add if Admins need to update this
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $attributes = [
        'holiday_days_remaining' => 20,
    ];

    // ✅ Role checks
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // ✅ Relationships
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }

    public function vanLogs()
    {
        return $this->hasMany(VanLog::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    // ✅ Convenience helper
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }
}
