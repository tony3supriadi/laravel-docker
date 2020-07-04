<?php

namespace App\Http\Controllers\Master\Produk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth;

use App\Models\Product;
use App\Models\ProductPrice as Price;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:produk-price-list|produk-price-create|produk-price-edit|produk-price-delete', ['only' => ['index','store']]);
         $this->middleware('permission:produk-price-create', ['only' => ['create','store']]);
         $this->middleware('permission:produk-price-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:produk-price-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = [];
        if (Auth::user()->branch_id != 0) {
            $products = Price::select('product_prices.*',
                                'products.code as product_code',
                                'products.name as product_name',
                                'customer_groups.name as group_name')
                            ->where('branch_id', '=', Auth::user()->branch_id)
                            ->join('products', 'products.id', '=', 'product_id')
                            ->join('customer_groups', 'customer_groups.id', 'group_id')
                            ->get();
        } else {
            $products = Price::select('product_prices.*',
                                'products.code as product_code',
                                'products.name as product_name',
                                'customer_groups.name as group_name')
                            ->join('products', 'products.id', '=', 'product_id')
                            ->join('customer_groups', 'customer_groups.id', 'group_id')
                            ->get();
        }

        $data = array(
            'title' => 'Produk',
            'actived' => 'master-produk',
            'products' => $products
        );
        return view('modules.master.product.price.index', $data);
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
            'title' => 'Harga Produk',
            'actived' => 'master-produk',
            'product' => Price::select('product_prices.*',
                            'products.code as product_code',
                            'products.name as product_name',
                            'customer_groups.name as group_name')
                        ->join('products', 'products.id', '=', 'product_id')
                        ->join('customer_groups', 'customer_groups.id', 'group_id')
                        ->where('product_prices.id', '=', decrypt($id))
                        ->first()
        );
        return view('modules.master.product.price.show', $data);
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
            'title' => 'Harga Produk',
            'actived' => 'master-produk',
            'product' => Price::select('product_prices.*',
                            'products.code as product_code',
                            'products.name as product_name',
                            'customer_groups.name as group_name')
                        ->join('products', 'products.id', '=', 'product_id')
                        ->join('customer_groups', 'customer_groups.id', 'group_id')
                        ->where('product_prices.id', '=', decrypt($id))
                        ->first()
        );
        return view('modules.master.product.price.edit', $data);
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
            'price' => 'required|numeric'
        ], [
            'price.required' => 'Harga jual harus diisi',
            'price.numeric' => 'Masukan harga dengan angka'
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $price = Price::find(decrypt($id));
            $price->fill($request->all());
            $price->save();

            if ($price->group_id == 1) {
                $product = Product::find($price->product_id);
                $product->price = $request->price;
                $product->save();
            }

            return redirect('produk/harga')->with('success', true);
        }
    }

    public function exportToExcel() {
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=harga-produk-".date('Ymd').time().".xls");

        $products = [];
        if (Auth::user()->branch_id != 0) {
            $products = Price::select('product_prices.*',
                                'products.code as product_code',
                                'products.name as product_name',
                                'customer_groups.name as group_name')
                            ->where('branch_id', '=', Auth::user()->branch_id)
                            ->join('products', 'products.id', '=', 'product_id')
                            ->join('customer_groups', 'customer_groups.id', 'group_id')
                            ->orderBy('customer_groups.name', 'ASC')
                            ->orderBy('products.name', 'ASC')
                            ->get();
        } else {
            $products = Price::select('product_prices.*',
                                'products.code as product_code',
                                'products.name as product_name',
                                'customer_groups.name as group_name')
                            ->join('products', 'products.id', '=', 'product_id')
                            ->join('customer_groups', 'customer_groups.id', 'group_id')
                            ->orderBy('customer_groups.name', 'ASC')
                            ->orderBy('products.name', 'ASC')
                            ->get();
        }

        $data = array(
            'products' => $products
        );
        return view('modules.master.product.price.excel', $data);
    }
}
