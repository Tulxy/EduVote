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
        Schema::table('ideas', function (Blueprint $table) {
            // Sjednoceno na 'pending', aby ti nápady správně padaly do fronty
            $table->string('status')->default('pending')->after('description');

            // Kategorie jako string, nullable (pro případ starších záznamů) nebo s výchozí hodnotou
            $table->string('category')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ideas', function (Blueprint $table) {
            // OPRAVENO: Mazeme oba sloupce při rollbacku
            $table->dropColumn(['status',]);
        });
    }
};
