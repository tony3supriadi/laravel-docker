@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-cube mr-3"></i>Produk
        </h2>
        <div class="col-md-6 text-right">
            @can('produk-edit')
            <a href="{{ url('produk/'.encrypt($product->id).'/edit') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-edit mr-2"></i>Ubah
            </a>
            @endcan
            
            @can('produk-create')
            <a href="{{ url('produk/create') }}" class="btn btn-primary btn-sm">
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
                <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                DETAIL PRODUK
            </div>

            <table class="table">
                <tr>
                    <th width="20%" class="text-right">Barcode</th>
                    <th width="10px">:</th>
                    <td>{{ $product->code }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Kategori</th>
                    <th width="10px">:</th>
                    <td>{{ $product->category_name }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Nama Produk</th>
                    <th width="10px">:</th>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Harga Beli</th>
                    <th width="10px">:</th>
                    <td>Rp{{ number_format($product->purchase_price, 0, '', '.') }},-</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Harga Jual</th>
                    <th width="10px">:</th>
                    <td>Rp{{ number_format($product->price, 0, '', '.') }},-</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Stok</th>
                    <th width="10px">:</th>
                    <td>{{ $product->stock }}{{ $product->symbol }} <span class="text-gray">({{ $product->stockmin }})</span></td>
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