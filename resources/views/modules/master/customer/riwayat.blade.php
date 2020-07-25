@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-address-book-o mr-3"></i>Pelanggan
        </h2>
        <div class="col-md-6 text-right">
            @can('pelanggan-edit')
            <a href="{{ url('pelanggan/'.encrypt($customer->id).'/edit') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-edit mr-2"></i>Ubah
            </a>
            @endcan
            
            @can('pelanggan-create')
            <a href="{{ url('pelanggan/create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus-circle mr-2"></i>Tambah
            </a>
            @endcan
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
<div class="row">
        <div class="col-md-12">
            <div class="py-2 border-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ url('pelanggan') }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        DETAIL PELANGGAN
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ url('pelanggan/'.encrypt($customer->id)) }}" class="btn btn-sm btn-outline-primary px-3 mx-1 rounded-pill">DETAIL</a>
                        <a href="{{ url('pelanggan/'.encrypt($customer->id).'/tabungan') }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill">SALDO TABUNGAN</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-body d-flex justify-content-between">
                <span>SALDO TABUNGAN :</span>
                <h3>{{ number_format($customer->saldo_tabungan, 0, ',', '.') }}</h3>
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