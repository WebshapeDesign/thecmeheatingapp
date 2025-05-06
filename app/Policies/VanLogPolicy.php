<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VanLog;

class VanLogPolicy
{
    /**
     * Determine whether the user can view any van logs.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the van log.
     */
    public function view(User $user, VanLog $vanLog): bool
    {
        return $user->isAdmin() || $user->id === $vanLog->user_id;
    }

    /**
     * Determine whether the user can create van logs.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->vehicle !== null;
    }

    /**
     * Determine whether the user can update the van log.
     */
    public function update(User $user, VanLog $vanLog): bool
    {
        return $user->role === 'admin' || $user->id === $vanLog->user_id;
    }

    /**
     * Determine whether the user can delete the van log.
     */
    public function delete(User $user, VanLog $vanLog): bool
    {
        return $user->isAdmin();
    }
}
