<?php

namespace App\Http\Controllers\Master\Produk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth;

use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductStock as Stock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:produk-stock-list|produk-stock-create|produk-stock-edit|produk-stock-delete', ['only' => ['index','store']]);
         $this->middleware('permission:produk-stock-create', ['only' => ['create','store']]);
         $this->middleware('permission:produk-stock-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:produk-stock-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = [];
        $productItems = Product::orderBy('name', 'ASC')->get();
        foreach($productItems as $item) {
            if (Auth::user()->branch_id != 0) {
                $products[] = Stock::select('product_stocks.*',
                                    'products.code as product_code',
                                    'products.name as product_name',
                                    'products.stockmin as product_stockmin')
                                ->where('branch_id', '=', Auth::user()->branch_id)
                                ->where('product_id', '=', $item->id)
                                ->join('products', 'products.id', '=', 'product_id')
                                ->orderBy('id', 'DESC')
                                ->first();
            } else {
                $products[] = Stock::select('product_stocks.*',
                                    'products.code as product_code',
                                    'products.name as product_name',
                                    'products.stockmin as product_stockmin',
                                    'product_units.symbol')
                                ->where('product_id', '=', $item->id)
                                ->join('products', 'products.id', '=', 'product_id')
                                ->join('product_units', 'unit_id', '=', 'product_units.id')
                                ->orderBy('id', 'DESC')
                                ->first();
            }
        }

        $data = array(
            'title' => 'Stok Produk',
            'actived' => 'master-produk',
            'products' => $products
        );
        return view('modules.master.product.stock.index', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $product = Product::find(decrypt($id));
        $product_stocks = Stock::select('product_stocks.*',
                                'products.code as product_code',
                                'products.name as product_name',
                                'products.stockmin as product_stockmin',
                                'product_units.symbol')
                            ->where('product_id', '=', decrypt($id))
                            ->whereBetween('product_stocks.created_at', $request->start ? 
                                    [$request->start . ' 00:00:00', $request->end . ' 23.59.59'] : 
                                    [date('Y-m').'-1 00:00:00', date('Y-m-d').' 23:59:59'])
                            ->join('products', 'products.id', '=', 'product_id')
                            ->join('product_units', 'unit_id', '=', 'product_units.id')
                            ->orderBy('id', 'DESC')
                            ->get();
        
        $data = array(
            'title' => 'Stok Produk',
            'actived' => 'master-produk',
            'id' => $id,
            'product' => $product,
            'products' => $product_stocks
        );

        if ($request->exportTo) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=stok-produk-"
                .strtolower(str_replace(" ","-",$product->name))
                ."-".date('Ymd').time().".xls");
                
            return view('modules.master.product.stock.showExel', $data);
        }

        return view('modules.master.product.stock.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find(decrypt($id));
        $branch = Branch::find(Auth::user()->branch_id);

        $data = array(
            'title' => 'Stok Produk',
            'actived' => 'master-produk',
            'product' => $product,
            'branch' => $branch,
            'branchs' => Branch::all()
        );
        return view('modules.master.product.stock.edit', $data);
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
        // return response()->json($request->stock_status);
        $last_stock = Stock::where('product_id', '=', decrypt($id))
                ->orderBy('id', 'DESC')->first();

        $stock_in = $last_stock->stock_saldo + $request->stock_nominal;
        $stcok_out = $last_stock->stock_saldo - $request->stock_nominal;

        if ($request->stock_status == "Masuk") {
            $stock = Stock::create([
                "product_id" => $request->product_id,
                "branch_id" => $request->branch_id,
                "stock_status" => "Masuk",
                "stock_nominal" => $request->stock_nominal,
                "stock_saldo" => $stock_in,
                "description" => $request->description
            ]);
        
            $this->_update_product_stock($id);
        } else 
        if ($request->stock_status == "Keluar") {
            $stock = Stock::create([
                "product_id" => $request->product_id,
                "branch_id" => $request->branch_id,
                "stock_status" => "Keluar",
                "stock_nominal" => $request->stock_nominal,
                "stock_saldo" => $stcok_out,
                "description" => $request->description
            ]);
            
            $this->_update_product_stock($id);
        } else 
        if ($request->stock_status == "Opnam") {
            $stock = Stock::create([
                "product_id" => $request->product_id,
                "branch_id" => $request->branch_id,
                "stock_status" => "Opnam",
                "stock_nominal" => $request->stock_nominal,
                "stock_saldo" => $request->stock_nominal,
                "description" => $request->description
            ]);
            
            $this->_update_product_stock($id);
        } else 
        if ($request->stock_status == "Transfer") {
            Stock::create([
                "product_id" => $request->product_id,
                "branch_id" => $request->branch_id,
                "stock_status" => "Keluar",
                "stock_nominal" => $request->stock_nominal,
                "stock_saldo" => $stcok_out,
                "description" => $request->description
            ]);

            Stock::create([
                "product_id" => $request->product_id,
                "branch_id" => $request->branch_to,
                "stock_status" => "Masuk",
                "stock_nominal" => $request->stock_nominal,
                "stock_saldo" => $stock_in,
                "description" => $request->description
            ]);
            
            $this->_update_product_stock($id);
        }

        return redirect('produk/stok/'.$id)->with('success', true);
    }

    private function _update_product_stock($id) 
    {
        $stock_total = 0;
        $branch = Branch::all();
        foreach($branch as $b) {
            $product_item = Stock::where('branch_id', '=', $b->id)
                                ->orderBy('id', 'DESC')
                                ->first();
            $stock_total = $stock_total + $product_item->stock_saldo;
        }

        $product = Product::find(decrypt($id));
        $product->stock = $stock_total;
        $product->save();
    }

    public function exportToExcel() {
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=stok-produk-".date('Ymd').time().".xls");

        $products = [];
        $productItems = Product::orderBy('name', 'ASC')->get();
        foreach($productItems as $item) {
            if (Auth::user()->branch_id != 0) {
                $products[] = Stock::select('product_stocks.*',
                                    'products.code as product_code',
                                    'products.name as product_name',
                                    'products.stockmin as product_stockmin')
                                ->where('branch_id', '=', Auth::user()->branch_id)
                                ->where('product_id', '=', $item->id)
                                ->join('products', 'products.id', '=', 'product_id')
                                ->orderBy('id', 'DESC')
                                ->first();
            } else {
                $products[] = Stock::select('product_stocks.*',
                                    'products.code as product_code',
                                    'products.name as product_name',
                                    'products.stockmin as product_stockmin',
                                    'product_units.symbol')
                                ->where('product_id', '=', $item->id)
                                ->join('products', 'products.id', '=', 'product_id')
                                ->join('product_units', 'unit_id', '=', 'product_units.id')
                                ->orderBy('id', 'DESC')
                                ->first();
            }
        }

        $data = array(
            'products' => $products
        );
        return view('modules.master.product.stock.excel', $data);
    }
}
