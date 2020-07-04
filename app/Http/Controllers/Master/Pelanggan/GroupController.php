<?php

namespace App\Http\Controllers\Master\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\CustomerGroups as Group;
use App\Models\ProductPrice as Price;
use App\Models\Branch;
use App\Models\Product;

use Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:pelanggan-group-list|pelanggan-group-create|pelanggan-group-edit|pelanggan-group-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pelanggan-group-create', ['only' => ['create','store']]);
         $this->middleware('permission:pelanggan-group-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pelanggan-group-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = [];
        if (Auth::user()->branch_id > 0) {
            $groups = Group::orderBy('name', 'ASC')
                ->where('branch_id', '=', Auth::user()->branch_id)
                ->get();
        } else {
            $groups = Group::orderBy('name', 'ASC')->get();
        }

        $data = array(
            'title' => 'Grup Pelanggan',
            'actived' => 'master-pelanggan',
            'branchs' => Branch::orderBy('name', 'ASC')->get(),
            'groups' => $groups
        );
        return view('modules.master.customer.group.index', $data);
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
            'branch_id.required' => 'Cabang haris dipilih',
            'name.required' => 'Nama kategori harus diisi.'
        ]);
        
        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Group::create($request->all());

            foreach(Product::all() as $item) {
                Price::create([
                    'product_id' => $item->id,
                    'group_id' => $data->id,
                    'branch_id' => $request->branch_id,
                    'price' => $item->price,
                    'description' => 'Harga jual ' . strtolower($request->name) . ' produk ' . strtolower($item->name) . ' ('. $item->code .').'
                ]);
            }

            return redirect('pelanggan/grup')->with('success', true);
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
            'title' => 'Grup Pelanggan',
            'actived' => 'master-pelanggan',
            'group' => Group::find(decrypt($id))
        );
        return view('modules.master.customer.group.show', $data);
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
            'title' => 'Grup Pelanggan',
            'actived' => 'master-pelanggan',
            'branchs' => Branch::orderBy('name', 'ASC')->get(),
            'group' => Group::find(decrypt($id))
        );
        return view('modules.master.customer.group.edit', $data);
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
                        ['name.required' => 'Nama kategori harus diisi.']);
        
        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Group::find(decrypt($id));
            $data->fill($request->all());
            $data->save();

            return redirect('pelanggan/grup')->with('success', true);
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
        Price::where('group_id', '=', decrypt($id))->delete();
        
        $data = Group::find(decrypt($id));
        $data->delete();
        
        return redirect('pelanggan/grup')->with('success', true);
    }
}
