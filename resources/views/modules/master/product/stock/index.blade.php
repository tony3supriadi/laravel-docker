@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-cubes mr-3"></i>Stok Produk
        </h2>

        <div class="col-md-6 text-right">
            <a href="{{ url('produk/stok/export-to-excel') }}" class="btn btn-outline-primary btn-sm">
                <i class="fa fa-file-excel-o mr-2"></i>Export
            </a>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <table class="table datatable no-ordering">
        <thead>
            <tr>
                <th width="10px" class="text-center no-sort">#</th>
                <th width="15%">KODE</th>
                <th>NAMA PRODUK</th>
                <th width="20%">STOK SALDO</th>

                <th width="80px" class="text-center">AKSI</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            @foreach($products as $item)
                <tr>
                    <td class="text-center">{{ $num }}.</td>
                    <td>{{ $item->product_code }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->stock_saldo }}{{ $item->symbol }} <span class="text-gray">({{ $item->product_stockmin }})</span></td>

                    <td class="text-center">
                        <a href="{{ url('produk/stok/'.encrypt($item->product_id)) }}" class="text-primary mx-1">
                            <i class="fa fa-clipboard"></i>
                        </a>

                        @can('produk-stock-edit')
                        <a href="{{ url('produk/stok/'.encrypt($item->product_id) . '/edit') }}" class="text-dark mx-1">
                            <i class="fa fa-cubes"></i>
                        </a>
                        @endcan
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