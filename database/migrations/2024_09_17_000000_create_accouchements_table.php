<?php

use App\Models\Patiente;
use App\Models\Grossesse;
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
        Schema::create('accouchements', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Grossesse::class)->onDelete('cascade');
            $table->foreignIdFor(SageFemme::class)->onDelete('cascade');

            // Lieu de l'accouchement (maternité, domicile)
            $table->enum('lieu', ['maternité', 'domicile']);

            // Mode de l'accouchement (naturel, instrumental, césarienne)
            $table->enum('mode', ['naturel', 'instrumental', 'césarienne']);

            // Date et heure de l'accouchement
            $table->date('date');
            $table->time('heure');

            // Terme (prématuré, à terme, post-terme)
            $table->string('terme');

            // Mois de grossesse (nombre de mois de la grossesse)
            $table->integer('mois_grossesse');

            // Début du travail
            $table->time('debut_travail');

            // Périnée (intact, épisiotomie, déchirure)
            $table->enum('perinee', ['intact', 'episiotomie', 'dechirure']);

            // Pathologies éventuelles pendant l'accouchement
            $table->string('pathologie')->nullable();

            // Évolution/réanimation (favorable, transfert, décès)
            $table->enum('evolution_reanimation', ['favorable', 'transfert', 'décès']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accouchements');
    }
};
