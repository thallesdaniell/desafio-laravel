<?php

use App\Models\Phone;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleAdminSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RoleDefaultSeeder::class);

    }
}
