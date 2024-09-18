<?php

use App\Models\SageFemme;
use App\Models\User;
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
        Schema::create('badien_goxes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->foreignIdFor(SageFemme::class)->onDelete('cascade');
            $table->string('adresse');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badien_goxes');
    }
};
