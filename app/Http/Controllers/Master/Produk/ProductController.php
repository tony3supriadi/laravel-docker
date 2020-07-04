<?php

namespace App\Http\Controllers\Master\Produk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;
use App\Models\ProductCategory as Category;
use App\Models\ProductUnit as Unit;
use App\Models\ProductStock as Stock;
use App\Models\ProductPrice as Price;
use App\Models\CustomerGroups as Group;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:produk-list|produk-create|produk-edit|produk-delete', ['only' => ['index','store']]);
         $this->middleware('permission:produk-create', ['only' => ['create','store']]);
         $this->middleware('permission:produk-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:produk-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'Produk',
            'actived' => 'master-produk',
            'products' => Product::select('products.*', 'product_categories.name as category_name', 'product_units.symbol as symbol')
                            ->join('product_categories', 'product_categories.id', '=', 'category_id')
                            ->join('product_units', 'product_units.id', '=', 'unit_id')
                            ->orderBy('products.name', 'ASC')->get()
        );
        return view('modules.master.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Produk',
            'actived' => 'master-produk',
            'units' => Unit::orderBy('name', 'ASC')->get(),
            'categories' => Category::orderBy('name', 'ASC')->get()
        );
        return view('modules.master.product.create', $data);
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
            'code' => 'required|min:8|max:16|unique:products',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'stockmin' => 'required|numeric',
            'unit_id' => 'required',
            'category_id' => 'required'
        ], [
            'code.required' => 'Barcode harus diisi.',
            'code.min' => 'Barcode minimal 8 karakter.',
            'code.max' => 'Barcode maximal 16 karakter.',
            'code.unique' => 'Barcode sudah terdaftar.',
            'name.required' => 'Nama produk harus diisi.',
            'price.required' => 'Harga jual produk harus diisi.',
            'price.numeric' => 'Harga jual produk harus berupa angka.',
            'stock.required' => 'Stok awal produk harus diisi.',
            'stock.numeric' => 'Stok awal produk harus berupa angka.',
            'stockmin.required' => 'Stok minimal produk harus diisi.',
            'stockmin.numeric' => 'Stok minimal produk harus berupa angka.',
            'unit_id.required' => 'Satuan belum dipilih.',
            'category_id.required' => 'Kategori belum dipilih.'
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Product::create($request->all());

            $stok = Stock::create([
                'product_id' => $data->id,
                'branch_id' => 1,
                'stock_status' => 'Masuk',
                'stock_nominal' => $data->stock,
                'stock_saldo' => $data->stock,
                'description' => 'Stok awal produk ' . strtolower($data->name) . ' ('. $data->code .').'
            ]);

            foreach(Group::all() as $group) {
                $price = Price::create([
                    'product_id' => $data->id,
                    'branch_id' => 1,
                    'group_id' => $group->id,
                    'price' => $request->price,
                    'description' => 'Harga jual ' . strtolower($group->name) . ' produk ' . strtolower($data->name) . ' ('. $data->code .').'
                ]);
            }

            return redirect('produk')->with('success', true);
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
            'title' => 'Produk',
            'actived' => 'master-produk',
            'product' => Product::select('products.*', 'product_categories.name as category_name', 'product_units.symbol as symbol')
                            ->join('product_categories', 'product_categories.id', '=', 'category_id')
                            ->join('product_units', 'product_units.id', '=', 'unit_id')
                            ->where('products.id', '=', decrypt($id))->first(),
        );
        return view('modules.master.product.show', $data);
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
            'title' => 'Produk',
            'actived' => 'master-produk',
            'product' => Product::select('products.*', 'product_categories.name as category_name', 'product_units.symbol as symbol')
                            ->join('product_categories', 'product_categories.id', '=', 'category_id')
                            ->join('product_units', 'product_units.id', '=', 'unit_id')
                            ->where('products.id', '=', decrypt($id))->first(),
            'units' => Unit::orderBy('name', 'ASC')->get(),
            'categories' => Category::orderBy('name', 'ASC')->get()
        );
        return view('modules.master.product.edit', $data);
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
            'code' => 'required|min:8|max:16',
            'name' => 'required',
            'stockmin' => 'required|numeric',
            'unit_id' => 'required',
            'category_id' => 'required'
        ], [
            'code.required' => 'Barcode harus diisi.',
            'code.min' => 'Barcode minimal 8 karakter.',
            'code.max' => 'Barcode maximal 16 karakter.',
            'name.required' => 'Nama produk harus diisi.',
            'stockmin.required' => 'Stok minimal produk harus diisi.',
            'stockmin.numeric' => 'Stok minimal produk harus berupa angka.',
            'unit_id.required' => 'Satuan belum dipilih.',
            'category_id.required' => 'Kategori belum dipilih.'
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $data = Product::find(decrypt($id));
            $data->fill($request->all());
            $data->save();

            return redirect('produk')->with('success', true);
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
        Price::where('product_id', '=', decrypt($id))->delete();
        Stock::where('product_id', '=', decrypt($id))->delete();
        
        $data = Product::find(decrypt($id));
        $data->delete();
        
        return redirect('produk')->with('success', true);
    }

    public function create_category(Request $request) {
        $data = Category::create($request->all());
        return back()->with('category_id', $data->id);
    }

    public function create_unit(Request $request) {
        $data = Unit::create($request->all());
        return back()->with('unit_id', $data->id);
    }

    public function exportToExcel() {
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=data-produk-".date('Ymd').time().".xls");

        $data = array(
            'products' => Product::select('products.*', 'product_categories.name as category_name', 'product_units.symbol as symbol')
                            ->join('product_categories', 'product_categories.id', '=', 'category_id')
                            ->join('product_units', 'product_units.id', '=', 'unit_id')
                            ->orderBy('products.name', 'ASC')->get()
        );
        return view('modules.master.product.excel', $data);
    }
}
