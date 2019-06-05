<?php

use Illuminate\Database\Seeder;

class RentLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\RentLog::class, 100)->create();
    }
}
