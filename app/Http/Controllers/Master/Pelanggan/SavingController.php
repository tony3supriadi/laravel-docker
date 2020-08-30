<?php

namespace App\Http\Controllers\Master\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerSaving;
use App\Models\Sale;
use App\Models\SalePayment;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $between = $request->start ?
            [$request->start . ' 00:00:00', $request->end . ' 23.59.59'] :
            [date('Y-m').'-1 00:00:00', date('Y-m-d').' 23:59:59'];

        $savings = CustomerSaving::select('customer_savings.*', 'customers.name')
                ->join('customers', 'customers.id', '=', 'customer_id')
                ->whereBetween('customer_savings.created_at', $between)
                ->orderBy('customer_savings.id', 'DESC')
                ->get();

        $data = array(
            'title' => 'Catatan Tabungan',
            'actived' => 'master-pelanggan',
            'savings' => $savings,
        );

        if ($request->exportTo) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=catatan-penjualan-".date('Ymd').time().".xls");
            return view('modules.master.customer.saving.excel', $data);
        }
        return view('modules.master.customer.saving.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Catatan Tabungan',
            'actived' => 'master-pelanggan',
            'customers' => Customer::orderBy('name', 'ASc')->get(),
        );
        return view('modules.master.customer.saving.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $saldo = 0;
        if($request->status == 'Kredit') {
            $saldo = $request->saldo_saat_ini + $request->nominal;
        } else {
            $saldo = $request->saldo_saat_ini - $request->nominal;
        }

        $this->_update_saldo($request->customer_id, $saldo);

        $saving = CustomerSaving::create([
            'customer_id' => $request->customer_id,
            'code' => $request->code,
            'description' => $request->description,
            'status' => $request->status,
            'nominal' => $request->nominal,
            'saldo' => $saldo
        ]);

        $this->_repayment_sales($request->customer_id, $saving);

        return redirect('pelanggan/catatan-tabungan')
            ->with('success', true)
            ->with('saving', $saving);
    }

    private function _repayment_sales($id, $saving) {
        $results = false;
        $cust = Customer::find($id);

        if (count($this->_get_sales_customer($id))) {

            foreach($this->_get_sales_customer($id) as $item) {
                if ($item->is_barter) {
                    $sale = SalePayment::orderBy('id', 'DESC')->where('sale_id', '=', $item->id)->first();

                    SalePayment::create([
                        'sale_id' => $item->id,
                        'customer_id' => $id,
                        'billing' => $item->price_total, 
                        'payment' => $sale->payment + $saving->nominal, 
                        'debit' => $saving->nominal,
                        'description' => 'PELUNASAN #REF'.$saving->code, 
                        'metode_pembayaran' => 'tabungan'
                    ]);

                    $this->_update_sales_status($item->id);
                } else {
                    $sale = SalePayment::orderBy('id', 'DESC')->where('sale_id', '=', $item->id)->first();
                    $debit = $sale->billing - $sale->payment;
                    $update_saldo = $cust->saldo_tabungan - $debit;

                    if ($debit > $cust->saldo_tabungan) {
                        $debit = $cust->saldo_tabungan;
                    }

                    SalePayment::create([
                        'sale_id' => $item->id,
                        'customer_id' => $id,
                        'billing' => $item->price_total, 
                        'payment' => $sale->payment + $debit, 
                        'debit' => $debit,
                        'description' => 'PELUNASAN #REF'.$saving->code, 
                        'metode_pembayaran' => 'tabungan'
                    ]);

                    $this->_update_sales_status($item->id);
                }
            }
        }

        return $results;
    }


    private function _get_sales_customer($id)
    {  
        return Sale::where('customer_id', '=', $id)
            ->where('status', '=', 'Piutang')
            ->get();
    }

    private function _update_sales_status($id) {
        $sale = Sale::find($id);
        $sale->status = 'Lunas';
        $sale->save();
    }

    private function _update_saldo($id, $saldo) {
        $customer = Customer::find($id);
        $customer->saldo_tabungan = $saldo;
        $customer->save();
    }
}
