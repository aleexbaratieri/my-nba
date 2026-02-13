<?php

namespace Database\Seeders;

use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::updateOrCreate(['name' => 'create_user'], ['name' => 'create_user']);
        Permission::updateOrCreate(['name' => 'edit_user'], ['name' => 'edit_user']);

        Permission::updateOrCreate(['name' => 'view_team'], ['name' => 'view_team']);
        Permission::updateOrCreate(['name' => 'create_team'], ['name' => 'create_team']);
        Permission::updateOrCreate(['name' => 'edit_team'], ['name' => 'edit_team']);
        Permission::updateOrCreate(['name' => 'delete_team'], ['name' => 'delete_team']);

        Permission::updateOrCreate(['name' => 'view_player'], ['name' => 'view_player']);
        Permission::updateOrCreate(['name' => 'create_player'], ['name' => 'create_player']);
        Permission::updateOrCreate(['name' => 'edit_player'], ['name' => 'edit_player']);
        Permission::updateOrCreate(['name' => 'delete_player'], ['name' => 'delete_player']);

        Permission::updateOrCreate(['name' => 'view_game'], ['name' => 'view_game']);
        Permission::updateOrCreate(['name' => 'create_game'], ['name' => 'create_game']);
        Permission::updateOrCreate(['name' => 'edit_game'], ['name' => 'edit_game']);
        Permission::updateOrCreate(['name' => 'delete_game'], ['name' => 'delete_game']);

        $admin = Role::updateOrCreate(['name' => 'admin'], ['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $user = Role::updateOrCreate(['name' => 'user'], ['name' => 'user']);
        $user->givePermissionTo('view_team', 'view_player', 'view_game');
        $user->givePermissionTo('create_team', 'create_player', 'create_game');
        $user->givePermissionTo('edit_team', 'edit_player', 'edit_game');

        $userRepo = app()->make(UserRepository::class);

        $adminUser = $userRepo->findByEmail('admin@admin.com');
        $adminUser->assignRole('admin');

        $basicUser = $userRepo->findByEmail('user@user.com');
        $basicUser->assignRole('user');
    }
}
