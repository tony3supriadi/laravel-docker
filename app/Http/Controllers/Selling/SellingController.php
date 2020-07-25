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

            $customer = Customer::find($request->customer_id);
            $inv = time();
            if ($request->metodePembayaran == 'tabungan') {
                $sisa_pembayaran = $request->payment - $request->total;
                $customer->saldo_tabungan = $sisa_pembayaran;
                $customer->save();
            }

            if ($request->metodePembayaran == 'barter') {
                $product = Product::find($request->barang_barter);
                $product->stock = $product->stock + $request->jumlah_barang_barter;
                $product->save();

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
                'jml_barter' => $request->jumlah_barang_barter
            ]);

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
                'description' => 'PAYMENT-'.time().' ('.strtoupper($request->status).')'
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
        $data = $request->all();
        $data['payment'] = $data['payment'] + $data['debit'];
        $pay = SalePayment::create($data);

        if ($pay->billing <= $pay->payment) {
            $sale = Sale::find($pay->sale_id);
            $sale->status = "Lunas";
            $sale->save();
        }

        $sale = Sale::find($request->sale_id);
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

        return back()->with('backPayment', $request->debit > $request->billing ? true : false);
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
        return back()->with('id', $id);
    }

    public function destroyCart($index = null)
    {
        Cart::remove($index);
        return back();
    }

    public function simpanTabungan(Request $request, $id)
    {
        $data = Customer::find(decrypt($id));
        $data->saldo_tabungan = $data->saldo_tabungan + $request->saldo_tabungan;
        $data->save();

        return back();
    }
}
