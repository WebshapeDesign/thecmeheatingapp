<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Livewire Components
use App\Livewire\Users\Index;
use App\Livewire\Users\Create;
use App\Livewire\Users\Edit;
use App\Livewire\Users\Show;
use App\Livewire\Users\Timesheets as UserTimesheets;
use App\Livewire\Users\Holidays as UserHolidays;

use App\Livewire\Vehicles\Index as VehicleIndex;
use App\Livewire\Vehicles\Create as VehicleCreate;
use App\Livewire\Vehicles\Edit as VehicleEdit;
use App\Livewire\Vehicles\Show as VehicleShow;

use App\Livewire\VanLogs\Index as VanLogIndex;
use App\Livewire\VanLogs\Create as VanLogCreate;
use App\Livewire\VanLogs\Edit as VanLogEdit;
use App\Livewire\VanLogs\Show as VanLogShow;

use App\Livewire\MileageLogs\Index as MileageLogIndex;
use App\Livewire\MileageLogs\Create as MileageLogCreate;
use App\Livewire\MileageLogs\Edit as MileageLogEdit;
use App\Livewire\MileageLogs\Show as MileageLogShow;

use App\Livewire\Timesheets\Index as TimesheetIndex;
use App\Livewire\Timesheets\Create as TimesheetCreate;
use App\Livewire\Timesheets\Edit as TimesheetEdit;
use App\Livewire\Timesheets\Show as TimesheetShow;

use App\Livewire\Holidays\Index as HolidayIndex;
use App\Livewire\Holidays\Create as HolidayCreate;
use App\Livewire\Holidays\Edit as HolidayEdit;
use App\Livewire\Holidays\Show as HolidayShow;

// Models
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VanLog;
use App\Models\MileageLog;
use App\Models\Timesheet;
use App\Models\Holiday;
// Public Route
Route::get('/', fn () => view('welcome'))->name('home');

// Dashboard (authenticated and verified users)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Profile Settings (Volt)
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // ✅ User Management
    Route::get('/users', Index::class)->name('users.index')->middleware('can:viewAny,' . User::class);
    Route::get('/users/create', Create::class)->name('users.create')->middleware('can:create,' . User::class);
    Route::get('/users/{user}/edit', Edit::class)->name('users.edit')->middleware('can:update,user');
    Route::get('/users/{user}', Show::class)->name('users.show')->middleware('can:view,user');
    Route::get('/users/{user}/timesheets', UserTimesheets::class)->name('users.timesheets')->middleware('can:view,user');
    Route::get('/users/{user}/holidays', UserHolidays::class)->name('users.holidays')->middleware('can:view,user');

    // ✅ Vehicle Management
    Route::get('/vehicles', VehicleIndex::class)->name('vehicles.index')->middleware('can:viewAny,' . Vehicle::class);
    Route::get('/vehicles/create', VehicleCreate::class)->name('vehicles.create')->middleware('can:create,' . Vehicle::class);
    Route::get('/vehicles/{vehicle}/edit', VehicleEdit::class)->name('vehicles.edit')->middleware('can:update,vehicle');
    Route::get('/vehicles/{vehicle}', VehicleShow::class)->name('vehicles.show')->middleware('can:view,vehicle');
    Route::get('/vehicles/{vehicle}/vanlogs', \App\Livewire\Vehicles\VanLogs::class)->name('vehicles.vanlogs')->middleware('can:view,vehicle');
    Route::get('/vehicles/{vehicle}/mileagelogs', \App\Livewire\Vehicles\MileageLogs::class)->name('vehicles.mileagelogs')->middleware('can:view,vehicle');

    // ✅ Van Log Management
    Route::get('/vanlogs', VanLogIndex::class)->name('vanlogs.index')->middleware('can:viewAny,' . VanLog::class);
    Route::get('/vanlogs/create', VanLogCreate::class)->name('vanlogs.create')->middleware('can:create,' . VanLog::class);
    Route::get('/vanlogs/{vanlog}/edit', VanLogEdit::class)->name('vanlogs.edit')->middleware('can:update,vanlog');
    Route::get('/vanlogs/{vanlog}', VanLogShow::class)->name('vanlogs.show')->middleware('can:view,vanlog');

    // ✅ Mileage Log Management
    Route::get('/mileagelogs', MileageLogIndex::class)->name('mileagelogs.index')->middleware('can:viewAny,' . MileageLog::class);
    Route::get('/mileagelogs/create', MileageLogCreate::class)->name('mileagelogs.create')->middleware('can:create,' . MileageLog::class);
    Route::get('/mileagelogs/{mileagelog}/edit', MileageLogEdit::class)->name('mileagelogs.edit')->middleware('can:update,mileagelog');
    Route::get('/mileagelogs/{mileagelog}', MileageLogShow::class)->name('mileagelogs.show')->middleware('can:view,mileagelog');

    // ✅ Timesheet Management
    Route::get('/timesheets', TimesheetIndex::class)->name('timesheets.index')->middleware('can:viewAny,' . Timesheet::class);
    Route::get('/timesheets/create', TimesheetCreate::class)->name('timesheets.create')->middleware('can:create,' . Timesheet::class);
    Route::get('/timesheets/{timesheet}', TimesheetShow::class)->name('timesheets.show')->middleware('can:view,timesheet');
    Route::get('/timesheets/{timesheet}/edit', TimesheetEdit::class)->name('timesheets.edit')->middleware('can:update,timesheet');

    // ✅ Holiday Management
    Route::get('/holidays', HolidayIndex::class)->name('holidays.index')->middleware('can:viewAny,' . Holiday::class);
    Route::get('/holidays/create', HolidayCreate::class)->name('holidays.create')->middleware('can:create,' . Holiday::class);
    Route::get('/holidays/{holiday}', HolidayShow::class)->name('holidays.show')->middleware('can:view,holiday');
    Route::get('/holidays/{holiday}/edit', HolidayEdit::class)->name('holidays.edit')->middleware('can:update,holiday');
});

// Auth Scaffolding
require __DIR__.'/auth.php';
