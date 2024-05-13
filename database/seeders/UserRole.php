<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRole extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = $this->defaultUsers();

        foreach ($users as $user) {
            DB::table('user_roles')->insert($user);
        }
    }
    private function defaultUsers(): array
    {
        return [
            0 => [
                "user_id" => 1,
                "role_id" => 1,
                'is_active'=>true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
    }
}
