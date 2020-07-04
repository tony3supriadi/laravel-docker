@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-share-alt mr-3"></i>Data Cabang
            </h2>
            <div class="col-md-6 text-right">
                @can('branch-edit')
                <a href="{{ url('cabang/'.encrypt($branch->id).'/edit') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-edit mr-2"></i> Ubah
                </a>
                @endcan
                @can('branch-create')
                <a href="{{ url('cabang/create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus-circle mr-2"></i> Tambah
                </a>
                @endcan
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <div class="py-2 border-bottom">
        <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
            <i class="fa fa-arrow-left"></i>
        </a>
        DETAIL CABANG
    </div>

    <table class="table table-striped">
        <tr>
            <th width="20%" class="text-right">Nama Cabang</th>
            <th width="10px">:</th>
            <td>{{ $branch->name }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Alamat</th>
            <th width="10px">:</th>
            <td>
                {{ $branch->address ? $branch->address : '-' }}{{ $branch->regency_id ? ', '.DB::table('regencies')->where('id', '=', $branch->regency_id)->first()->name : '' }}{{ $branch->province_id ? ', '.DB::table('provinces')->where('id', '=', $branch->province_id)->first()->name : '' }}{{ $branch->postcode ? ', '.$branch->postcode : '' }}
            </td>
        </tr>
        <tr>
            <th width="20%" class="text-right">HP/WA</th>
            <th width="10px">:</th>
            <td>{{ $branch->phone ? $branch->phone : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Telphone</th>
            <th width="10px">:</th>
            <td>{{ $branch->telp ? $branch->telp : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">E-Mail</th>
            <th width="10px">:</th>
            <td>{{ $branch->email ? $branch->email : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Deskripsi</th>
            <th width="10px">:</th>
            <td>{{ $branch->description ? $branch->description : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Terdaftar Pada</th>
            <th width="10px">:</th>
            <td>{{ Carbon\Carbon::parse($branch->created_at)->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Diperbarui Pada</th>
            <th width="10px">:</th>
            <td>{{ Carbon\Carbon::parse($branch->updated_at)->format('d M Y H:i:s') }}</td>
        </tr>
    </table>
</section>
@endsection