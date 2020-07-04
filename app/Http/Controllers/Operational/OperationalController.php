<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\OperationalOther as Other;

class OperationalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:operational-list|operational-create|operational-edit|operational-delete', ['only' => ['index','store']]);
         $this->middleware('permission:operational-create', ['only' => ['create','store']]);
         $this->middleware('permission:operational-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:operational-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = isset($_GET['m']) 
            ? $_GET['y'].'-'.$_GET['m'].'%' 
            : date('Y-m').'%';

        $data = array(
            'title' => 'Operasional Lainnya',
            'actived' => 'op-lainnya',
            'operationals' => Other::where('created_at', 'LIKE', $filter)->get(),
            'total' => Other::where('created_at', 'LIKE', $filter)->sum('nominal')
        );
        return view('modules.operational.others.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Operasional Lainnya',
            'actived' => 'op-lainnya',
        );
        return view('modules.operational.others.create', $data);
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
            ['nominal' => 'required|numeric'],
            ['nominal.required' => 'Nominal operasional harus diisi.',
             'nominal.numeric' => 'Nominal operasional harus berupa angka']);
        
        if ($validate->fails()) {
            return back()->withInputs()->withError($validate);
        } else {
            $data = Other::create($request->all());
            return redirect('/operasional/lainnya');
        }
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
            'title' => 'Operasional Lainnya',
            'actived' => 'op-lainnya',
            'operational' => Other::find(decrypt($id))
        );
        return view('modules.operational.others.edit', $data);
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
            ['nominal' => 'required|numeric'],
            ['nominal.required' => 'Nominal operasional harus diisi.',
             'nominal.numeric' => 'Nominal operasional harus berupa angka']);
        
        if ($validate->fails()) {
            return back()->withInputs()->withError($validate);
        } else {
            $data = Other::find(decrypt($id));
            $data->fill($request->all());
            $data->save();

            return redirect('/operasional/lainnya');
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
        $data = Other::find(decrypt($id));
        $data->delete();
        
        return redirect('/operasional/lainnya');
    }
}
