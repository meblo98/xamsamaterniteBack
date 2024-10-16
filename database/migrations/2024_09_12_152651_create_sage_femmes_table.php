<?php

use App\Models\StructureSante;
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
        Schema::create('sage_femmes', function (Blueprint $table) {
            $table->id();
            $table->boolean('archived')->default(false);
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->foreignIdFor(StructureSante::class)->onDelete('cascade');
            $table->string('matricule');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sage_femmes');
    }
};
