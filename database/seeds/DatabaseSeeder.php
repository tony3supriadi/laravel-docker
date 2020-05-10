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
        $this->call(PermissionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(BankTableSeeder::class);
        $this->call(ProductUnitTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
        $this->call(RegencyTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(BranchTableSeeder::class);
    }
}
