<?php

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
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PropertySeeder::class);
        $this->call(HouseSeeder::class);
        $this->call(RentLogSeeder::class);
        $this->call(TenantSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
