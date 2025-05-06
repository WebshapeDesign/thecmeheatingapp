<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        // Core fields
        'vehicle_id',
        'user_id',
        'week_starting',
        'mileage',

        // Vehicle checks
        'oil_checked',
        'oil_action',
        'water_checked',
        'water_action',
        'tyres_checked',
        'tyres_action',
        'wash_checked',
        'wash_action',
        'vehicle_defects',

        // Equipment checks
        'ladder_checked',
        'ladder_signed',
        'ladder_defects',
        'vacuum_checked',
        'vacuum_signed',
        'vacuum_defects',
        'tools_checked',
        'tools_signed',
        'tools_defects',
        'extinguisher_checked',
        'extinguisher_signed',
        'extinguisher_defects',

        // PPE / Health & Safety Equipment
        'first_aid_required',
        'first_aid_actual',
        'first_aid_checked',
        'first_aid_signed',
        'first_aid_defects',

        'fire_extinguisher_required',
        'fire_extinguisher_actual',
        'fire_extinguisher_checked',
        'fire_extinguisher_signed',
        'fire_extinguisher_defects',

        'accident_book_required',
        'accident_book_actual',
        'accident_book_checked',
        'accident_book_signed',
        'accident_book_defects',

        'eye_wash_required',
        'eye_wash_actual',
        'eye_wash_checked',
        'eye_wash_signed',
        'eye_wash_defects',

        'company_id_required',
        'company_id_actual',
        'company_id_checked',
        'company_id_signed',
        'company_id_defects',

        'safety_boots_required',
        'safety_boots_actual',
        'safety_boots_checked',
        'safety_boots_signed',
        'safety_boots_defects',

        'safety_goggles_required',
        'safety_goggles_actual',
        'safety_goggles_checked',
        'safety_goggles_signed',
        'safety_goggles_defects',

        'hi_viz_required',
        'hi_viz_actual',
        'hi_viz_checked',
        'hi_viz_signed',
        'hi_viz_defects',

        'gloves_required',
        'gloves_actual',
        'gloves_checked',
        'gloves_signed',
        'gloves_defects',

        'hard_hat_required',
        'hard_hat_actual',
        'hard_hat_checked',
        'hard_hat_signed',
        'hard_hat_defects',
    ];

    protected $casts = [
        'week_starting' => 'date',
        'oil_checked' => 'boolean',
        'water_checked' => 'boolean',
        'tyres_checked' => 'boolean',
        'wash_checked' => 'boolean',

        'ladder_checked' => 'boolean',
        'ladder_signed' => 'boolean',
        'vacuum_checked' => 'boolean',
        'vacuum_signed' => 'boolean',
        'tools_checked' => 'boolean',
        'tools_signed' => 'boolean',
        'extinguisher_checked' => 'boolean',
        'extinguisher_signed' => 'boolean',

        // PPE booleans
        'first_aid_checked' => 'boolean',
        'first_aid_signed' => 'boolean',
        'fire_extinguisher_checked' => 'boolean',
        'fire_extinguisher_signed' => 'boolean',
        'accident_book_checked' => 'boolean',
        'accident_book_signed' => 'boolean',
        'eye_wash_checked' => 'boolean',
        'eye_wash_signed' => 'boolean',
        'company_id_checked' => 'boolean',
        'company_id_signed' => 'boolean',
        'safety_boots_checked' => 'boolean',
        'safety_boots_signed' => 'boolean',
        'safety_goggles_checked' => 'boolean',
        'safety_goggles_signed' => 'boolean',
        'hi_viz_checked' => 'boolean',
        'hi_viz_signed' => 'boolean',
        'gloves_checked' => 'boolean',
        'gloves_signed' => 'boolean',
        'hard_hat_checked' => 'boolean',
        'hard_hat_signed' => 'boolean',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
