<?php

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
        // Používáme Schema::table, protože tabulka už existuje
        Schema::table('users', function (Blueprint $table) {
            // Opravená syntaxe (jen jedenkrát $table->)
            $table->enum('accepted', ['accepted', 'wait', 'canceled'])->default('wait');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('accepted');
        });
    }
};
