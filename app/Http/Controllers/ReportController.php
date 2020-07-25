<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = [];

        $reports = SaleItem::select('*')
                        ->whereBetween('sale_items.created_at', $request->start ? 
                                [$request->start . ' 00:00:00', $request->end . ' 23.59.59'] : 
                                [date('Y-m').'-1 00:00:00', date('Y-m-d').' 23:59:59'])
                        ->get();
        
        foreach($reports as $item) {
            $product = Product::find($item->product_id);
            $item['code'] = $product->code;
            $item['product_name'] = $product->name;
            $item['omset'] = $item->sub_total;
            $item['profit'] = $item->sub_total - ($item->qty * $item->purchase_price);
        }

        $data = array(
            'title' => 'Laporan',
            'actived' => 'laporan',
            'reports' => $reports
        );

        if ($request->exportTo) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan-laba-rugi-".date('Ymd').time().".xls");
            return view('pages.report.excel', $data);
        }
        return view('pages.report.index', $data);
    }
}
