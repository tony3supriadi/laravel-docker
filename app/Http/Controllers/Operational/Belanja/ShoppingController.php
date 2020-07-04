<?php

namespace App\Http\Controllers\Operational\Belanja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Shopping;
use App\Models\ShoppingItem;
use App\Models\ShoppingPayment;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductStock;

use Auth;
use Cart;

class ShoppingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:belanja-list|belanja-create|belanja-edit|belanja-delete', ['only' => ['index','store']]);
         $this->middleware('permission:belanja-create', ['only' => ['create','store']]);
         $this->middleware('permission:belanja-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:belanja-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total = 0;
        $shoppings = [];
        if (($request->start && $request->end) || $request->status) {
            if ($request->status && $request->status != 'semua') {
                $shoppings = Shopping::select('shoppings.*', 'suppliers.name as supplier_name')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_id')
                            ->whereBetween('shoppings.created_at', [date('Y-m').'-1 00:00:00', date('Y-m-d').' 23:59:59'])
                            ->where('shoppings.status', '=', $request->status)
                            ->orderBy('id', 'DESC')
                            ->get();

                $between = $request->start ?
                    [$request->start, $request->end] :
                    [date('Y-m').'-1 00:00:00', date('Y-m-d').' 23:59:59'];

                
                if ($request->status == 'lunas') {
                    foreach(ShoppingPayment::whereBetween('created_at', $between)
                        ->get() as $item) {
                            if ($item->billing <= $item->payment) {
                                $total = $total + $item->payment;
                            }
                    }
                } else 
                if ($request->status == 'hutang') {
                    $bill = 0;
                    $pay = 0;
                    $shopping_id = 0;
                    foreach(ShoppingPayment::whereBetween('created_at', $between)
                        ->orderBy('shopping_id', 'ASC')
                        ->get() as $item) {
                            $pay = $pay + $item->debit;
                            if ($shopping_id != $item->shopping_id) {
                                $shopping_id = $item->shopping_id;

                                $bill = $bill + $item->billing;
                            }
                    }
                    
                    $total = $bill - $pay;
                }
                
            } else {
                $shoppings = Shopping::select('shoppings.*', 'suppliers.name as supplier_name')
                                ->join('suppliers', 'suppliers.id', '=', 'supplier_id')
                                ->whereBetween('shoppings.created_at', [date('Y-m').'-1 00:00:00', date('Y-m-d').' 23:59:59'])
                                ->orderBy('id', 'DESC')
                                ->get();
            }
        } else {
            $shoppings = Shopping::select('shoppings.*', 'suppliers.name as supplier_name')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_id')
                            ->whereBetween('shoppings.created_at', [date('Y-m').'-1 00:00:00', date('Y-m-d').' 23:59:59'])
                            ->orderBy('id', 'DESC')
                            ->get();
        }

        $data = array(
            'title' => 'Belanja',
            'actived' => 'op-belanja',
            'shoppings' => $shoppings,
            'total' => $total
        );
        return view('modules.operational.shopping.index', $data);
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
            'actived' => 'op-belanja',
            'products' => Product::orderBy('name', 'ASC')->get(),
            'suppliers' => Supplier::orderBy('name', 'ASC')->get(),
        );
        return view('modules.operational.shopping.create', $data);
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
            'supplier_id' => 'required',
        ], [
            'supplier_id.required' => 'Anda belum memilih supplier'
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        } else {

            $shopping = Shopping::create([
                'supplier_id' => $request->supplier_id,
                'invoice' => time(),
                'price_total' => $request->total,
                'status' => $request->status != "Uang Muka" ? $request->status : 'Hutang',
                'description' => $request->description
            ]);

            foreach(Cart::getContent() as $item) {
                ShoppingItem::create([
                    'shopping_id' => $shopping->id,
                    'supplier_id' => $request->supplier_id,
                    'product_id' => $item->id,
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
                    'stock_status' => 'Masuk',
                    'stock_nominal' => $item->quantity,
                    'stock_saldo' => $product->stock + $item->quantity,
                    'description' => 'Belanja produk '.strtolower($product->name).' ('.$shopping->invoice.')'
                ]);

                $product->purchase_price = $item->price;
                $product->stock = $product->stock + $item->quantity;
                $product->save();
            }

            ShoppingPayment::create([
                'shopping_id' => $shopping->id,
                'supplier_id' => $request->supplier_id,
                'billing' => Cart::getTotal(),
                'payment' => $request->payment,
                'debit' => $request->payment,
                'description' => 'PAYMENT-'.time().' ('.strtoupper($request->status).')'
            ]);

            Cart::clear();
            return redirect('/belanja')->with('success', true);
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
        $shopping = [];

        $shopping = Shopping::select('shoppings.*', 'suppliers.name as supplier_name')
                        ->join('suppliers', 'suppliers.id', '=', 'supplier_id')
                        ->where('shoppings.id', '=', decrypt($id))
                        ->first();

        $shopping['items'] = ShoppingItem::select('shopping_items.*', 'products.name as name')
                        ->join('products', 'products.id', '=', 'product_id')
                        ->where('shopping_id', '=', $shopping->id)
                        ->get();
        $shopping['payments'] = ShoppingPayment::where('shopping_id', '=', $shopping->id)->get();

        $data = array(
            'title' => 'Belanja',
            'actived' => 'op-belanja',
            'shopping' => $shopping,
        );
        return view('modules.operational.shopping.show', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shopping = Shopping::find(decrypt($id));
        $shopping->status = 'Batal';
        $shopping->save();

        foreach(ShoppingItem::
            where('shopping_id', '=', $shopping->id)->get() 
            as $item) {

                $product = Product::find($item->product_id);
                $branch_id = Auth::user()->branch_id != 0 
                        ? Auth::user()->branch_id
                        : 1;
                
                ProductStock::create([
                    'product_id' => $item->product_id,
                    'branch_id' => $branch_id,
                    'stock_status' => 'Keluar',
                    'stock_nominal' => $item->qty,
                    'stock_saldo' => $product->stock - $item->qty,
                    'description' => 'Pembatalan belanja produk '.strtolower($product->name).' ('.$shopping->invoice.')'
                ]);

                $product->stock = $product->stock + $item->qty;
                $product->save();
            }


        ShoppingPayment::where('shopping_id', '=', decrypt($id))->delete();
        return back()->with('success', true);
    }

    public function createPayment(Request $request)
    {
        $data = $request->all();
        $data['payment'] = $data['payment'] + $data['debit'];
        $pay = ShoppingPayment::create($data);

        if ($pay->billing <= $pay->payment) {
            $shopping = Shopping::find($pay->shopping_id);
            $shopping->status = "Lunas";
            $shopping->save();
        }

        return back();
    }

    public function createSupplier(Request $request)
    {
        $data = Supplier::create([
            'branch_id'=> Auth::user()->branch_id != 0 ? Auth::user()->branch_id : 1,
            'bank_id' => 1,
            'name' => $request->name
        ]);
        return back()->with('id', $data->id);
    }

    public function addToCart(Request $request) 
    {
        $cartItem = Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'attributes' => [
                'code' => $request->code,
                'description' => $request->description
            ]
        ]);
        return back();
    }

    public function destroyCart($index = null)
    {
        Cart::remove($index);
        return back();
    }
}
