<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::group(['middleware' => ['auth']], function() {
    
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@index')->name('home');

    Route::get('/akun', 'AccountController@index')->name('account');
    Route::get('/akun/{id}/edit', 'AccountController@edit')->name('account.edit');
    Route::put('/akun/update', 'AccountController@update')->name('account.update');

    Route::resource('/perusahaan', 'CompanyController')
        ->only('index', 'edit', 'update');
    Route::resource('/cabang', 'BranchController');

    Route::resource('users', 'UserController');
    Route::resource('hak-akses', 'RoleController');
    Route::resource('module', 'PermissionController')
        ->only('index');

    Route::resource('produk/kategori', 'Master\Produk\CategoryController')
        ->except('create');

    Route::resource('produk/satuan', 'Master\Produk\UnitController')
        ->except('create');

    Route::get('produk/harga/export-to-excel', 'Master\Produk\PriceController@exportToExcel');
    Route::resource('produk/harga', 'Master\Produk\PriceController')
        ->except('create', 'store', 'delete');

    Route::get('produk/stok/export-to-excel', 'Master\Produk\StockController@exportToExcel');
    Route::resource('produk/stok', 'Master\Produk\StockController')
        ->except('create', 'store', 'delete');
    
    Route::get('produk/export-to-excel', 'Master\Produk\ProductController@exportToExcel');

    Route::post('produk/create-category', 'Master\Produk\ProductController@create_category');
    Route::post('produk/create-unit', 'Master\Produk\ProductController@create_unit');
    Route::resource('produk', 'Master\Produk\ProductController');

    Route::resource('pelanggan/grup', 'Master\Pelanggan\GroupController')
        ->except('create');
    
    Route::resource('pelanggan/catatan-tabungan', 'Master\Pelanggan\SavingController')
        ->only('index', 'create', 'store');

    Route::get('pelanggan/{id}/tabungan', 'Master\Pelanggan\CustomerController@riwayat');
    Route::post('pelanggan/create-group', 'Master\Pelanggan\CustomerController@create_group');
    Route::resource('pelanggan', 'Master\Pelanggan\CustomerController');

    Route::resource('supplier', 'Master\Supplier\SupplierController');

    Route::resource('karyawan', 'Master\Karyawan\EmployeeController');
    
    Route::post('/belanja/add-to-cart', 'Operational\Belanja\ShoppingController@addToCart');
    Route::delete('/belanja/destroy-cart/{index}', 'Operational\Belanja\ShoppingController@destroyCart');
    Route::post('/belanja/create-supplier', 'Operational\Belanja\ShoppingController@createSupplier');
    Route::post('/belanja/create-payments', 'Operational\Belanja\ShoppingController@createPayment');
    
    Route::get('/belanja/hutang', 'Operational\Belanja\HutangController@index');
    Route::get('/belanja/hutang/{id}', 'Operational\Belanja\HutangController@pelunasan');
    Route::post('/belanja/hutang/{id}', 'Operational\Belanja\HutangController@store');

    Route::resource('belanja', 'Operational\Belanja\ShoppingController')
        ->except('edit', 'update');

    Route::get('gaji-karyawan/print', 'Operational\SallaryController@print');
    Route::resource('gaji-karyawan', 'Operational\SallaryController')
            ->only('index', 'create', 'store');

    Route::resource('operasional/lainnya', 'Operational\OperationalController')
            ->except('show');

    Route::post('/penjualan/{id}/simpanTabungan', 'Selling\SellingController@simpanTabungan');
    Route::post('/penjualan/add-to-cart', 'Selling\SellingController@addToCart');
    Route::get('/penjualan/update-to-cart/{id}', 'Selling\SellingController@editToCart');
    Route::delete('/penjualan/destroy-cart/{index}', 'Selling\SellingController@destroyCart');
    Route::post('/penjualan/create-customer', 'Selling\SellingController@createCustomer');
    Route::post('/penjualan/create-payments', 'Selling\SellingController@createPayment');
    Route::get('penjualan', 'Selling\SellingController@create');
    Route::post('penjualan', 'Selling\SellingController@store');
    Route::get('penjualan/riwayat', 'Selling\SellingController@index');
    Route::get('penjualan/bukti-pembayaran/{id}', 'Selling\SellingController@nota');
    Route::get('penjualan/{id}', 'Selling\SellingController@show');
    Route::delete('penjualan/{id}', 'Selling\SellingController@destroy');

    Route::get('laporan', 'ReportController@index');
    Route::get('laporan/hutang', 'ReportController@hutang');
    Route::get('laporan/piutang', 'ReportController@piutang');

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
});
