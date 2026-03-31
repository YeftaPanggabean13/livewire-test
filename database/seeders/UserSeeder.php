<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function up()
    {
        // Add 15 dummy users for testing pagination and search
        $users = [
            ['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'position' => 'Manager'],
            ['name' => 'Siti Aminah', 'email' => 'siti@example.com', 'position' => 'Staff'],
            ['name' => 'Andi Wijaya', 'email' => 'andi@example.com', 'position' => 'Senior Developer'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'position' => 'UI/UX Designer'],
            ['name' => 'Eko Prasetyo', 'email' => 'eko@example.com', 'position' => 'Backend Developer'],
            ['name' => 'Fitriani', 'email' => 'fitri@example.com', 'position' => 'QA Engineer'],
            ['name' => 'Guntur Saputra', 'email' => 'guntur@example.com', 'position' => 'Manager'],
            ['name' => 'Hani Nuraini', 'email' => 'hani@example.com', 'position' => 'Fullstack Developer'],
            ['name' => 'Irfan Hakim', 'email' => 'irfan@example.com', 'position' => 'Staff'],
            ['name' => 'Joko Widodo', 'email' => 'joko@example.com', 'position' => 'DevOps Engineer'],
            ['name' => 'Kiki Amalia', 'email' => 'kiki@example.com', 'position' => 'Content Writer'],
            ['name' => 'Lutfi Arifin', 'email' => 'lutfi@example.com', 'position' => 'Marketing'],
            ['name' => 'Maya Sari', 'email' => 'maya@example.com', 'position' => 'Sales'],
            ['name' => 'Nanda Pratama', 'email' => 'nanda@example.com', 'position' => 'Project Manager'],
            ['name' => 'Oki Setiana', 'email' => 'oki@example.com', 'position' => 'Analyst'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }

    public function run() {
        $this->up();
    }
}
