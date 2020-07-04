<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Company;
use App\Models\Provincy;
use App\Models\Regency;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:company-list|company-create|company-edit|company-delete', ['only' => ['index','store']]);
         $this->middleware('permission:company-create', ['only' => ['create','store']]);
         $this->middleware('permission:company-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:company-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'Perusahaan',
            'actived' => 'perusahaan',
            'company' => Company::find(1)
        );
        return view('pages.companies.index', $data);
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
            'title' => 'Perusahaan',
            'actived' => 'perusahaan',
            'company' => Company::find(1),
            'provinces' => Provincy::orderBy('name', 'ASC')->get(),
            'regencies' => Regency::orderBy('name', 'ASC')->get()
        );
        return view('pages.companies.edit', $data);
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
        $request->validate([
            'name' => 'required'
        ]);

        $find = Company::find(decrypt($id));
        $find->fill($request->all());
        $find->save();
        return redirect('perusahaan')->with('success', true);
    }
}
