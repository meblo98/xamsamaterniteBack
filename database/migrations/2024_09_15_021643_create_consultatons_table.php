<?php

use App\Models\Patiente;
use App\Models\SageFemme;
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
        Schema::create('consultatons', function (Blueprint $table) {
            $table->id();
            $table->string('plaintes');
            $table->date('date_consult');
            $table->string('terme');
            $table->string('mois');
            $table->string('SA');
            $table->integer('taille');
            $table->integer('poids');
            $table->foreignIdFor(Patiente::class)->onDelete('cascade');
            $table->foreignIdFor(SageFemme::class)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultatons');
    }
};
