<?php

use App\Models\Patiente;
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
        Schema::create('conseils', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->text('description');
            $table->foreignIdFor(SageFemme::class)->onDelete('cascade');
            $table->foreignIdFor(Patiente::class)->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conseils');
    }
};
