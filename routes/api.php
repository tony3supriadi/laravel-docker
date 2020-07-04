<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Product;

Route::get('produk/{code}', function($id) {
    $data = Product::select('products.*', 
                            'product_units.name as unit_name', 
                            'product_units.symbol as unit_symbol')
                    ->join('product_units', 'product_units.id', '=', 'unit_id')
                    ->where('products.id', '=', $id)
                    ->first();
    return response()->json($data);
});
