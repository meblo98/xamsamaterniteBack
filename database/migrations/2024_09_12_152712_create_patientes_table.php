<?php

use App\Models\User;
use App\Models\BadienGox;
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
        Schema::create('patientes', function (Blueprint $table) {
            $table->id();
            $table->string('lieu_de_naissance');
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->foreignIdFor(SageFemme::class)->onDelete('cascade');
            $table->foreignIdFor(BadienGox::class)->onDelete('cascade');
            $table->boolean('archived')->default(false);
            $table->string('date_de_naissance');
            $table->string('profession');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patientes');
    }
};
