<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Laporan',
            'actived' => 'laporan'
        );
        return view('pages.report.index', $data);
    }
}
