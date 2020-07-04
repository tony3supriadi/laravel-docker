<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;
use App\Models\Branch;
use App\User;
use DB;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'Users',
            'actived' => 'users',
            'users' => User::orderBy('name', 'ASC')->get(),
        );
        return view('pages.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Tambah User',
            'actived' => 'users',
            'roles' => Role::orderBy('name', 'ASC')->get(),
            'branchs' => Branch::orderBy('name', 'ASC')->get()
        );
        return view('pages.users.create', $data);
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
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'email',
            'password' => 'required|min:8|same:confirm-password',
            'roles' => 'required'
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);

            $user = User::create($data);
            $user->assignRole($request->roles);

            return redirect('users')->with('success', true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array(
            'title' => 'Detail User',
            'actived' => 'users',
            'user' => User::find(decrypt($id)),
            'userRole' => User::find(decrypt($id))->roles->pluck('name')->all()
        );
        return view('pages.users.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array(
            'title' => 'Ubah User',
            'actived' => 'users',
            'user' => User::find(decrypt($id)),
            'roles' => Role::orderBy('name', 'ASC')->get(),
            'branchs' => Branch::orderBy('name', 'ASC')->get(),
            'userRole' => User::find(decrypt($id))->roles->pluck('name')->all()
        );
        return view('pages.users.edit', $data);
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
            'username' => 'required',
            'email' => 'email',
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = $request->all();
            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            } else {
                $data = Arr::except($data, array('password'));    
            }

            $user = User::find(decrypt($id));
            $user->fill($data);
            $user->save();
            
            DB::table('model_has_roles')->where('model_id',decrypt($id))->delete();

            $user->assignRole($request->roles);
            return redirect('users')->with('success', true);
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
        $data = User::find(decrypt($id));
        $data->delete();

        return back()->with('success', true);
    }
}
