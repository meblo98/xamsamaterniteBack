<?php

use App\Models\BadienGox;
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
        Schema::table('patientes', function (Blueprint $table) {
            $table->foreignIdFor(BadienGox::class)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patientes', function (Blueprint $table) {
            $table->dropForeign(['badien_gox_id']);
            $table->dropColumn('badiene_gox_id');
        });
    }
};
