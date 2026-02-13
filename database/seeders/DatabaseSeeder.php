<?php

namespace Database\Seeders;

use App\Data\UserData;
use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userRepo = app()->make(UserRepository::class);

        $userRepo->create(
            new UserData(
                name: 'Administrador', 
                email: 'admin@admin.com', 
                password: 'secret'
            )
        );

        $userRepo->create(
            new UserData(
                name: 'Usuário', 
                email: 'user@user.com', 
                password: 'secret'
            )
        );
    }
}
