<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('van_logs', function (Blueprint $table) {
        $table->id();

        $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->date('week_starting'); // auto-filled (Sunday)
        $table->unsignedBigInteger('mileage'); // mileage of vehicle at creation

        // Vehicle checks
        $table->boolean('oil_checked');
        $table->text('oil_action')->nullable();
        $table->boolean('water_checked');
        $table->text('water_action')->nullable();
        $table->boolean('tyres_checked');
        $table->text('tyres_action')->nullable();
        $table->boolean('wash_checked');
        $table->text('wash_action')->nullable();

        // Defects
        $table->text('vehicle_defects')->nullable();

        // Equipment checks
        foreach (['ladder', 'vacuum', 'tools', 'extinguisher'] as $item) {
            $table->boolean("{$item}_checked");
            $table->boolean("{$item}_signed");
            $table->text("{$item}_defects")->nullable();
        }

        // PPE/Health and Safety
        foreach ([
            'first_aid', 'fire_extinguisher', 'accident_book', 'eye_wash',
            'company_id', 'safety_boots', 'safety_goggles',
            'hi_viz', 'gloves', 'hard_hat'
        ] as $item) {
            $table->unsignedTinyInteger("{$item}_required")->default(1);
            $table->unsignedTinyInteger("{$item}_actual")->default(0);
            $table->boolean("{$item}_checked");
            $table->boolean("{$item}_signed");
            $table->text("{$item}_defects")->nullable();
        }

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('van_logs');
    }
};
