<?php

use App\Models\Patiente;
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
        Schema::create('grossesses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Patiente::class)->onDelete('cascade');
            $table->date('date_debut');
            $table->enum('statut', [
                'en_cours',
                'termine',
                'avorte',
            ])->default('en_cours');
            $table->date('date_prevue_accouchement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grossesses');
    }
};
