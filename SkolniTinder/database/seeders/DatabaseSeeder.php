<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Přidali jsme pole 'address'
        $school = School::create([
            'name' => 'Testovací škola',
            'student_code' => 'ABCDE',
            'address' => 'Vymyšlená 123, Praha',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'school_id' => $school->id,
        ]);
    }
}
