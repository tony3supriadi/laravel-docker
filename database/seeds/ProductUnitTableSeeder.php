<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO product_units (name, symbol)
                        VALUES ('Peti', 'peti')");
    }
}
