@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-clipboard mr-3"></i>Laporan Laba / Rugi
        </h2>

        <div class="col-md-6 text-right">
            <a href="?exportTo=excel{{ isset($_GET['start']) ? '&start='.$_GET['start'] : '' }}{{ isset($_GET['end']) ? '&end='.$_GET['end'] : '' }}" class="btn btn-sm btn-outline-primary">
                <i class="fa fa-file-excel-o mr-1"></i>
                Export
            </a>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    @if(isset($_GET['status']) && ($_GET['status'] == 'lunas' || $_GET['status'] == 'hutang'))
    <div class="row">
        <div class="col-md-3 offset-md-9">
            <div class="border py-2 px-3 text-right">
                <small class="text-secondary">TOTAL {{ $_GET['status'] == 'lunas' ? 'BELANJA' : 'HUTANG' }} :</small>
                <h3 class="no-margin-bottom">Rp{{ number_format($total, 0, ',', '.') }},-</h3>
            </div>
        </div>
    </div>
    @endif
    <div class="row mb-0">
        <div class="col-md-1 py-1">
            FILTER : 
        </div>
        <div class="col-md-6">
            <form action="" method="get">
                @if(isset($_GET['status']))
                <input type="hidden" name="status" value="{{ $_GET['status'] }}">
                @endif
                <div class="form-group row">
                    <div class="col-4 px-0">
                        <input type="date" name="start" value="{{ isset($_GET['start']) ? $_GET['start'] : date('Y').'-'.date('m').'-01' }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-4 px-0">
                        <input type="date" name="end" value="{{ isset($_GET['end']) ? $_GET['end'] : date('Y-m-d') }}" timezone="Asia/Jakarta" class="form-control form-control-sm">
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-sm btn-primary btn-block">
                            TAMPIL
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr class="mt-0" />

    <table class="table datatable no-ordering">
        <thead>
            <tr>
                <th width="10px" class="text-center no-sort">#</th>
                <th width="10%">KODE</th>
                <th>PRODUK</th>
                <th width="10%">QTY</th>
                <th width="10%" class="text-right">OMSET</th>
                <th width="10%" class="text-right">PROFIT</th>
                <th width="15%">WAKTU</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            <?php $omset = 0; ?>
            <?php $profit = 0; ?>
            @foreach($reports as $item)
                <?php $omset = $omset + $item->omset; ?>
                <?php $profit = $profit + $item->profit; ?>

                <tr>
                    <td class="text-center">{{ $num }}.</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td class="text-right">Rp{{ number_format($item->omset, 0, ',', '.') }},-</td>
                    <td class="text-right">Rp{{ number_format($item->profit, 0, ',', '.') }},-</td>
                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-m-y H:i:s') }}</td>
                </tr>
                <?php $num++; ?>
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-4">
            <div class="card mt-3">
                <div class="card-header">
                    Keterangan :
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <tr>
                            <td width="40%">TOTAL OMSET</td>
                            <td width="5px">:</td>
                            <td>Rp{{ number_format($omset, 0, ",", ".") }},-</td>
                        </tr>
                        <tr>
                            <td width="30%">TOTAL PROFIT</td>
                            <td width="5px">:</td>
                            <td>Rp{{ number_format($profit, 0, ",", ".") }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
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