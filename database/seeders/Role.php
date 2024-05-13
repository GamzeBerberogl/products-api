<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Role extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = $this->defaultRoles();

        foreach($roles as $role){
            DB::table('roles')->insert([
                'name' => $role['name'],
                'title' => $role['title'],
                'weight'=>$role['weight'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function defaultRoles(): array
    {
        return [
            [
                'name' => 'ROLE_ADMIN',
                'title' => 'Admin',
                'weight' => 100,
            ]
        ];
    }
}
