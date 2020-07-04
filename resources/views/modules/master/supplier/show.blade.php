@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-truck mr-3"></i>Supplier
        </h2>
        <div class="col-md-6 text-right">
            @can('supplier-edit')
            <a href="{{ url('supplier/'.encrypt($supplier->id).'/edit') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-edit mr-2"></i>Ubah
            </a>
            @endcan
            
            @can('supplier-create')
            <a href="{{ url('supplier/create') }}" class="btn btn-primary btn-sm">
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
                DETAIL SUPPLIER
            </div>

            <table class="table">
                <tr>
                    <th width="20%" class="text-right">Nama Supplier</th>
                    <th width="10px">:</th>
                    <td>{{ $supplier->name }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">E-Mail</th>
                    <th width="10px">:</th>
                    <td>{{ $supplier->email ? $supplier->email : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">No HP / WA</th>
                    <th width="10px">:</th>
                    <td>{{ $supplier->phone ? $supplier->phone : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Telephone</th>
                    <th width="10px">:</th>
                    <td>{{ $supplier->telp ? $supplier->telp : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Fax Mail</th>
                    <th width="10px">:</th>
                    <td>{{ $supplier->faxmail ? $supplier->faxmail : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Alamat</th>
                    <th width="10px">:</th>
                    <td>
                        {{ $supplier->address ? $supplier->address : '-' }}, 
                        {{ $supplier->regency_id ? $supplier->regency_name : '-' }},
                        {{ $supplier->province_id ? $supplier->province_name : '-' }}.
                        {{ $supplier->postcode ? $supplier->postcode : '-' }}.
                    </td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Bank</th>
                    <th width="10px">:</th>
                    <td>
                        ({{ $supplier->bank_code }}) {{ $supplier->bank_name }}
                    </td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">No.Rekening</th>
                    <th width="10px">:</th>
                    <td>{{ $supplier->bank_number ? $supplier->bank_number : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Nama Pemilik Rekening</th>
                    <th width="10px">:</th>
                    <td>{{ $supplier->bank_account ? $supplier->bank_account : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Deskripsi</th>
                    <th width="10px">:</th>
                    <td>{{ $supplier->description ? $supplier->description : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Terdaftar Pada</th>
                    <th width="10px">:</th>
                    <td>{{ Carbon\Carbon::parse($supplier->created_at)->format('d M Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Diperbarui Pada</th>
                    <th width="10px">:</th>
                    <td>{{ Carbon\Carbon::parse($supplier->updated_at)->format('d M Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
    </div>
</section>
@endsection