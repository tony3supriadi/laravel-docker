@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">
            <i class="fa fa-cubes mr-3"></i>Satuan
        </h2>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <div class="row">
        <div class="col-md-12">
            <div class="py-2 mb-2 border-bottom">
                <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                DETAIL SATUAN
            </div>

            <table class="table table-striped">
                <tr>
                    <th width="20%" class="text-right">Nama Satuan</th>
                    <th width="10px">:</th>
                    <td>{{ $unit->name }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Simbol Satuan</th>
                    <th width="10px">:</th>
                    <td>{{ $unit->symbol }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Deskripsi</th>
                    <th width="10px">:</th>
                    <td>{{ $unit->description }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Terdaftar Pada</th>
                    <th width="10px">:</th>
                    <td>{{ Carbon\Carbon::parse($unit->created_at)->format('d M Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Diperbarui Pada</th>
                    <th width="10px">:</th>
                    <td>{{ Carbon\Carbon::parse($unit->updated_at)->format('d M Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
    </div>
</section>
@endsection