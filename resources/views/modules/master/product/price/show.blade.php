@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-money mr-3"></i>Harga Produk
        </h2>
        <div class="col-md-6 text-right">
            @can('produk-price-edit')
            <a href="{{ url('produk/harga/'.encrypt($product->id).'/edit') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-edit mr-2"></i>Ubah
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
                <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                DETAIL PRODUK
            </div>

            <table class="table">
                <tr>
                    <th width="20%" class="text-right">Barcode</th>
                    <th width="10px">:</th>
                    <td width="">{{ $product->product_code }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Nama Produk</th>
                    <th width="10px">:</th>
                    <td>{{ $product->product_name }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Harga Jual</th>
                    <th width="10px">:</th>
                    <td>Rp{{ number_format($product->price, 0, '', '.') }},-</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Grup Pelanggan</th>
                    <th width="10px">:</th>
                    <td>{{ $product->group_name }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Deskripsi</th>
                    <th width="10px">:</th>
                    <td>{{ $product->description ? $product->description : '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
</section>
@endsection