<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\OperationalOther;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Shopping;
use App\Models\ShoppingItem;
use App\Models\Supplier;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $results = [];
        $results['operational'] = $this->_operasional($request->m);
        $results['penjualan'] = $this->_penjualan($request->m);

        // return response()->json($results);

        $data = array(
            'title' => 'Laporan',
            'actived' => 'laporan',
            'reports' => $results
        );

        if ($request->exportTo) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan-laba-rugi-".date('Ymd').time().".xls");
            return view('pages.report._exportReport', $data);
        } else 
        if ($request->exportTo == 'pdf') {
            $view = view('pages.report._exportReport', $data)->render();
            $pdf = PDF::loadHTML($view)
                        ->setPaper('a4', 'landscape')
                        ->setWarnings(false);
            return $pdf->stream('laporan-laporan-'.time().'.pdf');
        } 
        return view('pages.report.index', $data);
    }

    public function hutang(Request $request) {
        $index = 0;
        $suppliers = Supplier::where('companies', '=', true)
                        ->orderBy('name', 'ASC')->get();

        foreach ($suppliers as $item) {
            $suppliers[$index] = [
                'id' => $item->id,
                'supplier_name' => $item->name,
                'jumlah_hutang' => Shopping::where('supplier_id', '=', $item->id)
                                                ->where('status', '=', 'Hutang')
                                                ->sum('price_total')
            ];
            $index++;
        }

        $data = array(
            'title' => 'Laporan Hutang',
            'actived' => 'laporan',
            'suppliers' => $suppliers,
        );

        if ($request->exportTo == 'excel') {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan-hutang-".date('Ymd').time().".xls");
            return view('pages.report._exportHutang', $data);
        } else 
        if ($request->exportTo == 'pdf') {
            $view = view('pages.report._exportHutang', $data)->render();
            $pdf = PDF::loadHTML($view)
                        ->setPaper('a4', 'potrait')
                        ->setWarnings(false);
            return $pdf->stream('laporan-hutang-'.time().'.pdf');
        } 
        return view('pages.report.hutang', $data);
    }

    public function piutang(Request $request) {
        $index = 0;
        $results = [];
        $customers = Customer::orderBy('name', 'ASC')->get();

        foreach($customers as $item) {

            $results[$index] = [
                "id" => $item->id,
                "name" => $item->name,
            ];

            $w = 1;
            $id = $item->id;
            $start = (date('YW') - 3);
            for($i = $start; $i <= date('YW'); $i++) {
                $billing = DB::select("SELECT SUM(price_total) as billing 
                                    FROM sales
                                    WHERE YEARWEEK(created_at) < $i
                                    AND customer_id=$id
                                    ORDER BY YEARWEEK(created_at) ASC")[0]->billing;

                $payment = DB::select("SELECT SUM(debit) as payment 
                                    FROM sale_payments
                                    WHERE YEARWEEK(created_at) < $i
                                    AND customer_id=$id
                                    ORDER BY YEARWEEK(created_at) ASC")[0]->payment;

                if ($billing) {
                    $results[$index]["minggu-".$w] = $billing - $payment;
                } else {
                    $nilai = Customer::find($id)->saldo_tabungan;
                    $results[$index]["minggu-".$w] = $nilai - ($nilai * 2);
                }
                $w++;
            }
            $index++;
        }

        $data = array(
            'title' => 'Laporan Piutang',
            'actived' => 'laporan',
            'customers' => $results,
        );

        if ($request->exportTo == 'excel') {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan-piutang-".date('Ymd').time().".xls");
            return view('pages.report._exportPiutang', $data);
        } else 
        if ($request->exportTo == 'pdf') {
            $view = view('pages.report._exportPiutang', $data)->render();
            $pdf = PDF::loadHTML($view)
                        ->setPaper('a4', 'potrait')
                        ->setWarnings(false);
            return $pdf->stream('laporan-piutang-'.time().'.pdf');
        } 

        return view('pages.report.piutang', $data);
    }

    public function _operasional($month) {
        $results = [];
        $results['belanja'] = $this->_belanja($month);
        $results['gaji_karyawan'] = $this->_gaji_karyawan($month);
        $results['other'] = $this->_operasional_lain($month);

        return $results;
    }

    private function _gaji_karyawan($month) {
        $index = 0;
        $results = [];
        $gaji_pokok = 0;
        $gaji_tambahan = 0;
        $gaji_total = 0;

        $salaries = EmployeeSalary::where('created_at', 'like', $month ? $month.'%' : date('Y-m').'%')->get();
        foreach($salaries as $item) {
            $results['items'][$index] = array(
                'id' => $item->id,
                'name' => Employee::find($item->employee_id)->name,
                "salary" => $item->salary,
                "salary_extra" => $item->salary_extra,
                "salary_total" => $item->salary_total
            );

            $gaji_pokok += $item->salary;
            $gaji_tambahan += $item->salary_extra;
            $gaji_total += $item->salary_total;

            $index++;
        }       
        
        $results['total_gaji_pokok']  = $gaji_pokok;
        $results['total_gaji_tambahan']  = $gaji_tambahan;
        $results['total_gaji_total']  = $gaji_total;

        return $results;
    }

    private function _operasional_lain($month) {
        $index = 0;
        $results = [];
        $total_nominal = 0;

        $operationals = OperationalOther::where('created_at', 'like', $month ? $month.'%' : date('Y-m').'%')->get();
        foreach($operationals as $item) {
            $results['items'][$index] = $item;
            $total_nominal += $item->nominal;
            $index++;
        }       
        
        $results['total_nominal']  = $total_nominal;
        return $results;
    }

    private function _belanja($month) {
        $index = 1;
        $results = [];
        $categories = ProductCategory::where('id', '!=', 1)->get();

        $results[0]['kategori'] = 'telor';
        $results[0]['data_belanja'] = $this->_belanja_telor($month);

        foreach($categories as $item) {
            $results[$index]['kategori'] = $item->name;
            $results[$index]['data_belanja'] = $this->_belanja_product($month, $item->id);
            $index++;
        }

        return $results;
    }

    private function _belanja_product($month, $categoryId = 2) {
        $index = 0;
        $total_stok_pembelian = 0;
        $total_harga_pembelian = 0;

        $products = Product::where('category_id', '=', $categoryId)
                        ->orderBy('name', 'ASC')->get();
        foreach($products as $item) {
            $products[$index] = array(
                'id' => $item->id,
                'name' => $item->name,
                'stok_pembelian' => ShoppingItem::where('product_id', '=', $item->id)
                                    ->where('created_at', 'like', $month ? $month.'%' : date('Y-m').'%')
                                    ->sum('qty'),
                'harga_pembelian' => ShoppingItem::where('product_id', '=', $item->id)
                                    ->where('created_at', 'like', $month ? $month.'%' : date('Y-m').'%')
                                    ->sum('price'),
            );

            $total_stok_pembelian += $products[$index]['stok_pembelian'];
            $total_harga_pembelian += $products[$index]['harga_pembelian'];
            $index++;
        }
        $results['products']['items'] = $products;
        $results['products']['total_stok_pembelian'] = $total_stok_pembelian;
        $results['products']['total_harga_pembelian'] = $total_harga_pembelian;

        return $results;
    }

    private function _belanja_telor($month) {
        $index = 0;
        $results = [];
        $total_stok_pembelian = 0;
        $total_harga_pembelian = 0;

        $telors = ShoppingItem::where('product_id', '=', 1)
                                ->where('created_at', 'like', $month ? $month.'%' : date('Y-m').'%')
                                ->get();
        foreach($telors as $item) {
            $results['telor']['items'][$index] = array(
                'id' => $item->id,
                'name' => Supplier::find($item->supplier_id)->name,
                'stok_pembelian' => $item->qty,
                'harga_pembelian' => $item->price,
            );
            $total_harga_pembelian += $item->price;
            $total_stok_pembelian += $item->qty;
            $index++;
        }
        $results['telor']['total_harga_pembelian'] = $total_harga_pembelian;
        $results['telor']['total_stok_pembelian'] = $total_stok_pembelian;

        return $results;
    }

    private function _penjualan($month) {
        $index = 1;
        $results = [];
        $categories = ProductCategory::where('id', '!=', 1)->get();

        $results[0]['kategori'] = 'telor';
        $results[0]['data_penjualan'] = $this->_penjualan_telor($month);

        foreach($categories as $item) {
            $results[$index]['kategori'] = $item->name;
            $results[$index]['data_penjualan'] = $this->_penjualan_product($month, $item->id);
            $index++;
        }

        return $results;
    }

    private function _penjualan_product($month, $categoryId = 2) {
        $index = 0;
        $total_harga_modal = 0;
        $total_stok_terjual = 0;
        $total_harga_profit = 0;
        $total_harga_omset = 0;

        $products = Product::where('category_id', '=', $categoryId)
                        ->orderBy('name', 'ASC')->get();
        foreach($products as $item) {
            $products[$index] = array(
                'id' => $item->id,
                'name' => $item->name,
                'harga_modal' => SaleItem::where('product_id', '=', $item->id)
                                    ->where('created_at', 'like', $month ? $month.'%' : date('Y-m').'%')
                                    ->sum('purchase_price'),
                'stok_terjual' => SaleItem::where('product_id', '=', $item->id)
                                    ->where('created_at', 'like', $month ? $month.'%' : date('Y-m').'%')
                                    ->sum('qty'),
                'harga_profit' => SaleItem::where('product_id', '=', $item->id)
                                    ->where('created_at', 'like', $month ? $month.'%' : date('Y-m').'%')
                                    ->sum('price'),
                'harga_omset' => SaleItem::where('product_id', '=', $item->id)                    
                                    ->where('created_at', 'like', $month ? $month.'%' : date('Y-m').'%')
                                    ->sum('price') - 
                                 SaleItem::where('product_id', '=', $item->id)
                                    ->where('created_at', 'like', $month ? $month.'%' : date('Y-m').'%')
                                    ->sum('purchase_price'),
            );

            $total_harga_modal += $products[$index]['harga_modal'];
            $total_stok_terjual += $products[$index]['stok_terjual'];
            $total_harga_profit += $products[$index]['harga_profit'];
            $total_harga_omset += $products[$index]['harga_omset'];
            $index++;
        }
        $results['products']['items'] = $products;
        $results['products']['total_harga_modal'] = $total_harga_modal;
        $results['products']['total_stok_terjual'] = $total_stok_terjual;
        $results['products']['total_harga_profit'] = $total_harga_profit;
        $results['products']['total_harga_omset'] = $total_harga_omset;

        return $results;
    }

    private function _penjualan_telor($month) {
        $index = 0;
        $results = [];
        $total_harga_modal = 0;
        $total_stok_terjual = 0;
        $total_harga_profit = 0;
        $total_harga_omset = 0;

        $telors = SaleItem::where('product_id', '=', 1)
                                ->where('created_at', 'like', $month ? $month.'%' : date('Y-m').'%')
                                ->get();
        foreach($telors as $item) {
            $results['telor']['items'][$index] = array(
                'id' => $item->id,
                'name' => Customer::find(Sale::find($item->sale_id)->customer_id)->name,
                'harga_modal' => $item->purchase_price,
                'stok_terjual' => $item->qty,
                'harga_profit' => $item->price,
                'harga_omset' => $item->price - $item->purchase_price,
            );
            $total_harga_modal += $item->purchase_price;
            $total_stok_terjual += $item->qty;
            $total_harga_profit += $item->price;
            $total_harga_omset += ($item->price - $item->purchase_price);
            $index++;
        }
        $results['telor']['total_harga_modal'] = $total_harga_modal;
        $results['telor']['total_stok_terjual'] = $total_stok_terjual;
        $results['telor']['total_harga_profit'] = $total_harga_profit;
        $results['telor']['total_harga_omset'] = $total_harga_omset;

        return $results;
    }
}
