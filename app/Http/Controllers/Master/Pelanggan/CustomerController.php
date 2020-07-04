<?php

namespace App\Http\Controllers\Master\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Customer;
use App\Models\CustomerGroups as Group;
use App\Models\Regency;
use App\Models\Provincy;

use Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:pelanggan-list|pelanggan-create|pelanggan-edit|pelanggan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pelanggan-create', ['only' => ['create','store']]);
         $this->middleware('permission:pelanggan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pelanggan-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = [];
        if (Auth::user()->branch_id != 0) {
            $customers = Customer::select('customers.*', 'customer_groups.name as group_name')
                ->join('customer_groups', 'customer_groups.id', '=', 'group_id')
                ->where('customer_groups.branch_id', '=', Auth::user()->branch_id)
                ->orderBy('name', 'ASC')->get();
        } else {
            $customers = Customer::select('customers.*', 'customer_groups.name as group_name')
                ->join('customer_groups', 'customer_groups.id', '=', 'group_id')
                ->orderBy('name', 'ASC')->get();
        }

        $data = array(
            'title' => 'Pelanggan',
            'actived' => 'master-pelanggan',
            'customers' => $customers
        );
        return view('modules.master.customer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Pelanggan',
            'actived' => 'master-pelanggan',
            'groups' => Group::orderBy('name', 'ASC')->get(),
            'provinces' => Provincy::orderBy('name', 'ASC')->get(),
            'regencies' => Regency::orderBy('name', 'ASC')->get()
        );
        return view('modules.master.customer.create', $data);
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
            'group_id' => 'required',
            'name' => 'required',
        ], [
            'group_id.required' => 'Grup harus dipilih.',
            'name.required' => 'Nama pelanggan harus diisi.',
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Customer::create($request->all());
            return redirect('pelanggan')->with('success', true);
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
            'title' => 'Pelanggan',
            'actived' => 'master-pelanggan',
            'customer' => Customer::select('customers.*',
                    'customer_groups.name as group_name',
                    'regencies.name as regency_name',
                    'provinces.name as province_name')
                ->join('customer_groups', 'customer_groups.id', '=', 'group_id')
                ->join('regencies', 'regencies.id', '=', 'regency_id')
                ->join('provinces', 'provinces.id', '=', 'province_id')
                ->where('customers.id', '=', decrypt($id))
                ->first()
        );
        return view('modules.master.customer.show', $data);
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
            'title' => 'Pelanggan',
            'actived' => 'master-pelanggan',
            'customer' => Customer::find(decrypt($id)),
            'groups' => Group::orderBy('name', 'ASC')->get(),
            'provinces' => Provincy::orderBy('name', 'ASC')->get(),
            'regencies' => Regency::orderBy('name', 'ASC')->get()
        );
        return view('modules.master.customer.edit', $data);
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
            'group_id' => 'required',
            'name' => 'required',
        ], [
            'group_id.required' => 'Grup harus dipilih.',
            'name.required' => 'Nama pelanggan harus diisi.',
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Customer::find(decrypt($id));
            $data->fill($request->all());
            $data->save();

            return redirect('pelanggan')->with('success', true);
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
        $data = Customer::find(decrypt($id));
        $data->delete();
        
        return redirect('pelanggan')->with('success', true);
    }

    public function create_group(Request $request)
    {
        $data = Group::create([
            'branch_id' => Auth::user()->branch_id != 0 ? Auth::user()->branch_id : 1,
            'name' => $request->name
        ]);
        return back()->with('group_id', $data->id);
    }
}
