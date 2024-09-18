<?php

use App\Models\DistrictSanitaire;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('structure_santes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignIdFor(DistrictSanitaire::class)->onDelete('cascade');
            $table->string('lieu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structure_santes');
    }
};
