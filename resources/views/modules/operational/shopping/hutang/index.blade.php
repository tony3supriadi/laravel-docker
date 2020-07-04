@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-credit-card-alt mr-3"></i>Catatan Hutang
        </h2>

        <!-- <div class="col-md-6 text-right">
            <a href="javascript::" class="btn btn-primary btn-sm">
                <i class="fa fa-plus-circle mr-2"></i>INPUT PEMBAYARAN
            </a>
        </div> -->
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <table class="table table-bordered datatable no-ordering">
        <thead>
            <tr>
                <th width="10px" class="text-center no-sort">#</th>
                <th>PENYUPLAI</th>
                <th width="18%" class="text-right">TOTAL TAGIHAN</th>
                <th width="18%" class="text-right">PEMBAYARAN</th>
                <th width="18%" class="text-right">SISA HUTANG</th>
                <!-- <th width="30px" class="text-center"></th> -->
            </tr>
        </thead>
        <tbody>
            <?php 
            $num = 1; 
            $billing = 0;
            $payment = 0;
            $debt = 0;
            ?>
            @foreach($results as $item)
                @if ($item->debt > 0)
                <tr>
                    <td class="text-center">{{ $num }}.</td>
                    <td>{{ $item->name }}</td>
                    <td class="text-right">Rp{{ number_format($item->billing, 0, ',', '.') }},-</td>
                    <td class="text-right">Rp{{ number_format($item->payment, 0, ',', '.') }},-</td>
                    <td class="text-right">Rp{{ number_format($item->debt, 0, ',', '.') }},-</td>
                    <!-- <td class="text-center">
                        <a href="{{ url('belanja/hutang/'.encrypt($item->supplier_id)) }}" class="text-primary mx-1">
                            <i class="fa fa-search"></i>
                        </a>
                    </td> -->
                </tr>
                <?php 
                $num++;
                $billing = $billing + $item->billing;
                $payment = $payment + $item->payment;
                $debt = $debt + $item->debt;
                ?>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col-5">
            <div class="card mt-3">
                <div class="card-header">
                    TOTAL KESELURUHAN
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <tr>
                            <th width="40%">TOTAL TAGIHAN</th>
                            <th width="5px">:</th>
                            <td>Rp{{ number_format($billing, 0, ',', '.') }},-</td>
                        </tr>
                        <tr>
                            <th width="40%">PEMBAYARAN</th>
                            <th width="5px">:</th>
                            <td>Rp{{ number_format($payment, 0, ',', '.') }},-</td>
                        </tr>
                        <tr>
                            <th width="40%">SISA HUTANG</th>
                            <th width="5px">:</th>
                            <td>Rp{{ number_format($debt, 0, ',', '.') }},-</td>
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