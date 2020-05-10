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
                        VALUES ('Kilogram', 'kg'), 
                               ('Ons', 'ons'), 
                               ('Grams', 'gr'), 
                               ('Liter', 'l'), 
                               ('Mililiter', 'ml'), 
                               ('Botol', 'btl'), 
                               ('Kardus', 'dus'), 
                               ('Pieces', 'pcs'), 
                               ('Paket', 'pack')");
    }
}
