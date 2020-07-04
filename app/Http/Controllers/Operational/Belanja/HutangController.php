<?php

namespace App\Http\Controllers\Operational\Belanja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Shopping;
use App\Models\ShoppingPayment as Payment;

class HutangController extends Controller
{
    
    public  function __construct()
    {
        $this->middleware('permission:belanja-hutang|belanja-hutang-input', ['only' => ['index','penjualan']]);
        $this->middleware('permission:belanja-hutang-input', ['only' => ['penjualan','store']]);
    }

    public function index()
    {
        $results = [];
        $suppliers = Payment::select(DB::raw('supplier_id'))
                        ->groupBy('supplier_id')
                        ->get();

        $i = 0;
        foreach($suppliers as $item) {
            $payment = Payment::select(
                                'shopping_payments.id', 'shopping_payments.shopping_id', 
                                'shopping_payments.supplier_id', 'suppliers.name')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_id')
                            ->where('supplier_id', '=', $item->supplier_id)
                            ->orderBy('id', 'DESC')
                            ->first();
            $results[$i] = $payment;
            
            $payments = Payment::select('shopping_id')
                            ->groupBy('shopping_id')
                            ->where('supplier_id', '=', $item->supplier_id)
                            ->get();
            foreach($payments as $pay) {
                $payItem = Payment::where('shopping_id', '=', $pay->shopping_id)
                                ->orderBy('id', 'DESC')
                                ->first();

                $results[$i]['billing'] = $results[$i]['billing'] + $payItem->billing;
                $results[$i]['payment'] = $results[$i]['payment'] + $payItem->payment;
            }
            $results[$i]['debt'] = $results[$i]['billing'] - $results[$i]['payment'];
            $results[$i] = $payment;
            $i++;
        }


        $data = array(
            'title' => 'Hutang',
            'actived' => 'belanja-hutang',
            'results' => $results
        );
        return view('modules.operational.shopping.hutang.index', $data);
    }

    public function pelunasan($id)
    {
        $results = [];
        $shoppings = Payment::select(DB::raw('shopping_id'))
                        ->groupBy('shopping_id')
                        ->where('supplier_id', '=', decrypt($id))
                        ->get();        
        $i = 0;
        foreach($shoppings as $item) {
            $payment = Shopping::where('id', '=', $item->shopping_id)
                            ->orderBy('id', 'DESC')
                            ->first();
            $results[$i] = $payment;
        }

        return response()->json($results);


        $data = array(
            'title' => 'Hutang',
            'actived' => 'belanja-hutang',
            'results' => $results
        );
        return view('modules.operational.shopping.hutang.show', $data);
    }

    public function store(Request $request, $id)
    {

    }
}
