<?php

namespace App\Http\Controllers\Master\Produk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\ProductCategory as Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:produk-category-list|produk-category-create|produk-category-edit|produk-category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:produk-category-create', ['only' => ['create','store']]);
         $this->middleware('permission:produk-category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:produk-category-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'Kategori Produk',
            'actived' => 'master-produk',
            'categories' => Category::orderBy('name', 'ASC')->get()
        );
        return view('modules.master.product.category.index', $data);
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
                        ['name' => 'required'],
                        ['name.required' => 'Nama kategori harus diisi.']);
        
        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Category::create($request->all());
            return redirect('produk/kategori')->with('success', true);
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
            'title' => 'Kategori Produk',
            'actived' => 'master-produk',
            'category' => Category::find(decrypt($id))
        );
        return view('modules.master.product.category.show', $data);
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
            'title' => 'Kategori Produk',
            'actived' => 'master-produk',
            'category' => Category::find(decrypt($id))
        );
        return view('modules.master.product.category.edit', $data);
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
            $data = Category::find(decrypt($id));
            $data->fill($request->all());
            $data->save();

            return redirect('produk/kategori')->with('success', true);
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
        $data = Category::find(decrypt($id));
        $data->delete();
        
        return redirect('produk/kategori')->with('success', true);
    }
}
