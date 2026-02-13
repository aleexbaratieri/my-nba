<?php

namespace Database\Seeders;

use App\Data\UserData;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRepo = app()->make(UserRepository::class);

        $userRepo->createOrUpdate(
            new UserData(
                name: 'Administrador', 
                email: 'admin@admin.com', 
                password: 'secret'
            )
        );

        $userRepo->createOrUpdate(
            new UserData(
                name: 'Usuário', 
                email: 'user@user.com', 
                password: 'secret'
            )
        );
    }
}
