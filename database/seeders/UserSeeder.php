<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            // User::factory(20)->create();
            
			$userManagement = Permission::create(['name' => 'akses manajemen user']);

			$superAdminRole = Role::create(['name' => 'Super Admin']);

			$superAdmin = User::create([
				'name' => 'Super Admin',
                'email' => 'super@gmail.com',
                'password' => Hash::make('password')
			]);

			$superAdmin->assignRole($superAdminRole);
		});
    }
}