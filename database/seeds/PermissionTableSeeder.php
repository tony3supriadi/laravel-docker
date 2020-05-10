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
            ['name' => 'user-list', 'name_string' => 'Users', 'parent_id' => 0],
            ['name' => 'user-create', 'name_string' => 'Tambah', 'parent_id' => 1],
            ['name' => 'user-update', 'name_string' => 'Ubah', 'parent_id' => 1],
            ['name' => 'user-delete', 'name_string' => 'Hapus', 'parent_id' => 1],
            ['name' => 'role-list', 'name_string' => 'Hak Akses', 'parent_id' => 0],
            ['name' => 'role-create', 'name_string' => 'Tambah', 'parent_id' => 5],
            ['name' => 'role-update', 'name_string' => 'Ubah', 'parent_id' => 5],
            ['name' => 'role-delete', 'name_string' => 'Hapus', 'parent_id' => 5],
            ['name' => 'permission-list', 'name_string' => 'Module', 'parent_id' => 0],
            ['name' => 'bank-list', 'name_string' => 'Bank', 'parent_id' => 0],
            ['name' => 'provincy-list', 'name_string' => 'Provinsi', 'parent_id' => 0],
            ['name' => 'regency-list', 'name_string' => 'Kota/Kabupaten', 'parent_id' => 0],
            ['name' => 'district-list', 'name_string' => 'Kecamatan', 'parent_id' => 0],
        ];
    
         foreach ($permissions as $permission) {
              Permission::create($permission);
         }
    }
}
