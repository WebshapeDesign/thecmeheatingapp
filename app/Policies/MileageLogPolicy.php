<?php

namespace App\Policies;

use App\Models\MileageLog;
use App\Models\User;

class MileageLogPolicy
{
    /**
     * Determine whether the user can view any mileage logs.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->vehicle !== null;
    }

    /**
     * Determine whether the user can view a specific mileage log.
     */
    public function view(User $user, MileageLog $mileageLog): bool
    {
        return $user->isAdmin()
            || ($user->vehicle && $user->vehicle->id === $mileageLog->vehicle_id);
    }

    /**
     * Determine whether the user can create mileage logs.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->vehicle !== null;
    }

    /**
     * Determine whether the user can update a mileage log.
     */
    public function update(User $user, MileageLog $log): bool
    {
        return $log->status === 'draft'
            && ($user->isAdmin() || ($user->vehicle && $user->vehicle->id === $log->vehicle_id));
    }
}
