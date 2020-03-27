<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $update = [
            'is_admin' => true,
            'name'     => 'Administrador',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('123456')];

        $user = User::firstOrCreate(['name' => 'Administrador', 'email' => 'admin@admin.com'], $update);
        $user->assignRole(config('desafio.role-admin'));
    }
}
