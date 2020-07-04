<?php

use Illuminate\Database\Seeder;

use App\Models\CustomerGroups as Group;

class CustomerGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            'branch_id' => 1,
            'name' => 'Umum'
        ]);
    }
}
