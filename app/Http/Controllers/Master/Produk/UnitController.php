<?php

namespace App\Http\Controllers\Master\Produk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\ProductUnit as Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:produk-unit-list|produk-unit-create|produk-unit-edit|produk-unit-delete', ['only' => ['index','store']]);
         $this->middleware('permission:produk-unit-create', ['only' => ['create','store']]);
         $this->middleware('permission:produk-unit-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:produk-unit-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'Satuan Produk',
            'actived' => 'master-produk',
            'units' => Unit::orderBy('name', 'ASC')->get()
        );
        return view('modules.master.product.unit.index', $data);
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
                        [
                            'name' => 'required', 
                            'symbol' => 'required'
                        ], [
                            'name.required' => 'Nama satuan harus diisi.',
                            'symbol.required' => 'Simbol satuan harus diisi.'
                        ]);
        
        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Unit::create($request->all());
            return redirect('produk/satuan')->with('success', true);
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
            'title' => 'Satuan Produk',
            'actived' => 'master-produk',
            'unit' => Unit::find(decrypt($id))
        );
        return view('modules.master.product.unit.show', $data);
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
            'title' => 'Satuan Produk',
            'actived' => 'master-produk',
            'unit' => Unit::find(decrypt($id))
        );
        return view('modules.master.product.unit.edit', $data);
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
                        ['name' => 'required', 'symbol' => 'required'],
                        ['name.required' => 'Nama satuan harus diisi.','symbol.required' => 'Simbol satuan harus diisi.']);
        
        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Unit::find(decrypt($id));
            $data->fill($request->all());
            $data->save();

            return redirect('produk/satuan')->with('success', true);
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
        $data = Unit::find(decrypt($id));
        $data->delete();
        
        return redirect('produk/satuan')->with('success', true);
    }
}
