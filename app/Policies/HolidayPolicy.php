<?php

namespace App\Policies;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HolidayPolicy
{
    public function create(User $user): bool
    {
        return $user->holiday_days_remaining > 0;
    }
    
    
    public function approve(User $user): bool
    {
        return $user->isAdmin();
    }

    public function viewAny(User $user): bool
{
    return $user->isAdmin() || $user->id !== null; // or just $user->isAdmin();
}

public function view(User $user, Holiday $holiday): bool
{
    // Admins can view all, users can view their own
    return $user->isAdmin() || $user->id === $holiday->user_id;
}

public function update(User $user, Holiday $holiday): bool
{
    // Admins can update all, users can update their own "requested" holidays
    return $user->isAdmin() || ($user->id === $holiday->user_id && $holiday->status === 'requested');
}
    
}
