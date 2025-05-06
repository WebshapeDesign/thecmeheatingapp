<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Vehicle;
use App\Policies\UserPolicy;
use App\Policies\VehiclePolicy;
use App\Models\VanLog;
use App\Policies\VanLogPolicy;
use App\Models\Timesheet;
use App\Policies\TimesheetPolicy;
use App\Models\Holiday;
use App\Policies\HolidayPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Vehicle::class => VehiclePolicy::class,
        VanLog::class => VanLogPolicy::class,
        MileageLog::class => MileageLogPolicy::class,
        Timesheet::class => TimesheetPolicy::class,
        Holiday::class => HolidayPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // You can define gates here if needed in the future.
    }
}
