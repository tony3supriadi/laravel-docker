<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Branch;
use App\Models\Regency;
use App\Models\Provincy;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:branch-list|branch-create|branch-edit|branch-delete', ['only' => ['index','store']]);
         $this->middleware('permission:branch-create', ['only' => ['create','store']]);
         $this->middleware('permission:branch-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:branch-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'Cabang',
            'actived' => 'perusahaan',
            'branchs' => Branch::all()
        );
        return view('pages.branchs.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Cabang',
            'actived' => 'perusahaan',
            'regencies' => Regency::orderBy('name', 'ASC')->get(),
            'provinces' => Provincy::orderBy('name', 'ASC')->get()
        );
        return view('pages.branchs.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
            ['name' => 'required'], [ 'name.required' => 'Nama Cabang harus diisi.' ]);
        
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $branch = Branch::create($request->all());
            return redirect('cabang')
                ->with('success', true);
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
            'title' => 'Cabang',
            'actived' => 'perusahaan',
            'branch' => Branch::find(decrypt($id))
        );
        return view('pages.branchs.show', $data);
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
            'title' => 'Cabang',
            'actived' => 'perusahaan',
            'branch' => Branch::find(decrypt($id)),
            'regencies' => Regency::orderBy('name', 'ASC')->get(),
            'provinces' => Provincy::orderBy('name', 'ASC')->get()
        );
        return view('pages.branchs.edit', $data);
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
        $validate = Validator::make($request->all(),
            ['name' => 'required'], 
            ['name.required' => 'Nama Cabang harus diisi.']);
        
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $branch = Branch::find(decrypt($id));
            $branch->fill($request->all());
            $branch->save();

            return redirect('cabang')
                ->with('success', true);
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
        $branch = Branch::find(decrypt($id));
        $branch->delete();

        return redirect('cabang')
                ->with('success', true);
    }
}
