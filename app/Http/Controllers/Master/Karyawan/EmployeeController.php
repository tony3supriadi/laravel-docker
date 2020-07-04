<?php

namespace App\Http\Controllers\Master\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Employee;
use App\Models\Regency;
use App\Models\Provincy;
use App\Models\Branch;

use Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:employee-list|employee-create|employee-edit|employee-delete', ['only' => ['index','store']]);
         $this->middleware('permission:employee-create', ['only' => ['create','store']]);
         $this->middleware('permission:employee-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:employee-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = [];
        if (Auth::user()->branch_id != 0) {
            $employees = Employee::select('employees.*',
                    'provinces.name as province_name', 
                    'regencies.name as regency_name')
                ->join('provinces', 'provinces.id', '=', 'province_id')
                ->join('regencies', 'regencies.id', '=', 'regency_id')
                ->where('employees.branch_id', '=', Auth::user()->branch_id)
                ->orderBy('name', 'ASC')->get();
        } else {
            $employees = Employee::select('employees.*',
                    'provinces.name as province_name', 
                    'regencies.name as regency_name')
                ->join('provinces', 'provinces.id', '=', 'province_id')
                ->join('regencies', 'regencies.id', '=', 'regency_id')
                ->orderBy('name', 'ASC')->get();
        }

        $data = array(
            'title' => 'Karyawan',
            'actived' => 'master-karyawan',
            'employees' => $employees
        );
        return view('modules.master.employee.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Karyawan',
            'actived' => 'master-karyawan',
            'branchs' => Branch::orderBy('name', 'ASC')->get(),
            'provinces' => Provincy::orderBy('name', 'ASC')->get(),
            'regencies' => Regency::orderBy('name', 'ASC')->get(),
        );
        return view('modules.master.employee.create', $data);
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
            'name' => 'required'
        ], [
            'branch_id.required' => 'Cabang harus dipilih.',
            'name.required' => 'Nama karyawan harus diisi.'
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Employee::create($request->all());
            return redirect('karyawan')->with('success', true);
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
            'title' => 'Karyawan',
            'actived' => 'master-karyawan',
            'employee' => Employee::select('employees.*',
                        'provinces.name as province_name', 
                        'regencies.name as regency_name')
                    ->join('provinces', 'provinces.id', '=', 'province_id')
                    ->join('regencies', 'regencies.id', '=', 'regency_id')
                    ->where('employees.id', '=', decrypt($id))
                    ->first()
        );
        return view('modules.master.employee.show', $data);
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
            'title' => 'Karyawan',
            'actived' => 'master-karyawan',
            'employee' => Employee::find(decrypt($id)),
            'branchs' => Branch::orderBy('name', 'ASC')->get(),
            'provinces' => Provincy::orderBy('name', 'ASC')->get(),
            'regencies' => Regency::orderBy('name', 'ASC')->get(),
        );
        return view('modules.master.employee.edit', $data);
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
        ], [
            'branch_id.required' => 'Cabang harus dipilih.',
            'name.required' => 'Nama karyawan harus diisi.'
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Employee::find(decrypt($id));
            $data->fill($request->all());
            $data->save();

            return redirect('karyawan')->with('success', true);
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
        $data = Employee::find(decrypt($id));
        $data->delete();
        
        return redirect('karyawan')->with('success', true);
    }
}
