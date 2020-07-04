<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'user-list', 'name_string' => 'Users', 'parent' => 0],
            ['name' => 'user-create', 'name_string' => 'Tambah', 'parent' => 1],
            ['name' => 'user-edit', 'name_string' => 'Ubah', 'parent' => 1],
            ['name' => 'user-delete', 'name_string' => 'Hapus', 'parent' => 1],
            ['name' => 'role-list', 'name_string' => 'Hak Akses', 'parent' => 0],
            ['name' => 'role-create', 'name_string' => 'Tambah', 'parent' => 5],
            ['name' => 'role-edit', 'name_string' => 'Ubah', 'parent' => 5],
            ['name' => 'role-delete', 'name_string' => 'Hapus', 'parent' => 5],
            ['name' => 'permission-list', 'name_string' => 'Module', 'parent' => 0],
            ['name' => 'company-list', 'name_string' => 'Perusahaan', 'parent' => 0],
            ['name' => 'company-edit', 'name_string' => 'Ubah', 'parent' => 10],
            ['name' => 'branch-list', 'name_string' => 'Cabang', 'parent' => 0],
            ['name' => 'branch-create', 'name_string' => 'Tambah', 'parent' => 12],
            ['name' => 'branch-edit', 'name_string' => 'Ubah', 'parent' => 12],
            ['name' => 'branch-delete', 'name_string' => 'Hapus', 'parent' => 12],
            ['name' => 'produk-list', 'name_string' => 'Produk', 'parent' => 0],
            ['name' => 'produk-create', 'name_string' => 'Tambah', 'parent' => 16],
            ['name' => 'produk-edit', 'name_string' => 'Ubah', 'parent' => 16],
            ['name' => 'produk-delete', 'name_string' => 'Hapus', 'parent' => 16],
            ['name' => 'produk-category-list', 'name_string' => 'Produk - Kategori', 'parent' => 0],
            ['name' => 'produk-category-create', 'name_string' => 'Tambah', 'parent' => 20],
            ['name' => 'produk-category-edit', 'name_string' => 'Ubah', 'parent' => 20],
            ['name' => 'produk-category-delete', 'name_string' => 'Hapus', 'parent' => 20],
            ['name' => 'produk-unit-list', 'name_string' => 'Produk - Satuan', 'parent' => 0],
            ['name' => 'produk-unit-create', 'name_string' => 'Tambah', 'parent' => 24],
            ['name' => 'produk-unit-edit', 'name_string' => 'Ubah', 'parent' => 24],
            ['name' => 'produk-unit-delete', 'name_string' => 'Hapus', 'parent' => 24],
            ['name' => 'produk-price-list', 'name_string' => 'Produk - Harga', 'parent' => 0],
            ['name' => 'produk-price-create', 'name_string' => 'Tambah', 'parent' => 28],
            ['name' => 'produk-price-edit', 'name_string' => 'Ubah', 'parent' => 28],
            ['name' => 'produk-price-delete', 'name_string' => 'Hapus', 'parent' => 28],
            ['name' => 'produk-stock-list', 'name_string' => 'Produk - Stok', 'parent' => 0],
            ['name' => 'produk-stock-create', 'name_string' => 'Tambah', 'parent' => 32],
            ['name' => 'produk-stock-edit', 'name_string' => 'Ubah', 'parent' => 32],
            ['name' => 'produk-stock-delete', 'name_string' => 'Hapus', 'parent' => 32],
            ['name' => 'produk-barcode-list', 'name_string' => 'Produk - Barcode', 'parent' => 0],
            ['name' => 'pelanggan-group-list', 'name_string' => 'Pelanggan - Group', 'parent' => 0],
            ['name' => 'pelanggan-group-create', 'name_string' => 'Tambah', 'parent' => 37],
            ['name' => 'pelanggan-group-edit', 'name_string' => 'Ubah', 'parent' => 37],
            ['name' => 'pelanggan-group-delete', 'name_string' => 'Hapus', 'parent' => 37],
            ['name' => 'pelanggan-list', 'name_string' => 'Pelanggan', 'parent' => 0],
            ['name' => 'pelanggan-create', 'name_string' => 'Tambah', 'parent' => 41],
            ['name' => 'pelanggan-edit', 'name_string' => 'Ubah', 'parent' => 41],
            ['name' => 'pelanggan-delete', 'name_string' => 'Hapus', 'parent' => 41],
            ['name' => 'supplier-list', 'name_string' => 'Supplier', 'parent' => 0],
            ['name' => 'supplier-create', 'name_string' => 'Tambah', 'parent' => 45],
            ['name' => 'supplier-edit', 'name_string' => 'Ubah', 'parent' => 45],
            ['name' => 'supplier-delete', 'name_string' => 'Hapus', 'parent' => 45],
            ['name' => 'employee-list', 'name_string' => 'Karyawan', 'parent' => 0],
            ['name' => 'employee-create', 'name_string' => 'Tambah', 'parent' => 49],
            ['name' => 'employee-edit', 'name_string' => 'Ubah', 'parent' => 49],
            ['name' => 'employee-delete', 'name_string' => 'Hapus', 'parent' => 49],
            ['name' => 'belanja-list', 'name_string' => 'Belanja', 'parent' => 0],
            ['name' => 'belanja-create', 'name_string' => 'Tambah', 'parent' => 53],
            ['name' => 'belanja-edit', 'name_string' => 'Ubah', 'parent' => 53],
            ['name' => 'belanja-delete', 'name_string' => 'Hapus', 'parent' => 53],
            ['name' => 'sallary-list', 'name_string' => 'Gaji Karyawan', 'parent' => 0],
            ['name' => 'sallary-create', 'name_string' => 'Tambah', 'parent' => 57],
            ['name' => 'operational-list', 'name_string' => 'Operational Lainnya', 'parent' => 0],
            ['name' => 'operational-create', 'name_string' => 'Tambah', 'parent' => 59],
            ['name' => 'operational-edit', 'name_string' => 'Ubah', 'parent' => 59],
            ['name' => 'operational-delete', 'name_string' => 'Hapus', 'parent' => 59],
            ['name' => 'belanja-hutang', 'name_string' => 'Daftar Hutang', 'parent' => 0],
            ['name' => 'belanja-hutang-input', 'name_string' => 'Input Pembayaran Hutang', 'parent' => 0],
            ['name' => 'penjualan', 'name_string' => 'Penjualan', 'parent' => 0],
            ['name' => 'penjualan-riwayat', 'name_string' => 'Riwayat Penjualan', 'parent' => 0],
            ['name' => 'penjualan-piutang', 'name_string' => 'Piutang Penjualan', 'parent' => 0],
            ['name' => 'penjualan-piutang-input', 'name_string' => 'Input Piutang Penjualan', 'parent' => 0],
        ];
    
         foreach ($permissions as $permission) {
              Permission::create($permission);
         }
    }
}
