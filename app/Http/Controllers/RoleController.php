<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $i = 0;
        $permissions = [];
        foreach(Permission::where('parent', '=', 0)
            ->orderBy('id', 'DESC')
            ->get() as $parent) {
                $parent["childs"] = Permission::where('parent', '=', $parent->id)->get();
                $permissions[$i] = $parent;
                $i++;
            }

        $data = array(
            'title' => 'Hak Akses',
            'actived' => 'users',
            'navigate' => 'main-menu',
            'roles' => Role::orderBy('name', 'ASC')->get(),
            'permissions' => $permissions
        );
        return view('pages.roles.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:roles',
            'permission' => 'required'
        ], [
            'name.required' => 'Nama akses harus diisi.',
            'name.unique' => 'Nama akses '.$request->name.' sudah ada.',
            'permission.required' => 'Minimal 1 module terpilih.'
        ]);
        
        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $role = Role::create(['name' => $request->name]);
            $role->syncPermissions($request->permission);

            return redirect('hak-akses')->with('success', true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $i = 0;
        $permissions = [];
        foreach(Permission::where('parent', '=', 0)
            ->orderBy('id', 'DESC')
            ->get() as $parent) {
                $parent["childs"] = Permission::where('parent', '=', $parent->id)->get();
                $permissions[$i] = $parent;
                $i++;
            }

        $data = array(
            'title' => 'Ubah Hak Akses',
            'actived' => 'users',
            'navigate' => 'main-menu',
            'role' => Role::find(decrypt($id)),
            'permissions' => $permissions,
            'rolePermissions' => DB::table("role_has_permissions")->where("role_has_permissions.role_id", decrypt($id))
                                    ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                                    ->all()
        );
        return view('pages.roles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'permission' => 'required',
        ], [
            'name.required' => 'Nama akses harus diisi.',
            'permission.required' => 'Minimal 1 module terpilih.'
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $role = Role::find(decrypt($id));
            $role->name = $request->input('name');
            $role->save();
        
            $role->syncPermissions($request->input('permission'));
            return redirect('hak-akses')->with('success', true);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find(decrypt($id));
        $role->delete();

        return redirect('hak-akses')->with('success', true);
    }
}
