<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `product_categories`
                        (`name`, `description`, `created_at`, `updated_at`)
                        VALUES ('Obat', '', '".date('Y-m-d')."', '".date('Y-m-d')."'),
                               ('Pakan', '', '".date('Y-m-d')."', '".date('Y-m-d')."'),
                               ('Konsentrat', '', '".date('Y-m-d')."', '".date('Y-m-d')."')");
    }
}
