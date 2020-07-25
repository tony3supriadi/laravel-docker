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
            <table class="table">
                <tr>
                    <th width="20%" class="text-right">Nama Pelanggan</th>
                    <th width="10px">:</th>
                    <td>{{ $customer->name }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Grup</th>
                    <th width="10px">:</th>
                    <td>{{ $customer->group_name }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">E-Mail</th>
                    <th width="10px">:</th>
                    <td>{{ $customer->email ? $customer->email : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">NO HP / WA</th>
                    <th width="10px">:</th>
                    <td>{{ $customer->phone ? $customer->phone : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Alamat</th>
                    <th width="10px">:</th>
                    <td>
                        {{ $customer->address ? $customer->address : '-' }}, 
                        {{ $customer->regency_id ? $customer->regency_name : '-' }},
                        {{ $customer->province_id ? $customer->province_name : '-' }}.
                    </td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Deskripsi</th>
                    <th width="10px">:</th>
                    <td>{{ $customer->description ? $customer->description : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Terdaftar Pada</th>
                    <th width="10px">:</th>
                    <td>{{ Carbon\Carbon::parse($customer->created_at)->format('d M Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Diperbarui Pada</th>
                    <th width="10px">:</th>
                    <td>{{ Carbon\Carbon::parse($customer->updated_at)->format('d M Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
    </div>
</section>
@endsection