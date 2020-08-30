<?php

namespace App\Http\Controllers\Selling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalePayment;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductPrice as Price;
use App\Models\Company;
use App\Models\CustomerSaving;
use App\Models\Shopping;
use App\Models\ShoppingItem;
use App\Models\ShoppingPayment;
use Cart;
use Auth;

class SellingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total = 0;
        $sales = [];
        if (($request->start && $request->end) || $request->status) {
            if ($request->status && $request->status != 'semua') {
                $sales = Sale::select('sales.*', 'customers.name as customer_name')
                            ->join('customers', 'customers.id', '=', 'customer_id')
                            ->whereBetween('sales.created_at', $request->start ? 
                                [$request->start . ' 00:00:00', $request->end . ' 23.59.59'] : 
                                [date('Y-m').'-1 00:00:00', date('Y-m-d').' 23:59:59'])
                            ->where('sales.status', '=', $request->status)
                            ->orderBy('id', 'DESC')
                            ->get();

                $between = $request->start ?
                    [$request->start . ' 00:00:00', $request->end . ' 23.59.59'] :
                    [date('Y-m').'-1 00:00:00', date('Y-m-d').' 23:59:59'];

                
                if ($request->status == 'lunas') {
                    foreach(SalePayment::whereBetween('created_at', $between)
                        ->get() as $item) {
                            if ($item->billing <= $item->payment) {
                                $total = $total + $item->payment;
                            }
                    }
                } else 
                if ($request->status == 'piutang') {
                    $bill = 0;
                    $pay = 0;
                    $sale_id = 0;
                    foreach(SalePayment::whereBetween('created_at', $between)
                        ->orderBy('sale_id', 'ASC')
                        ->get() as $item) {
                            $pay = $pay + $item->debit;
                            if ($sale_id != $item->sale_id) {
                                $sale_id = $item->sale_id;

                                $bill = $bill + $item->billing;
                            }
                    }
                    
                    $total = $bill - $pay;
                }
                
            } else {
                $sales = Sale::select('sales.*', 'customers.name as customer_name')
                                ->join('customers', 'customers.id', '=', 'customer_id')
                                ->whereBetween('sales.created_at', $request->start ? 
                                    [$request->start . ' 00:00:00', $request->end . ' 23.59.59'] : 
                                    [date('Y-m').'-1 00:00:00', date('Y-m-d').' 23:59:59'])
                                ->orderBy('id', 'DESC')
                                ->get();
            }
        } else {
            $sales = Sale::select('sales.*', 'customers.name as customer_name')
                            ->join('customers', 'customers.id', '=', 'customer_id')
                            ->whereBetween('sales.created_at', [date('Y-m').'-1 00:00:00', date('Y-m-d').' 23:59:59'])
                            ->orderBy('id', 'DESC')
                            ->get();
        }

        $data = array(
            'title' => 'Penjualan',
            'actived' => 'penjualan-riwayat',
            'sales' => $sales,
            'total' => $total
        );

        if ($request->exportTo) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan-penjualan-".date('Ymd').time().".xls");
            return view('modules.selling.excel', $data);
        }
        return view('modules.selling.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Belanja',
            'actived' => 'penjualan',
            'products' => Product::orderBy('name', 'ASC')
                            ->where('stock', '>', 0)
                            ->get(),
            'customers' => Customer::orderBy('name', 'ASC')->get(),
        );
        return view('modules.selling.create', $data);
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
            'customer_id' => 'required',
        ], [
            'customer_id.required' => 'Anda belum memilih pelanggan'
        ]);
        
        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {
            $inv = time();
            $customer = Customer::find($request->customer_id);
            
            $sale = Sale::create([
                'invoice' => $inv,
                'customer_id' => $request->customer_id,
                'branch_id' => Auth::user()->branch_id != 0 
                                    ? Auth::user()->branch_id
                                    : 1,
                'price_total' => $request->total,
                'status' => $request->payment >= $request->total ? 'Lunas' : 'Piutang',
                'description' => $request->description,
                'is_barter' => $request->metodePembayaran == 'barter' ? true : false,
                'jml_barter' => $request->jumlah_barang_barter,
                'metode_pembayaran' => $request->metodePembayaran
            ]);

            CustomerSaving::create([
                'customer_id' => $request->customer_id,
                'code' => time(),
                'description' => 'PEMBELIAN (INV-'.$sale->invoice.')',
                'status' => 'Debit',
                'nominal' => $request->total,
                'saldo' => ($customer->saldo_tabungan - $request->total)
            ]);

            if (($request->payment - Cart::getTotal()) > 0 
                && $request->metodePembayaran == 'tunai') {
                    
                CustomerSaving::create([
                    'customer_id' => $request->customer_id,
                    'code' => time(),
                    'description' => 'PEMBAYARAN (INV-'.$sale->invoice.')',
                    'status' => 'Kredit',
                    'nominal' => $request->total,
                    'saldo' => $customer->saldo_tabungan
                ]);
            }

            if ($request->metodePembayaran == 'tabungan') {
                $sisa_pembayaran = $request->payment - $request->total;
                $customer->saldo_tabungan = $sisa_pembayaran;
                $customer->save();
            } else
            if ($request->metodePembayaran == 'tunai' && $request->payment == 0) {
                $customer->saldo_tabungan = $customer->saldo_tabungan - $request->total;
                $customer->save();
            }

            if ($request->metodePembayaran == 'barter') {
                $product = Product::find($request->barang_barter);
                $product->stock = $product->stock + $request->jumlah_barang_barter;
                $product->save();

                $customer->saldo_tabungan = $customer->saldo_tabungan - $request->total;
                $customer->save();

                ProductStock::create([
                    'product_id' => $request->barang_barter,
                    'branch_id' => Auth::user()->branch_id != 0 
                                        ? Auth::user()->branch_id
                                        : 1,
                    'stock_status' => 'Masuk',
                    'stock_nominal' => $request->jumlah_barang_barter,
                    'stock_saldo' => $product->stock,
                    'description' => 'Stock Barter dari '.$customer->name.' (INV-'.$inv.')'
                ]);
            }

            foreach(Cart::getContent() as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item->id,
                    'purchase_price' => explode("-", $item->name)[1],
                    'price' => $item->price,
                    'qty' => $item->quantity,
                    'sub_total' => ($item->price * $item->quantity),
                    'description' => $item->attributes->description
                ]);

                $product = Product::find($item->id);
                $branch_id = Auth::user()->branch_id != 0 
                        ? Auth::user()->branch_id
                        : 1;
                
                ProductStock::create([
                    'product_id' => $item->id,
                    'branch_id' => $branch_id,
                    'stock_status' => 'Keluar',
                    'stock_nominal' => $item->quantity,
                    'stock_saldo' => $product->stock - $item->quantity,
                    'description' => 'Penjualan produk '.strtolower($product->name)
                ]);

                $product->stock = $product->stock - $item->quantity;
                $product->save();
            }

            SalePayment::create([
                'sale_id' => $sale->id,
                'customer_id' => $request->customer_id,
                'billing' => Cart::getTotal(),
                'payment' => $request->payment,
                'debit' => $request->payment,
                'description' => 'PAYMENT-'.time().' ('.strtoupper($request->status).')',
                'metode_pembayaran' => $request->metodePembayaran
            ]);

            Cart::clear();

            if ($request->metodePembayaran == 'tunai') {
                return redirect('penjualan/'.encrypt($sale->id))
                        ->with('backPayment', $request->payment > $request->total ? true : false);
            } else {
                return redirect('penjualan/'.encrypt($sale->id));
            }
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
        $sale = [];

        $sale = Sale::select('sales.*', 'customers.name as customer_name')
                        ->join('customers', 'customers.id', '=', 'customer_id')
                        ->where('sales.id', '=', decrypt($id))
                        ->first();

        $sale['items'] = SaleItem::select('sale_items.*', 'products.name as name')
                        ->join('products', 'products.id', '=', 'product_id')
                        ->where('sale_id', '=', $sale->id)
                        ->get();
        $sale['payments'] = SalePayment::where('sale_id', '=', $sale->id)->get();

        $data = array(
            'title' => 'Penjualan',
            'actived' => 'penjualan-riwayat',
            'sale' => $sale,
            'company' => Company::find(1)
        );
        return view('modules.selling.show', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find(decrypt($id));
        $sale->status = 'Batal';
        $sale->save();

        foreach(SaleItem::
            where('sale_id', '=', decrypt($id))->get() 
            as $item) {

                $product = Product::find($item->product_id);
                $branch_id = Auth::user()->branch_id != 0 
                        ? Auth::user()->branch_id
                        : 1;

                ProductStock::create([
                    'product_id' => $item->product_id,
                    'branch_id' => $branch_id,
                    'stock_status' => 'Masuk',
                    'stock_nominal' => $item->qty,
                    'stock_saldo' => $product->stock + $item->qty,
                    'description' => 'Pembatalan penjualan produk '.strtolower($product->name).' ('.$sale->invoice.')'
                ]);

                $product->stock = $product->stock + $item->qty;
                $product->save();
            }


        SalePayment::where('sale_id', '=', decrypt($id))->delete();
        return back()->with('success', true);
    }

    public function createPayment(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        if ($request->metode_pembayaran == 'tabungan') {

            $debit = ($request->debit > $request->billing)
                ? ($request->billing - $request->payment)
                : $request->debit;
            SalePayment::create([
                'sale_id' => $request->sale_id, 
                'customer_id' => $request->customer_id, 
                'billing' => $request->billing, 
                'payment' => ($request->payment + $debit), 
                'debit' => $debit,
                'description' => $request->description,
                'metode_pembayaran' => 'tabungan'
            ]);

            CustomerSaving::create([
                'customer_id' => $request->customer_id,
                'code' => time(),
                'description' => 'PEMBAYARAN HUTANG (INV-'.Sale::find($request->sale_id)->invoice.')',
                'status' => 'Debit',
                'nominal' => $debit,
                'saldo' => ($customer->saldo_tabungan - $debit)
            ]);

            $customer->saldo_tabungan = ($customer->saldo_tabungan - $debit);
            $customer->save();
        } else {
            $data = $request->all();
            $data['payment'] = $data['payment'] + $data['debit'];

            $pay = SalePayment::create($data);
            $sale = Sale::find($pay->sale_id);
            
            if ($pay->billing <= $pay->payment) {
                $sale->status = "Lunas";
                $sale->save();
            }

            if ($pay->billing < $pay->payment) {
                $nominal = $request->debit - ($pay->payment - $pay->billing);
                $saldo = $customer->saldo_tabungan + $nominal;

                CustomerSaving::create([
                    'customer_id' => $data['customer_id'],
                    'code' => time(),
                    'description' => 'PEMBAYARAN HUTANG (INV-'.$sale->invoice.')',
                    'status' => 'Kredit',
                    'nominal' => $nominal,
                    'saldo' => $saldo
                ]);

                $customer->saldo_tabungan = $saldo;
                $customer->save();
            } else {
                $saldo = $customer->saldo_tabungan + $request->debit;

                CustomerSaving::create([
                    'customer_id' => $data['customer_id'],
                    'code' => time(),
                    'description' => 'PEMBAYARAN HUTANG (INV-'.$sale->invoice.')',
                    'status' => 'Kredit',
                    'nominal' => $request->debit,
                    'saldo' => $saldo
                ]);
                
                $customer->saldo_tabungan = $saldo;
                $customer->save();
            }
        }

        $this->is_barter_payment($request, $sale);
        return back()
            ->with(
                'backPayment', 
                ($data['payment'] > $request->billing) 
                ? true : false);
    }

    public function createCustomer(Request $request)
    {
        $data = Customer::create([
            'group_id' => 1,
            'name' => $request->name
        ]);
        return redirect('penjualan/update-to-cart/'.$data->id);
    }

    public function addToCart(Request $request) 
    {
        $cartItem = Cart::add([
            'id' => $request->id,
            'name' => $request->name.'-'.$request->purchase_price,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'attributes' => [
                'code' => $request->code,
                'purchase_price' => $request->purchase_price,
                'description' => $request->description
            ]
        ]);
        return back();
    }

    public function editToCart(Request $request, $id) 
    {
        $data = [];
        $carts = Cart::getContent();
        $customer = Customer::find($id);
        
        foreach($carts as $item) {
            $data = $item;
            $data['price'] = Price::where('product_id', '=', $item->id)
                                ->where('group_id', '=', $customer->group_id)
                                ->first()
                                ->price;
            
            Cart::remove($item->id);
            Cart::add([
                'id' => $data['id'],
                'name' => $data['name'],
                'quantity' => $data['quantity'],
                'price' => $data['price'],
                'attributes' => [
                    'code' => $data['attributes']['code'],
                    'description' => $data['attributes']['description']
                ]
            ]);
        } 
        return back()
            ->with('id', $id)
            ->with('customer', $customer);
    }

    public function destroyCart($index = null)
    {
        Cart::remove($index);
        return back();
    }

    public function simpanTabungan(Request $request, $id)
    {
        $data = Customer::find(decrypt($id));
        
        if ($data->saldo_tabungan >= 0) {
            $data->saldo_tabungan = $data->saldo_tabungan + $request->saldo_tabungan;
            $data->save();
            
            CustomerSaving::create([
                'customer_id' => $data->id,
                'code' => time(),
                'description' => 'SIMPAN KEMBALIAN (INV-'.$request->invoice.')',
                'status' => 'Kredit',
                'nominal' => $request->saldo_tabungan,
                'saldo' => $data->saldo_tabungan
            ]);
        } else {
            $sales = Sale::where('customer_id', '=', $data->id)
                ->where('status', '=', 'Piutang')
                ->get();

            if (count($sales)) {

                $sisa_pembayaran = $request->saldo_tabungan;
                foreach($sales as $sale) {

                    $payment = SalePayment::where('sale_id', '=', $sale->id)->sum('payment');
                    $debit = ($request->saldo_tabungan > $sale->price_total)
                                ? $sale->price_total 
                                : $sisa_pembayaran;

                    if ($sisa_pembayaran > 0) {
                        $data->saldo_tabungan = $data->saldo_tabungan + $debit;
                        $data->save();

                        $saleP = SalePayment::create([
                            'sale_id' => $sale->id, 
                            'customer_id' => $data->id, 
                            'billing' => $sale->price_total, 
                            'payment' => $payment + $debit, 
                            'debit' => $debit,
                            'description' => 'KEMBALIAN INV-'.$request->invoice, 
                            'metode_pembayaran' => 'tabungan'
                        ]);

                        CustomerSaving::create([
                            'customer_id' => $data->id,
                            'code' => time(),
                            'description' => 'PEMBAYARAN HUTANG (INV-'.$sale->invoice.')',
                            'status' => 'Kredit',
                            'nominal' => $sisa_pembayaran,
                            'saldo' => $data->saldo_tabungan
                        ]);

                        if ($saleP->billing < $saleP->payment) {
                            $up = Sale::find($sale->id);
                            $up->status = 'Lunas';
                            $up->save();
                        }
                    }
                    $sisa_pembayaran = $sisa_pembayaran - $sale->price_total;
                }
            }
        }
        return back();
    }

    private function is_barter_payment($request, $sale)
    {   
        if ($sale->is_barter) {
            $shopping = Shopping::create([
                'supplier_id' => 1,
                'invoice' => time(),
                'price_total' => $request->debit,
                'status' => 'Lunas',
                'description' => 'Belanja Pembayaran Telor Barter INV-'.$sale->invoice,
            ]);

            ShoppingItem::create([
                'shopping_id' => $shopping->id,
                'supplier_id' => 1,
                'product_id' => 1,
                'price' => ($request->debit / $sale->jml_barter),
                'qty' => $sale->jml_barter,
                'sub_total' => $request->debit,
                'description' => 'Belanja Pembayaran Telor Barter INV-'.$sale->invoice,
            ]);

            ShoppingPayment::create([
                'shopping_id' => $shopping->id,
                'supplier_id' => 1,
                'billing' => $request->debit,
                'payment' => $request->debit,
                'debit' => $request->debit,
                'description' => 'PAYMENT-'.time().' ('.strtoupper($request->status).')'
            ]);
        }
    }
}
