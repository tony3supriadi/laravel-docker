@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-clipboard mr-3"></i>Laporan Hutang
        </h2>

        <div class="col-md-6 px-0 text-right">
            <a href="?exportTo=excel" class="btn btn-sm rounded-pill btn-outline-primary">
                <i class="fa fa-file-excel-o mr-1"></i>
                Excel
            </a>
            <a href="?exportTo=pdf" target="_blank" class="btn btn-sm rounded-pill btn-outline-primary">
                <i class="fa fa-file-pdf-o mr-1"></i>
                PDF
            </a>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <table class="table">
        <thead>
            <tr>
                <th width="10px" class="text-center no-sort">#</th>
                <th>NAMA PERUSAHAAN</th>
                <th width="20%" class="text-right">JUMLAH HUTANG</th>
                <th width="40%">TERBILANG</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            <?php $total = 0; ?>
            @foreach($suppliers as $item)
                <?php $total += $item['jumlah_hutang']; ?>
                <tr>
                    <td class="text-center">{{ $num }}.</td>
                    <td>{{ $item['supplier_name'] }}</td>
                    <td class="text-right">Rp{{ number_format($item['jumlah_hutang'], 0, ',', '.') }},-</td>
                    <td>{{ terbilang($item['jumlah_hutang']) }}</td>
                </tr>
                <?php $num++; ?>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="2">TOTAL HUTANG :</th>
                <th class="text-right">Rp{{ number_format($total, 0, ',', '.') }}</th>
                <th>{{ terbilang($total) }}</th>
            </tr>
        </tfoot>
    </table>
</section>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/datatable/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendor/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('js/init/datatable.init.js')}}"></script>
@endsection