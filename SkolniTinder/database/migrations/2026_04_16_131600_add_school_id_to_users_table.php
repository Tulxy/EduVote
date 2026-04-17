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
        Schema::table('users', function (Blueprint $table) {
            // Propojení se školou
            $table->foreignId('school_id')->constrained()->onDelete('cascade');

            // Role: student, pedagog, spravce (defaultně nastavíme studenta)
            $table->enum('role', ['student', 'teacher', 'admin'])->default('student');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
