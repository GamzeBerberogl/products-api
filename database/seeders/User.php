<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = $this->defaultUsers();

        foreach ($users as $user) {
            DB::table('users')->insert([
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'name' => $user['name'],
                'surname' => $user['surname'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    private function defaultUsers(): array
    {
        return [
            0 => [
                "name" => "Yönetici",
                "surname" => "Kullanıcı",
                "email" => "yonetici@sirket.com.tr",
                "password" => "sifre123"
            ]
        ];
    }
}
