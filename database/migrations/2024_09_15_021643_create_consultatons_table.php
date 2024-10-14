<?php

use App\Models\Patiente;
use App\Models\RendezVous;
use App\Models\SageFemme;
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
        Schema::create('consultatons', function (Blueprint $table) {
            $table->id();

            // Informations générales
            $table->date('date');  // Date de la consultation
            $table->string('terme');  // Terme
            $table->integer('SA');  // Semaines d'Aménorrhée (SA)
            $table->text('plaintes')->nullable();  // Plaintes
            $table->integer('mois');  // Mois de grossesse

            // Examen clinique
            $table->decimal('poids', 5, 2);  // Poids en kg
            $table->decimal('taille', 5, 2);  // Taille en cm
            $table->decimal('PB', 5, 2)->nullable();  // Périmètre Brachial (PB)
            $table->decimal('temperature', 5, 2);  // Température corporelle en °C
            $table->string('urine')->nullable();  // Examen d'urine
            $table->string('sucre')->nullable();  // Présence de sucre dans l'urine
            $table->decimal('TA', 5, 2);  // Tension artérielle (TA)
            $table->integer('pouls');  // Pouls
            $table->string('EG')->nullable();  // État Général (EG)
            $table->string('muqueuse')->nullable();  // Muqueuse
            $table->string('mollet')->nullable();  // Mollet
            $table->string('OMI')->nullable();  // OMI (Œdème des Membres Inférieurs)

            // Examen des seins
            $table->string('examen_seins')->nullable();  // Examen des seins

            // Examen obstétrique
            $table->string('hu')->nullable();  // Hauteur Utérine (HU)
            $table->string('speculum')->nullable();  // Examen au spéculum
            $table->string('tv')->nullable();  // Toucher vaginal (TV)

            // Médication et traitement
            $table->string('fer_ac_folique')->nullable();  // Fer et Acide Folique
            $table->string('milda')->nullable();  // Moustiquaire imprégnée d'insecticide (MILDA)
            $table->text('autre_traitement')->nullable();  // Autres traitements

            // Signes obstétriques
            $table->string('maf')->nullable();  // Mouvements Actifs Fœtaux (MAF)
            $table->string('bdcf')->nullable();  // Battements du Cœur Fœtal (BDCF)
            $table->string('alb')->nullable();  // Protéine dans l'urine (albumine)
            $table->string('vat')->nullable();  // Vaccination Antitétanique (VAT)
            $table->string('tpi')->nullable();  // Traitement Préventif Intermittent (TPI)

            // Palpation
            $table->string('palpation')->nullable();  // Palpation abdominale
            $table->string('bdc')->nullable();  // Battements du Cœur Fœtal (BDC)
            $table->string('presentation')->nullable();  // Présentation du fœtus
            $table->string('bassin')->nullable();  // Bassin obstétrical

            // Pelvimétrie
            $table->string('pelvimetre_externe')->nullable();  // Pelvimètre externe
            $table->string('pelvimetre_interne')->nullable();  // Pelvimètre interne
            $table->string('biischiatique')->nullable();  // Diamètre bi-ischiatique
            $table->string('trillat')->nullable();  // Ligne de Trillat
            $table->string('lign_innominees')->nullable();  // Lignes innominées

            // Autres examens et résultats
            $table->text('autre_examen')->nullable();  // Autres examens effectués
            $table->string('resultat')->nullable();  // Résultats des examens

            // Informations sur l'accouchement
            $table->string('lieu_accouchement_apre_consentement')->nullable();  // Lieu d'accouchement après consentement

            // Traitement proposé
            $table->text('traitement')->nullable();  // Traitement proposé

            $table->foreignIdFor(SageFemme::class)->onDelete('cascade');
            $table->foreignIdFor(RendezVous::class)->onDelete('cascade');

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
