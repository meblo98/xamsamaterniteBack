<?php

use App\Models\BadienGox;
use App\Models\SageFemme;
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
        Schema::create('campagnes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description');
            $table->string('image');
            $table->string('lieu');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->foreignIdFor(BadienGox::class)->nullable()->onDelete('cascade');
            $table->foreignIdFor(SageFemme::class)->nullable()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campagnes');
    }
};
