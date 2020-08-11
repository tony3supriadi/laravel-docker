@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-clipboard mr-3"></i>Laporan Piutang
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
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th width="10px" rowspan="2" class="text-center align-middle no-sort">#</th>
                <th rowspan="2" class="align-middle">NAMA PELANGGAN</th>
                <th colspan="4" class="text-center">CATATAN HUTANG</th>
            </tr>
            <tr>
                <th class="text-right">MINGGU-{{ date('W')-3 }}</th>
                <th class="text-right">MINGGU-{{ date('W')-2 }}</th>
                <th class="text-right">MINGGU-{{ date('W')-1 }}</th>
                <th class="text-right">MINGGU-{{ date('W')-0 }}</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            <?php $total = 0; ?>
            @foreach($customers as $item)
                <tr>
                    <td class="text-center">{{ $num }}.</td>
                    <td>{{ $item['name'] }}</td>
                    <td class="text-right">
                        <span class="{{ $item['minggu-1'] <= 0 ? 'text-success' : 'text-danger' }}">
                            Rp{{ number_format(str_replace('-', '', $item['minggu-1']), 0, ',', '.') }},-
                        </span>
                    </td>
                    <td class="text-right">
                        <span class="{{ $item['minggu-2'] <= 0 ? 'text-success' : 'text-danger' }}">
                            Rp{{ number_format(str_replace('-', '', $item['minggu-2']), 0, ',', '.') }},-
                        </span>
                    </td>
                    <td class="text-right">
                        <span class="{{ $item['minggu-3'] <= 0 ? 'text-success' : 'text-danger' }}">
                            Rp{{ number_format(str_replace('-', '', $item['minggu-3']), 0, ',', '.') }},-
                        </span>
                    </td>
                    <td class="text-right">
                        <span class="{{ $item['minggu-4'] <= 0 ? 'text-success' : 'text-danger' }}">
                            Rp{{ number_format(str_replace('-', '', $item['minggu-4']), 0, ',', '.') }},-
                        </span>
                    </td>
                </tr>
                <?php $num++; ?>
            @endforeach
        </tbody>
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