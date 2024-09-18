<?php

use App\Models\Patiente;
use App\Models\SageFemme;
use App\Models\Vaccination;
use App\Models\Visite;
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
        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Patiente::class)->onDelete('cascade');
            $table->foreignIdFor(SageFemme::class)->onDelete('cascade');
            $table->foreignIdFor(Visite::class)->nullable()->onDelete('cascade');
            $table->foreignIdFor(Vaccination::class)->nullable()->onDelete('cascade');
            $table->date('date_rv');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
