<?php

namespace App\Http\Controllers\Master\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Supplier;
use App\Models\Regency;
use App\Models\Provincy;
use App\Models\Bank;
use App\Models\Branch;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:supplier-list|supplier-create|supplier-edit|supplier-delete', ['only' => ['index','store']]);
         $this->middleware('permission:supplier-create', ['only' => ['create','store']]);
         $this->middleware('permission:supplier-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'Supplier',
            'actived' => 'master-supplier',
            'suppliers' => Supplier::orderBy('name', 'ASC')->get()
        );
        return view('modules.master.supplier.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Supplier',
            'actived' => 'master-supplier',
            'branchs' => Branch::orderBy('name', 'ASC')->get(),
            'provinces' => Provincy::orderBy('name', 'ASC')->get(),
            'regencies' => Regency::orderBy('name', 'ASC')->get(),
            'banks' => Bank::all()
        );
        return view('modules.master.supplier.create', $data);
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
            'branch_id' => 'required',
            'name' => 'required',
            'bank_id' => 'required'
        ], [
            'branch_id.required' => 'Cabang harus dipilih.',
            'name.required' => 'Nama supplier harus diisi.',
            'bank_id.required' => 'Bank harus dipilih.',
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Supplier::create($request->all());
            return redirect('supplier')->with('success', true);
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
            'title' => 'Supplier',
            'actived' => 'master-supplier',
            'supplier' => Supplier::select('suppliers.*',
                        'provinces.name as province_name', 
                        'regencies.name as regency_name',
                        'banks.code as bank_code',
                        'banks.name as bank_name')
                    ->join('provinces', 'provinces.id', '=', 'province_id')
                    ->join('regencies', 'regencies.id', '=', 'regency_id')
                    ->join('banks', 'banks.id', '=', 'bank_id')
                    ->where('suppliers.id', '=', decrypt($id))
                    ->first()
        );
        return view('modules.master.supplier.show', $data);
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
            'title' => 'Supplier',
            'actived' => 'master-supplier',
            'supplier' => Supplier::find(decrypt($id)),
            'branchs' => Branch::orderBy('name', 'ASC')->get(),
            'provinces' => Provincy::orderBy('name', 'ASC')->get(),
            'regencies' => Regency::orderBy('name', 'ASC')->get(),
            'banks' => Bank::all()
        );
        return view('modules.master.supplier.edit', $data);
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
            'branch_id' => 'required',
            'name' => 'required',
            'bank_id' => 'required'
        ], [
            'branch_id.required' => 'Cabang harus dipilih.',
            'name.required' => 'Nama supplier harus diisi.',
            'bank_id.required' => 'Bank harus dipilih.',
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Supplier::find(decrypt($id));
            $data->fill($request->all());
            $data->save();

            return redirect('supplier')->with('success', true);
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
        $data = Supplier::find(decrypt($id));
        $data->delete();
        
        return redirect('supplier')->with('success', true);
    }
}
