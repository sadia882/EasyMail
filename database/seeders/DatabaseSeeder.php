<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //Ajout de rôles et permissions
        $role = Role::create(['name' => 'admin']);
        $permission = Permission::create(['name' => 'manage users']);

        $role->givePermissionTo($permission);

        //Assignation à un utilisateur :
        $user = User::find(1);
        $user->assignRole('admin');

    }

    //Vérification des permissions dans les contrôleurs :

}
