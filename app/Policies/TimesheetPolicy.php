<?php

namespace App\Policies;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TimesheetPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }
    
    public function view(User $user, Timesheet $timesheet): bool
    {
        return $user->isAdmin() || $user->id === $timesheet->user_id;
    }
    
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->role === 'user';
    }
    
    public function update(User $user, Timesheet $timesheet): bool
    {
        return $timesheet->status === 'draft' && ($user->isAdmin() || $user->id === $timesheet->user_id);
    }
    
}
