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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('address');

            $table->timestamps();

            $table->foreignId('province_id')
                ->constrained()
                ->restrictOnUpdate()
                ->restrictOnDelete();
            
            $table->foreignId('city_id')
                ->constrained()
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('subdistrict_id')
                ->constrained()
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
