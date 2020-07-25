<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                        VALUES ('Telor', '', '".date('Y-m-d')."', '".date('Y-m-d')."'),
                               ('Obat', '', '".date('Y-m-d')."', '".date('Y-m-d')."'),
                               ('Pakan', '', '".date('Y-m-d')."', '".date('Y-m-d')."'),
                               ('Konsentrat', '', '".date('Y-m-d')."', '".date('Y-m-d')."')");
        
        DB::insert("INSERT INTO `products`
                        (`category_id`, `unit_id`, `code`, `name`, 
                         `purchase_price`, `price`, `stock`, `stockmin`,
                         `description`, `created_at`, `updated_at`)
                        VALUES (1, 1, ".time().", 'Telor', 120000, 120000, 0, 0, '', 
                                '".date('Y-m-d')."','".date('Y-m-d')."')");

        DB::insert("INSERT INTO `product_prices` VALUES 
            (1, 1, 1, 1, 120000, '', '".date('Y-m-d')."','".date('Y-m-d')."')");
        
        DB::insert("INSERT INTO `product_stocks` VALUES
            (1, 1, 1, 'Masuk', 0, 0, '', '".date('Y-m-d')."','".date('Y-m-d')."')");

        DB::insert("INSERT INTO `suppliers` (`branch_id`, `name`, `bank_id`, `created_at`, `updated_at`) VALUES
            (1, 'Supplier Pelanggan', 1, '".date('Y-m-d')."','".date('Y-m-d')."')");
    }
}
