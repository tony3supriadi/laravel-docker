<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','store']]);
         $this->middleware('permission:permission-create', ['only' => ['create','store']]);
         $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
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
            'title' => 'Module',
            'actived' => 'users',
            'navigate' => 'main-menu',
            'permissions' => $permissions
        );
        return view('pages.permissions.index', $data);
    }
}
