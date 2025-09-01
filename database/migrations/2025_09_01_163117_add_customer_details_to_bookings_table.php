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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('first_name')->after('vehicle_id');
            $table->string('last_name')->after('first_name');
            $table->string('email')->after('last_name');
            $table->string('phone')->after('email');
            $table->string('additional_contact')->nullable()->after('phone');
            $table->string('country')->after('additional_contact');
            $table->string('national_id_passport')->after('country');
            $table->string('license_number')->after('national_id_passport');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name', 
                'email',
                'phone',
                'additional_contact',
                'country',
                'national_id_passport',
                'license_number'
            ]);
        });
    }
};
