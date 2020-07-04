<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;
use Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'Akunku',
            'actived' => 'akun',
            'userRole' => User::find(Auth::user()->id)->roles->pluck('name')->all()
        );
        return view('pages.accounts.index', $data);
    }

    public function edit($id)
    {
        $data = array(
            'title' => 'Ubah User',
            'actived' => 'users',
            'user' => User::find(decrypt($id)),
        );
        return view('pages.accounts.edit', $data);
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

            return redirect('akun')->with('success', true);
        }
    }
}
