<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Anonimous', 
            'username' => 'me',
        	'email' => 'anonimous@dev.me',
            'password' => bcrypt('devid1234'),
            'branch_id' => 0
        ]);
  
        $role = Role::create(['name' => 'Anonimous']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
